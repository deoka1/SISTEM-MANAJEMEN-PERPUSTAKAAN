<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Booking;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PortalController extends Controller
{
    // ── Halaman utama katalog ──────────────────────────────────
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tersedia')) {
            $query->where('stok_tersedia', '>', 0);
        }

        $buku     = $query->latest()->paginate(12)->withQueryString();
        $kategori = Buku::distinct()->pluck('kategori')->sort()->values();
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok_tersedia', '>', 0)->count();

        return view('portal.index', compact('buku', 'kategori', 'totalBuku', 'bukuTersedia'));
    }

    // ── Detail buku ────────────────────────────────────────────
    public function detail(Buku $buku)
    {
        $bukuLain = Buku::where('kategori', $buku->kategori)
            ->where('id', '!=', $buku->id)
            ->where('stok_tersedia', '>', 0)
            ->take(4)
            ->get();

        return view('portal.detail', compact('buku', 'bukuLain'));
    }

    // ── Form booking ───────────────────────────────────────────
    public function formBooking(Buku $buku)
    {
        if ($buku->stok_tersedia <= 0) {
            return redirect()->route('portal.detail', $buku)
                ->with('error', 'Maaf, stok buku ini sedang tidak tersedia.');
        }

        return view('portal.booking', compact('buku'));
    }

    // ── Simpan booking ─────────────────────────────────────────
    public function simpanBooking(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'nama_peminjam'         => 'required|string|max:255',
            'email_peminjam'        => 'required|email',
            'telepon_peminjam'      => 'nullable|string|max:20',
            'no_anggota'            => 'required|string|max:30',
            'tanggal_pinjam_rencana'=> 'required|date|after_or_equal:today',
            'tanggal_kembali_rencana'=> 'required|date|after:tanggal_pinjam_rencana',
            'catatan'               => 'nullable|string|max:500',
        ], [
            'nama_peminjam.required'          => 'Nama wajib diisi.',
            'email_peminjam.required'         => 'Email wajib diisi.',
            'no_anggota.required'             => 'Nomor anggota wajib diisi.',
            'tanggal_pinjam_rencana.required' => 'Tanggal pinjam wajib diisi.',
            'tanggal_pinjam_rencana.after_or_equal' => 'Tanggal pinjam tidak boleh sebelum hari ini.',
            'tanggal_kembali_rencana.required'=> 'Tanggal kembali wajib diisi.',
            'tanggal_kembali_rencana.after'   => 'Tanggal kembali harus setelah tanggal pinjam.',
        ]);

        // Cek no anggota valid
        $anggota = Anggota::where('no_anggota', $request->no_anggota)->first();
        if (!$anggota) {
            return back()->withErrors(['no_anggota' => 'Nomor anggota tidak ditemukan. Silakan daftar terlebih dahulu.'])->withInput();
        }

        if (!$anggota->isAktif()) {
            return back()->withErrors(['no_anggota' => 'Keanggotaan Anda sudah tidak aktif atau expired. Hubungi petugas perpustakaan.'])->withInput();
        }

        // Cek sudah ada booking aktif untuk buku yang sama
        $bookingAktif = Booking::where('no_anggota', $request->no_anggota)
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->exists();

        if ($bookingAktif) {
            return back()->with('error', 'Anda sudah memiliki booking aktif untuk buku ini.')->withInput();
        }

        // Generate kode booking
        $last  = Booking::latest()->first();
        $nomor = $last ? (intval(substr($last->kode_booking, -5)) + 1) : 1;
        $validated['kode_booking']   = 'BKG' . date('Y') . str_pad($nomor, 5, '0', STR_PAD_LEFT);
        $validated['buku_id']        = $buku->id;
        $validated['tanggal_booking']= today();
        $validated['status']         = 'menunggu';

        Booking::create($validated);

        return redirect()->route('portal.cek-booking', ['kode' => $validated['kode_booking']])
            ->with('success', 'Booking berhasil! Kode booking Anda: <strong>' . $validated['kode_booking'] . '</strong>. Simpan kode ini untuk cek status.');
    }

    // ── Cek status booking ─────────────────────────────────────
    public function cekBooking(Request $request)
    {
        $booking = null;

        if ($request->filled('kode')) {
            $booking = Booking::with('buku')
                ->where('kode_booking', strtoupper($request->kode))
                ->first();
        }

        return view('portal.cek-booking', compact('booking'));
    }
}
