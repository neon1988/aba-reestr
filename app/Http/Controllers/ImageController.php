<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreImageRequest $request)
    {
        $file = $request->file('file');
        // Вычисляем хэш файла
        $hash = hash_file('crc32', $file->getRealPath());
        $hashPart = substr($hash, 0, 2); // Первые два символа хэша

        // Определяем путь для сохранения
        $directory = "/temp/$hashPart/$hash";
        $filename = fileNameFormat($file->getClientOriginalName());
        $path = "$directory/$filename";

        // Сохраняем файл на указанный диск
        Storage::disk('public')
            ->putFileAs($directory, $file, $filename);

        if (str_starts_with($file->getMimeType(), 'image/')) {
            $isImage = True;
        } else {
            $isImage = False;
        }

        return response()
            ->json([
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'hash' => $hash,
                'message' => 'Изображение загружено',
                'isImage' => $isImage,
                'mimeType' => $file->getMimeType()
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
