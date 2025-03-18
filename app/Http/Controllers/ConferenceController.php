<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConferenceRequest;
use App\Http\Requests\UpdateConferenceRequest;
use App\Http\Resources\ConferenceResource;
use App\Models\Conference;
use App\Models\File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConferenceController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $upcoming = Conference::upcoming()->with('cover')->orderBy('created_at', 'desc')->get();
        $ended = Conference::ended()->with('cover')->orderBy('created_at', 'desc')->simplePaginate(10);

        return view('conferences.index', compact('upcoming', 'ended'));
    }

    public function upcoming()
    {
        $conferences = Conference::upcoming()->with('cover')->orderBy('created_at', 'desc')->simplePaginate(10);
        return ConferenceResource::collection($conferences);
    }

    public function ended()
    {
        $conferences = Conference::ended()->with('cover')->orderBy('created_at', 'desc')->simplePaginate(10);
        return ConferenceResource::collection($conferences);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConferenceRequest $request)
    {
        $this->authorize('create', Conference::class);

        $conference = DB::transaction(function () use ($request) {
            $user = Auth::user();
            $conference = Conference::make($request->validated());
            $conference->creator()->associate($user);

            if ($upload = $request->get('cover')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'public';
                        $file->save();
                        $conference->cover_id = $file->id;
                    }
                }
            }

            if ($upload = $request->get('file')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->moveToStorage('public');
                        $conference->file_id = $file->id;
                    }
                }
            }

            $conference->creator()->associate($user);
            $conference->save();

            return $conference;
        });

        if ($request->expectsJson()) {
            return [
                'redirect_to' => route('conferences.show', compact('conference')),
                'conference' => new ConferenceResource($conference)
            ];
        } else
            return redirect()->route('conferences.index')
                ->with('success', 'Мероприятие успешно добавлена');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Conference $conference)
    {
        $conference->load('cover', 'creator', 'file');

        if ($request->expectsJson()) {
            return new ConferenceResource($conference);
        }

        return view('conferences.show', ['item' => $conference]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConferenceRequest $request, Conference $conference)
    {
        $this->authorize('update', $conference);

        $conference = DB::transaction(function () use ($request, $conference) {
            $conference->fill($request->validated());
            $conference->save();

            if ($upload = $request->get('cover')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $conference->cover()->delete();
                        $file->storage = 'public';
                        $file->save();
                        $conference->cover_id = $file->id;
                        $conference->save();
                    }
                }
            }

            if ($upload = $request->get('file')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $conference->file()->delete();
                        $file->moveToStorage('public');
                        $conference->file_id = $file->id;
                        $conference->save();
                    }
                }
            }
            return $conference;
        });

        if ($request->expectsJson()) {
            return [
                'redirect_to' => route('conferences.show', compact('conference')),
                'conference' => new ConferenceResource($conference)
            ];
        } else
            return redirect()
                ->route('conferences.index')
                ->with('success', 'Мероприятие обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($conference)
    {
        $conference = Conference::withTrashed()
            ->findOrFail($conference);

        $this->authorize('delete', $conference);

        if ($conference->trashed())
            $conference->restore();
        else
            $conference->delete();

        return new ConferenceResource($conference);
    }

    /**
     * Download conference
     */
    public function download(Conference $conference)
    {
        if ($conference->isVideo())
            $this->authorize('watch', $conference);
        else
            $this->authorize('download', $conference);

        $file = $conference->file;

        if (!$file instanceof File or $file->trashed() or !$file->exists())
            return response('File not found.', 404);

        if ($file->storage == 'private') {
            return response('')
                ->header('X-Accel-Redirect', $file->url)
                ->header('Content-Disposition', 'attachment; filename="' . $file->name . '"')
                ->header('Content-Type', 'application/x-force-download')
                ->header('Cache-Control', 'public, max-age=' . intval(60 * 60 * 31))  // Устанавливает кэш на 24 часа
                ->header('Last-Modified', gmdate('D, d M Y H:i:s', strtotime($file->updated_at)) . ' GMT')
                ->header('ETag', md5($file->id . $file->updated_at . $file->size));
        } else {
            return redirect()->to($file->url);
        }
    }

    public function toggleSubscription(Request $request, Conference $conference)
    {
        $this->authorize('toggleSubscription', $conference);

        // Получаем текущего пользователя
        $user = Auth::user();

        // Проверяем, подписан ли уже пользователь на этот вебинар
        $subscription = $user->conferenceSubscriptions()
            ->where('conference_id', $conference->id)
            ->first();

        if ($subscription) {
            $this->authorize('unsubscribe', $conference);
            // Если подписка есть, отменяем подписку
            $subscription->delete();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Вы успешно отменили регистрацию на вебинар'
                ]);
            } else {
                return redirect()->route('conferences.show', compact('conference'));
            }
        } else {
            $this->authorize('subscribe', $conference);
            // Если подписки нет, создаем новую подписку
            $newSubscription = WebinarSubscription::create([
                'user_id' => $user->id,
                'conference_id' => $conference->id,
                'subscribed_at' => Carbon::now(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Вы успешно зарегистрировались на вебинар',
                    'subscription' => new WebinarResource($newSubscription)
                ], 201);
            } else {
                return redirect()->route('conferences.show', compact('conference'));
            }
        }
    }
}
