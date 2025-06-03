<?php

namespace Feature\File;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FileDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function testInvalidParameter()
    {
        $this->get(route('files.download', ['file' => 'dfsdfsdf.sdfsdf']))
            ->assertNotFound();
    }
}
