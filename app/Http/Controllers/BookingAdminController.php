<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('buku');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_booking', 'like', "%{$search}%")
                  ->orWhere('nama_peminjam', 'like', "%{$search}%")
                  ->orWhere('no_anggota', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $booking       = $query->latest()->paginate(10)->withQueryString();
        $totalMenunggu = Booking::where('status', 'menunggu')->count();

        return view('booking.index', compact('booking', 'totalMenunggu'));
    }

    public function show(Booking $booking)
    {
        $booking->load('buku');
        return view('booking.show', compact('booking'));
    }

    public function setujui(Request $request, Booking $booking)
    {
        if ($booking->status !== 'menunggu') {
            return back()->with('error', 'Booking ini sudah diproses sebelumnya.');
        }

        if ($booking->buku->stok_tersedia <= 0) {
            return back()->with('error', 'Stok buku tidak tersedia untuk disetujui.');
        }

        $booking->update(['status' => 'disetujui']);

        return back()->with('success', 'Booking berhasil disetujui! Pelanggan dapat mengambil buku sesuai jadwal.');
    }

    public function tolak(Request $request, Booking $booking)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:500',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
        ]);

        if ($booking->status !== 'menunggu') {
            return back()->with('error', 'Booking ini sudah diproses sebelumnya.');
        }

        $booking->update([
            'status'            => 'ditolak',
            'alasan_penolakan'  => $request->alasan_penolakan,
        ]);

        return back()->with('success', 'Booking telah ditolak.');
    }

    public function selesai(Booking $booking)
    {
        if ($booking->status !== 'disetujui') {
            return back()->with('error', 'Hanya booking yang disetujui yang bisa diselesaikan.');
        }

        // Buat record peminjaman otomatis dari booking
        $last   = \App\Models\Peminjaman::latest()->first();
        $nomor  = $last ? (intval(substr($last->kode_pinjam, -5)) + 1) : 1;

        \App\Models\Peminjaman::create([
            'kode_pinjam'             => 'PJM' . date('Y') . str_pad($nomor, 5, '0', STR_PAD_LEFT),
            'anggota_id'              => \App\Models\Anggota::where('no_anggota', $booking->no_anggota)->first()?->id,
            'buku_id'                 => $booking->buku_id,
            'user_id'                 => Auth::id(),
            'tanggal_pinjam'          => $booking->tanggal_pinjam_rencana,
            'tanggal_kembali_rencana' => $booking->tanggal_kembali_rencana,
            'status'                  => 'dipinjam',
            'denda'                   => 0,
            'keterangan'              => 'Dari booking: ' . $booking->kode_booking,
        ]);

        $booking->buku->decrement('stok_tersedia');
        $booking->update(['status' => 'selesai']);

        return back()->with('success', 'Booking selesai dan peminjaman berhasil dicatat!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('booking.index')->with('success', 'Data booking berhasil dihapus.');
    }
}
