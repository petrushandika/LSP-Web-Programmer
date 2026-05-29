<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Komentar extends Model
{
    protected $table = 't_komentar';
    protected $primaryKey = 'id_komentar';
    public $timestamps = false;

    protected $fillable = [
        'id_artikel',
        'nama_user',
        'email_user',
        'isi_komentar',
        'tanggal_komentar',
        'status_tampil',
    ];

    protected $dates = [
        'tanggal_komentar',
    ];

    public function artikel(): BelongsTo
    {
        return $this->belongsTo(Artikel::class, 'id_artikel', 'id_artikel');
    }
}
