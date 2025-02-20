<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurgeSoftDeletedRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purge:soft-deleted {model} {days=30 : Number of days after which records should be permanently deleted}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently delete soft-deleted records older than a specified time';

    /**
     * Execute the console command.
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

        $this->info("Starting purge for soft-deleted records in $modelClass older than $days days...");

        $modelClass::onlyTrashed()
            ->where('deleted_at', '<', $thresholdDate)
            ->chunkById(100, function ($records) {
                foreach ($records as $record) {
                    $this->info("Deleting record ID {$record->id}...");
                    $record->forceDelete();
                }
            });

        $this->info("Soft-deleted records older than {$thresholdDate} have been purged.");
        return Command::SUCCESS;
    }
}
