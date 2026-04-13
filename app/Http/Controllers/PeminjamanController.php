<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_pinjam', 'like', "%{$search}%")
                  ->orWhereHas('anggota', fn($a) => $a->where('nama', 'like', "%{$search}%"))
                  ->orWhereHas('buku', fn($b) => $b->where('judul', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Auto-update status terlambat
        Peminjaman::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali_rencana', '<', now())
            ->update(['status' => 'terlambat']);

        $peminjaman = $query->latest()->paginate(10)->withQueryString();

        return view('loans.index', compact('peminjaman'));
    }

    public function create()
    {
        $anggota = Anggota::where('status', 'aktif')
            ->whereDate('tanggal_expired', '>=', now())
            ->get();
        $buku = Buku::where('stok_tersedia', '>', 0)->get();
        return view('loans.create', compact('anggota', 'buku'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id'               => 'required|exists:anggota,id',
            'buku_id'                  => 'required|exists:buku,id',
            'tanggal_pinjam'           => 'required|date',
            'tanggal_kembali_rencana'  => 'required|date|after:tanggal_pinjam',
            'keterangan'               => 'nullable|string',
        ]);

        $buku    = Buku::findOrFail($request->buku_id);
        $anggota = Anggota::findOrFail($request->anggota_id);

        if ($buku->stok_tersedia <= 0) {
            return back()->with('error', 'Stok buku tidak tersedia!')->withInput();
        }

        if (!$anggota->isAktif()) {
            return back()->with('error', 'Keanggotaan anggota tidak aktif atau sudah expired!')->withInput();
        }

        // Cek apakah anggota sudah meminjam buku ini
        if (Peminjaman::where('anggota_id', $request->anggota_id)
                ->where('buku_id', $request->buku_id)
                ->where('status', 'dipinjam')
                ->exists()) {
            return back()->with('error', 'Anggota sudah meminjam buku ini!')->withInput();
        }

        // Generate kode pinjam
        $lastPinjam = Peminjaman::latest()->first();
        $nomor = $lastPinjam ? (intval(substr($lastPinjam->kode_pinjam, -5)) + 1) : 1;
        $validated['kode_pinjam'] = 'PJM' . date('Y') . str_pad($nomor, 5, '0', STR_PAD_LEFT);
        $validated['user_id']     = Auth::id();
        $validated['status']      = 'dipinjam';
        $validated['denda']       = 0;

        Peminjaman::create($validated);

        // Kurangi stok tersedia
        $buku->decrement('stok_tersedia');

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dicatat!');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['anggota', 'buku', 'user']);
        return view('loans.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Peminjaman yang sudah dikembalikan tidak dapat diedit!');
        }
        $anggota = Anggota::where('status', 'aktif')->get();
        $buku    = Buku::all();
        return view('loans.edit', compact('peminjaman', 'anggota', 'buku'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'tanggal_kembali_rencana' => 'required|date',
            'keterangan'              => 'nullable|string',
        ]);

        $peminjaman->update($validated);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'dipinjam' || $peminjaman->status === 'terlambat') {
            // Kembalikan stok
            $peminjaman->buku->increment('stok_tersedia');
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus!');
    }

    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan!');
        }

        $request->validate([
            'tanggal_kembali_aktual' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $tanggalAktual = Carbon::parse($request->tanggal_kembali_aktual);
        $denda         = 0;

        if ($tanggalAktual->gt($peminjaman->tanggal_kembali_rencana)) {
            $hariTerlambat = $tanggalAktual->diffInDays($peminjaman->tanggal_kembali_rencana);
            $denda         = $hariTerlambat * 1000;
        }

        $peminjaman->update([
            'tanggal_kembali_aktual' => $tanggalAktual,
            'status'                 => 'dikembalikan',
            'denda'                  => $denda,
            'keterangan'             => $request->keterangan,
        ]);

        // Tambah stok tersedia
        $peminjaman->buku->increment('stok_tersedia');

        return redirect()->route('peminjaman.index')
            ->with('success', 'Buku berhasil dikembalikan! Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }
}
