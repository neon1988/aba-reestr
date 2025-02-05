<?php

use App\Enums\CurrencyEnum;
use App\Enums\SubscriptionLevelEnum;
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
        Schema::create('purchased_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('activated_at')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->unique()->constrained('payments')->onDelete('cascade');
            $table->smallInteger('days');
            $table->enum('subscription_level', SubscriptionLevelEnum::getValues());
            $table->decimal('amount', 10, 2); // Сумма платежа
            $table->enum('currency', CurrencyEnum::getValues());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchased_subscriptions');
    }
};
