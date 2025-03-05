<?php

namespace Tests\Feature\Conferences;

use App\Models\Conference;
use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConferenceModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_mp4_video()
    {
        $file = File::factory()->video();

        $conference = Conference::factory()
            ->withFile($file)
            ->create();

        $this->assertTrue($conference->file->isVideo());
        $this->assertTrue($conference->isVideo());
    }

    public function test_is_pdf_not_video()
    {
        $file = File::factory()->pdf();

        $conference = Conference::factory()
            ->withFile($file)
            ->create();

        $this->assertFalse($conference->file->isVideo());
        $this->assertFalse($conference->isVideo());
    }
}
