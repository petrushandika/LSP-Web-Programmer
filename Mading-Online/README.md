# Mading Online JeWePe 📰

Platform Mading Online (Majalah Dinding Digital) untuk Sekolah Tinggi JeWePe, dibangun dengan **Laravel 11** dan **Eloquent ORM**.

---

## ✨ Fitur

### Publik
- 🏠 Halaman Utama — Mading populer & terbaru dengan carousel
- 📰 Daftar Artikel — Semua artikel dengan fitur pencarian
- 📄 Detail Artikel — Baca artikel lengkap + komentar
- 💬 Form Komentar — Kirim komentar tanpa login
- 👤 Profil — Halaman profil sekolah

### Admin (Login Required)
- 🔐 Login / Logout
- 📊 Dashboard — Panel admin dengan sidebar
- ✏️ Buat Artikel — Editor artikel dengan CKEditor
- 🗑️ Hapus Artikel
- 🔄 Toggle Komentar — Buka/tutup kolom komentar per artikel
- 💬 Kelola Komentar — Hapus & ubah status tampil komentar
- 📊 Laporan — Laporan jumlah komentar per artikel + cetak

---

## 🛠️ Tech Stack

| | |
|---|---|
| Framework | Laravel 11 |
| ORM | Eloquent |
| Templating | Blade |
| CSS Framework | Bootstrap 5 |
| Text Editor | CKEditor 5 |
| Database | MySQL |
| Auth | Session-based (custom middleware) |

---

## 🚀 Cara Menjalankan

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL

### Setup

```bash
# 1. Clone repo
git clone https://github.com/petrushandika/LSP-Web-Programmer.git
cd LSP-Web-Programmer/Mading-Online

# 2. Install dependencies
composer install

# 3. Copy .env
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Buat database MySQL bernama: db_jewepe
# Sesuaikan .env dengan kredensial database Anda

# 6. Jalankan migration + seeder
php artisan migrate
php artisan db:seed

# 7. Jalankan server
php artisan serve
```

### Kredensial Admin (setelah seeding)

| Email | Password |
|---|---|
| fr_12119481@gmail.com | 123 |
| brian.kang@gmail.com | 123 |

---

## 📁 Struktur Folder

```
Mading-Online/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ArtikelController.php
│   │   │   ├── KomentarController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── LaporanController.php
│   │   │   └── ProfilController.php
│   │   └── Middleware/
│   │       └── AdminAuth.php
│   └── Models/
│       ├── Admin.php
│       ├── Artikel.php
│       └── Komentar.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php
│   │   └── dashboard.blade.php
│   ├── home/index.blade.php
│   ├── artikel/
│   ├── profil/index.blade.php
│   ├── auth/login.blade.php
│   └── dashboard/
└── routes/web.php
```

---

## 🔒 Security Improvements (vs PHP Native)

| Sebelum | Sesudah |
|---|---|
| Password MD5 | Bcrypt (`Hash::make`) |
| Rentan SQL Injection | Eloquent ORM |
| Hardcoded URLs | Named routes |
| Tidak ada CSRF | Laravel CSRF otomatis |
| `$_SESSION` manual | Laravel Session |
| `alert()` JS | Flash messages Blade |

> Project ini adalah bagian dari LSP Web Programmer — migrasi dari PHP native ke Laravel.
