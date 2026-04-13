<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_anggota', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $anggota = $query->latest()->paginate(10)->withQueryString();
        
        // Add stats for dashboard
        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::where('status', 'aktif')->count();
        $anggotaNonaktif = Anggota::where('status', 'nonaktif')->count();
        $akanExpired = Anggota::where('tanggal_expired', '<=', now()->addDays(30))
                               ->where('status', 'aktif')
                               ->count();

        return view('members.index', compact('anggota', 'totalAnggota', 'anggotaAktif', 'anggotaNonaktif', 'akanExpired'));
    }

    public function create()
    {
        $generatedNoAnggota = $this->generateNoAnggota();
        return view('members.create', compact('generatedNoAnggota'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'           => 'required|string|max:255',
            'email'          => 'required|email|unique:anggota,email',
            'telepon'        => 'nullable|string|max:20',
            'alamat'         => 'nullable|string',
            'jenis_kelamin'  => 'required|in:L,P',
            'tanggal_daftar' => 'required|date',
        ]);

        // Generate no anggota
        $validated['no_anggota'] = $this->generateNoAnggota();
        $validated['tanggal_expired'] = Carbon::parse($request->tanggal_daftar)->addYear();
        $validated['status'] = 'aktif';

        Anggota::create($validated);

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function show(Anggota $anggota)
    {
        $anggota->load(['peminjaman.buku']);
        $riwayat = $anggota->peminjaman()->with('buku')->latest()->paginate(10);
        $totalPinjaman = $anggota->peminjaman()->count();
        $pinjamanAktif = $anggota->peminjaman()->where('status', 'dipinjam')->count();
        
        return view('members.show', compact('anggota', 'riwayat', 'totalPinjaman', 'pinjamanAktif'));
    }

    public function edit(Anggota $anggota)
    {
        return view('members.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'nama'             => 'required|string|max:255',
            'email'            => 'required|email|unique:anggota,email,' . $anggota->id,
            'telepon'          => 'nullable|string|max:20',
            'alamat'           => 'nullable|string',
            'jenis_kelamin'    => 'required|in:L,P',
            'tanggal_daftar'   => 'required|date',
            'tanggal_expired'  => 'required|date|after:tanggal_daftar',
            'status'           => 'required|in:aktif,nonaktif',
        ]);

        // Jika status diubah menjadi nonaktif, cek apakah ada pinjaman aktif
        if ($validated['status'] == 'nonaktif' && $anggota->status == 'aktif') {
            if ($anggota->peminjaman()->where('status', 'dipinjam')->exists()) {
                return back()->with('error', 'Anggota tidak dapat dinonaktifkan karena masih memiliki pinjaman aktif!')
                             ->withInput();
            }
        }

        $anggota->update($validated);

        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy(Anggota $anggota)
    {
        // Cek apakah anggota memiliki pinjaman aktif
        if ($anggota->peminjaman()->where('status', 'dipinjam')->exists()) {
            return back()->with('error', 'Anggota tidak dapat dihapus karena masih memiliki pinjaman aktif!');
        }
        
        // Cek apakah anggota memiliki booking yang menunggu
        if ($anggota->booking()->where('status', 'menunggu')->exists()) {
            return back()->with('error', 'Anggota tidak dapat dihapus karena masih memiliki booking yang menunggu konfirmasi!');
        }

        $anggota->delete();

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil dihapus!');
    }
    
    /**
     * Generate unique no anggota
     * 
     * @return string
     */
    private function generateNoAnggota()
    {
        $tahun = date('Y');
        $bulan = date('m');
        
        // Cari anggota terakhir di tahun dan bulan yang sama
        $lastAnggota = Anggota::whereYear('created_at', $tahun)
                              ->whereMonth('created_at', $bulan)
                              ->latest()
                              ->first();
        
        if ($lastAnggota) {
            // Ambil 4 digit terakhir dari no_anggota
            $lastNumber = (int) substr($lastAnggota->no_anggota, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return 'LIB' . $tahun . $bulan . $newNumber;
    }
    
    /**
     * API endpoint to check email uniqueness
     */
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'id' => 'nullable|exists:anggota,id'
        ]);
        
        $exists = Anggota::where('email', $request->email)
                         ->when($request->id, function($query, $id) {
                             return $query->where('id', '!=', $id);
                         })
                         ->exists();
        
        return response()->json([
            'available' => !$exists
        ]);
    }
    
    /**
     * Toggle status anggota
     */
    public function toggleStatus(Anggota $anggota)
    {
        // Cek jika akan menonaktifkan tapi ada pinjaman aktif
        if ($anggota->status == 'aktif') {
            if ($anggota->peminjaman()->where('status', 'dipinjam')->exists()) {
                return back()->with('error', 'Anggota tidak dapat dinonaktifkan karena masih memiliki pinjaman aktif!');
            }
            $anggota->status = 'nonaktif';
            $message = 'Anggota berhasil dinonaktifkan';
        } else {
            $anggota->status = 'aktif';
            $message = 'Anggota berhasil diaktifkan kembali';
        }
        
        $anggota->save();
        
        return redirect()->route('anggota.index')
            ->with('success', $message);
    }
    
    /**
     * Perpanjang masa berlaku anggota
     */
    public function perpanjangMasaBerlaku(Anggota $anggota)
    {
        $anggota->tanggal_expired = Carbon::parse($anggota->tanggal_expired)->addYear();
        $anggota->save();
        
        return redirect()->route('anggota.show', $anggota)
            ->with('success', 'Masa berlaku anggota berhasil diperpanjang 1 tahun!');
    }
}