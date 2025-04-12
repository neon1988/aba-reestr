<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWebinarRequest;
use App\Http\Requests\UpdateWebinarRequest;
use App\Http\Resources\WebinarResource;
use App\Models\Conference;
use App\Models\File;
use App\Models\Webinar;
use App\Models\WebinarSubscription;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WebinarController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $upcomingWebinars = Webinar::upcoming()->with('cover')->orderBy('created_at', 'desc')->get();
        $endedWebinars = Webinar::ended()->with('cover')->orderBy('created_at', 'desc')->paginate(9);

        return view('webinars.index', compact('upcomingWebinars', 'endedWebinars'));
    }

    public function upcoming()
    {
        $webinars = Webinar::upcoming()->with('cover')->orderBy('created_at', 'desc')->paginate(9);
        return WebinarResource::collection($webinars);
    }

    public function ended()
    {
        $webinars = Webinar::ended()->with('cover')->orderBy('created_at', 'desc')->paginate(9);
        return WebinarResource::collection($webinars);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWebinarRequest $request)
    {
        $this->authorize('create', Webinar::class);

        $user = Auth::user();

        $webinar = DB::transaction(function () use ($request, $user) {
            $webinar = Webinar::make($request->validated());
            $webinar->creator()->associate($user);

            if ($upload = $request->get('cover')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'public';
                        $file->save();
                        $webinar->cover_id = $file->id;
                    }
                }
            }

            $webinar->save();
            return $webinar;
        });

        if ($request->expectsJson()) {
            $webinar->refresh();
            return [
                'redirect_to' => route('webinars.show', compact('webinar')),
                'webinar' => new WebinarResource($webinar->load('cover', 'creator')),
            ];
        } else
            return redirect()->route('webinars.index')
                ->with('success', 'Вебинар успешно добавлен');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Webinar $webinar)
    {
        $userSubscription = null;

        if (Auth::check()) {
            $userSubscription = $webinar->subscriptions()
                ->where('user_id', Auth::id())
                ->first();
        }

        $webinar->load('cover', 'record_file');

        if ($request->expectsJson()) {
            return new WebinarResource($webinar);
        }

        return view('webinars.show', ['item' => $webinar, 'userSubscription' => $userSubscription]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebinarRequest $request, Webinar $webinar)
    {
        $this->authorize('update', $webinar);

        $webinar = DB::transaction(function () use ($request, $webinar) {
            $webinar->fill($request->validated());
            $webinar->save();

            if ($upload = $request->get('cover')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $webinar->cover()->delete();
                        $file->storage = 'public';
                        $file->save();
                        $webinar->cover_id = $file->id;
                        $webinar->save();
                    }
                }
            }

            if ($upload = $request->get('record_file')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $webinar->record_file()->delete();
                        $file->storage = 'public';
                        $file->save();
                        $webinar->record_file_id = $file->id;
                        $webinar->save();
                    }
                }
            }
            return $webinar;
        });

        if ($request->expectsJson()) {

            return [
                'redirect_to' => route('webinars.show', compact('webinar')),
                'webinar' => new WebinarResource($webinar->load('cover', 'creator', 'record_file')),
            ];
        } else
            return redirect()
                ->route('webinars.index')
                ->with('success', 'Вебинар успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($webinar)
    {
        $webinar = Webinar::withTrashed()
            ->findOrFail($webinar);

        $this->authorize('delete', $webinar);

        if ($webinar->trashed())
            $webinar->restore();
        else
            $webinar->delete();

        return new WebinarResource($webinar);
    }

    public function toggleSubscription(Request $request, Webinar $webinar)
    {
        $this->authorize('toggleSubscription', $webinar);

        // Получаем текущего пользователя
        $user = Auth::user();

        // Проверяем, подписан ли уже пользователь на этот вебинар
        $subscription = $user->webinarSubscriptions()
            ->where('webinar_id', $webinar->id)
            ->first();

        if ($subscription) {
            $this->authorize('unsubscribe', $webinar);
            // Если подписка есть, отменяем подписку
            $subscription->delete();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Вы успешно отменили регистрацию на вебинар'
                ]);
            } else {
                return redirect()->route('webinars.show', compact('webinar'));
            }
        } else {
            $this->authorize('subscribe', $webinar);
            // Если подписки нет, создаем новую подписку
            $newSubscription = WebinarSubscription::create([
                'user_id' => $user->id,
                'webinar_id' => $webinar->id,
                'subscribed_at' => Carbon::now(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Вы успешно зарегистрировались на вебинар',
                    'subscription' => new WebinarResource($newSubscription)
                ], 201);
            } else {
                return redirect()->route('webinars.show', compact('webinar'));
            }
        }
    }

    public function download(Webinar $webinar)
    {
        if ($webinar->isVideo())
            $this->authorize('watch', $webinar);
        else
            $this->authorize('download', $webinar);

        $file = $webinar->record_file;

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
}
