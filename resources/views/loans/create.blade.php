@extends('layouts.master')

@section('title', 'Catat Peminjaman')
@section('page-title', 'Catat Peminjaman')
@section('page-subtitle', 'Tambahkan transaksi peminjaman buku baru')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <form method="POST" action="{{ route('peminjaman.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Anggota --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Anggota <span class="text-red-500">*</span>
                    </label>
                    <select name="anggota_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all bg-gray-50 @error('anggota_id') border-red-400 @enderror" required>
                        <option value="">Pilih Anggota...</option>
                        @foreach($anggota as $a)
                            <option value="{{ $a->id }}" {{ old('anggota_id') == $a->id ? 'selected' : '' }}>
                                {{ $a->no_anggota }} — {{ $a->nama }}
                            </option>
                        @endforeach
                    </select>
                    @if($anggota->isEmpty())
                        <p class="text-amber-600 text-xs mt-1">
                            <i class="fas fa-triangle-exclamation mr-1"></i>
                            Tidak ada anggota aktif. <a href="{{ route('anggota.create') }}" class="underline text-yellow-600 hover:text-yellow-700">Tambah anggota</a>
                        </p>
                    @endif
                    @error('anggota_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Buku --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Buku <span class="text-red-500">*</span>
                    </label>
                    <select name="buku_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all bg-gray-50 @error('buku_id') border-red-400 @enderror" required>
                        <option value="">Pilih Buku...</option>
                        @foreach($buku as $b)
                            <option value="{{ $b->id }}" {{ old('buku_id') == $b->id ? 'selected' : '' }}>
                                [{{ $b->kode_buku }}] {{ $b->judul }} (Stok: {{ $b->stok_tersedia }})
                            </option>
                        @endforeach
                    </select>
                    @if($buku->isEmpty())
                        <p class="text-amber-600 text-xs mt-1">
                            <i class="fas fa-triangle-exclamation mr-1"></i>
                            Tidak ada buku tersedia. <a href="{{ route('buku.create') }}" class="underline text-yellow-600 hover:text-yellow-700">Tambah buku</a>
                        </p>
                    @endif
                    @error('buku_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tanggal Pinjam --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Tanggal Pinjam <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" 
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all bg-gray-50 @error('tanggal_pinjam') border-red-400 @enderror" 
                           id="tanggal-pinjam" onchange="setMinKembali()">
                    @error('tanggal_pinjam') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tanggal Kembali Rencana --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Tanggal Kembali Rencana <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_kembali_rencana" value="{{ old('tanggal_kembali_rencana', date('Y-m-d', strtotime('+7 days'))) }}" 
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all bg-gray-50 @error('tanggal_kembali_rencana') border-red-400 @enderror" 
                           id="tanggal-kembali">
                    <p class="text-xs text-gray-400 mt-1">
                        <i class="fas fa-info-circle text-yellow-500 mr-1"></i>
                        Maksimal peminjaman: 14 hari
                    </p>
                    @error('tanggal_kembali_rencana') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Keterangan --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="3" 
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all bg-gray-50 @error('keterangan') border-red-400 @enderror" 
                              placeholder="Catatan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Info Denda --}}
            <div class="bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="fas fa-circle-info text-white text-sm"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-yellow-800">
                            <strong class="font-semibold">Perhatian:</strong> Denda keterlambatan dikenakan 
                            <strong class="text-yellow-700">Rp 1.000 per hari</strong> setelah tanggal kembali rencana.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white font-semibold px-6 py-2.5 rounded-xl transition-all shadow-md">
                    <i class="fas fa-save"></i> Catat Peminjaman
                </button>
                <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center gap-2 border border-gray-300 hover:border-yellow-500 text-gray-600 hover:text-yellow-600 font-semibold px-6 py-2.5 rounded-xl transition-all bg-white">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function setMinKembali() {
    const pinjam = document.getElementById('tanggal-pinjam').value;
    if (pinjam) {
        const next = new Date(pinjam);
        next.setDate(next.getDate() + 1);
        const maxDate = new Date(pinjam);
        maxDate.setDate(maxDate.getDate() + 14);
        
        const kembaliInput = document.getElementById('tanggal-kembali');
        kembaliInput.min = next.toISOString().split('T')[0];
        kembaliInput.max = maxDate.toISOString().split('T')[0];
        
        // Jika tanggal kembali melebihi max, set ke max
        if (kembaliInput.value && kembaliInput.value > kembaliInput.max) {
            kembaliInput.value = kembaliInput.max;
        }
    }
}

// Panggil saat halaman load
document.addEventListener('DOMContentLoaded', function() {
    setMinKembali();
});
</script>
@endpush
@endsection