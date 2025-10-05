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
            $table->id('order_id');
            $table->foreignId('catalogue_id')->constrained('catalogues', 'catalogue_id');
            $table->string('name', 120);
            $table->string('email', 256);
            $table->string('phone_number', 30);
            $table->date('wedding_date');
            $table->enum('status', ['requested', 'approved']);
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->timestamps();
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
