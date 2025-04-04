<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->renameColumn('stream_url', 'registration_url');
        });
    }

    public function down(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->renameColumn('registration_url', 'stream_url');
        });
    }
};

