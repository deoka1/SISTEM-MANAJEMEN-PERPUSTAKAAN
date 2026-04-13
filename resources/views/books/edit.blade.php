@extends('layouts.master')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')
@section('page-subtitle', 'Perbarui informasi buku: ' . $buku->judul)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-amber-50/20 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-book text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Edit Buku</h1>
                    <p class="text-slate-500 text-sm mt-1">Perbarui informasi buku: <span class="font-semibold text-amber-600">{{ $buku->judul }}</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Main Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 sm:px-8 py-5">
                        <h2 class="text-white font-bold text-lg flex items-center gap-2">
                            <i class="fas fa-edit"></i>
                            Form Edit Buku
                        </h2>
                        <p class="text-slate-400 text-sm mt-1">Lengkapi data buku dengan benar</p>
                    </div>

                    <form method="POST" action="{{ route('buku.update', $buku) }}" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                        @csrf @method('PUT')

                        <div class="space-y-5">
                            {{-- Judul Buku --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Judul Buku <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-heading text-slate-400"></i>
                                    </div>
                                    <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" 
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('judul') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all"
                                        placeholder="Masukkan judul buku">
                                </div>
                                @error('judul') 
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                    </p> 
                                @enderror
                            </div>

                            {{-- Pengarang & Penerbit --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Pengarang <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user-pen text-slate-400"></i>
                                        </div>
                                        <input type="text" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}" 
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('pengarang') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all"
                                            placeholder="Nama pengarang">
                                    </div>
                                    @error('pengarang') 
                                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Penerbit <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-building text-slate-400"></i>
                                        </div>
                                        <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" 
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('penerbit') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all"
                                            placeholder="Nama penerbit">
                                    </div>
                                    @error('penerbit') 
                                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                    @enderror
                                </div>
                            </div>

                            {{-- Tahun & Kategori --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Tahun Terbit <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-calendar text-slate-400"></i>
                                        </div>
                                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" 
                                            min="1900" max="{{ date('Y')+1 }}" 
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('tahun_terbit') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all"
                                            placeholder="Tahun terbit">
                                    </div>
                                    @error('tahun_terbit') 
                                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Kategori <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-tag text-slate-400"></i>
                                        </div>
                                        <input type="text" name="kategori" value="{{ old('kategori', $buku->kategori) }}" 
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('kategori') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all"
                                            list="kategori-list" placeholder="Pilih atau ketik kategori">
                                        <datalist id="kategori-list">
                                            @foreach($kategoris as $kat)
                                                <option value="{{ $kat }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                    @error('kategori') 
                                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                    @enderror
                                </div>
                            </div>

                            {{-- ISBN & Stok --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        ISBN
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-barcode text-slate-400"></i>
                                        </div>
                                        <input type="text" name="isbn" value="{{ old('isbn', $buku->isbn) }}" 
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('isbn') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all"
                                            placeholder="Nomor ISBN">
                                    </div>
                                    @error('isbn') 
                                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Jumlah Stok <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-boxes text-slate-400"></i>
                                        </div>
                                        <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" 
                                            min="1" 
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('stok') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all"
                                            placeholder="Jumlah stok">
                                    </div>
                                    <div class="mt-1.5 flex items-center gap-2 text-xs">
                                        <span class="text-slate-500">Stok tersedia saat ini:</span>
                                        <span class="font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">{{ $buku->stok_tersedia }}</span>
                                    </div>
                                    @error('stok') 
                                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                    @enderror
                                </div>
                            </div>

                            {{-- Cover Buku --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Cover Buku
                                </label>
                                @if($buku->cover)
                                    <div class="mb-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('covers/'.$buku->cover) }}" alt="cover" class="h-24 w-20 object-cover rounded-lg shadow-md">
                                            <div class="text-sm">
                                                <p class="text-slate-600">Cover saat ini</p>
                                                <p class="text-xs text-slate-400 mt-1">Upload gambar baru untuk mengganti</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-image text-slate-400"></i>
                                    </div>
                                    <input type="file" name="cover" accept="image/jpg,image/jpeg,image/png" 
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('cover') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100"
                                        onchange="previewCover(event)">
                                </div>
                                <div id="cover-preview" class="mt-3 hidden">
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                                        <p class="text-xs text-slate-500 mb-2">Preview cover baru:</p>
                                        <img id="preview-img" src="" alt="preview" class="h-24 w-20 object-cover rounded-lg shadow-md">
                                    </div>
                                </div>
                                @error('cover') 
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Deskripsi
                                </label>
                                <div class="relative">
                                    <div class="absolute top-3 left-3 pointer-events-none">
                                        <i class="fas fa-align-left text-slate-400"></i>
                                    </div>
                                    <textarea name="deskripsi" rows="5" 
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border-2 @error('deskripsi') border-red-400 bg-red-50 @else border-slate-200 focus:border-amber-400 @enderror focus:outline-none focus:ring-2 focus:ring-amber-200 transition-all resize-none"
                                        placeholder="Deskripsi singkat tentang buku...">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                                </div>
                                @error('deskripsi') 
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col sm:flex-row items-center gap-3 pt-4 border-t border-slate-200">
                            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i>
                                Perbarui Buku
                                <i class="fas fa-arrow-right"></i>
                            </button>
                            <a href="{{ route('buku.index') }}" class="w-full sm:w-auto bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 px-6 rounded-xl transition-all duration-200 flex items-center justify-center gap-2">
                                <i class="fas fa-times"></i>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sidebar Info --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    {{-- Info Card --}}
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-info-circle text-white"></i>
                            </div>
                            <h3 class="font-bold text-slate-800">Tips Mengisi Form</h3>
                        </div>
                        <div class="space-y-3 text-sm text-slate-700">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                                <span>Pastikan semua data terisi dengan benar</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                                <span>Cover buku maksimal 2MB (JPG/PNG)</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                                <span>Stok minimal 1 buku</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                                <span>Deskripsi opsional tapi disarankan</span>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-4 flex items-center gap-2">
                            <i class="fas fa-chart-line text-amber-500"></i>
                            Statistik Cepat
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500 text-sm">Kode Buku</span>
                                <span class="font-mono text-sm font-semibold text-slate-700">{{ $buku->kode_buku }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500 text-sm">Total Dibuat</span>
                                <span class="text-sm font-semibold text-slate-700">{{ $buku->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500 text-sm">Terakhir Update</span>
                                <span class="text-sm font-semibold text-slate-700">{{ $buku->updated_at->format('d/m/Y') }}</span>
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
function previewCover(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB.');
            event.target.value = '';
            return;
        }
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung! Gunakan JPG, JPEG, atau PNG.');
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('cover-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection