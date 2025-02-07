<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;

class ImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request)
    {
        $upload = $request->file('file');

        $file = new Image();
        $file->open($upload);
        $file->storage = 'temp';
        $file->name = $upload->getClientOriginalName();
        $file->save();

        return new ImageResource($file);
    }
}
