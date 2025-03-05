<?php

namespace Tests\Feature\Webinars;

use App\Models\File;
use App\Models\Webinar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebinarModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_mp4_video()
    {
        $file = File::factory()->video();

        $webinar = Webinar::factory()
            ->withFile($file)
            ->create();

        $this->assertTrue($webinar->record_file->isVideo());
        $this->assertTrue($webinar->isVideo());
    }

    public function test_is_pdf_not_video()
    {
        $file = File::factory()->pdf();

        $webinar = Webinar::factory()
            ->withFile($file)
            ->create();

        $this->assertFalse($webinar->record_file->isVideo());
        $this->assertFalse($webinar->isVideo());
    }
}
