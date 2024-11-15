<?php

namespace App\Observers;

use App\Models\Image;
use Exception;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Imagick;
use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\DifferenceHash;
use Litlife\Url\Url;

class ImageObserver
{
    /**
     * Listen to the User created event.
     *
     * @param Image $image
     * @return void
     * @throws Exception
     */
    public function creating(Image $image)
    {
        $image->creator()->associate(Auth::user());

        if (empty($image->size))
            $image->size = $image->imagick->getImageLength();

        $image->type = strtolower($image->imagick->getImageFormat());

        if (empty($image->name))
            $image->name = $image->imagick->getImageSignature();

        $image->name = mb_strtolower(Url::fromString($image->name)
            ->withExtension(mb_strtolower($image->imagick->getImageFormat()))
            ->getBasename());

        $image->dirname = '';
        $image->width = $image->imagick->getImageWidth();
        $image->height = $image->imagick->getImageHeight();
    }

    /**
     * @throws Exception
     */
    public function created(Image $image)
    {
        if (empty($image->dirname))
            $image->dirname = $image->getDirname();

        while ($image->isFileExists()) {
            /*
             * Добавляем уникальный набор символов в конце файла, чтобы сделать имя файла уникальным
             */

            $name = Url::fromString($image->name);

            $image->name = $name->withFilename(mb_substr($name->getFilename(), 0, 180))
                ->appendToFilename('_' . uniqid());
        }

        if ($image->isFileExists())
            throw new Exception('File ' . $image->url . ' is storage ' . $image->storage . ' already exists ');

        // пришлось вот сохранять источник файла, а не то что выходит через getImageBlob,
        // так как он сжимает изображение и получается измененный хеш

        if (is_resource($image->source)) {
            rewind($image->source);
            Storage::disk($image->storage)
                ->put($image->dirname . '/' . $image->name, $image->source);
        } elseif (file_exists($image->source)) {
            Storage::disk($image->storage)
                ->putFileAs($image->dirname, new File($image->source), $image->name);
        } else {
            throw new Exception('resource or file not found');
        }

        // уточняем размер и тип

        $image->size = $image->getSize();
        $image->type = strtolower($image->imagick->getImageFormat());

        //$image->unsetEventDispatcher();
        $image->save();
        //Image::unignoreObservableEvents();
    }

    public function deleting(Image $image)
    {
        //Storage::disk($image->storage)->delete($image->dirname . '/' . $image->name);
    }

    public function deleted(Image $image)
    {
        if ($image->isForceDeleting())
            if ($image->isFileExists())
                $image->deleteFile();
    }

}
