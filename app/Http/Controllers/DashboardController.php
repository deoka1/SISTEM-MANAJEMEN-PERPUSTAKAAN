<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku      = Buku::count();
        $totalAnggota   = Anggota::count();
        $totalPinjam    = Peminjaman::where('status', 'dipinjam')->count();
        $totalTerlambat = Peminjaman::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali_rencana', '<', now())
            ->count();

        $peminjamanTerbaru = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        $bukuTerpopuler = Buku::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(5)
            ->get();

        $anggotaAktif = Anggota::where('status', 'aktif')->count();
        $bukuTersedia = Buku::where('stok_tersedia', '>', 0)->count();

        return view('dashboard.index', compact(
            'totalBuku',
            'totalAnggota',
            'totalPinjam',
            'totalTerlambat',
            'peminjamanTerbaru',
            'bukuTerpopuler',
            'anggotaAktif',
            'bukuTersedia'
        ));
    }
}
