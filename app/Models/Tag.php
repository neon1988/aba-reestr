<?php

namespace App\Models;

use Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    /** @use HasFactory<TagFactory> */
    use HasFactory, Searchable;

    public $fillable = ['name'];

    public function worksheets(): BelongsToMany
    {
        return $this->belongsToMany(Worksheet::class);
    }
}
