<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Komentar;

class KomentarSeeder extends Seeder
{
    public function run(): void
    {
        $komentars = [
            ['id_komentar' => 1,  'id_artikel' => 1,  'nama_user' => 'Anonim',    'email_user' => 'ayaya@mail.com',  'isi_komentar' => 'pertamax gan',              'tanggal_komentar' => '2023-06-17', 'status_tampil' => 1],
            ['id_komentar' => 2,  'id_artikel' => 1,  'nama_user' => 'adudu',     'email_user' => 'adudu@mail.com',  'isi_komentar' => 'keren kak!',                'tanggal_komentar' => '2023-06-17', 'status_tampil' => 1],
            ['id_komentar' => 3,  'id_artikel' => 1,  'nama_user' => 'boboiboy',  'email_user' => 'bobo@mail.com',   'isi_komentar' => 'terbaik!👍',                'tanggal_komentar' => '2023-06-17', 'status_tampil' => 1],
            ['id_komentar' => 4,  'id_artikel' => 1,  'nama_user' => 'aku siapa?','email_user' => 'gtw@mail.com',    'isi_komentar' => 'nyimak kak',                'tanggal_komentar' => '2023-06-17', 'status_tampil' => 1],
            ['id_komentar' => 5,  'id_artikel' => 1,  'nama_user' => 'spammer',   'email_user' => 'spam@mail.com',   'isi_komentar' => 'Lorem ipsum ayayayayayay',  'tanggal_komentar' => '2023-06-17', 'status_tampil' => 1],
            ['id_komentar' => 17, 'id_artikel' => 19, 'nama_user' => 'mhs',       'email_user' => 'gtw@mail.com',    'isi_komentar' => 'nooooo:(((',                'tanggal_komentar' => '2023-06-17', 'status_tampil' => 1],
            ['id_komentar' => 19, 'id_artikel' => 4,  'nama_user' => 'Anonim',    'email_user' => 'gtw@mail.com',    'isi_komentar' => 'wih keren kak',             'tanggal_komentar' => '2023-06-18', 'status_tampil' => 1],
            ['id_komentar' => 20, 'id_artikel' => 4,  'nama_user' => 'aku siapa?','email_user' => 'ayaya@mail.com',  'isi_komentar' => 'ajarin ak jd heker donk min','tanggal_komentar' => '2023-06-18', 'status_tampil' => 1],
            ['id_komentar' => 24, 'id_artikel' => 19, 'nama_user' => 'aku siapa?','email_user' => 'gtw@mail.com',    'isi_komentar' => 'online atau offline min?',  'tanggal_komentar' => '2023-06-18', 'status_tampil' => 1],
            ['id_komentar' => 29, 'id_artikel' => 19, 'nama_user' => 'test',      'email_user' => 'test@mail.com',   'isi_komentar' => 'halo',                      'tanggal_komentar' => '2024-03-30', 'status_tampil' => 1],
        ];

        Komentar::insert($komentars);
    }
}
