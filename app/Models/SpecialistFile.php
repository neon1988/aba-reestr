<?php

namespace App\Models;

use App\Traits\HasFilePreview;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecialistFile extends Pivot
{
    use SoftDeletes;
}
