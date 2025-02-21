<?php

namespace Tests\Feature\Rules;

use App\Rules\FileExistsOnDiskRule;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\TestCase;

class FileExistsOnDiskRuleTest extends TestCase
{
    public function testValidatesSingleFile()
    {
        Storage::shouldReceive('disk')
            ->with('local')
            ->andReturnSelf();

        Storage::shouldReceive('exists')
            ->with('path/to/file.txt')
            ->andReturn(true);

        $rule = new FileExistsOnDiskRule();

        $rule->validate('file', ['path' => 'path/to/file.txt', 'storage' => 'local'], function ($message) {
            $this->fail("Validation failed unexpectedly with message: $message");
        });

        $this->assertTrue(true);
    }

    public function testValidatesMultipleFiles()
    {
        Storage::shouldReceive('exists')
            ->with('path/to/file1.txt')
            ->andReturn(true);

        Storage::shouldReceive('exists')
            ->with('path/to/file2.txt')
            ->andReturn(true);

        $rule = new FileExistsOnDiskRule();

        $rule->validate('files', [
            ['path' => 'path/to/file1.txt', 'storage' => 'local'],
            ['path' => 'path/to/file2.txt', 'storage' => 'local']
        ], function ($message) {
            $this->fail('Validation should not fail');
        });

        $this->assertTrue(true);
    }

    public function testFailsForNonExistingFile()
    {
        Storage::shouldReceive('disk')
            ->with('local')
            ->andReturnSelf();

        Storage::shouldReceive('exists')
            ->with('path/to/missing_file.txt')
            ->andReturn(false);

        $rule = new FileExistsOnDiskRule();

        $rule->validate('file', ['path' => 'path/to/missing_file.txt', 'storage' => 'local'], function ($message) {
            $this->assertEquals('Файл не найден', $message);
        });
    }

    public function testFailsWhenNoPathOrStorageProvided()
    {
        $rule = new FileExistsOnDiskRule();

        $rule->validate('file', [['name' => '123']], function ($message) {
            $this->assertEquals('Ошибка загрузки файла', $message);
        });
    }

    public function testFailsWhenValueIsNotAnArray()
    {
        $rule = new FileExistsOnDiskRule();

        $rule->validate('file', 'invalid_value', function ($message) {
            $this->assertEquals('Ошибка загрузки файла', $message);
        });
    }
}
