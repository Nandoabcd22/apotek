<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Models\Obat;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user dummy
        $users = [
            [
                'name' => 'Admin Apotek',
                'email' => 'admin@apotek.com',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ],
            [
                'name' => 'Apoteker 1',
                'email' => 'apoteker1@apotek.com',
                'password' => bcrypt('password'),
                'role' => 'apoteker'
            ],
            [
                'name' => 'Apoteker 2',
                'email' => 'apoteker2@apotek.com',
                'password' => bcrypt('password'),
                'role' => 'apoteker'
            ],
            [
                'name' => 'Pelanggan 1',
                'email' => 'pelanggan1@apotek.com',
                'password' => bcrypt('password'),
                'role' => 'pelanggan'
            ],
            [
                'name' => 'Pelanggan 2',
                'email' => 'pelanggan2@apotek.com',
                'password' => bcrypt('password'),
                'role' => 'pelanggan'
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Buat supplier dummy
        $suppliers = [
            [
                'id_supplier' => 'SP001',
                'nama_supplier' => 'PT Pharma Jaya',
                'alamat' => 'Jl. Gatot Subroto No. 123, Jakarta Selatan',
                'kota' => 'Jakarta',
                'telepon' => '021-1234567'
            ],
            [
                'id_supplier' => 'SP002',
                'nama_supplier' => 'CV Medika Indonesia',
                'alamat' => 'Jl. Ahmad Yani No. 456, Surabaya',
                'kota' => 'Surabaya',
                'telepon' => '031-9876543'
            ],
            [
                'id_supplier' => 'SP003',
                'nama_supplier' => 'PT Kimia Farma',
                'alamat' => 'Jl. Cikini Raya No. 21, Jakarta Pusat',
                'kota' => 'Jakarta',
                'telepon' => '021-5555555'
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // Buat obat dummy
        $obats = [
            [
                'id_obat' => 'OB001',
                'nama_obat' => 'Paracetamol 500mg',
                'jenis' => 'Tablet',
                'satuan' => 'Strip',
                'harga_beli' => 500,
                'harga_jual' => 1000,
                'stok' => 100,
                'id_supplier' => 'SP001',
                'tanggal_kadaluarsa' => date('Y-m-d', strtotime('+1 year'))
            ],
            [
                'id_obat' => 'OB002',
                'nama_obat' => 'Ibuprofen 400mg',
                'jenis' => 'Tablet',
                'satuan' => 'Strip',
                'harga_beli' => 600,
                'harga_jual' => 1500,
                'stok' => 80,
                'id_supplier' => 'SP001',
                'tanggal_kadaluarsa' => date('Y-m-d', strtotime('+2 months'))
            ],
            [
                'id_obat' => 'OB003',
                'nama_obat' => 'Amoxicillin 500mg',
                'jenis' => 'Kapsul',
                'satuan' => 'Strip',
                'harga_beli' => 1200,
                'harga_jual' => 2500,
                'stok' => 50,
                'id_supplier' => 'SP002',
                'tanggal_kadaluarsa' => date('Y-m-d', strtotime('-10 days'))
            ],
            [
                'id_obat' => 'OB004',
                'nama_obat' => 'Omeprazole 20mg',
                'jenis' => 'Kapsul',
                'satuan' => 'Strip',
                'harga_beli' => 800,
                'harga_jual' => 1800,
                'stok' => 75,
                'id_supplier' => 'SP003',
                'tanggal_kadaluarsa' => date('Y-m-d', strtotime('+6 months'))
            ],
            [
                'id_obat' => 'OB005',
                'nama_obat' => 'Metformin 500mg',
                'jenis' => 'Tablet',
                'satuan' => 'Strip',
                'harga_beli' => 1000,
                'harga_jual' => 2000,
                'stok' => 60,
                'id_supplier' => 'SP002',
                'tanggal_kadaluarsa' => date('Y-m-d', strtotime('+1 month'))
            ],
            [
                'id_obat' => 'OB006',
                'nama_obat' => 'Simvastatin 10mg',
                'jenis' => 'Tablet',
                'satuan' => 'Strip',
                'harga_beli' => 1500,
                'harga_jual' => 3000,
                'stok' => 40,
                'id_supplier' => 'SP001',
                'tanggal_kadaluarsa' => date('Y-m-d', strtotime('+3 years'))
            ],
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }

        // Buat pelanggan dummy
        $pelanggans = [
            [
                'id_pelanggan' => 'PL001',
                'nama_pelanggan' => 'Budi Santoso',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta',
                'kota' => 'Jakarta',
                'telepon' => '081-2345678'
            ],
            [
                'id_pelanggan' => 'PL002',
                'nama_pelanggan' => 'Siti Nurhaliza',
                'alamat' => 'Jl. Gatot Subroto No. 50, Jakarta',
                'kota' => 'Jakarta',
                'telepon' => '082-9876543'
            ],
            [
                'id_pelanggan' => 'PL003',
                'nama_pelanggan' => 'Andi Wijaya',
                'alamat' => 'Jl. Ahmad Yani No. 100, Surabaya',
                'kota' => 'Surabaya',
                'telepon' => '083-5555555'
            ],
            [
                'id_pelanggan' => 'PL004',
                'nama_pelanggan' => 'Maya Putri',
                'alamat' => 'Jl. Diponegoro No. 25, Bandung',
                'kota' => 'Bandung',
                'telepon' => '085-7777777'
            ],
            [
                'id_pelanggan' => 'PL005',
                'nama_pelanggan' => 'Roni Pratama',
                'alamat' => 'Jl. Sudirman No. 15, Medan',
                'kota' => 'Medan',
                'telepon' => '086-4444444'
            ],
        ];

        foreach ($pelanggans as $pelanggan) {
            Pelanggan::create($pelanggan);
        }
    }
}
