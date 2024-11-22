<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('role'); // Роль пользователя, например 'admin', 'moderator', 'manager'
            $table->text('settings_access')->nullable(); // Дополнительные привилегии или настройки для роли
            $table->timestamps(); // Время создания и обновления записи
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
