<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
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
    public function store(StoreFileRequest $request)
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
                'message' => 'Файл загружен',
                'isImage' => $isImage,
                'mimeType' => $file->getMimeType()
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        //
    }
}
