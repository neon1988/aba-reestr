<?php

namespace App\Traits;

use App\Models\File;
use Illuminate\Support\Facades\DB;

trait HasFilePreview
{
    use Storable;

    public function getFileIdColumn(): string
    {
        return 'file_id';
    }

    public function getPreviewFileIdColumn(): string
    {
        return 'preview_file_id';
    }

    public function file()
    {
        return $this->belongsTo(File::class, $this->getFileIdColumn());
    }

    public function preview_file()
    {
        return $this->belongsTo(File::class, $this->getPreviewFileIdColumn());
    }

    public function updatePreview()
    {
        DB::transaction(function () {
            $file = $this->file;

            $this->{$this->getPreviewFileIdColumn()} = $this->{$this->getFileIdColumn()};

            if ($file->extension == 'pdf') {

            }

            $this->save();
        });
    }
}
