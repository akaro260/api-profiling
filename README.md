<div align="center">

# API Profiling

**Open-source REST API untuk profil pengguna, berita, tugas, dan materi pembelajaran.**

Dibangun dengan Laravel — bebas dipelajari, digunakan, dikembangkan, dan dikustomisasi sesuai kebutuhan.

</div>

API Profiling adalah proyek **open source** yang ditujukan untuk komunitas developer. Kamu dapat mempelajari kode, menyesuaikan struktur database, menambah endpoint, mengubah role, dan mengembangkan fitur sesuai kebutuhan proyekmu.

> **Status proyek:** Dalam pengembangan. Ide, laporan bug, perbaikan, dan kontribusi fitur dipersilakan. Hak penggunaan, modifikasi, dan distribusi mengikuti lisensi yang dipilih dan disertakan di repository.

REST API berbasis **Laravel** untuk mengelola profil pengguna dan data pendukung sekolah/organisasi, meliputi berita, tugas, dan library pembelajaran. API menggunakan MySQL sebagai database bawaan (dapat disesuaikan melalui konfigurasi Laravel) serta Laravel Sanctum untuk autentikasi token dan middleware role untuk pembatasan akses.

> **Status proyek:** Dalam pengembangan. Endpoint atau fitur dapat bertambah dan dokumentasi ini bisa diperbarui mengikuti perubahan kode.

## Daftar Isi

