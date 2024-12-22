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
        $upcoming = Conference::upcoming()->with('cover')->get();
        $ended = Conference::ended()->with('cover')->simplePaginate(10);

        return view('conferences.index', compact('upcoming', 'ended'));
    }

    public function upcoming()
    {
        $conferences = Conference::upcoming()->with('cover')->simplePaginate(10);
        return ConferenceResource::collection($conferences);
    }

    public function ended()
    {
        $conferences = Conference::ended()->with('cover')->simplePaginate(10);
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

            if ($upload = $request->get('cover'))
            {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'public';
                        $file->save();
                        $conference->cover_id = $file->id;
                    }
                }
            }

            if ($upload = $request->get('file'))
            {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'public';
                        $file->save();
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
        $this->authorize('view', $conference);

        $conference->load('cover', 'creator', 'file');

        if ($request->expectsJson()) {
            return new ConferenceResource($conference);
        }

        return view('conferences.show', ['item' => $conference]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Conference $conference)
    {
        //
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
                        $file->storage = 'public';
                        $file->save();
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
    public function destroy(Conference $conference)
    {
        $this->authorize('delete', $conference);

        if ($conference->trashed())
            $conference->restore();
        else
            $conference->delete();

        return new ConferenceResource($conference);
    }
}
