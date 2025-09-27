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
        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedInteger('order_id')->primary();
            $table->unsignedInteger('catalogue_id');
            $table->string('name', 120);
            $table->string('email', 256);
            $table->string('phone_number', 30);
            $table->date('wedding_date');
            $table->enum('status', ['requested', 'approved']);
            $table->unsignedInteger('user_id');
            $table->timestamps();
            
            $table->foreign('catalogue_id')->references('catalogue_id')->on('catalogues');
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
