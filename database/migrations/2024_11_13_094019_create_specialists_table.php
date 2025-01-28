<?php

use App\Enums\EducationEnum;
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
            $table->string('name');
            $table->string('lastname');
            $table->string('middlename')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->enum('education', EducationEnum::getValues());
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('center_id')->nullable();  // Связь с центром (если работает в центре)
            $table->boolean('is_available')->default(true);  // Доступность специалиста
            $table->integer('photo_id')->nullable();
            $table->unsignedBigInteger('create_user_id');
            $table->smallInteger('status')->nullable();
            $table->dateTime('status_changed_at')->nullable();
            $table->integer('status_changed_user_id')->nullable();
            $table->string('center_name')->nullable();
            $table->string('curator')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('professional_interests')->nullable();
            $table->boolean('show_email')->default(false);
            $table->boolean('show_phone')->default(false);
            $table->string('telegram_profile', 50)->nullable();
            $table->string('vk_profile', 50)->nullable();
            $table->text('aba_education')->nullable();
            $table->text('aba_trainings')->nullable();
            $table->text('professional_specialization')->nullable();
            $table->text('additional_info')->nullable();
            $table->boolean('has_available_hours')->default(true);
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
