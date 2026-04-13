@extends('layouts.portal')

@section('title', 'Booking: ' . $buku->judul)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-amber-50/30 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="text-sm text-slate-500 mb-6 sm:mb-8 flex items-center gap-2 flex-wrap">
            <a href="{{ route('portal.index') }}" class="hover:text-amber-600 transition-colors">
                <i class="fas fa-home mr-1"></i>Katalog
            </a>
            <i class="fas fa-chevron-right text-xs text-slate-400"></i>
            <a href="{{ route('portal.detail', $buku) }}" class="hover:text-amber-600 transition-colors">
                {{ Str::limit($buku->judul, 30) }}
            </a>
            <i class="fas fa-chevron-right text-xs text-slate-400"></i>
            <span class="text-amber-600 font-medium">Form Booking</span>
        </nav>

        {{-- Header --}}
        <div class="text-center mb-8 sm:mb-12">
            <div class="inline-flex items-center gap-2 bg-amber-100 text-amber-700 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                <i class="fas fa-book-open"></i>
                <span>Peminjaman Buku</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 mb-3">Booking Buku</h1>
            <p class="text-slate-500 max-w-md mx-auto">Isi formulir di bawah untuk memesan buku secara online</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

            {{-- Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 sm:px-8 py-5">
                        <h2 class="text-white font-bold text-xl flex items-center gap-2">
                            <i class="fas fa-file-alt"></i>
                            Form Pemesanan
                        </h2>
                        <p class="text-amber-100 text-sm mt-1">Lengkapi data dengan benar</p>
                    </div>

                    <form method="POST" action="{{ route('portal.booking.simpan', $buku) }}" class="p-6 sm:p-8 space-y-6">
                        @csrf

                        {{-- No Anggota --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nomor Anggota <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-id-card text-slate-400"></i>
                                </div>
                                <input type="text" name="no_anggota" value="{{ old('no_anggota') }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('no_anggota') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all"
                                    placeholder="Contoh: LIB20240001" autofocus>
                            </div>
                            <p class="text-xs text-slate-400 mt-1.5 flex items-center gap-1">
                                <i class="fas fa-circle-info"></i>
                                Belum punya kartu anggota? Daftar dulu ke petugas perpustakaan.
                            </p>
                            @error('no_anggota') 
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <i class="fas fa-triangle-exclamation"></i>{{ $message }}
                                </p> 
                            @enderror
                        </div>

                        {{-- Nama Lengkap --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-slate-400"></i>
                                </div>
                                <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam') }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('nama_peminjam') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all"
                                    placeholder="Nama sesuai kartu anggota">
                            </div>
                            @error('nama_peminjam') 
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Email & Telepon --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-slate-400"></i>
                                    </div>
                                    <input type="email" name="email_peminjam" value="{{ old('email_peminjam') }}"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('email_peminjam') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all"
                                        placeholder="email@contoh.com">
                                </div>
                                @error('email_peminjam') 
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    No. Telepon
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-slate-400"></i>
                                    </div>
                                    <input type="text" name="telepon_peminjam" value="{{ old('telepon_peminjam') }}"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('telepon_peminjam') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all"
                                        placeholder="08xxxxxxxxxx">
                                </div>
                                @error('telepon_peminjam') 
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                @enderror
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Tanggal Ambil Buku <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-slate-400"></i>
                                    </div>
                                    <input type="date" name="tanggal_pinjam_rencana"
                                        value="{{ old('tanggal_pinjam_rencana') }}"
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('tanggal_pinjam_rencana') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all"
                                        id="tgl-pinjam" onchange="updateMinKembali()">
                                </div>
                                @error('tanggal_pinjam_rencana') 
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Tanggal Kembali <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-check text-slate-400"></i>
                                    </div>
                                    <input type="date" name="tanggal_kembali_rencana"
                                        value="{{ old('tanggal_kembali_rencana') }}"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('tanggal_kembali_rencana') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all"
                                        id="tgl-kembali">
                                </div>
                                <p class="text-xs text-slate-400 mt-1.5 flex items-center gap-1">
                                    <i class="fas fa-info-circle"></i>
                                    Maksimal 14 hari peminjaman
                                </p>
                                @error('tanggal_kembali_rencana') 
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                @enderror
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Catatan <span class="text-slate-400 font-normal">(opsional)</span>
                            </label>
                            <textarea name="catatan" rows="3"
                                class="w-full px-4 py-3 rounded-xl border-2 @error('catatan') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all resize-none"
                                placeholder="Pesan tambahan untuk petugas...">{{ old('catatan') }}</textarea>
                            @error('catatan') 
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Warning Box --}}
                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-l-4 border-amber-500 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-exclamation-triangle text-amber-600 text-lg mt-0.5"></i>
                                <div class="text-sm text-amber-800">
                                    <p class="font-semibold mb-1">Perhatian:</p>
                                    <p>Booking akan dikonfirmasi oleh petugas dalam 1×24 jam.</p>
                                    <p class="mt-1">Denda keterlambatan <strong>Rp 1.000/hari</strong>.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-bold py-3.5 px-6 rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg flex items-center justify-center gap-2">
                            <i class="fas fa-bookmark"></i>
                            Kirim Permintaan Booking
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Ringkasan Buku --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    {{-- Book Card --}}
                    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden mb-6">
                        <div class="bg-gradient-to-br from-slate-700 to-slate-800 px-6 py-4">
                            <h3 class="text-white font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                                <i class="fas fa-book"></i>
                                Detail Buku
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex gap-4 mb-5">
                                <div class="w-20 h-28 bg-gradient-to-br from-amber-100 to-orange-100 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden shadow-md">
                                    @if($buku->cover && file_exists(public_path('covers/'.$buku->cover)))
                                        <img src="{{ asset('covers/'.$buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-book text-amber-400 text-3xl"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-slate-800 text-sm leading-tight line-clamp-3">{{ $buku->judul }}</p>
                                    <p class="text-slate-500 text-xs mt-2">
                                        <i class="fas fa-user-edit mr-1"></i>{{ $buku->pengarang }}
                                    </p>
                                    <p class="text-slate-400 text-xs mt-0.5">
                                        <i class="fas fa-building mr-1"></i>{{ $buku->penerbit }}, {{ $buku->tahun_terbit }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-3 text-xs border-t border-slate-100 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-500 flex items-center gap-1">
                                        <i class="fas fa-tag"></i> Kategori
                                    </span>
                                    <span class="font-medium text-slate-700 bg-slate-100 px-2 py-1 rounded-lg">{{ $buku->kategori }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-500 flex items-center gap-1">
                                        <i class="fas fa-barcode"></i> Kode Buku
                                    </span>
                                    <span class="font-mono text-slate-700 bg-slate-100 px-2 py-1 rounded-lg text-xs">{{ $buku->kode_buku }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-500 flex items-center gap-1">
                                        <i class="fas fa-boxes"></i> Stok Tersedia
                                    </span>
                                    <span class="font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">
                                        {{ $buku->stok_tersedia }} eksemplar
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-5 border border-blue-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-info-circle text-white"></i>
                            </div>
                            <h4 class="font-bold text-slate-800">Info Pemesanan</h4>
                        </div>
                        <div class="space-y-3 text-sm text-slate-700">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                                <span>Booking gratis, tanpa biaya pendaftaran</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-clock text-blue-500 mt-0.5"></i>
                                <span>Konfirmasi dalam 1×24 jam</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-save text-purple-500 mt-0.5"></i>
                                <span>Simpan kode booking untuk pengecekan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
function updateMinKembali() {
    const pinjam = document.getElementById('tgl-pinjam').value;
    if (pinjam) {
        const d = new Date(pinjam);
        d.setDate(d.getDate() + 1);
        document.getElementById('tgl-kembali').min = d.toISOString().split('T')[0];

        // Set default kembali = +7 hari dari pinjam
        const def = new Date(pinjam);
        def.setDate(def.getDate() + 7);
        if (!document.getElementById('tgl-kembali').value) {
            document.getElementById('tgl-kembali').value = def.toISOString().split('T')[0];
        }
        
        // Set max kembali = +14 hari
        const max = new Date(pinjam);
        max.setDate(max.getDate() + 14);
        document.getElementById('tgl-kembali').max = max.toISOString().split('T')[0];
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('tgl-pinjam').value) {
        updateMinKembali();
    }
});
</script>
@endpush
@endsection