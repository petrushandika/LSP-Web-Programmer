<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artikel extends Model
{
    protected $table = 't_artikel';
    protected $primaryKey = 'id_artikel';
    public $timestamps = false;

    protected $fillable = [
        'judul_artikel',
        'isi_artikel',
        'gambar',
        'tanggal_posting',
        'tanggal_edit',
        'id_admin',
        'status_komentar',
    ];

    protected $dates = [
        'tanggal_posting',
        'tanggal_edit',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function komentars(): HasMany
    {
        return $this->hasMany(Komentar::class, 'id_artikel', 'id_artikel');
    }

    public function komentarsAktif(): HasMany
    {
        return $this->hasMany(Komentar::class, 'id_artikel', 'id_artikel')->where('status_tampil', 1);
    }
}
