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

    public function getDirname(): string
    {
        $idDirname = new IdDirname($this->id);
        $dirname = 'images/' . implode('/', $idDirname->getDirnameArrayEncoded());
        $url = (new Url)->withDirname(trim($dirname, '/'));
        return $url->getPath();
    }
}
