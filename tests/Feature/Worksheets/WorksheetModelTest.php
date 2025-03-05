<?php

namespace Tests\Feature\Worksheets;

use App\Models\File;
use App\Models\Webinar;
use App\Models\Worksheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorksheetModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_mp4_video()
    {
        $file = File::factory()->video();

        $worksheet = Worksheet::factory()
            ->withFile($file)
            ->create();

        $this->assertTrue($worksheet->file->isVideo());
        $this->assertTrue($worksheet->isVideo());
    }

    public function test_is_pdf_not_video()
    {
        $file = File::factory()->pdf();

        $worksheet = Worksheet::factory()
            ->withFile($file)
            ->create();

        $this->assertFalse($worksheet->file->isVideo());
        $this->assertFalse($worksheet->isVideo());
    }
}
