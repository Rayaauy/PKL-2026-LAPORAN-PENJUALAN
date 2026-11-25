# Aplikasi Web Pencatatan Penjualan UMKM

Aplikasi web untuk membantu pelaku UMKM melakukan pencatatan penjualan secara sederhana dan terstruktur.

## Fitur Utama

- **Autentikasi**: Register dan Login
- **Profil Usaha**: Kelola informasi usaha
- **Kategori Produk**: Organisasi produk berdasarkan kategori
- **Manajemen Produk**: Tambah, edit, hapus produk dengan harga
- **Transaksi Penjualan**: Catat penjualan harian
- **Riwayat Transaksi**: Lihat histori lengkap transaksi
- **Dashboard**: Ringkasan penjualan dan statistik
- **Laporan**: Laporan berdasarkan periode tanggal
- **Export CSV**: Ekspor data untuk analisis lebih lanjut

## Tech Stack

- Laravel 10
- MySQL
- Blade Templates
- Tailwind CSS (akan ditambahkan)
- Chart.js (untuk dashboard)

## Instalasi

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM (untuk assets)

### Setup

1. Clone repository
```bash
git clone <repository-url>
cd umkm-sales
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Konfigurasi database di `.env`
```
DB_DATABASE=umkm_sales
DB_USERNAME=root
DB_PASSWORD=your_password
```

5. Migrasi database
```bash
php artisan migrate --seed
```

6. Build assets
```bash
npm run dev
```

7. Jalankan server
```bash
php artisan serve
```

Aplikasi bisa diakses di `http://localhost:8000`

## Struktur Database

### Tables
- `users` - Data pengguna/pemilik usaha
- `business_profiles` - Profil usaha
- `categories` - Kategori produk
- `products` - Daftar produk
- `transactions` - Transaksi penjualan
- `transaction_items` - Detail item per transaksi

## Development

### Project Team
- Kelompok: Kelompok 4
- Sekolah: SMK AS-SYAFI'IYAH 01 JAKARTA
- Tahun Pelajaran: 2026/2027

### Documentation
Lihat folder `docs/` untuk dokumentasi lengkap:
- 01_REQUIREMENT.md
- 02_PROJECT_BACKLOG.md
- 03_USER_FLOW.md
- 04_UI_UX.md
- 05_DATABASE_ERD.md
- 06_PROJECT_STRUCTURE.md

## License

MIT License
