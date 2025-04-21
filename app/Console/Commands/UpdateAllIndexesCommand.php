<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateAllIndexesCommand extends Command
{
    protected $signature = 'scout:update-all-indexes {--flush}';

    protected $description = 'Обновить все индексы в Scout';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->call('scout:sync-index-settings');

        $models = [
            'App\Models\Center',
            'App\Models\Specialist',
            'App\Models\Bulletin',
            'App\Models\User',
            'App\Models\Worksheet',
            'App\Models\Tag',
        ];

        foreach ($models as $model) {
            if ($this->option('flush'))
                $this->call('scout:flush', ['model' => $model]);
            $this->call('scout:import', ['model' => $model]);
        }

        $this->info('Все индексы обновлены.');
    }
}

