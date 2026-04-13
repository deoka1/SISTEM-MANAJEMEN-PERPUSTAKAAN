@extends('layouts.master')

@section('title', 'Tambah Anggota')
@section('page-title', 'Tambah Anggota')
@section('page-subtitle', 'Daftarkan anggota baru ke perpustakaan')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-5xl">
    {{-- Card dengan gradient border --}}
    <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden">
        {{-- Gradient Border Top --}}
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-500 via-amber-500 to-yellow-500"></div>
        
        <div class="p-6 lg:p-8">
            {{-- Header Form dengan Icon --}}
            <div class="flex items-center gap-4 mb-8 pb-5 border-b border-slate-100">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-yellow-500 to-amber-500 flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-plus text-white text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-2xl">Form Pendaftaran Anggota</h3>
                    <p class="text-slate-400 text-sm mt-1">Isi data anggota dengan lengkap dan benar</p>
                </div>
            </div>

            <form method="POST" action="{{ route('anggota.store') }}">
                @csrf
                
                {{-- 2 Columns Layout untuk Desktop --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-6">
                    
                    {{-- Kolom Kiri --}}
                    <div class="space-y-6">
                        {{-- Nama Lengkap --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-user text-yellow-500 mr-2"></i>
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                <input type="text" 
                                       name="nama" 
                                       value="{{ old('nama') }}" 
                                       class="w-full pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('nama') border-red-500 @enderror" 
                                       placeholder="Masukkan nama lengkap anggota">
                            </div>
                            @error('nama') 
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p> 
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-envelope text-yellow-500 mr-2"></i>
                                Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       class="w-full pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('email') border-red-500 @enderror" 
                                       placeholder="anggota@example.com">
                            </div>
                            <p class="text-xs text-slate-400 mt-1.5 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i>
                                Email akan digunakan untuk login dan notifikasi
                            </p>
                            @error('email') 
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- No. Telepon --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-phone text-yellow-500 mr-2"></i>
                                No. Telepon
                            </label>
                            <div class="relative">
                                <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                <input type="tel" 
                                       name="telepon" 
                                       value="{{ old('telepon') }}" 
                                       class="w-full pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('telepon') border-red-500 @enderror" 
                                       placeholder="08123456789">
                            </div>
                            <p class="text-xs text-slate-400 mt-1.5 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i>
                                Nomor WhatsApp aktif untuk komunikasi
                            </p>
                            @error('telepon') 
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-6">
                        {{-- Jenis Kelamin --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-venus-mars text-yellow-500 mr-2"></i>
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-venus-mars absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                <select name="jenis_kelamin" 
                                        class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition appearance-none cursor-pointer bg-white @error('jenis_kelamin') border-red-500 @enderror">
                                    <option value="">Pilih jenis kelamin</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>👨 Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>👩 Perempuan</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                            </div>
                            @error('jenis_kelamin') 
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Tanggal Daftar --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-calendar-alt text-yellow-500 mr-2"></i>
                                Tanggal Daftar <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                <input type="date" 
                                       name="tanggal_daftar" 
                                       value="{{ old('tanggal_daftar', date('Y-m-d')) }}" 
                                       class="w-full pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('tanggal_daftar') border-red-500 @enderror">
                            </div>
                            <div class="mt-1.5 flex items-center gap-2">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs bg-emerald-100 text-emerald-700">
                                    <i class="fas fa-check-circle text-[10px]"></i>
                                    Masa berlaku otomatis 1 tahun
                                </span>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-700">
                                    <i class="fas fa-id-card text-[10px]"></i>
                                    No. Anggota auto generate
                                </span>
                            </div>
                            @error('tanggal_daftar') 
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-map-marker-alt text-yellow-500 mr-2"></i>
                                Alamat
                            </label>
                            <div class="relative">
                                <i class="fas fa-map-marker-alt absolute left-4 top-4 text-slate-400 text-base"></i>
                                <textarea name="alamat" 
                                          rows="5" 
                                          class="w-full pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition resize-y @error('alamat') border-red-500 @enderror" 
                                          placeholder="Alamat lengkap anggota&#10;&#10;Contoh:&#10;Jl. Merdeka No. 123, RT 01/RW 02&#10;Kel. Sukamaju, Kec. Sukabumi&#10;Kota Bandung, Jawa Barat 12345">{{ old('alamat') }}</textarea>
                            </div>
                            <p class="text-xs text-slate-400 mt-1.5 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i>
                                Isi alamat dengan lengkap untuk memudahkan komunikasi dan pengiriman
                            </p>
                            @error('alamat') 
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Preview Kartu Anggota --}}
                <div class="mt-8 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl p-5 border border-yellow-200">
                    <p class="text-sm font-semibold text-yellow-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-id-card text-yellow-600"></i>
                        Preview Kartu Anggota
                    </p>
                    <div class="bg-white rounded-xl p-4 border border-yellow-200 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-yellow-500 to-amber-500 flex items-center justify-center shadow-md">
                                <i class="fas fa-user text-white text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-base font-bold text-slate-800" id="previewNama">-</p>
                                <p class="text-sm text-slate-500" id="previewEmail">-</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-mono text-slate-400">No. Anggota</p>
                                <p class="text-sm font-bold text-yellow-600" id="previewNoAnggota">LIB2024120001</p>
                                <p class="text-xs text-emerald-600 mt-1">✓ Aktif 1 tahun</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Informasi Penting --}}
                <div class="mt-6 bg-blue-50 rounded-xl p-4 border border-blue-200">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shield-alt text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-blue-800 text-sm">Informasi Keanggotaan</p>
                            <p class="text-blue-700 text-xs mt-1">
                                Setelah mendaftar, anggota akan mendapatkan No. Anggota otomatis dan dapat langsung melakukan peminjaman buku.
                                Masa berlaku keanggotaan adalah 1 tahun dari tanggal pendaftaran.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-4 mt-8 pt-6 border-t border-slate-100">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2 text-base">
                        <i class="fas fa-save"></i>
                        Daftarkan Anggota
                    </button>
                    <a href="{{ route('anggota.index') }}" class="px-8 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-base">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Live preview untuk nama dan email
    const namaInput = document.querySelector('input[name="nama"]');
    const emailInput = document.querySelector('input[name="email"]');
    const previewNama = document.getElementById('previewNama');
    const previewEmail = document.getElementById('previewEmail');
    const previewNoAnggota = document.getElementById('previewNoAnggota');

    if (namaInput) {
        namaInput.addEventListener('input', function() {
            previewNama.textContent = this.value || '-';
        });
    }

    if (emailInput) {
        emailInput.addEventListener('input', function() {
            previewEmail.textContent = this.value || '-';
        });
    }

    // Animasi preview No Anggota (simulasi)
    const tahun = new Date().getFullYear();
    const bulan = String(new Date().getMonth() + 1).padStart(2, '0');
    if (previewNoAnggota) {
        previewNoAnggota.textContent = `LIB${tahun}${bulan}0001`;
    }

    // Validasi nomor telepon real-time
    const teleponInput = document.querySelector('input[name="telepon"]');
    if (teleponInput) {
        teleponInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 0 && !this.value.startsWith('08')) {
                this.value = '08' + this.value.substring(2);
            }
            if (this.value.length > 13) {
                this.value = this.value.substring(0, 13);
            }
        });
    }
</script>
@endpush
@endsection