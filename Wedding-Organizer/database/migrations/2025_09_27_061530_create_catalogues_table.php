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
            $table->id('catalogue_id');
            $table->string('image', 500);
            $table->string('package_name', 256);
            $table->text('description');
            $table->unsignedInteger('price');
            $table->enum('status_publish', ['Y', 'N']);
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->timestamps();
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
