<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Litlife\Url\Url;

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
}
