# DPR_019_MuhammadHasbiHardian
## ETS
---

# Sistem Informasi Penggajian Anggota DPR

Sistem Informasi Penggajian Anggota DPR adalah aplikasi web yang dibangun menggunakan framework Laravel untuk mengelola data anggota DPR beserta rincian gajinya. Aplikasi ini menerapkan sistem Role-Based Access Control (RBAC) yang memisahkan fungsionalitas antara pengguna Admin dan Public.

Aplikasi ini dibuat sebagai demonstrasi implementasi operasi CRUD (Create, Read, Update, Delete) modern, pencarian data dinamis tanpa reload halaman (AJAX), validasi real-time di sisi klien, dan kalkulasi data yang kompleks di sisi server.

---

## ✨ Fitur Utama

- **Role Admin**
  - Kelola data anggota DPR (CRUD)
  - Kelola data komponen gaji DPR (CRUD)
  - Kelola data penggajian DPR (CRUD)
- **Role Public**
  - Melihat daftar anggota DPR
  - Melihat detail penggajian anggota DPR

---

## 🛠️ Teknologi yang Digunakan

- [Laravel 12](https://laravel.com/)
- [Laravel Breeze](https://laravel.com/docs/12.x/starter-kits#laravel-breeze)
- [PHP 8.2+](https://www.php.net/)
- [PostgreSQL](https://www.postgresql.org/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Alpine.js](https://alpinejs.dev/)
- [Javascript](https://www.javascript.com/)

---

## 🚀 Cara Menjalankan Aplikasi

### 1. Clone Repository

```sh
git clone https://github.com/Nnurvyy/Akademik-Laravel.git
cd Akademik-Laravel
```

### 2. Copy File Environment
Salin file .env.example menjadi .env:

```sh
cp .env.example .env
```

### 3. Siapkan Database 
- Buat database PostgreSQL baru, misal: dpr
- Pastikan konfigurasi DB di file .env sudah sesuai
```sh
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=dpr
DB_USERNAME=postgres
DB_PASSWORD=postgres
```


### 4. Install Dependency PHP $ JS
```sh
composer install
npm install
```

### 5. Generate APP_KEY
```sh
php artisan key:generate
```

### 6. Create Table Database
Gunakan link ini untuk export .sql 
[https://dbdiagram.io/d/Proyek-3-Gaji-DPR-68dba08cd2b621e4228f3e5d](https://dbdiagram.io/d/Proyek-3-Gaji-DPR-68dba08cd2b621e4228f3e5d)

### 7. Insert Data ke Database
Gunakan link ini untuk data dummy
[https://gist.github.com/alifiharafi/5eca278f487c5e3ebe607f30d777d925](https://gist.github.com/alifiharafi/5eca278f487c5e3ebe607f30d777d925)

### 8. Jalankan Build Frontend
```sh 
npm run dev
```

### 9. Jalankan Aplikasi 
Pilih salah satu
```sh 
php artisan serve
# atau 
php -S 127.0.0.1:9000 -t public
# atau gunakan Laravel Herd/Laragon sesuai preferensi
```

### 10. Login Menggunakan Akun Seeder
Gunakan akun yang sudah disediakan, misal:


- Admin
  Username: admin
  Password: admin123


- Public
  Username: citizen
  Password: public123


