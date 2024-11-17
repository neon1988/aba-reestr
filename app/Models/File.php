<?php

namespace App\Models;

use App\Observers\FileObserver;
use App\Traits\Storable;
use App\Traits\UserCreated;
use Exception;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InvalidArgumentException;
use Litlife\IdDirname\IdDirname;
use Litlife\Url\Url;

#[ObservedBy([FileObserver::class])]
class File extends Model
{
    use SoftDeletes, HasFactory, UserCreated, Storable;

    public function getDirname(): string
    {
        $idDirname = new IdDirname($this->id);
        $dirname = 'files/' . implode('/', $idDirname->getDirnameArrayEncoded());
        $url = (new Url)->withDirname(trim($dirname, '/'));
        return $url->getPath();
    }

    protected mixed $sourceStream = null;

    public function setSourceStream(&$sourceStream): void
    {
        $this->sourceStream = &$sourceStream;
    }

    public function getSourceStream()
    {
        return $this->sourceStream;
    }

    public function open($source, $extension = null)
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
}
