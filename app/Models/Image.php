<?php

namespace App\Models;

use App\Observers\ImageObserver;
use App\Traits\ImageResizable;
use App\Traits\UserCreated;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Litlife\IdDirname\IdDirname;
use Litlife\Url\Url;

#[ObservedBy([ImageObserver::class])]
class Image extends Model
{
    use SoftDeletes, HasFactory, UserCreated, ImageResizable;

    public string $folder = '_i';

    public function getDirname(): string
    {
        $idDirname = new IdDirname($this->id);

        $url = (new Url)->withDirname('images/' . implode('/', $idDirname->getDirnameArrayEncoded()));

        return $url->getPath();
    }
}
