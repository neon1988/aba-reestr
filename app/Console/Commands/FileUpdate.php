<?php

namespace App\Console\Commands;

use App\Models\File;
use Illuminate\Console\Command;

class FileUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:update {id : ID файла}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Пока команда обновляет только размер файла';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = File::find($this->argument('id'));

        if (!$file instanceof File) {
            $this->error(__('Файл не найден'));
            return Command::FAILURE;
        }

        if (!$file->isFileExists()) {
            $this->error(__('Файл '.$file->storage.' '.$file->dirname . '/' . $file->name.' не найден'));
            return Command::FAILURE;
        }

        $file->size = $file->getSize();
        $file->save();

        $this->info(__('Файл обновлен'));

        return Command::SUCCESS;
    }
}
