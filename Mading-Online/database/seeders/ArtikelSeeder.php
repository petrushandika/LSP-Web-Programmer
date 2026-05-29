<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        Artikel::insert([
            [
                'id_artikel'      => 1,
                'judul_artikel'   => 'Web Framework: Bootstrap 5',
                'isi_artikel'     => '<blockquote><p>The most popular HTML, CSS, and JavaScript framework for developing responsive, mobile first projects on the web.</p></blockquote><h1>What\'s Bootstrap?</h1><p>Bootstrap is the world\'s most powerful, extensible, and feature-packed frontend toolkit.</p>',
                'gambar'          => 'https://getbootstrap.com/docs/5.3/assets/img/bootstrap-icons.png',
                'tanggal_posting' => '2023-06-16',
                'tanggal_edit'    => '2023-06-16',
                'id_admin'        => 1,
                'status_komentar' => 1,
            ],
            [
                'id_artikel'      => 3,
                'judul_artikel'   => 'Android UI Toolkit: Jetpack Compose',
                'isi_artikel'     => '<blockquote><p>Build better apps faster with Jetpack Compose.</p></blockquote><h1>What\'s Jetpack Compose?</h1><p>Jetpack Compose is Android\'s recommended modern toolkit for building native UI.</p>',
                'gambar'          => 'https://developer.android.com/static/codelabs/jetpack-compose-animation/img/5bb2e531a22c7de0.png',
                'tanggal_posting' => '2023-06-16',
                'tanggal_edit'    => '2023-06-16',
                'id_admin'        => 1,
                'status_komentar' => 1,
            ],
            [
                'id_artikel'      => 4,
                'judul_artikel'   => 'Basic Cyber Security #1: Kali Linux',
                'isi_artikel'     => '<blockquote><p>The most advanced Penetration Testing Distribution. Ever.</p></blockquote><h1>The Industry Standard</h1><p>Kali Linux is not about its tools, nor the operating system. Kali Linux is a <strong>platform</strong>.</p>',
                'gambar'          => 'https://www.anti-malware.ru/files/styles/amp_image/public/images/source/kali_linux_2022.3_news.png',
                'tanggal_posting' => '2023-06-16',
                'tanggal_edit'    => '2023-06-16',
                'id_admin'        => 2,
                'status_komentar' => 1,
            ],
            [
                'id_artikel'      => 19,
                'judul_artikel'   => 'Pengumuman UAS',
                'isi_artikel'     => '<p>Jangan lupa</p><h2>!!! UAS: 31 JULI - 12 AGUSTUS 2023 !!!</h2><p>Harap pengumuman ini diperhatikan dan disimak dengan baik. Terima kasih</p>',
                'gambar'          => 'none',
                'tanggal_posting' => '2023-06-17',
                'tanggal_edit'    => '2023-06-17',
                'id_admin'        => 1,
                'status_komentar' => 1,
            ],
        ]);
    }
}
