<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Litlife\Url\Url;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class FileController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request): FileResource
    {
        $this->authorize('create', File::class);

        $upload = $request->file('file');
        $stream = fopen($upload, 'r');

        $file = new File();
        $file->open($stream, Url::fromString($upload->getClientOriginalName())->getExtension());
        $file->storage = 'temp';
        $file->name = $upload->getClientOriginalName();
        $file->save();

        return new FileResource($file);
    }

    /**
     * Скачивание файла
     *
     * @param File $file
     * @return Response|RedirectResponse
     * @throws AuthorizationException
     */
    public function download(File $file): Response|RedirectResponse
    {
        $this->authorize('download', $file);

        if ($file->trashed() or !$file->exists())
            return response('File not found.', HttpResponse::HTTP_NOT_FOUND);

        if ($file->storage == 'private') {
            return response('')
                ->header('X-Accel-Redirect', $file->url)
                ->header('Content-Disposition', 'attachment; filename="' . $file->name . '"')
                ->header('Content-Type', 'application/x-force-download');
        } else {
            return redirect()->to($file->url);
        }
    }
}
