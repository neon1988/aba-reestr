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
            $table->string('inn')->unique();  // ИНН
            $table->string('kpp')->nullable();  // КПП (при наличии)
            $table->string('country');
            $table->string('region')->nullable();
            $table->string('city');
            $table->string('phone');
            $table->text('services')->nullable();  // Услуги, предоставляемые центром
            $table->text('intensives')->nullable();  // Интенсивы (если платно, можно сделать поле текстом)
            $table->integer('photo_id')->nullable();
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
