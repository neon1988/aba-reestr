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
        Schema::create('webinar_subscriptions', function (Blueprint $table) {
            $table->id(); // ID подписки
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Внешний ключ на таблицу пользователей
            $table->foreignId('webinar_id')->constrained()->onDelete('cascade'); // Внешний ключ на таблицу вебинаров
            $table->timestamp('subscribed_at')->useCurrent(); // Время подписки
            $table->timestamps(); // Стандартные поля created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webinar_subscriptions');
    }
};