- [Fitur](#fitur)
- [Teknologi](#teknologi)
- [Struktur Folder](#struktur-folder)
- [Struktur Database](#struktur-database)
- [Role dan Hak Akses](#role-dan-hak-akses)
- [Instalasi](#instalasi)
- [Menjalankan API](#menjalankan-api)
- [Autentikasi](#autentikasi)
- [Daftar Endpoint](#daftar-endpoint)
- [Contoh Request](#contoh-request)
- [Catatan Pengembangan](#catatan-pengembangan)

## Tentang Open Source

API Profiling dibuat agar bisa digunakan dan dikembangkan bersama. Kamu dapat:

- Menggunakan proyek ini sebagai dasar proyek pribadi, sekolah, komunitas, atau eksperimen.
- Mempelajari controller, middleware, validasi request, autentikasi, dan route Laravel.
- Mengubah database, field, role, endpoint, serta integrasi sesuai kebutuhan.
- Menambahkan fitur sendiri dan berbagi perbaikan dengan pengguna lain.

### Cara mengembangkan proyek

1. Fork atau clone repository.
2. Buat branch baru untuk perubahanmu.
3. Ubah kode sesuai kebutuhan.
4. Jalankan migration dan tes API untuk memeriksa hasil perubahan.
5. Jika ingin berkontribusi ke repository utama, ajukan pull request atau diskusikan perubahan terlebih dahulu.

**Catatan lisensi:** agar orang lain jelas mengetahui izin penggunaan, modifikasi, dan distribusi, tambahkan file `LICENSE` ke repository. Kamu bisa mempertimbangkan lisensi open source seperti MIT atau Apache-2.0. Jangan menyatakan proyek sudah memakai lisensi tertentu sebelum file lisensinya benar-benar tersedia. Jika belum memilih, tulis bahwa lisensi masih akan ditentukan.

## Fitur

- Autentikasi dan pengelolaan sesi/token menggunakan Laravel Sanctum.
- Pengelolaan akun pengguna oleh admin.
- CRUD berita.
- CRUD link pembelajaran (library).
- CRUD tugas.
- Pembatasan akses berdasarkan role: `admin`, `osis`, `guru`, dan `siswa`.
- Validasi input melalui Laravel.
- Respons API berbentuk JSON.

## Teknologi

- PHP
- Laravel
- MySQL (dapat diganti melalui konfigurasi database Laravel)
- Laravel Sanctum
- Composer
- Postman atau REST client lain untuk pengujian endpoint

Versi PHP/Laravel mengikuti versi yang terpasang di lingkungan proyek.

## Struktur Folder

Berdasarkan struktur proyek saat ini:

```text
app/
└── Http/
    ├── Controllers/
    │   ├── Auth/
    │   │   ├── AuthenticatedSessionController.php
    │   │   ├── EmailVerificationNotificationController.php
    │   │   ├── NewPasswordController.php
    │   │   ├── PasswordResetLinkController.php
    │   │   ├── RegisteredUserController.php
    │   │   └── VerifyEmailController.php
    │   ├── BeritaController.php
    │   ├── LibraryController.php
    │   ├── TugasController.php
    │   └── UserController.php
    ├── Middleware/
    │   ├── EnsureEmailsVerified.php
    │   └── RoleMiddleware.php
    └── Requests/
        ├── Auth/
        ├── tugas/
        ├── StoreBeritaRequest.php
        ├── StoreLibrary.php
        ├── UpdatedBerita.php
        ├── UpdatedLibrary.php
        ├── StoreTugasRequest.php
        └── UpdatedTugas.php
```

Nama file pada proyek harus tetap konsisten dengan nama class dan pemanggilannya. Contohnya, pastikan nama request seperti `StoreLibrary.php` sesuai dengan class yang digunakan controller.

## Struktur Database

Struktur berikut adalah gambaran skema yang direncanakan/dituliskan untuk proyek. Sesuaikan nama kolom, tipe data, foreign key, dan timestamp dengan migration yang benar-benar digunakan.

### Tabel `users`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT / INT | Primary key |
| `user` | VARCHAR(255) | Nama/username pengguna |
| `email` | VARCHAR(255) | Email unik |
| `role` | VARCHAR(30) | `admin`, `osis`, `guru`, atau `siswa` |
| `password` | VARCHAR | Password yang sudah di-hash |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diperbarui |

> Laravel secara default menggunakan tabel `users` dan kolom `name`. Jika proyek memakai kolom `user`, pastikan model `User` dan proses autentikasi sudah disesuaikan.

### Tabel `berita`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | INT / BIGINT | Primary key |
| `user_id` | INT / BIGINT | Relasi ke `users.id` |
| `judul` | VARCHAR(255) | Judul berita |
| `isian` | LONGTEXT | Isi berita |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diperbarui |

### Tabel `tugas`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | INT / BIGINT | Primary key |
| `user_id` | INT / BIGINT | Relasi ke `users.id` |
| `nama_tugas` | VARCHAR(255) | Nama tugas |
| `link_tugas` | VARCHAR / TEXT | Tautan tugas |
| `kategori_tugas` | VARCHAR | Kategori tugas |

Tambahkan `created_at` dan `updated_at` apabila migration/model menggunakan timestamps.

### Tabel `library`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | INT / BIGINT | Primary key |
| `user_id` | INT / BIGINT | Relasi ke `users.id` |
| `link_pembelajaran` | VARCHAR / TEXT | Tautan materi pembelajaran |
| `kategori` | VARCHAR | Kategori materi |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diperbarui |

### Relasi

```text
users.id  1 ───── N  berita.user_id
users.id  1 ───── N  tugas.user_id
users.id  1 ───── N  library.user_id
```

Satu pengguna dapat membuat banyak berita, tugas, atau item library. Pastikan foreign key pada migration memakai tipe yang kompatibel dengan `users.id`.

## Role dan Hak Akses

| Fitur | Role yang diizinkan | Autentikasi |
|---|---|---|
| Melihat berita (`GET /api/berita`) | Publik | Tidak wajib |
| Melihat detail berita (`GET /api/berita/{id}`) | Publik | Tidak wajib |
| Membuat/mengubah/menghapus berita | `admin`, `osis`, `guru` | Sanctum |
| Melihat library | Semua role yang sudah login | Sanctum |
| Membuat/mengubah/menghapus library | `admin`, `osis`, `guru` | Sanctum |
| Melihat tugas | `siswa`, `osis` | Sanctum |
| Membuat/mengubah/menghapus tugas | `admin`, `guru` | Sanctum |
| Membuat/mengubah/menghapus akun pengguna | `admin` | Sanctum |

Role diperiksa oleh `RoleMiddleware`. Pastikan middleware alias `role` telah didaftarkan di `bootstrap/app.php`. Nama role pada database harus sama persis dengan yang dipakai di route.

## Instalasi

Panduan ini ditujukan untuk instalasi lokal di Windows menggunakan Laragon atau lingkungan PHP/MySQL lain. Jika proyek sudah tersedia di komputer, mulai dari langkah 3.

### 1. Instal kebutuhan

Pastikan perangkat sudah memiliki PHP yang sesuai dengan versi Laravel proyek, Composer, MySQL/MariaDB (misalnya melalui Laragon), serta Postman (opsional untuk pengujian API). Periksa instalasi melalui terminal:

```bash
php -v
composer -V
```

### 2. Ambil atau buka proyek

Jika proyek berada di repository Git, clone repository menggunakan URL milik proyek:

```bash
git clone URL_REPOSITORY
cd NAMA_FOLDER_PROYEK
```

Ganti `URL_REPOSITORY` dan `NAMA_FOLDER_PROYEK` dengan informasi yang benar. Jika folder proyek sudah ada, cukup buka terminal pada folder tersebut.

### 3. Instal dependency Laravel

```bash
composer install
```

Tunggu sampai Composer selesai. Jika muncul error versi PHP atau ekstensi, periksa versi PHP aktif dan ekstensi yang dibutuhkan proyek.

### 4. Siapkan file environment

Jika `.env` belum ada, salin `.env.example` menjadi `.env`. Di PowerShell Windows:

```powershell
Copy-Item .env.example .env
```

Di Git Bash/Linux/macOS:

```bash
cp .env.example .env
```

Jangan unggah `.env` yang berisi password, token, atau rahasia aplikasi ke repository publik.

### 5. Buat database dan atur koneksi

Jalankan MySQL melalui Laragon atau layanan database yang digunakan. Buat database, misalnya `Api-proyek`, melalui phpMyAdmin atau MySQL client. Kemudian sesuaikan `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Api-proyek
DB_USERNAME=root
DB_PASSWORD=
```

Contoh ini mengasumsikan MySQL lokal dengan user `root` tanpa password. Ubah username dan password sesuai konfigurasi komputermu. Nama database boleh diganti asalkan database sudah dibuat dan namanya sesuai dengan `.env`.

### 6. Buat application key

```bash
php artisan key:generate
```

Perintah ini mengisi `APP_KEY` di `.env`.

### 7. Periksa migration dan siapkan database

Periksa file di `database/migrations` dan pastikan skemanya sesuai dengan model serta controller proyek. Setelah itu jalankan:

```bash
php artisan migrate
```

Jika proyek membutuhkan data awal, periksa seeder yang tersedia sebelum menjalankannya. **Jangan menjalankan `php artisan migrate:fresh` pada database yang berisi data penting**, karena perintah tersebut menghapus seluruh tabel lalu membuatnya kembali.

### 8. Periksa autentikasi dan middleware

Pastikan Laravel Sanctum sudah terpasang dan dikonfigurasi sesuai versi proyek. Periksa juga hal berikut:

- Model `User` menggunakan konfigurasi Sanctum yang diperlukan, seperti trait `HasApiTokens` jika memakai personal access token.
- Alias middleware `role` sudah didaftarkan di `bootstrap/app.php`.
- Nilai role di database sesuai dengan route, misalnya `admin`, `osis`, `guru`, dan `siswa`.
- Route login tersedia dan metode autentikasi sesuai dengan konfigurasi proyek.

Jika Sanctum belum terpasang, periksa `composer.json` dan konfigurasi proyek terlebih dahulu, lalu ikuti instruksi instalasi yang sesuai dengan versi Laravel yang digunakan.

### 9. Jalankan server API

```bash
php artisan serve --port=8000
```

Base URL lokal:

```text
http://127.0.0.1:8000
```

Endpoint API biasanya menggunakan prefix `/api`, contohnya `http://127.0.0.1:8000/api/berita`.

### 10. Periksa route dan uji API

Lihat daftar route API:

```bash
php artisan route:list --path=api
```

Buka Postman dan uji endpoint publik, misalnya `GET http://127.0.0.1:8000/api/berita`. Untuk endpoint yang memakai `auth:sanctum`, lakukan login terlebih dahulu dan kirim token atau cookie sesuai metode autentikasi proyek.

Jika konfigurasi berubah tetapi aplikasi masih memakai cache lama, jalankan:

```bash
php artisan optimize:clear
```

Instalasi dapat dianggap selesai jika migration berjalan tanpa error, server dapat dijalankan, route API terdaftar, dan endpoint bisa diuji sesuai hak aksesnya.

## Menjalankan API

Jalankan server pengembangan:

```bash
php artisan serve --port=8000
```

Secara default, base URL lokal:

```text
http://127.0.0.1:8000
```

Endpoint API Laravel biasanya memakai prefix `/api`, sehingga contoh endpoint berita adalah:

```text
http://127.0.0.1:8000/api/berita
```

Untuk melihat route yang terdaftar:

```bash
php artisan route:list --path=api
```

## Autentikasi

Endpoint yang menggunakan `auth:sanctum` membutuhkan autentikasi yang sesuai dengan konfigurasi Sanctum.

Untuk penggunaan personal access token di Postman:

1. Lakukan login melalui endpoint autentikasi yang tersedia di proyek.
2. Salin token dari respons login jika endpoint tersebut mengembalikannya.
3. Pilih **Authorization → Bearer Token** di Postman.
4. Masukkan token.
5. Kirim request ke endpoint yang dilindungi.

Contoh header:

```http
Accept: application/json
Authorization: Bearer TOKEN_ANDA
```

Jangan membagikan token atau menyimpan password dalam bentuk teks biasa. Password harus di-hash sebelum disimpan.

## Daftar Endpoint

Semua path berikut adalah path relatif terhadap `/api`.

| Method | Endpoint | Kegunaan | Akses |
|---|---|---|---|
| GET | `/user` | Mendapatkan data pengguna yang login | Login |
| GET | `/berita` | Daftar berita | Publik |
| GET | `/berita/{id}` | Detail berita | Publik |
| POST | `/berita` | Membuat berita | `admin`, `osis`, `guru` |
| PUT | `/berita/{id}` | Mengubah berita | `admin`, `osis`, `guru` |
| DELETE | `/berita/{id}` | Menghapus berita | `admin`, `osis`, `guru` |
| GET | `/library` | Daftar library | Login |
| GET | `/library/{id}` | Detail library | Login |
| POST | `/library` | Menambahkan library | `admin`, `osis`, `guru` |
| PUT | `/library/{id}` | Mengubah library | `admin`, `osis`, `guru` |
| DELETE | `/library/{id}` | Menghapus library | `admin`, `osis`, `guru` |
| GET | `/tugas` | Daftar tugas | `siswa`, `osis` |
| GET | `/tugas/{id}` | Detail tugas | `siswa`, `osis` |
| POST | `/tugas` | Membuat tugas | `admin`, `guru` |
| PUT | `/tugas/{id}` | Mengubah tugas | `admin`, `guru` |
| DELETE | `/tugas/{id}` | Menghapus tugas | `admin`, `guru` |
| POST | `/user` | Membuat akun pengguna | `admin` |
| PUT | `/user/{id}` | Mengubah akun berdasarkan ID | `admin` |
| DELETE | `/user/{id}` | Menghapus akun berdasarkan ID | `admin` |

Route autentikasi lain seperti register, login, reset password, dan logout dapat tersedia melalui file route auth yang disertakan oleh proyek. Periksa `routes/auth.php` untuk daftar lengkapnya.

## Contoh Request

Contoh berikut menggunakan JSON. Sesuaikan field dengan validasi dan resource controller di versi kode yang aktif.

### Membuat berita

`POST /api/berita`

```json
{
  "judul": "Informasi Kegiatan OSIS",
  "isian": "Informasi kegiatan sekolah dan organisasi."
}
```

### Membuat item library

`POST /api/library`

```json
{
  "link_pembelajaran": "https://example.com/materi",
  "kategori": "Pemrograman"
}
```

### Membuat tugas

`POST /api/tugas`

```json
{
  "nama_tugas": "Membuat API Laravel",
  "link_tugas": "https://example.com/tugas",
  "kategori_tugas": "Pemrograman"
}
```

### Membuat akun pengguna

`POST /api/user`

```json
{
  "name": "Nama Pengguna",
  "email": "pengguna@example.com",
  "password": "GantiPassword123",
  "role": "siswa"
}
```

> Contoh payload di atas bersifat ilustratif. Field yang wajib, nama kolom pengguna (`name` atau `user`), dan format respons harus mengikuti validasi controller, model, serta migration proyek yang sebenarnya.

## Kode Status HTTP Umum

| Status | Arti |
|---|---|
| `200 OK` | Request berhasil |
| `201 Created` | Data berhasil dibuat |
| `401 Unauthorized` | Belum terautentikasi atau token tidak valid |
| `403 Forbidden` | Sudah terautentikasi, tetapi role tidak diizinkan |
| `404 Not Found` | Data atau endpoint tidak ditemukan |
| `422 Unprocessable Entity` | Validasi input gagal |
| `500 Internal Server Error` | Kesalahan pada aplikasi/server |

## Catatan Pengembangan

- Dokumentasi ini mengikuti struktur dan route yang diberikan saat ini; fitur baru dapat ditambahkan kemudian.
- Samakan nama kolom database dengan field pada controller dan model. Contoh: `user` dan `name` bukan nama kolom yang sama.
- Gunakan `updated_at` secara konsisten. Laravel Eloquent secara default menggunakan `created_at` dan `updated_at`, bukan `update_at`.
- Pastikan `StoreLibrary` dan `UpdatedLibrary` memvalidasi field yang sesuai dengan migration tabel `library`.
- Jangan izinkan pengguna biasa mengganti role sendiri. Endpoint pengelolaan role sebaiknya dibatasi untuk admin.
- Untuk operasi update/delete berdasarkan ID, pertimbangkan policy atau pemeriksaan kepemilikan data jika pengguna hanya boleh mengubah data miliknya.
- Setelah mengubah route atau konfigurasi, jalankan `php artisan route:list --path=api` untuk memeriksa hasilnya.

## Lisensi

Dokumentasi ini dibuat untuk kebutuhan pengembangan dan pembelajaran proyek **API Profiling**.
