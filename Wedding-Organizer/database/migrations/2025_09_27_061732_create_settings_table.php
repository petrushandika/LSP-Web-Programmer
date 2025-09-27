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
        Schema::create('settings', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('website_name', 256);
            $table->string('phone_number', 15);
            $table->string('email', 80);
            $table->text('address');
            $table->text('maps');
            $table->string('logo', 80);
            $table->string('facebook_url', 256);
            $table->string('instagram_url', 256);
            $table->string('youtube_url', 256);
            $table->string('header_business_hour', 160);
            $table->text('time_business_hour');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
