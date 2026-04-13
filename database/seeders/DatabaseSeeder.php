<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────────
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@perpus.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Petugas Perpustakaan',
            'email'    => 'petugas@perpus.com',
            'password' => Hash::make('password'),
            'role'     => 'petugas',
        ]);

        // ── Buku ───────────────────────────────────────────────────
        $buku = [
            ['FIK0001', 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 'Fiksi', 5],
            ['FIK0002', 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Lentera Dipantara', 2000, 'Fiksi', 3],
            ['FIK0003', 'Perahu Kertas', 'Dee Lestari', 'Bentang Pustaka', 2009, 'Fiksi', 4],
            ['FIK0004', 'Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia', 2009, 'Fiksi', 3],
            ['SAI0001', 'Sapiens: Sejarah Singkat Umat Manusia', 'Yuval Noah Harari', 'KPG', 2017, 'Sains', 2],
            ['SAI0002', 'A Brief History of Time', 'Stephen Hawking', 'Bantam Books', 1988, 'Sains', 2],
            ['TEK0001', 'Clean Code', 'Robert C. Martin', 'Prentice Hall', 2008, 'Teknologi', 3],
            ['TEK0002', 'Laravel: Up & Running', 'Matt Stauffer', 'O\'Reilly', 2019, 'Teknologi', 2],
            ['SEJ0001', 'Arus Balik', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1995, 'Sejarah', 2],
            ['AGM0001', 'Fiqih Islam Wa Adillatuhu', 'Wahbah Zuhaili', 'Gema Insani', 2011, 'Agama', 4],
        ];

        foreach ($buku as $b) {
            Buku::create([
                'kode_buku'      => $b[0],
                'judul'          => $b[1],
                'pengarang'      => $b[2],
                'penerbit'       => $b[3],
                'tahun_terbit'   => $b[4],
                'kategori'       => $b[5],
                'stok'           => $b[6],
                'stok_tersedia'  => $b[6],
            ]);
        }

        // ── Anggota ────────────────────────────────────────────────
        $anggota = [
            ['LIB20240001', 'Budi Santoso', 'budi@email.com', '081234567890', 'L', 'Jl. Merdeka No. 1, Jakarta'],
            ['LIB20240002', 'Siti Rahayu', 'siti@email.com', '082345678901', 'P', 'Jl. Sudirman No. 5, Bandung'],
            ['LIB20240003', 'Ahmad Fauzi', 'ahmad@email.com', '083456789012', 'L', 'Jl. Gatot Subroto No. 10, Surabaya'],
            ['LIB20240004', 'Dewi Kusuma', 'dewi@email.com', '084567890123', 'P', 'Jl. Diponegoro No. 3, Yogyakarta'],
            ['LIB20240005', 'Rudi Hartono', 'rudi@email.com', '085678901234', 'L', 'Jl. Ahmad Yani No. 7, Medan'],
        ];

        foreach ($anggota as $a) {
            Anggota::create([
                'no_anggota'      => $a[0],
                'nama'            => $a[1],
                'email'           => $a[2],
                'telepon'         => $a[3],
                'jenis_kelamin'   => $a[4],
                'alamat'          => $a[5],
                'tanggal_daftar'  => Carbon::now()->subMonths(rand(1, 6)),
                'tanggal_expired' => Carbon::now()->addMonths(rand(6, 18)),
                'status'          => 'aktif',
            ]);
        }

        // ── Peminjaman ─────────────────────────────────────────────
        $anggotaList = Anggota::all();
        $bukuList    = Buku::all();
        $admin       = User::first();

        foreach ([1, 2, 3] as $i) {
            $bk = $bukuList[$i - 1];
            $ag = $anggotaList[$i - 1];
            $tglPinjam = Carbon::now()->subDays(rand(5, 20));
            $tglRencana = $tglPinjam->copy()->addDays(7);

            Peminjaman::create([
                'kode_pinjam'             => 'PJM2024' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'anggota_id'              => $ag->id,
                'buku_id'                 => $bk->id,
                'user_id'                 => $admin->id,
                'tanggal_pinjam'          => $tglPinjam,
                'tanggal_kembali_rencana' => $tglRencana,
                'status'                  => 'dipinjam',
                'denda'                   => 0,
            ]);

            $bk->decrement('stok_tersedia');
        }

        // Satu peminjaman yang sudah dikembalikan
        $bk = $bukuList[3];
        $ag = $anggotaList[3];
        Peminjaman::create([
            'kode_pinjam'              => 'PJM2024' . str_pad(4, 5, '0', STR_PAD_LEFT),
            'anggota_id'               => $ag->id,
            'buku_id'                  => $bk->id,
            'user_id'                  => $admin->id,
            'tanggal_pinjam'           => Carbon::now()->subDays(15),
            'tanggal_kembali_rencana'  => Carbon::now()->subDays(8),
            'tanggal_kembali_aktual'   => Carbon::now()->subDays(7),
            'status'                   => 'dikembalikan',
            'denda'                    => 0,
        ]);
    }
}
