# Buku Tamu Digital — BPS Kota Bukittinggi

Aplikasi web sederhana untuk pencatatan kunjungan tamu di BPS Kota Bukittinggi, dibangun sebagai jawaban **Tes Seleksi Magang Web Developer (PHP & Laravel)**.

## Teknologi

| Komponen | Versi |
| --- | --- |
| PHP | 8.4 |
| Laravel | 13.x (kompatibel PHP 8, sesuai ketentuan "Laravel 10 atau versi terbaru") |
| Database | MySQL 8.4 |
| CSS | Tailwind CSS 4 (via Vite) |

## Fitur

1. **Login admin** — satu kolom input yang menerima **username atau email** + password, dengan pembatasan percobaan login (throttle 5x/menit) dan opsi "ingat saya".
2. **Data tamu** — admin dapat melihat daftar tamu dengan detail lengkap: nama, nomor HP, email, instansi, tujuan kunjungan, tanggal kunjungan, dan sumber kunjungan. Admin juga dapat mengedit dan menghapus data.
3. **Pencarian** — mencari tamu berdasarkan nama (`?q=`).
4. **Dashboard** — menampilkan jumlah tamu bulan ini, total seluruh tamu, rekap jumlah tamu per sumber kunjungan, dan tabel kunjungan terbaru.
5. **Validasi** — nama wajib diisi, email wajib dengan format benar, nomor HP wajib diisi (hanya menerima angka, `+`, `-`, spasi, tanda kurung), tanggal kunjungan tidak boleh di masa depan. Pesan validasi dalam Bahasa Indonesia (`lang/id`).
6. **URL berdasarkan sumber pengunjung** — empat URL berbeda menuju buku tamu yang sama:

   | URL | Sumber yang tercatat |
   | --- | --- |
   | `https://domain.com/` | `direct` (pengunjung langsung) |
   | `https://domain.com/whatsapp` | `whatsapp` |
   | `https://domain.com/instagram` | `instagram` |
   | `https://domain.com/facebook` | `facebook` |

   Setiap tamu yang mengisi form melalui URL tersebut otomatis menyimpan asal pengunjung ke database (kolom `sumber`), sehingga admin dapat melihat jumlah pengunjung berdasarkan sumber kunjungan di dashboard.

## Akun Admin

| | |
| --- | --- |
| Username | `admin` |
| Email | `admin@bpskotabukittinggi.test` |
| Password | `Admin@12345` |

## Cara Menjalankan Aplikasi

1. **Kebutuhan**: PHP >= 8.2 (ekstensi `pdo_mysql` aktif), Composer, Node.js & npm, MySQL/MariaDB.
2. **Install dependency**:
   ```bash
   composer install
   npm install
   ```
3. **Siapkan konfigurasi**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Lalu sesuaikan bagian database di `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bukutamu
   DB_USERNAME=root
   DB_PASSWORD=root
   ```
4. **Buat database** `bukutamu` (charset `utf8mb4`), atau impor `bukutamu.sql` yang sudah tersedia:
   ```sql
   CREATE DATABASE bukutamu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
5. **Jalankan migration + seeder** (membuat tabel + akun admin + beberapa data contoh):
   ```bash
   php artisan migrate --seed
   ```
6. **Build aset frontend**:
   ```bash
   npm run build
   ```
7. **Jalankan aplikasi**:
   ```bash
   php artisan serve
   ```
8. Buka <http://localhost:8000> untuk form buku tamu, dan <http://localhost:8000/login> untuk login admin.

### Alternatif: impor langsung dari file SQL

File `bukutamu.sql` berisi struktur + data (admin & data contoh) sehingga langkah 5 dapat dilewati:

```bash
mysql -u root -p bukutamu < bukutamu.sql
```

## Struktur Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/LoginController.php      # login username/email + logout
│   │   ├── GuestBookController.php       # form publik + simpan tamu
│   │   └── Admin/
│   │       ├── DashboardController.php   # statistik dashboard
│   │       └── GuestController.php       # daftar/edit/hapus tamu (admin)
│   └── Requests/StoreGuestRequest.php    # aturan validasi data tamu
└── Models/Guest.php                      # model tamu + scope pencarian/bulan
database/
├── migrations/                           # skema tabel users, guests
└── seeders/DatabaseSeeder.php            # akun admin + data contoh
lang/id/                                  # pesan validasi Bahasa Indonesia
resources/views/
├── guests/form.blade.php                 # form buku tamu (4 URL sumber)
└── admin/                                # login, dashboard, data tamu
routes/web.php                            # semua rute aplikasi
tests/Feature/                            # 21 feature test (PHPUnit)
bukutamu.sql                              # dump database MySQL
```

## Panduan Hosting (InfinityFree — gratis)

1. Daftar akun di <https://www.infinityfree.com> lalu buat satu akun hosting, pilih subdomain gratis (mis. `bukutamu.infinityfreeapp.com`).
2. Di panel (Client Area → Control Panel) buat **MySQL Database**. Catat: nama database, username, password, dan host (mis. `sqlXXX.infinityfree.com`).
3. Impor `bukutamu.sql` melalui **phpMyAdmin** (menu MySQL Databases → Admin phpMyAdmin).
4. Upload source code ke akun hosting:
   - Isi **seluruh isi project KECUALI folder `public/`** ke root akun (sejajar dengan folder `htdocs`).
   - Isi folder `public/` (index.php, `.htaccess`, folder `build/`) ke dalam `htdocs`.
   - Cara termudah: zip semua file lalu gunakan File Manager di panel untuk upload & extract; atau via FTP (FileZilla) dengan kredensial FTP dari panel.
5. Buat file `.env` di root akun berdasarkan `.env.example`, sesuaikan:
   - `APP_KEY` (generate lokal dengan `php artisan key:generate --show`, salin nilainya),
   - `APP_ENV=production`, `APP_DEBUG=false`,
   - `DB_HOST/DB_DATABASE/DB_USERNAME/DB_PASSWORD` dari langkah 2.
6. Selesai — buka URL subdomain untuk form tamu, dan `/login` untuk admin.

> Catatan: asset frontend sudah di-build (`public/build`) sehingga tidak perlu Node.js di hosting. Jika perlu membangun ulang, jalankan `npm run build` secara lokal sebelum upload.

## Status Pengerjaan

Seluruh fitur pada studi kasus telah selesai:

- [x] Login admin (username/email + password)
- [x] Data tamu (lihat, tambah otomatis via form publik, edit, hapus)
- [x] Pencarian tamu berdasarkan nama
- [x] Dashboard (tamu bulan ini, total tamu, rekap per sumber)
- [x] Validasi input sesuai ketentuan
- [x] Empat URL sumber pengunjung dengan pencatatan otomatis
- [x] Feature tests (21 tes, 68 assertions)

Fitur tambahan di luar brief: edit/hapus tamu oleh admin, throttle login, pagination, dan badge sumber kunjungan pada form.
