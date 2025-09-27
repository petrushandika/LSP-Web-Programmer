# 📚 Dokumentasi Pelatihan LSP Junior Web Programming  

Pelatihan ini bertujuan memberikan pemahaman dan pengalaman praktis bagi peserta dalam mengembangkan aplikasi web menggunakan teknologi modern, dengan fokus pada implementasi best practices, debugging, dan dokumentasi yang baik.

---

## 🗓️ Rangkaian Kegiatan Pelatihan

### 🔹 Sesi 1:  
- ✅ Instalasi Software Tools Pendukung  
- ✅ Implementasi User Interface (UI) Dasar  

### 🔹 Sesi 2:  
- ✅ Pemahaman dan Penggunaan Struktur Data  
- ✅ Menulis Kode dengan Mengikuti Guidelines dan Best Practices  

### 🔹 Sesi 3:  
- ✅ Pengembangan dengan Pemrograman Terstruktur  
- ✅ Pemanfaatan Library atau Komponen Pre-existing  

### 🔹 Sesi 4:  
- ✅ Dokumentasi Kode Program  
- ✅ Proses Debugging dan Troubleshooting  

---

## 🛠️ Tools yang Digunakan  
Pelatihan menggunakan berbagai tools dan software yang umum di industri web programming:  

| **Tools**       | **Kegunaan**                                               |
| --------------- | ----------------------------------------------------------|
| Laravel         | Framework PHP backend                                       |
| MySQL           | Database Relasional                                         |
| Herd            | Local development environment                               |
| Docker          | Containerization untuk konsistensi lingkungan development  |
| Navicat         | GUI manajemen database                                      |
| Trae AI         | AI assistant coding                                         |
| Warp            | Terminal modern                                            |
| Git/GitHub      | Version control dan kolaborasi kode                         |
| Figma           | Desain UI/UX                                               |
| Lucidchart      | Pembuatan diagram alur dan ERD                             |

---

## 🗄️ Struktur Database  
Database utama: `wedding`

---

### Tabel: `users`

| Kolom       | Tipe Data      | Keterangan                     |
| ----------- | -------------- | ------------------------------|
| user_id     | int(5)         | Primary key, ID pengguna       |
| name        | varchar(80)    | Nama lengkap pengguna          |
| username    | varchar(80)    | Username                      |
| password    | varchar(256)   | Password terenkripsi           |
| created_at  | datetime       | Tanggal pembuatan data         |
| updated_at  | datetime       | Tanggal update data            |

---

### Tabel: `catalogues`

| Kolom           | Tipe Data          | Keterangan                       |
| --------------- | ------------------ | ------------------------------- |
| catalogue_id    | int(11)            | Primary key                     |
| image          | varchar(100)       | Path atau URL gambar katalog    |
| package_name   | varchar(256)       | Nama paket                     |
| description    | text               | Deskripsi paket                |
| price          | int(11)            | Harga paket                   |
| status_publish | enum('Y', 'N')     | Status publish katalog         |
| user_id        | int(5)             | ID pengguna pembuat katalog    |
| created_at     | datetime           | Waktu pembuatan data           |
| updated_at     | datetime           | Waktu update data              |

---

### Tabel: `order`

| Kolom         | Tipe Data            | Keterangan                        |
| ------------- | -------------------- | -------------------------------- |
| order_id      | int(11)              | Primary key                     |
| catalogue_id  | int(11)              | ID katalog yang dipesan          |
| name          | varchar(120)         | Nama pemesan                    |
| email         | varchar(256)         | Email pemesan                  |
| phone_number  | varchar(30)          | Nomor telepon pemesan          |
| wedding_date  | date                 | Tanggal pernikahan              |
| status        | enum('requested','approved') | Status pesanan           |
| user_id       | int(5)               | ID pengguna pembuat pesanan     |
| created_at    | datetime             | Tanggal pembuatan data          |
| updated_at    | datetime             | Tanggal update data            |

---

### Tabel: `settings`

| Kolom               | Tipe Data          | Keterangan                         |
| ------------------- | ------------------ | --------------------------------- |
| id                  | int(11)            | Primary key                      |
| website_name        | varchar(256)       | Nama website                    |
| phone_number        | varchar(15)        | Nomor telepon bisnis            |
| email               | varchar(80)        | Email bisnis                   |
| address             | text               | Alamat bisnis                  |
| maps                | text               | Embed maps lokasi              |
| logo                | varchar(80)        | Path/logo website              |
| facebook_url        | varchar(256)       | URL Facebook                  |
| instagram_url       | varchar(256)       | URL Instagram                 |
| youtube_url         | varchar(256)       | URL Youtube                   |
| header_business_hour | varchar(160)       | Jam operasional header         |
| time_business_hour  | text               | Detail jam operasional         |
| created_at          | datetime           | Tanggal pembuatan data         |
| updated_at          | datetime           | Tanggal update data           |

---

## 💡 Best Practices dan Tips Pelatihan

- **Setup Environment dengan Docker dan Herd**  
  Pastikan environment development seragam dan mudah dikelola.
- **Gunakan Version Control Git/GitHub**  
  Rajin melakukan commit dan push dengan pesan yang jelas.
- **Ikuti Coding Guidelines Laravel dan PHP**  
  Supaya kode mudah dipahami dan maintainable.
- **Dokumentasikan setiap fitur dan API**  
  Gunakan tools seperti Lucidchart untuk diagram.
- **Lakukan Debugging secara sistematis**  
  Gunakan log dan breakpoint agar bug cepat ditemukan.
- **Jaga keamanan data user**  
  Gunakan hashing dan validasi input yang ketat.

---

## 📈 Kesimpulan  
Pelatihan ini memberikan pengalaman komprehensif dalam membangun aplikasi web berbasis Laravel dengan struktur yang baik, mengikuti standar industri, serta penggunaan tools modern untuk mendukung workflow development. Dokumentasi ini menjadi panduan lengkap untuk seluruh tahapan pelatihan LSP Junior Web Programming.

---

> **Catatan:**  
> Dokumentasi ini dapat digunakan sebagai acuan saat mengerjakan project, serta sebagai bahan review untuk mempersiapkan ujian kompetensi LSP.

---
