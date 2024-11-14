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
        Schema::create('specialists', function (Blueprint $table) {
            $table->id();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('country');
            $table->string('region')->nullable();
            $table->string('city');
            $table->string('education');
            $table->string('phone');
            $table->unsignedBigInteger('center_id')->nullable();  // Связь с центром (если работает в центре)
            $table->boolean('is_available')->default(true);  // Доступность специалиста
            $table->integer('photo_id')->nullable();
            $table->unsignedBigInteger('create_user_id');
            $table->smallInteger('status')->nullable();
            $table->dateTime('status_changed_at')->nullable();
            $table->integer('status_changed_user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Связь с центром, если указан
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialists');
    }
};
