<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_artikel', function (Blueprint $table) {
            $table->increments('id_artikel');
            $table->string('judul_artikel', 100);
            $table->longText('isi_artikel');
            $table->text('gambar');
            $table->date('tanggal_posting')->useCurrent();
            $table->date('tanggal_edit')->useCurrent();
            $table->unsignedInteger('id_admin');
            $table->tinyInteger('status_komentar')->default(1);

            $table->foreign('id_admin')->references('id_admin')->on('t_admin')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_artikel');
    }
};
