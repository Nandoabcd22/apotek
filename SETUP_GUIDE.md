# Sistem Manajemen Apotek

Aplikasi full-stack untuk mengelola penjualan obat dengan database relasional yang komprehensif.

## Fitur Utama

- **Manajemen Data Obat**: CRUD obat dengan detail jenis, satuan, harga beli/jual, dan stok
- **Manajemen Supplier**: Kelola supplier dengan detail kontak dan lokasi
- **Manajemen Pelanggan**: Kelola data pelanggan dan riwayat pembelian mereka
- **Penjualan**: Buat transaksi penjualan dengan multiple items, discount, dan perhitungan otomatis
- **Pembelian**: Buat pembelian obat dari supplier dengan tracking stok otomatis
- **Dashboard**: Overview statistik dan transaksi terbaru
- **Stok Management**: Tracking stok otomatis saat transaksi penjualan/pembelian

## Prasyarat

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js (untuk npm)

## Instalasi

### 1. Clone Repository
```bash
cd d:/laragon/www/apotek
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apotek
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Jalankan Migrations
```bash
php artisan migrate
```

### 5. Jalankan Seeders (Optional - untuk data dummy)
```bash
php artisan db:seed
```

### 6. Build Assets (if using Vite)
```bash
npm run dev
```

### 7. Jalankan Aplikasi
Menggunakan built-in server Laravel:
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`

## Struktur Database

### Tabel Utama

1. **suppliers** - Data supplier obat
   - Columns: id_supplier (PK), nama_supplier, alamat, kota, telepon

2. **obats** - Data obat
   - Columns: id_obat (PK), nama_obat, jenis, satuan, harga_beli, harga_jual, stok, id_supplier (FK)

3. **pelanggans** - Data pelanggan
   - Columns: id_pelanggan (PK), nama_pelanggan, alamat, kota, telepon

4. **penjualans** - Transaksi penjualan
   - Columns: no_penjualan (PK), tanggal_penjualan, id_pelanggan (FK), diskon, total

5. **penjualan_details** - Detail item penjualan
   - Columns: id (PK), no_penjualan (FK), id_obat (FK), jumlah, harga_satuan, subtotal

6. **pembelians** - Transaksi pembelian
   - Columns: no_pembelian (PK), tanggal_pembelian, id_supplier (FK), diskon, total

7. **pembelian_details** - Detail item pembelian
   - Columns: id (PK), no_pembelian (FK), id_obat (FK), jumlah, harga_satuan, subtotal

## Routes & Endpoints

### Supplier
- GET `/suppliers` - List semua supplier
- GET `/suppliers/create` - Form tambah supplier
- POST `/suppliers` - Store supplier
- GET `/suppliers/{id}` - Detail supplier
- GET `/suppliers/{id}/edit` - Form edit supplier
- PUT `/suppliers/{id}` - Update supplier
- DELETE `/suppliers/{id}` - Hapus supplier

### Obat
- GET `/obats` - List semua obat
- GET `/obats/create` - Form tambah obat
- POST `/obats` - Store obat
- GET `/obats/{id}` - Detail obat
- GET `/obats/{id}/edit` - Form edit obat
- PUT `/obats/{id}` - Update obat
- DELETE `/obats/{id}` - Hapus obat

### Pelanggan
- GET `/pelanggans` - List semua pelanggan
- GET `/pelanggans/create` - Form tambah pelanggan
- POST `/pelanggans` - Store pelanggan
- GET `/pelanggans/{id}` - Detail pelanggan & riwayat
- GET `/pelanggans/{id}/edit` - Form edit pelanggan
- PUT `/pelanggans/{id}` - Update pelanggan
- DELETE `/pelanggans/{id}` - Hapus pelanggan

### Penjualan
- GET `/penjualans` - List semua penjualan
- GET `/penjualans/create` - Form buat penjualan
- POST `/penjualans` - Store penjualan (dengan automatic stok update)
- GET `/penjualans/{id}` - Detail penjualan
- GET `/penjualans/{id}/edit` - Form edit penjualan
- PUT `/penjualans/{id}` - Update penjualan
- DELETE `/penjualans/{id}` - Hapus penjualan (restore stok)

