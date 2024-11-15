<?php

namespace App\Observers;

use App\Models\File;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Litlife\Url\Url;


class FileObserver
{
    /**
     * Listen to the User created event.
     *
     * @param File $file
     * @return void
     * @throws Exception
     */
    public function creating(File $file)
    {
        $file->creator()->associate(Auth::user());
        $file->dirname = '';
        $file->size = 0;
    }

    public function created(File $file)
    {
        if (empty($file->dirname))
            $file->dirname = $file->getDirname();

        while ($file->isFileExists()) {
            $name = Url::fromString($file->name);
            $file->name = $name->withFilename(mb_substr($name->getFilename(), 0, 180))
                ->appendToFilename('_' . uniqid());
        }

        if ($file->isFileExists())
            throw new Exception('File ' . $file->url . ' is storage ' . $file->storage . ' already exists ');

        $stream = $file->getSourceStream();

        if (is_resource($stream)) {
            rewind($stream);
            Storage::disk($file->storage)
                ->put($file->dirname . '/' . $file->name, $stream);
        } elseif (file_exists($stream)) {
            Storage::disk($file->storage)
                ->putFileAs($file->dirname, new \Illuminate\Http\File($stream), $file->name);
        } else {
            throw new Exception('resource or file not found');
        }

        $file->size = $file->getSize();
        $file->save();
    }

    public function deleting(File $file)
    {

    }

    public function deleted(File $file): void
    {
        if ($file->isForceDeleting()) {
            if ($file->isFileExists())
                $file->deleteFile();
        }
    }

    public function restored(File $file)
    {

    }
}
