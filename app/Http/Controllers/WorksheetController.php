<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorksheetRequest;
use App\Http\Requests\UpdateWorksheetRequest;
use App\Http\Resources\WorksheetResource;
use App\Models\File;
use App\Models\Image;
use App\Models\Worksheet;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Litlife\Url\Url;

class WorksheetController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection|Factory|View|Application
    {
        $items = Worksheet::with('cover', 'file', 'creator')
            ->paginate(10);

        if ($request->expectsJson()) {
            return WorksheetResource::collection($items);
        }

        return view('worksheets.index', compact('items'));
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
    public function store(StoreWorksheetRequest $request)
    {
        $this->authorize('create', Worksheet::class);

        $user = Auth::user();

        $worksheet = Worksheet::make($request->validated());

        if (trim($request->get('cover')) != '') {
            $disk = Storage::disk('public');
            $cover = $request->get('cover');
            $stream = $disk->getDriver()->readStream($cover);

            $cover = new Image;
            $cover->openImage($stream);
            $cover->storage = config('filesystems.default');
            $cover->name = Url::fromString($cover)->getBasename();
            $cover->save();

            $worksheet->cover_id = $cover->id;
        }

        if (trim($request->get('file')) != '') {
            $disk = Storage::disk('public');
            $path = $request->get('file');

            $stream = $disk->getDriver()->readStream($path);

            $file = new File();
            $file->open($stream, Url::fromString($path)->getExtension());
            $file->storage = config('filesystems.default');
            $file->name = Url::fromString($path)->getBasename();
            $file->save();

            $worksheet->file_id = $file->id;
        }
        $worksheet->creator()->associate($user);
        $worksheet->save();

        if ($request->expectsJson()) {
            return [
                'redirect_to' => route('worksheets.show', compact('worksheet')),
                'worksheet' => new WorksheetResource($worksheet)
            ];
        } else
            return redirect()->route('worksheets.index')
                ->with('success', 'Вебинар успешно добавлен');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Worksheet $worksheet): Factory|Application|View|WorksheetResource
    {
        $worksheet->load('cover', 'file', 'creator');
        if ($request->expectsJson()) {
            return new WorksheetResource($worksheet);
        }
        return view('worksheets.show', ['item' => $worksheet]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Worksheet $worksheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorksheetRequest $request, Worksheet $worksheet)
    {
        if (!$worksheet->id)
            throw new \Exception('Wrong worksheet type');

        $this->authorize('update', $worksheet);

        $worksheet->fill($request->validated());
        $worksheet->save();

        if (trim($request->get('cover')) != '') {
            $worksheet->cover()->delete();

            $disk = Storage::disk('public');
            $coverFile = $request->get('cover');
            $stream = $disk->getDriver()->readStream($coverFile);

            $cover = new Image;
            $cover->openImage($stream);
            $cover->storage = config('filesystems.default');
            $cover->name = Url::fromString($coverFile)->getBasename();
            $cover->save();

            $worksheet->cover_id = $cover->id;
            $worksheet->save();
        }

        if (trim($request->get('file')) != '') {
            $worksheet->file()->delete();

            $disk = Storage::disk('public');
            $path = $request->get('file');
            $stream = $disk->getDriver()->readStream($path);

            $file = new File();
            $file->open($stream, Url::fromString($path)->getExtension());
            $file->storage = config('filesystems.default');
            $file->name = Url::fromString($path)->getBasename();
            $file->save();

            $worksheet->file_id = $file->id;
            $worksheet->save();
        }

        if ($request->expectsJson()) {
            return [
                'redirect_to' => route('worksheets.show', compact('worksheet')),
                'worksheet' => new WorksheetResource($worksheet)
            ];
        } else
            return redirect()
                ->route('worksheets.index')
                ->with('success', 'Объявление успешно обновлено');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Worksheet $worksheet)
    {
        //
    }
}
