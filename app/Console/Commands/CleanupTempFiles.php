<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:temp {--days=7 : Удалять файлы старше указанного количества дней}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Рекурсивно удаляет старые файлы и пустые папки в папке temp';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $days = (int)$this->option('days');
        $threshold = now()->subDays($days)->getTimestamp();

        $disk = Storage::disk('public'); // Или другой диск
        $tempPath = 'temp'; // Укажите папку temp
        $deletedFiles = 0;

        if (!$disk->exists($tempPath)) {
            $this->error("Папка '$tempPath' не существует.");
            return Command::SUCCESS;
        }

        // Рекурсивное получение всех файлов и папок
        $files = $disk->allFiles($tempPath);
        $directories = $disk->allDirectories($tempPath);

        // Удаляем файлы старше заданного порога
        foreach ($files as $file) {
            $lastModified = $disk->lastModified($file);
            if ($lastModified < $threshold) {
                $disk->delete($file);
                $this->info("Удалён файл: $file");
                $deletedFiles++;
            }
        }

        // Удаляем пустые папки
        foreach (array_reverse($directories) as $directory) { // Удаляем папки с глубины
            if (empty($disk->files($directory)) && empty($disk->directories($directory))) {
                $disk->deleteDirectory($directory);
                $this->info("Удалена папка: $directory");
            }
        }

        $this->info("Удалено файлов: $deletedFiles");
        return Command::SUCCESS;
    }
}
