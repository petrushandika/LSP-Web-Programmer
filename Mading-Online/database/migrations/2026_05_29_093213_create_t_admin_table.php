<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_admin', function (Blueprint $table) {
            $table->increments('id_admin');
            $table->string('nama', 25);
            $table->string('email', 50)->unique();
            $table->string('password', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_admin');
    }
};
