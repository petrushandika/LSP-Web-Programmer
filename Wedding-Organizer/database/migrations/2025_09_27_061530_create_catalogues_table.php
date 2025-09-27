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
        Schema::create('catalogues', function (Blueprint $table) {
            $table->unsignedInteger('catalogue_id')->primary();
            $table->string('image', 100);
            $table->string('package_name', 256);
            $table->text('description');
            $table->unsignedInteger('price');
            $table->enum('status_publish', ['Y', 'N']);
            $table->unsignedInteger('user_id');
            $table->timestamps();
            
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogues');
    }
};
