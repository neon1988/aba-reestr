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
        Schema::create('center_file', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained()->onDelete('cascade'); // внешнее ключ на таблицу users
            $table->foreignId('file_id')->constrained()->onDelete('cascade'); // внешнее ключ на таблицу files
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['center_id', 'file_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('center_file');
    }
};
