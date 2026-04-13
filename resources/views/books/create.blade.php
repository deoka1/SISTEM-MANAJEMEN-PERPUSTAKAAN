@extends('layouts.master')

@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku')
@section('page-subtitle', 'Tambahkan koleksi buku baru ke perpustakaan')

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
                    <i class="fas fa-book-open text-white text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-2xl">Form Tambah Buku</h3>
                    <p class="text-slate-400 text-sm mt-1">Isi data buku dengan lengkap dan benar</p>
                </div>
            </div>

            <form method="POST" action="{{ route('buku.store') }}" enctype="multipart/form-data">
                @csrf
                
                {{-- 2 Columns Layout untuk Desktop --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-6">
                    
                    {{-- Kolom Kiri --}}
                    <div class="space-y-6">
                        {{-- Judul Buku --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-heading text-yellow-500 mr-2"></i>
                                Judul Buku <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-book absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                <input type="text" 
                                       name="judul" 
                                       value="{{ old('judul') }}" 
                                       class="w-full pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('judul') border-red-500 @enderror" 
                                       placeholder="Masukkan judul buku">
                            </div>
                            @error('judul') 
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p> 
                            @enderror
                        </div>

                        {{-- Pengarang --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-user-pen text-yellow-500 mr-2"></i>
                                Pengarang <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                <input type="text" 
                                       name="pengarang" 
                                       value="{{ old('pengarang') }}" 
                                       class="w-full pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('pengarang') border-red-500 @enderror" 
                                       placeholder="Nama pengarang">
                            </div>
                            @error('pengarang') 
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Penerbit --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-building text-yellow-500 mr-2"></i>
                                Penerbit <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-building absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                <input type="text" 
                                       name="penerbit" 
                                       value="{{ old('penerbit') }}" 
                                       class="w-full pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('penerbit') border-red-500 @enderror" 
                                       placeholder="Nama penerbit">
                            </div>
                            @error('penerbit') 
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Tahun Terbit & Kategori (Row) --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-calendar-alt text-yellow-500 mr-2"></i>
                                    Tahun Terbit <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fas fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                    <input type="number" 
                                           name="tahun_terbit" 
                                           value="{{ old('tahun_terbit', date('Y')) }}" 
                                           min="1900" 
                                           max="{{ date('Y') + 5 }}" 
                                           class="w-full pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('tahun_terbit') border-red-500 @enderror">
                                </div>
                                @error('tahun_terbit') 
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-tag text-yellow-500 mr-2"></i>
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                    <input type="text" 
                                           name="kategori" 
                                           value="{{ old('kategori') }}" 
                                           class="w-full pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('kategori') border-red-500 @enderror" 
                                           placeholder="Contoh: Fiksi" 
                                           list="kategori-list">
                                    <datalist id="kategori-list">
                                        <option value="Fiksi">
                                        <option value="Non-Fiksi">
                                        <option value="Sains">
                                        <option value="Sejarah">
                                        <option value="Teknologi">
                                        <option value="Agama">
                                        <option value="Pendidikan">
                                        <option value="Biografi">
                                        <option value="Komik">
                                        <option value="Majalah">
                                    </datalist>
                                </div>
                                @error('kategori') 
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                @enderror
                            </div>
                        </div>

                        {{-- ISBN & Stok (Row) --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-barcode text-yellow-500 mr-2"></i>
                                    ISBN
                                </label>
                                <div class="relative">
                                    <i class="fas fa-barcode absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                    <input type="text" 
                                           name="isbn" 
                                           value="{{ old('isbn') }}" 
                                           class="w-full pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('isbn') border-red-500 @enderror" 
                                           placeholder="978-xxx-xxx-xxx-x">
                                </div>
                                @error('isbn') 
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <i class="fas fa-boxes text-yellow-500 mr-2"></i>
                                    Jumlah Stok <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fas fa-box absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                    <input type="number" 
                                           name="stok" 
                                           value="{{ old('stok', 1) }}" 
                                           min="0" 
                                           class="w-full pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition @error('stok') border-red-500 @enderror">
                                </div>
                                @error('stok') 
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-6">
                        {{-- Cover Buku --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-image text-yellow-500 mr-2"></i>
                                Cover Buku
                            </label>
                            <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-yellow-500 hover:bg-yellow-50/30 transition-all cursor-pointer group"
                                 onclick="document.getElementById('cover-input').click()">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center group-hover:bg-yellow-100 transition mb-3">
                                        <i class="fas fa-cloud-upload-alt text-slate-400 group-hover:text-yellow-600 text-2xl"></i>
                                    </div>
                                    <p class="text-slate-600 font-medium">Klik untuk upload cover</p>
                                    <p class="text-slate-400 text-sm mt-1">JPG, JPEG, PNG (Max 2MB)</p>
                                </div>
                            </div>
                            <input type="file" 
                                   name="cover" 
                                   accept="image/jpeg,image/png,image/jpg" 
                                   class="hidden" 
                                   id="cover-input" 
                                   onchange="previewCover(event)">
                            
                            {{-- Preview Cover --}}
                            <div id="cover-preview" class="mt-4 hidden">
                                <div class="bg-slate-50 rounded-xl p-4">
                                    <p class="text-sm font-semibold text-slate-700 mb-3">Preview Cover:</p>
                                    <div class="relative inline-block">
                                        <img id="preview-img" src="" alt="Preview cover buku" class="h-40 w-32 object-cover rounded-xl border-2 border-yellow-500 shadow-md">
                                        <button type="button" 
                                                onclick="removeCover()" 
                                                class="absolute -top-2 -right-2 w-7 h-7 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition shadow-md">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @error('cover') 
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-align-left text-yellow-500 mr-2"></i>
                                Deskripsi Buku
                            </label>
                            <div class="relative">
                                <i class="fas fa-quote-left absolute left-4 top-4 text-slate-400 text-base"></i>
                                <textarea name="deskripsi" 
                                          rows="8" 
                                          class="w-full pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition resize-y @error('deskripsi') border-red-500 @enderror" 
                                          placeholder="Sinopsis atau deskripsi buku...&#10;&#10;Contoh:&#10;Buku ini membahas tentang...&#10;Menceritakan kisah...">{{ old('deskripsi') }}</textarea>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <p class="text-xs text-slate-400 flex items-center gap-1">
                                    <i class="fas fa-info-circle"></i>
                                    Deskripsi yang baik akan membantu pembaca memahami isi buku
                                </p>
                                <span id="charCount" class="text-xs text-slate-400">0 karakter</span>
                            </div>
                            @error('deskripsi') 
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Info Card --}}
                <div class="mt-8 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl p-5 border border-yellow-200">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-info-circle text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-yellow-800">Informasi Penting</p>
                            <p class="text-yellow-700 text-sm mt-1">
                                Pastikan data buku yang dimasukkan sudah benar. 
                                Kode buku akan otomatis digenerate berdasarkan kategori yang dipilih.
                                Stok yang dimasukkan akan langsung tersedia untuk dipinjam.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-4 mt-8 pt-6 border-t border-slate-100">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2 text-base">
                        <i class="fas fa-save"></i>
                        Simpan Buku
                    </button>
                    <a href="{{ route('buku.index') }}" class="px-8 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-base">
                        <i class="fas fa-arrow-left"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewCover(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('cover-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (file) {
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Format Tidak Didukung',
                text: 'Gunakan format JPG, JPEG, atau PNG!',
                confirmButtonColor: '#f59e0b'
            });
            event.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Ukuran Terlalu Besar',
                text: 'Maksimal ukuran file adalah 2MB!',
                confirmButtonColor: '#f59e0b'
            });
            event.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function removeCover() {
    const coverInput = document.getElementById('cover-input');
    const preview = document.getElementById('cover-preview');
    
    coverInput.value = '';
    preview.classList.add('hidden');
    
    Swal.fire({
        icon: 'success',
        title: 'Cover Dihapus',
        text: 'Cover buku berhasil dihapus',
        confirmButtonColor: '#f59e0b',
        timer: 1500,
        showConfirmButton: false
    });
}

// Character counter untuk deskripsi
const textarea = document.querySelector('textarea[name="deskripsi"]');
const charCount = document.getElementById('charCount');

if (textarea && charCount) {
    textarea.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = length + ' karakter';
    });
}
</script>
@endpush
@endsection