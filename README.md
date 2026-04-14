# 📚 SiPerpus — Sistem Manajemen Perpustakaan

Aplikasi manajemen perpustakaan berbasis Laravel 11 + Tailwind CSS dengan fitur CRUD lengkap.

---

## 🗂️ Struktur Fitur

| Fitur | Deskripsi |
|---|---|
| **Auth** | Login, logout, remember me |
| **Middleware** | `auth.custom` (login guard), `admin` (role guard) |
| **Dashboard** | Statistik, buku terpopuler, peminjaman terbaru |
| **Buku** | CRUD + upload cover + filter kategori |
| **Anggota** | CRUD + auto-generate no. anggota + expired |
| **Peminjaman** | CRUD + konfirmasi pengembalian + hitung denda |

---

## ⚙️ Cara Instalasi di Laragon

### 1. Buat Proyek Laravel Baru

Buka terminal di folder `C:\laragon\www\` lalu jalankan:

```bash
composer create-project laravel/laravel laravel-perpus
cd laravel-perpus
```

### 2. Salin Semua File

Salin semua file dari folder ini ke dalam proyek Laravel Anda sesuai path masing-masing:

```
app/Http/Controllers/AuthController.php
app/Http/Controllers/DashboardController.php
app/Http/Controllers/BukuController.php
app/Http/Controllers/AnggotaController.php
app/Http/Controllers/PeminjamanController.php

app/Http/Middleware/AuthMiddleware.php
app/Http/Middleware/AdminMiddleware.php

app/Models/User.php
app/Models/Buku.php
app/Models/Anggota.php
app/Models/Peminjaman.php

bootstrap/app.php  ← PENTING! Timpa file yang ada

database/migrations/*.php
database/seeders/DatabaseSeeder.php

resources/views/layouts/master.blade.php
resources/views/components/alert.blade.php
resources/views/components/badge.blade.php
resources/views/components/stats-card.blade.php
resources/views/auth/login.blade.php
resources/views/dashboard/index.blade.php
resources/views/books/*.blade.php
resources/views/members/*.blade.php
resources/views/loans/*.blade.php

routes/web.php
```

### 3. Konfigurasi .env

Buka file `.env` dan ubah:

```env
APP_NAME=SiPerpus
APP_URL=http://laravel-perpus.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpus
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat Database

Buka phpMyAdmin di http://localhost/phpmyadmin, lalu buat database baru:
```
Nama database: db_perpus
Collation: utf8mb4_unicode_ci
```

### 5. Buat Folder Cover

```bash
mkdir public\covers
```

### 6. Jalankan Migrasi & Seeder

```bash
php artisan migrate --seed
```

### 7. Buat Storage Link (jika diperlukan)

```bash
php artisan storage:link
```

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Atau akses langsung via Laragon: **http://laravel-perpus.test**

---

## 🔐 Akun Default

| Role | Email | Password |
|---|---|---|
| **Admin** | admin@perpus.com | password |
| **Petugas** | petugas@perpus.com | password |

---

## 🏗️ Arsitektur MVC

```
📁 app/
├── Http/
│   ├── Controllers/     ← Controller (C)
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── BukuController.php
│   │   ├── AnggotaController.php
│   │   └── PeminjamanController.php
│   └── Middleware/
│       ├── AuthMiddleware.php   ← Cek login
│       └── AdminMiddleware.php  ← Cek role admin
└── Models/              ← Model (M)
    ├── User.php
    ├── Buku.php
    ├── Anggota.php
    └── Peminjaman.php

📁 resources/views/      ← View (V)
├── layouts/
│   └── master.blade.php        ← Layout utama
├── components/
│   ├── alert.blade.php         ← Komponen alert
│   ├── badge.blade.php         ← Komponen badge status
│   └── stats-card.blade.php    ← Komponen kartu statistik
├── auth/login.blade.php
├── dashboard/index.blade.php
├── books/     (index, create, edit, show)
├── members/   (index, create, edit, show)
└── loans/     (index, create, edit, show)

📁 routes/web.php        ← Routing
📁 database/
├── migrations/          ← Skema database
└── seeders/             ← Data awal
```

---

## 🔁 Daftar Route

```
GET    /login                      → Form login
POST   /login                      → Proses login
POST   /logout                     → Logout

GET    /dashboard                  → Dashboard

GET    /buku                       → Daftar buku
GET    /buku/create                → Form tambah buku
POST   /buku                       → Simpan buku
GET    /buku/{id}                  → Detail buku
GET    /buku/{id}/edit             → Form edit buku
PUT    /buku/{id}                  → Update buku
DELETE /buku/{id}                  → Hapus buku

GET    /anggota                    → Daftar anggota (Admin)
GET    /anggota/create             → Form tambah anggota (Admin)
POST   /anggota                    → Simpan anggota (Admin)
GET    /anggota/{id}               → Detail anggota (Admin)
GET    /anggota/{id}/edit          → Form edit anggota (Admin)
PUT    /anggota/{id}               → Update anggota (Admin)
DELETE /anggota/{id}               → Hapus anggota (Admin)

GET    /peminjaman                 → Daftar peminjaman
GET    /peminjaman/create          → Form catat peminjaman
POST   /peminjaman                 → Simpan peminjaman
GET    /peminjaman/{id}            → Detail peminjaman
GET    /peminjaman/{id}/edit       → Form edit peminjaman
PUT    /peminjaman/{id}            → Update peminjaman
DELETE /peminjaman/{id}            → Hapus peminjaman
POST   /peminjaman/{id}/kembalikan → Konfirmasi pengembalian
```

---

## 💡 Aturan Bisnis

- **Denda**: Rp 1.000/hari keterlambatan
- **Masa anggota**: 1 tahun sejak tanggal daftar
- **Manajemen anggota**: Hanya Admin yang bisa akses
- **Stok buku**: Otomatis berkurang saat dipinjam, bertambah saat dikembalikan
- **Kode otomatis**: Kode buku, no. anggota, dan kode pinjam di-generate otomatis



edit supaya keliatan keren!
