# Panduan Instalasi Kasir DB

## Prasyarat

- PHP 8.0 atau lebih tinggi
- Composer
- MySQL/MariaDB
- Node.js & NPM (opsional)

## Langkah Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd kasir_db
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup File Konfigurasi
```bash
cp .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env` dan atur database connection:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kasir_db
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan Migration

Buat tabel di database:
```bash
php artisan migrate
```

### 7. Jalankan Development Server

```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## Struktur Folder

```
kasir_db/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── DashboardController.php
│   │       └── ProdukController.php
│   └── Models/
│       └── Produk.php
├── database/
│   └── migrations/
│       └── 2024_01_01_000001_create_produk_table.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── dashboard/
│       │   └── index.blade.php
│       └── inventaris/
│           ├── daftar-barang.blade.php
│           ├── tambah-produk.blade.php
│           ├── edit-produk.blade.php
│           └── informasi.blade.php
└── routes/
    └── web.php
```

## Fitur Utama

### Dashboard
- Menampilkan total produk
- Menampilkan total stok
- Menampilkan estimasi nilai inventaris

### Inventaris
- **Daftar Barang**: Lihat semua produk dalam bentuk tabel
- **Tambah Produk**: Tambahkan produk baru ke inventaris
- **Edit Produk**: Ubah informasi produk yang sudah ada
- **Hapus Produk**: Hapus produk dari inventaris
- **Informasi**: Lihat ringkasan statistik inventaris

## Penggunaan Dasar

### Menambah Produk
1. Klik menu "Tambah Produk" di sidebar
2. Isi form dengan data produk
3. Klik "Simpan Produk"

### Melihat Daftar Produk
1. Klik menu "Daftar Barang" di sidebar
2. Lihat semua produk dalam tabel

### Mengedit Produk
1. Di halaman "Daftar Barang", cari produk yang ingin diedit
2. Klik tombol edit (ikon pensil)
3. Ubah data sesuai kebutuhan
4. Klik "Perbarui Produk"

### Menghapus Produk
1. Di halaman "Daftar Barang", cari produk
2. Klik tombol hapus (ikon trash)
3. Konfirmasi penghapusan

## Troubleshooting

### Error: SQLSTATE[HY000] [2002] No such file or directory
- Pastikan MySQL/MariaDB sudah berjalan
- Periksa konfigurasi database di `.env`

### Error: Class 'Database' not found
- Jalankan `composer install` dan `php artisan migrate`

### Halaman tidak menemukan route
- Pastikan sudah jalankan `php artisan serve`
- Periksa file `routes/web.php`

## Support & Kontribusi

Untuk pertanyaan atau kontribusi, silakan buat issue atau pull request di repository.