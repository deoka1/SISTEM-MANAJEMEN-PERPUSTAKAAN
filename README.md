# 📚 SiPerpus — Library Management System

> ⚡ **Level Up!** Sistem manajemen perpustakaan berbasis **Laravel 11** + **Tailwind CSS**  
> *Fitur CRUD lengkap, auto-denda, dan role-based access — seperti RPG untuk librarian!*

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-red?style=for-the-badge&logo=laravel&logoColor=white"/>
  <img src="https://img.shields.io/badge/TailwindCSS-3-blue?style=for-the-badge&logo=tailwindcss&logoColor=white"/>
  <img src="https://img.shields.io/badge/PHP-8.2-purple?style=for-the-badge&logo=php&logoColor=white"/>
  <img src="https://img.shields.io/badge/MySQL-8.0-orange?style=for-the-badge&logo=mysql&logoColor=white"/>
</p>

---

## 🎮 **Fitur-Fitur (Quest List)**

| Fitur | Deskripsi | 🏆 XP |
|---|---|---|
| 🔐 **Auth System** | Login, logout, remember me | 100 XP |
| 🛡️ **Middleware** | `auth.custom` + `admin` role guard | 150 XP |
| 📊 **Dashboard** | Statistik realtime, buku terpopuler, peminjaman terbaru | 200 XP |
| 📖 **Manajemen Buku** | CRUD + upload cover + filter kategori | 250 XP |
| 👥 **Manajemen Anggota** | CRUD + auto-generate no. anggota + expired date | 250 XP |
| 🔄 **Peminjaman** | CRUD + konfirmasi pengembalian + hitung denda otomatis | 300 XP 💀 |

---

## 🚀 **Instalasi (Cara Unlock Game)**

### 📦 **Persyaratan Sistem (Minimum Spec)**
- ✅ Laragon / XAMPP
- ✅ PHP 8.2+
- ✅ Composer
- ✅ MySQL 8.0+

---

### 📝 **Step-by-Step Walkthrough**

#### 1️⃣ **Buat Karakter (Proyek Baru)**
```bash
cd C:\laragon\www\
composer create-project laravel/laravel laravel-perpus
cd laravel-perpus

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

bootstrap/app.php  ← ⚠️ TIMPA file yang ada!

database/migrations/*.php
database/seeders/DatabaseSeeder.php

resources/views/layouts/master.blade.php
resources/views/components/*.blade.php
resources/views/auth/login.blade.php
resources/views/dashboard/index.blade.php
resources/views/books/*.blade.php
resources/views/members/*.blade.php
resources/views/loans/*.blade.php

routes/web.php

APP_NAME=SiPerpus
APP_URL=http://laravel-perpus.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpus
DB_USERNAME=root
DB_PASSWORD=

# Buka phpMyAdmin: http://localhost/phpmyadmin
# Create database: db_perpus (utf8mb4_unicode_ci)

CREATE DATABASE db_perpus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

mkdir public\covers

php artisan migrate --seed
php artisan storage:link  # optional

php artisan serve
# atau akses: http://laravel-perpus.test
