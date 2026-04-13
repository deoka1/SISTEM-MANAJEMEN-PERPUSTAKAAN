@extends('layouts.master')

@section('title', 'Edit Anggota')
@section('page-title', 'Edit Anggota')
@section('page-subtitle', 'Perbarui data anggota: ' . ($anggota->nama ?? ''))

@section('content')
<div class="max-w-3xl">
    <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-500 via-amber-500 to-yellow-500"></div>
        
        <div class="p-8">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500 to-amber-500 flex items-center justify-center shadow-md">
                    <i class="fas fa-user-edit text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Form Edit Anggota</h3>
                    <p class="text-slate-400 text-xs">Perbarui data anggota dengan lengkap dan benar</p>
                </div>
            </div>

            {{-- PERBAIKAN: Gunakan parameter yang benar --}}
            <form method="POST" action="{{ route('anggota.update', $anggota->id) }}" class="space-y-6">
                @csrf 
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="md:col-span-2">
                        <label class="form-label flex items-center gap-2">
                            <i class="fas fa-user text-yellow-500 text-xs"></i>
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" 
                                   name="nama" 
                                   value="{{ old('nama', $anggota->nama ?? '') }}" 
                                   class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('nama') border-red-500 @enderror" 
                                   placeholder="Nama lengkap anggota">
                        </div>
                        @error('nama') 
                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p> 
                        @enderror
                    </div>

                    <div>
                        <label class="form-label flex items-center gap-2">
                            <i class="fas fa-envelope text-yellow-500 text-xs"></i>
                            Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email', $anggota->email ?? '') }}" 
                                   class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('email') border-red-500 @enderror" 
                                   placeholder="anggota@example.com">
                        </div>
                        @error('email') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <div>
                        <label class="form-label flex items-center gap-2">
                            <i class="fas fa-phone text-yellow-500 text-xs"></i>
                            No. Telepon
                        </label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="tel" 
                                   name="telepon" 
                                   value="{{ old('telepon', $anggota->telepon ?? '') }}" 
                                   class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('telepon') border-red-500 @enderror" 
                                   placeholder="08123456789">
                        </div>
                        @error('telepon') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <div>
                        <label class="form-label flex items-center gap-2">
                            <i class="fas fa-venus-mars text-yellow-500 text-xs"></i>
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-venus-mars absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <select name="jenis_kelamin" 
                                    class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition appearance-none @error('jenis_kelamin') border-red-500 @enderror">
                                <option value="L" {{ old('jenis_kelamin', $anggota->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>👨 Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $anggota->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>👩 Perempuan</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        </div>
                        @error('jenis_kelamin') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <div>
                        <label class="form-label flex items-center gap-2">
                            <i class="fas fa-circle text-yellow-500 text-xs"></i>
                            Status <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-flag-checkered absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <select name="status" 
                                    class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition appearance-none @error('status') border-red-500 @enderror">
                                <option value="aktif" {{ old('status', $anggota->status ?? '') == 'aktif' ? 'selected' : '' }}>✅ Aktif</option>
                                <option value="nonaktif" {{ old('status', $anggota->status ?? '') == 'nonaktif' ? 'selected' : '' }}>❌ Nonaktif</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        </div>
                        @error('status') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <div>
                        <label class="form-label flex items-center gap-2">
                            <i class="fas fa-id-card text-yellow-500 text-xs"></i>
                            No. Anggota
                        </label>
                        <div class="relative">
                            <i class="fas fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" 
                                   value="{{ $anggota->no_anggota ?? '-' }}" 
                                   class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-sm bg-slate-50 text-slate-600" 
                                   readonly
                                   disabled>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Nomor anggota tidak dapat diubah</p>
                    </div>

                    <div>
                        <label class="form-label flex items-center gap-2">
                            <i class="fas fa-calendar-plus text-yellow-500 text-xs"></i>
                            Tanggal Daftar <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="date" 
                                   name="tanggal_daftar" 
                                   value="{{ old('tanggal_daftar', isset($anggota->tanggal_daftar) ? $anggota->tanggal_daftar->format('Y-m-d') : date('Y-m-d')) }}" 
                                   class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('tanggal_daftar') border-red-500 @enderror">
                        </div>
                        @error('tanggal_daftar') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <div>
                        <label class="form-label flex items-center gap-2">
                            <i class="fas fa-calendar-times text-yellow-500 text-xs"></i>
                            Masa Berlaku <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="date" 
                                   name="tanggal_expired" 
                                   value="{{ old('tanggal_expired', isset($anggota->tanggal_expired) ? $anggota->tanggal_expired->format('Y-m-d') : date('Y-m-d', strtotime('+1 year'))) }}" 
                                   class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('tanggal_expired') border-red-500 @enderror">
                        </div>
                        <p class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                            <i class="fas fa-info-circle text-yellow-500"></i>
                            Atur masa berlaku keanggotaan
                        </p>
                        @error('tanggal_expired') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="form-label flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-yellow-500 text-xs"></i>
                            Alamat
                        </label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-4 top-4 text-slate-400 text-sm"></i>
                            <textarea name="alamat" 
                                      rows="4" 
                                      class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('alamat') border-red-500 @enderror" 
                                      placeholder="Alamat lengkap anggota">{{ old('alamat', $anggota->alamat ?? '') }}</textarea>
                        </div>
                        @error('alamat') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>

                <div class="bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl p-4 border border-yellow-200">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-yellow-600 mt-0.5"></i>
                        <div class="text-sm">
                            <p class="font-semibold text-yellow-800">Informasi Keanggotaan</p>
                            <p class="text-yellow-700 text-xs mt-1">
                                Status <strong>"Nonaktif"</strong> akan membuat anggota tidak dapat melakukan peminjaman buku.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white font-semibold py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        Perbarui Data
                    </button>
                    <a href="{{ route('anggota.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition-all duration-200 flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection