<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('kode_buku', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $buku      = $query->latest()->paginate(10)->withQueryString();
        $kategori  = Buku::distinct()->pluck('kategori')->sort()->values();

        return view('books.index', compact('buku', 'kategori'));
    }

    public function create()
    {
        $kategoris = Buku::distinct()->pluck('kategori')->sort()->values();
        $generatedKode = $this->generateKodeBuku(null);
        return view('books.create', compact('kategoris', 'generatedKode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'pengarang'    => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'kategori'     => 'required|string|max:100',
            'stok'         => 'required|integer|min:1',
            'isbn'         => 'nullable|string|max:20|unique:buku,isbn,' . ($request->id ?? 'NULL'),
            'deskripsi'    => 'nullable|string',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Generate kode buku dengan cek unique
        $validated['kode_buku'] = $this->generateKodeBuku($request->kategori);
        $validated['stok_tersedia'] = $request->stok;

        // Handle cover upload
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->extension();
            $file->move(public_path('covers'), $filename);
            $validated['cover'] = $filename;
        }

        try {
            Buku::create($validated);
            return redirect()->route('buku.index')
                ->with('success', 'Buku berhasil ditambahkan!');
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            // Jika terjadi duplicate, generate ulang kode
            $validated['kode_buku'] = $this->generateKodeBuku($request->kategori, true);
            Buku::create($validated);
            return redirect()->route('buku.index')
                ->with('success', 'Buku berhasil ditambahkan dengan kode: ' . $validated['kode_buku']);
        }
    }

    public function show(Buku $buku)
    {
        $buku->load(['peminjaman.anggota']);
        return view('books.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $kategoris = Buku::distinct()->pluck('kategori')->sort()->values();
        return view('books.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'pengarang'    => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'kategori'     => 'required|string|max:100',
            'stok'         => 'required|integer|min:1',
            'isbn'         => 'nullable|string|max:20|unique:buku,isbn,' . $buku->id,
            'deskripsi'    => 'nullable|string',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Sesuaikan stok tersedia jika stok berubah
        $selisih = $request->stok - $buku->stok;
        $validated['stok_tersedia'] = max(0, $buku->stok_tersedia + $selisih);

        // Jika kategori berubah, update kode_buku
        if ($request->kategori !== $buku->kategori) {
            $validated['kode_buku'] = $this->generateKodeBuku($request->kategori);
        }

        if ($request->hasFile('cover')) {
            // Hapus cover lama
            if ($buku->cover && file_exists(public_path('covers/' . $buku->cover))) {
                unlink(public_path('covers/' . $buku->cover));
            }
            $file = $request->file('cover');
            $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->extension();
            $file->move(public_path('covers'), $filename);
            $validated['cover'] = $filename;
        }

        $buku->update($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(Buku $buku)
    {
        // Cek apakah buku sedang dipinjam
        if ($buku->peminjaman()->whereIn('status', ['dipinjam', 'terlambat'])->exists()) {
            return back()->with('error', 'Buku tidak dapat dihapus karena sedang dipinjam!');
        }

        // Hapus file cover
        if ($buku->cover && file_exists(public_path('covers/' . $buku->cover))) {
            unlink(public_path('covers/' . $buku->cover));
        }

        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil dihapus!');
    }

    /**
     * Generate unique kode buku
     * 
     * @param string|null $kategori
     * @param bool $forceNew
     * @return string
     */
    private function generateKodeBuku($kategori, $forceNew = false)
    {
        if (!$kategori) {
            $kategori = 'BKU';
        }
        
        $prefix = strtoupper(substr($kategori, 0, 3));
        
        // Cari kode terakhir dengan prefix yang sama
        $lastBuku = Buku::where('kode_buku', 'LIKE', $prefix . '%')
                        ->orderBy('kode_buku', 'desc')
                        ->first();
        
        if ($lastBuku && !$forceNew) {
            $lastNumber = (int) substr($lastBuku->kode_buku, strlen($prefix));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        $newKode = $prefix . $newNumber;
        
        // Double check unique (untuk keamanan)
        $counter = 1;
        while (Buku::where('kode_buku', $newKode)->exists()) {
            $newNumber = str_pad((int)$newNumber + 1, 4, '0', STR_PAD_LEFT);
            $newKode = $prefix . $newNumber;
            $counter++;
            
            // Prevent infinite loop
            if ($counter > 1000) {
                $newKode = $prefix . time();
                break;
            }
        }
        
        return $newKode;
    }

    /**
     * API endpoint untuk generate kode secara AJAX
     */
    public function generateKodeAjax(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:100'
        ]);
        
        $kode = $this->generateKodeBuku($request->kategori);
        
        return response()->json([
            'success' => true,
            'kode' => $kode
        ]);
    }
}