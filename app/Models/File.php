<?php

namespace App\Models;

use App\Observers\FileObserver;
use App\Traits\ImageResizable;
use App\Traits\UserCreated;
use Exception;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use Litlife\IdDirname\IdDirname;
use Litlife\Url\Url;

#[ObservedBy([FileObserver::class])]
class File extends Model
{
    use SoftDeletes, HasFactory, UserCreated, ImageResizable;

    protected mixed $sourceStream = null;

    public function getDirname(): string
    {
        $idDirname = new IdDirname($this->id);
        $dirname = 'files/' . implode('/', $idDirname->getDirnameArrayEncoded());
        $url = (new Url)->withDirname(trim($dirname, '/'));
        return $url->getPath();
    }

    public function getSourceStream()
    {
        return $this->sourceStream;
    }

    public function setSourceStream(&$sourceStream): void
    {
        $this->sourceStream = &$sourceStream;
    }

    /**
     * @throws Exception
     */
    public function open($source, $extension = null): void
    {
        if (is_string($source) and is_file($source)) {
            $stream = fopen($source, 'r');
            $this->setSourceStream($stream);
            $source = Url::fromString($source);
            $this->extension = $source->getExtension();

        } elseif (is_resource($source)) {

            if (empty($extension))
                throw new InvalidArgumentException('The file extension is not provided');

            $this->setSourceStream($source);
            $this->extension = $extension;

        } else {
            throw new Exception('File or resource not found');
        }
    }

    /**
     * @throws Exception
     */
    public function moveFromTemp(): void
    {
        if ($this->storage != 'temp')
            throw new Exception('The file is not in temporary storage');

        $sourceStorage = 'temp';
        $sourcePath = $this->dirname . '/' . $this->name;

        // Проверяем, существует ли исходный файл
        if (!Storage::disk($sourceStorage)->exists($sourcePath)) {
            throw new Exception('The source file does not exist in temporary storage');
        }

        // Целевая папка и диск
        $idToDirname = new IdDirname($this->id);
        $targetStorage = 'public';
        $targetDirname = implode('/', $idToDirname->getDirnameArray());
        $targetFilename = $this->name;
        $targetPath = $targetDirname . '/' . $targetFilename;

        // Убедимся, что целевой каталог существует
        if (!Storage::disk($targetStorage)->exists($targetDirname))
            Storage::disk($targetStorage)->makeDirectory($targetDirname);

        // Генерация уникального имени, если файл уже существует
        $extension = Url::fromString($targetFilename)->getExtension();
        $basename = Url::fromString($targetFilename)->getBasename();
        $counter = 1;

        while (Storage::disk($targetStorage)->exists($targetDirname . '/' . $targetFilename)) {
            $targetFilename = $basename . '_' . $counter . ($extension ? '.' . $extension : '');
            $counter++;
        }

        $targetPath = $targetDirname . '/' . $targetFilename;

        // Перемещение файла
        try {
            Storage::disk($sourceStorage)->move($sourcePath, $targetPath);

            // Обновление атрибутов модели
            $this->storage = $targetStorage;
            $this->dirname = $targetDirname;
            $this->name = $targetFilename;
            $this->save();
        } catch (Exception $e) {
            throw new Exception('Failed to move file: ' . $e->getMessage());
        }
    }

    public function isVideo(): bool
    {
        return in_array(mb_strtolower($this->extension), [
            'mp4', 'webm', 'ogg', // наиболее широко поддерживаются в современных браузерах.
            'avi', 'mkv', 'mov', 'wmv', 'flv', 'm4v' // могут потребовать сторонних кодеков или не воспроизводиться в некоторых браузерах.
        ]);
    }
}
