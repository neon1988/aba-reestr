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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('storage');  // Путь к файлу изображения
            $table->string('dirname');  // Имя файла
            $table->string('filename');  // Тип файла (например, jpg, png)
            $table->integer('width');
            $table->integer('height');
            $table->unsignedBigInteger('create_user_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
