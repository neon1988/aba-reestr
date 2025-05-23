<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\SoftDeletes;

class CleanupTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purge:temp {model} {days=7 : Number of days after which records should be permanently deleted}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаляет не использованные temp файлы';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $modelClass = $this->argument('model');
        $days = (int)$this->argument('days');

        if (!class_exists($modelClass)) {
            $this->error("Model $modelClass does not exist.");
            return Command::FAILURE;
        }

        if (!in_array(SoftDeletes::class, class_uses_recursive($modelClass))) {
            $this->error("Model $modelClass does not use SoftDeletes.");
            return Command::FAILURE;
        }

        // Определите время, после которого записи должны быть удалены
        $thresholdDate = Carbon::now()->subDays($days); // Пример: записи старше 30 дней

        $this->info("Starting purge for temp records in $modelClass older than $days days...");

        $modelClass::where('storage', 'temp')
            ->where('created_at', '<', $thresholdDate)
            ->chunkById(100, function ($records) {
                foreach ($records as $record) {
                    $this->item($record);
                }
            });

        $this->info("Temp records older than {$thresholdDate} have been purged.");
        return Command::SUCCESS;
    }

    public function item($record) : bool
    {
        if ($record->storage != 'temp')
            return false;

        $this->info("Deleting record ID {$record->id}...");
        $record->forceDelete();
        return true;
    }
}
