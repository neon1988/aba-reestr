<?php

namespace App\Observers;

use App\Models\File;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
    public function creating(File $file): void
    {
        if (!$file->creator instanceof User)
            $file->creator()->associate(Auth::user());

        $file->dirname = '';
        $file->size = 0;
    }

    public function created(File $file): void
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

        rewind($file->getSourceStream());

        Storage::disk($file->storage)
            ->put($file->dirname . '/' . $file->name, $file->getSourceStream());

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
