<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecialistCertificate extends Pivot
{
    /** @use HasFactory<\Database\Factories\SpecialistCertificateFactory> */
    use HasFactory, SoftDeletes;
}
