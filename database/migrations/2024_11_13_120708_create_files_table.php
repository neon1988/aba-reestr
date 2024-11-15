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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('storage');
            $table->string('dirname');  // Путь к файлу
            $table->string('name')->nullable();  // Оригинальное имя файла
            $table->string('extension', 10);  // Оригинальное имя файла
            $table->unsignedInteger('size');
            $table->unsignedBigInteger('create_user_id');  // Владелец файла, если пользователь
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