### Pembelian
- GET `/pembelians` - List semua pembelian
- GET `/pembelians/create` - Form buat pembelian
- POST `/pembelians` - Store pembelian (dengan automatic stok update)
- GET `/pembelians/{id}` - Detail pembelian
- GET `/pembelians/{id}/edit` - Form edit pembelian
- PUT `/pembelians/{id}` - Update pembelian
- DELETE `/pembelians/{id}` - Hapus pembelian (restore stok)

### Dashboard
- GET `/` - Dashboard dengan overview

## Controllers

- `SupplierController` - Manajemen supplier (CRUD)
- `ObatController` - Manajemen obat (CRUD)
- `PelangganController` - Manajemen pelanggan (CRUD)
- `PenjualanController` - Manajemen penjualan (CRUD dengan stok management)
- `PembelianController` - Manajemen pembelian (CRUD dengan stok management)

## Features Khusus

### Dynamic Item Entry
- Form penjualan/pembelian memungkinkan penambahan multiple items secara dinamis
- Perhitungan harga otomatis dengan JavaScript
- Support untuk diskon per transaksi

### Stok Management
- Stok otomatis berkurang saat penjualan
- Stok otomatis bertambah saat pembelian
- Stok di-restore jika transaksi dihapus

### Data Validation
- Validasi input di server-side
- Unique constraint untuk ID
- Foreign key relationships dengan cascade delete

### UI/UX
- Responsive Bootstrap 5 design
- Breadcrumb navigation
- Alert messages untuk feedback
- Form error display dengan highlighting

## Tips Penggunaan

1. **Membuat Penjualan**:
   - Isikan nomor penjualan unik
   - Pilih pelanggan
   - Tambahkan item obat yang akan dijual
   - Sistem otomatis mengurangi stok obat

2. **Membuat Pembelian**:
   - Isikan nomor pembelian unik
   - Pilih supplier
   - Tambahkan item obat yang dibeli
   - Sistem otomatis menambah stok obat

3. **Melihat Detail Pelanggan**:
   - Klik nama pelanggan di halaman detail
   - Lihat statistik pembelian dan riwayat transaksi

4. **Monitoring Stok**:
   - Di dashboard, lihat obat dengan stok rendah (< 10)
   - Indikator status: Habis (merah), Kritis (kuning), Normal (hijau)

## File Struktur

```
project/
├── app/
│   ├── Models/
│   │   ├── Supplier.php
│   │   ├── Obat.php
│   │   ├── Pelanggan.php
│   │   ├── Penjualan.php
│   │   ├── PenjualanDetail.php
│   │   ├── Pembelian.php
│   │   └── PembelianDetail.php
│   └── Http/
│       └── Controllers/
│           ├── SupplierController.php
│           ├── ObatController.php
│           ├── PelangganController.php
│           ├── PenjualanController.php
│           └── PembelianController.php
├── database/
│   ├── migrations/
│   │   ├── *_create_suppliers_table.php
│   │   ├── *_create_obats_table.php
│   │   ├── *_create_pelanggans_table.php
│   │   ├── *_create_penjualans_table.php
│   │   ├── *_create_penjualan_details_table.php
│   │   ├── *_create_pembelians_table.php
│   │   └── *_create_pembelian_details_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── dashboard.blade.php
│       ├── suppliers/
│       ├── obats/
│       ├── pelanggans/
│       ├── penjualans/
│       └── pembelians/
└── routes/
    └── web.php
```

## Troubleshooting

**Error: Class not found**
- Jalankan: `composer dump-autoload`

**Error: SQLSTATE[HY000]**
- Pastikan MySQL/MariaDB berjalan
- Cek konfigurasi database di `.env`

**Error: Migration not found**
- Jalankan: `php artisan migrate --step`

**Stok tidak update**
- Pastikan tidak ada error di server log
- Cek database transactions

## Development

### Menjalankan dengan Debug
```bash
php artisan serve --debug
```

### ViewChecker Database
```bash
php artisan tinker
> DB::table('obats')->get();
```

## License

Proprietary - Aplikasi Manajemen Apotek

## Support

Untuk bantuan, silakan hubungi tim development atau baca dokumentasi Laravel di https://laravel.com/docs
