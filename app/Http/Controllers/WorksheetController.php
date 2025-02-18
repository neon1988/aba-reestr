<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorksheetRequest;
use App\Http\Requests\UpdateWorksheetRequest;
use App\Http\Resources\WorksheetResource;
use App\Models\File;
use App\Models\Worksheet;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorksheetController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection|Factory|View|Application
    {
        $extension = $request->get('extension');

        $items = Worksheet::search($request->input('search'))
            ->when($extension, function ($query, $extension) {
                return $query->where('extension', $extension);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(9)
            ->withQueryString();

        $items->load('cover', 'file', 'creator');

        if ($request->expectsJson()) {
            return WorksheetResource::collection($items);
        }

        return view('worksheets.index', compact('items', 'extension'));
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

        $worksheet = DB::transaction(function () use ($request) {
            $user = Auth::user();

            $worksheet = Worksheet::make($request->validated());

            if ($upload = $request->get('cover')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'public';
                        $file->save();
                        $worksheet->cover_id = $file->id;
                    }
                }
            }

            if ($upload = $request->get('file')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'private';
                        $file->save();
                        $worksheet->file_id = $file->id;
                    }
                }
            }

            $worksheet->creator()->associate($user);
            $worksheet->save();
            return $worksheet;
        });

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
     * Update the specified resource in storage.
     */
    public function update(UpdateWorksheetRequest $request, Worksheet $worksheet)
    {
        if (!$worksheet->id)
            throw new \Exception('Wrong worksheet type');

        $this->authorize('update', $worksheet);

        $worksheet = DB::transaction(function () use ($request, $worksheet) {

            $worksheet->fill($request->validated());
            $worksheet->save();

            if ($upload = $request->get('cover')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $worksheet->cover()->delete();
                        $file->storage = 'public';
                        $file->save();
                        $worksheet->cover_id = $file->id;
                        $worksheet->save();
                    }
                }
            }

            if ($upload = $request->get('file')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $worksheet->file()->delete();
                        $file->storage = 'public';
                        $file->save();
                        $worksheet->file_id = $file->id;
                        $worksheet->save();
                    }
                }
            }

            return $worksheet;
        });

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
        $this->authorize('delete', $worksheet);

        if ($worksheet->trashed())
            $worksheet->restore();
        else
            $worksheet->delete();

        return new WorksheetResource($worksheet);
    }

    public function download(Worksheet $worksheet)
    {
        $this->authorize('download', $worksheet);

        $file = $worksheet->file;

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
