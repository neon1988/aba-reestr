<?php

use App\Enums\PaymentProvider;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!\Illuminate\Support\Facades\App::environment('testing'))
        {
            // Используем SQL запрос с явным преобразованием данных
            DB::statement("
                ALTER TABLE payments
                ALTER COLUMN payment_provider TYPE smallint
                USING payment_provider::smallint
            ");

            // Если нужно, добавьте другие изменения
            DB::statement("ALTER TABLE payments ALTER COLUMN payment_provider SET NOT NULL");

            DB::statement("alter table payments drop constraint if exists payments_payment_provider_check;");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
