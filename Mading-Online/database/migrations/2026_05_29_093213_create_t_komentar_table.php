<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_komentar', function (Blueprint $table) {
            $table->increments('id_komentar');
            $table->unsignedInteger('id_artikel');
            $table->string('nama_user', 25);
            $table->string('email_user', 50);
            $table->string('isi_komentar', 280);
            $table->date('tanggal_komentar')->useCurrent();
            $table->tinyInteger('status_tampil')->default(1);

            $table->foreign('id_artikel')->references('id_artikel')->on('t_artikel')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_komentar');
    }
};
