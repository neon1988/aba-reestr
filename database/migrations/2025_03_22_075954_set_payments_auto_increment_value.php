<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Установка начального значения AUTO_INCREMENT
     */
    public function up(): void
    {
        if (App::environment() === 'production') {
            DB::statement('ALTER TABLE payments AUTO_INCREMENT = 1000;'); // Устанавливаем начальное значение в 1000
        }
    }

    /**
     * Откат изменений
     */
    public function down(): void
    {

    }
};

