<?php

use App\Enums\CurrencyEnum;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('payment_id');
            $table->enum('payment_provider', PaymentProvider::getValues());
            $table->decimal('amount', 10, 2);
            $table->enum('currency', CurrencyEnum::getValues());
            $table->enum('status', PaymentStatusEnum::getValues());
            $table->string('payment_method')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->unique(['payment_id', 'payment_provider']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
