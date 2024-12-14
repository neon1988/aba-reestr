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
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название конференции
            $table->text('description'); // Описание конференции
            $table->timestamp('start_at'); // Дата и время начала
            $table->timestamp('end_at')->nullable(); // Дата и время окончания
            $table->unsignedInteger('cover_id')->nullable(); // Путь к обложке
            $table->unsignedBigInteger('create_user_id');
            $table->timestamps(); // created_at и updated_at
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webinars');
    }
};
