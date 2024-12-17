<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\StoreConferenceRequest;
use App\Http\Requests\UpdateConferenceRequest;
use App\Http\Resources\ConferenceResource;
use App\Models\Conference;
use App\Models\File;
use App\Models\Image;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Litlife\Url\Url;

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

        $user = Auth::user();

        $conference = Conference::make($request->validated());

        if (trim($request->get('cover')) != '') {
            $conference->cover()->delete();

            $disk = Storage::disk('public');
            $coverFile = $request->get('cover');
            $stream = $disk->getDriver()->readStream($coverFile);

            $cover = new Image();
            $cover->openImage($stream);
            $cover->storage = config('filesystems.default');
            $cover->name = Url::fromString($coverFile)->getBasename();
            $cover->save();

            $conference->cover_id = $cover->id;
        }

        if (trim($request->get('file')) != '') {
            $conference->file()->delete();

            $disk = Storage::disk('public');
            $recordFile = $request->get('file');
            $stream = $disk->getDriver()->readStream($recordFile);

            $file = new File();
            $file->open($stream, Url::fromString($recordFile)->getExtension());
            $file->storage = config('filesystems.default');
            $file->name = Url::fromString($recordFile)->getBasename();
            $file->save();

            $conference->file_id = $file->id;
        }

        $conference->creator()->associate($user);
        $conference->save();

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

        $conference->fill($request->validated());
        $conference->save();

        if (trim($request->get('cover')) != '') {
            $conference->cover()->delete();

            $disk = Storage::disk('public');
            $coverFile = $request->get('cover');
            $stream = $disk->getDriver()->readStream($coverFile);

            $cover = new Image();
            $cover->openImage($stream);
            $cover->storage = config('filesystems.default');
            $cover->name = Url::fromString($coverFile)->getBasename();
            $cover->save();

            $conference->cover_id = $cover->id;
        }

        if (trim($request->get('file')) != '') {
            $conference->file()->delete();

            $disk = Storage::disk('public');
            $recordFile = $request->get('file');
            $stream = $disk->getDriver()->readStream($recordFile);

            $file = new File();
            $file->open($stream, Url::fromString($recordFile)->getExtension());
            $file->storage = config('filesystems.default');
            $file->name = Url::fromString($recordFile)->getBasename();
            $file->save();

            $conference->file_id = $file->id;
        }

        $conference->save();

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
