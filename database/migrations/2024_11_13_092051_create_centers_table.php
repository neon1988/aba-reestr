<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Название центра
            $table->string('legal_name');  // Юридическое название
            $table->string('inn');  // ИНН
            $table->string('kpp')->nullable();
            $table->string('ogrn');  // ОГРН
            $table->string('legal_address');  // Юридический адрес
            $table->string('actual_address');  // Фактический адрес
            $table->string('account_number');  // Расчетный счет
            $table->string('bik');  // БИК
            $table->string('director_position');  // Должность руководителя
            $table->string('director_name');  // ФИО руководителя
            $table->string('acting_on_basis');  // Действует на основании
            $table->string('profile_address_1')->nullable();  // Фактический адрес 1
            $table->string('profile_address_2')->nullable();  // Фактический адрес 2
            $table->string('profile_address_3')->nullable();  // Фактический адрес 3
            $table->string('profile_phone')->nullable();  // Телефон для отображения в профиле
            $table->string('profile_email')->nullable();  // Электронная почта для профиля
            $table->text('services')->nullable();  // Услуги, предоставляемые центром
            $table->text('intensives')->nullable();  // Интенсивы (если платно, можно сделать поле текстом)
            $table->integer('photo_id')->nullable();
            $table->smallInteger('status')->nullable();
            $table->dateTime('status_changed_at')->nullable();
            $table->integer('status_changed_user_id')->nullable();
            $table->unsignedBigInteger('create_user_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('centers');
    }
};
