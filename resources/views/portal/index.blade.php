@extends('layouts.portal')

@section('title', 'Katalog Buku')

@section('content')

{{-- Hero Section with Stats Bar --}}
<section class="relative text-white overflow-hidden min-h-screen flex flex-col"
         style="background-image: url('{{ asset('img/hero2.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
    
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/60 to-black/50"></div>
    
    {{-- Content - Flex to fill screen --}}
    <div class="relative z-10 flex flex-col flex-1">
        
        {{-- Spacer untuk navbar (karena navbar fixed) --}}
        <div class="h-16 md:h-20"></div>
        
        {{-- Hero Content - Centered vertically --}}
        <div class="flex-1 flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-8 sm:py-12">
                <div class="max-w-2xl">
                    <div class="animate-fade-in-up">
                        <p class="text-yellow-200 font-medium text-xs sm:text-sm mb-3 tracking-wider uppercase flex items-center gap-2">
                            <i class="fas fa-gem text-yellow-300"></i> 
                            <span>Selamat Datang di</span>
                        </p>
                        <h1 class="font-display text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-4 sm:mb-5">
                            Perpustakaan <br><em class="text-yellow-300">Digital</em> Kami
                        </h1>
                        <p class="text-gray-200 text-base sm:text-lg md:text-xl mb-8 sm:mb-10 leading-relaxed max-w-lg">
                            Temukan ribuan koleksi buku berkualitas. Booking online, ambil di perpustakaan.
                        </p>

                        {{-- Search bar --}}
                        <form method="GET" action="{{ route('portal.index') }}" class="flex flex-col sm:flex-row gap-3 max-w-xl animate-fade-in-up animation-delay-200">
                            <div class="relative flex-1">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm sm:text-base"></i>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari judul, pengarang, atau ISBN..."
                                    class="w-full pl-11 sm:pl-12 pr-4 py-3 sm:py-4 rounded-xl text-gray-800 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-yellow-500 shadow-lg bg-white/95 backdrop-blur-sm">
                            </div>
                            <button type="submit" class="bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white font-semibold px-6 sm:px-8 py-3 sm:py-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-yellow-500/30 hover:scale-105 text-sm sm:text-base whitespace-nowrap">
                                <i class="fas fa-search mr-2"></i> Cari Buku
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Bar - Tetap di bawah --}}
        <div class="border-t border-white/20 bg-black/30 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-5">
                <div class="flex flex-wrap justify-center md:justify-start gap-4 sm:gap-6 md:gap-10">
                    
                    {{-- Total Buku --}}
                    <div class="group flex items-center gap-2 sm:gap-3 bg-white/10 backdrop-blur-sm rounded-xl sm:rounded-2xl px-3 sm:px-5 py-2 sm:py-3 hover:bg-white/20 transition-all duration-300 hover:scale-105 cursor-pointer">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-yellow-500/30 transition-all">
                            <i class="fas fa-book text-white text-sm sm:text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xl sm:text-2xl font-bold text-white">{{ $totalBuku }}</p>
                            <p class="text-[10px] sm:text-xs text-yellow-200 font-medium">Total Buku</p>
                        </div>
                    </div>
                    
                    {{-- Buku Tersedia --}}
                    <div class="group flex items-center gap-2 sm:gap-3 bg-white/10 backdrop-blur-sm rounded-xl sm:rounded-2xl px-3 sm:px-5 py-2 sm:py-3 hover:bg-white/20 transition-all duration-300 hover:scale-105 cursor-pointer">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-emerald-500 to-green-500 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-emerald-500/30 transition-all">
                            <i class="fas fa-circle-check text-white text-sm sm:text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xl sm:text-2xl font-bold text-white">{{ $bukuTersedia }}</p>
                            <p class="text-[10px] sm:text-xs text-emerald-200 font-medium">Buku Tersedia</p>
                        </div>
                    </div>
                    
                    <!-- {{-- Total Peminjaman (opsional) --}}
                    <div class="group flex items-center gap-2 sm:gap-3 bg-white/10 backdrop-blur-sm rounded-xl sm:rounded-2xl px-3 sm:px-5 py-2 sm:py-3 hover:bg-white/20 transition-all duration-300 hover:scale-105 cursor-pointer">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-blue-500/30 transition-all">
                            <i class="fas fa-users text-white text-sm sm:text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xl sm:text-2xl font-bold text-white">{{ $totalPeminjam ?? '500+' }}</p>
                            <p class="text-[10px] sm:text-xs text-blue-200 font-medium">Peminjam Aktif</p>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .animation-delay-200 {
        animation-delay: 0.2s;
        opacity: 0;
        animation-fill-mode: forwards;
    }
    
    /* Responsive adjustments */
    @media (min-height: 800px) {
        .hero-content {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
    }
    
    @media (max-height: 600px) {
        .min-h-screen {
            min-height: 100vh;
        }
    }
    
    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }
    
    /* Enhanced stats bar hover effect */
    .group {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .group:hover {
        transform: translateY(-2px);
    }
</style>

{{-- Filter & Katalog --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

   {{-- Filter Bar Minimalis --}}
<form method="GET" action="{{ route('portal.index') }}" class="mb-6 sm:mb-8">
    <div class="flex flex-col md:flex-row gap-3">
        {{-- Search --}}
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs sm:text-sm"></i>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Cari buku..." 
                   class="w-full pl-9 sm:pl-10 pr-4 py-2.5 sm:py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 bg-white">
        </div>
        
        {{-- Kategori --}}
        <div class="relative md:w-48">
            <select name="kategori" onchange="this.form.submit()" class="w-full appearance-none bg-white border border-slate-200 rounded-xl px-4 py-2.5 sm:py-3 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
        </div>
        
        {{-- Tersedia --}}
        <label class="flex items-center gap-2 px-3 sm:px-4 py-2.5 sm:py-3 bg-white border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition">
            <input type="checkbox" name="tersedia" value="1" onchange="this.form.submit()" {{ request('tersedia') ? 'checked' : '' }} class="rounded border-slate-300 text-yellow-500 focus:ring-yellow-400">
            <span class="text-xs sm:text-sm text-slate-600">Tersedia</span>
        </label>
        
        {{-- Submit & Reset --}}
        <button type="submit" class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-5 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold hover:shadow-lg transition">
            <i class="fas fa-search"></i>
        </button>
        
        @if(request()->hasAny(['search', 'kategori', 'tersedia']))
            <a href="{{ route('portal.index') }}" class="flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 sm:py-3 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-red-500 hover:border-red-200 transition">
                <i class="fas fa-times"></i>
                <span class="hidden sm:inline">Reset</span>
            </a>
        @endif
    </div>
    
    {{-- Result & Active Filters --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mt-3 text-xs sm:text-sm">
        <div class="text-slate-500 flex items-center gap-1">
            <i class="fas fa-book-open text-yellow-500 text-xs sm:text-sm"></i>
            <span>{{ $buku->total() }} buku ditemukan</span>
        </div>
        
        @if(request()->hasAny(['search', 'kategori', 'tersedia']))
            <div class="flex flex-wrap gap-2">
                @if(request('search'))
                    <span class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-full">
                        <i class="fas fa-search mr-1 text-[10px]"></i>"{{ request('search') }}"
                    </span>
                @endif
                @if(request('kategori'))
                    <span class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-full">
                        <i class="fas fa-tag mr-1 text-[10px]"></i>{{ request('kategori') }}
                    </span>
                @endif
                @if(request('tersedia'))
                    <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full">
                        <i class="fas fa-check-circle text-[10px] mr-1"></i> Tersedia
                    </span>
                @endif
            </div>
        @endif
    </div>
</form>

    {{-- Grid Buku --}}
    @if($buku->isEmpty())
        <div class="text-center py-16 sm:py-20 text-slate-400">
            <i class="fas fa-book text-5xl sm:text-6xl mb-3 sm:mb-4 block opacity-20"></i>
            <h3 class="text-base sm:text-lg font-semibold text-slate-500">Buku tidak ditemukan</h3>
            <p class="text-xs sm:text-sm mt-1">Coba kata kunci atau filter yang berbeda</p>
            <a href="{{ route('portal.index') }}" class="btn-brand mt-4 inline-flex">Reset Pencarian</a>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4 md:gap-5">
            @foreach($buku as $b)
            <a href="{{ route('portal.detail', $b) }}" class="card-book group hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                {{-- Cover --}}
                <div class="aspect-[3/4] bg-gradient-to-br from-amber-50 to-orange-50 flex items-center justify-center relative overflow-hidden rounded-t-xl">
                    @if($b->cover && file_exists(public_path('covers/'.$b->cover)))
                        <img src="{{ asset('covers/'.$b->cover) }}" alt="{{ $b->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="text-center p-4">
                            <i class="fas fa-book text-amber-300 text-3xl sm:text-4xl mb-2 block"></i>
                            <p class="text-amber-400 text-xs font-medium leading-tight">{{ Str::limit($b->judul, 30) }}</p>
                        </div>
                    @endif
                    {{-- Badge tersedia --}}
                    <div class="absolute top-2 right-2">
                        @if($b->stok_tersedia > 0)
                            <span class="bg-emerald-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full shadow-lg">✓</span>
                        @else
                            <span class="bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full shadow-lg">Habis</span>
                        @endif
                    </div>
                </div>
                {{-- Info --}}
                <div class="p-2 sm:p-3 bg-white rounded-b-xl">
                    <p class="font-semibold text-slate-800 text-xs sm:text-sm leading-tight line-clamp-2 group-hover:text-amber-600 transition-colors min-h-[2rem] sm:min-h-[2.5rem]">{{ $b->judul }}</p>
                    <p class="text-slate-400 text-[10px] sm:text-xs mt-1 truncate">
                        <i class="fas fa-user-edit mr-1"></i>{{ $b->pengarang }}
                    </p>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-[10px] sm:text-xs bg-slate-100 text-slate-500 px-1.5 sm:px-2 py-0.5 rounded-full truncate max-w-[80px]">{{ $b->kategori }}</span>
                        <span class="text-[10px] sm:text-xs text-slate-400 font-medium">{{ $b->stok_tersedia }}/{{ $b->stok }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($buku->hasPages())
        <div class="mt-8 sm:mt-10 flex justify-center">
            <div class="custom-pagination">
                {{ $buku->links() }}
            </div>
        </div>
        @endif
    @endif

</section>

{{-- CTA Booking --}}
<section class="relative overflow-hidden bg-gradient-to-br from-slate-50 to-white text-gray-900 border-t border-slate-100">
    {{-- Background装饰 --}}
    <div class="absolute inset-0 opacity-30">
        <div class="absolute top-0 -left-20 w-72 h-72 bg-yellow-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -right-20 w-72 h-72 bg-amber-500 rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20 text-center">
        <div class="max-w-3xl mx-auto">
            {{-- Icon --}}
            <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto bg-gradient-to-br from-yellow-500 to-amber-500 rounded-2xl flex items-center justify-center shadow-xl mb-5 sm:mb-6 transform hover:scale-110 transition-transform duration-300">
                <i class="fas fa-book-open text-white text-2xl sm:text-3xl"></i>
            </div>
            
            <h2 class="font-display text-2xl sm:text-3xl md:text-4xl font-bold mb-3 sm:mb-4 text-gray-900">
                Sudah menemukan buku yang Anda inginkan?
            </h2>
            <p class="text-slate-600 text-sm sm:text-base md:text-lg mb-6 sm:mb-8 px-4">
                Klik buku di atas dan buat booking sekarang. <span class="text-yellow-600 font-semibold">Gratis, mudah, dan cepat!</span>
            </p>
            
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4 sm:px-0">
                <a href="{{ route('portal.cek-booking') }}" class="inline-flex items-center justify-center gap-2 sm:gap-3 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white font-semibold px-6 sm:px-8 py-2.5 sm:py-3.5 rounded-xl transition-all duration-300 shadow-lg hover:shadow-yellow-500/30 transform hover:-translate-y-1 text-sm sm:text-base">
                    <i class="fas fa-magnifying-glass"></i> 
                    Cek Status Booking Saya
                    <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                </a>
                <a href="{{ route('portal.index') }}" class="inline-flex items-center justify-center gap-2 border-2 border-slate-300 hover:border-yellow-500 text-slate-700 hover:text-yellow-600 font-semibold px-6 sm:px-8 py-2.5 sm:py-3.5 rounded-xl transition-all duration-300 hover:bg-yellow-50 text-sm sm:text-base">
                    <i class="fas fa-book"></i>
                    Jelajahi Katalog
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

{{-- Additional CSS for better responsiveness --}}
@push('styles')
<style>
    /* Enhanced card styles */
    .card-book {
        display: block;
        text-decoration: none;
        border-radius: 0.75rem;
        overflow: hidden;
        background: white;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
    }
    
    .card-book:hover {
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }
    
    /* Better touch targets on mobile */
    @media (max-width: 640px) {
        button, 
        .card-book,
        [type="submit"],
        [type="button"],
        a {
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Improve form elements on mobile */
        input, select, button {
            font-size: 16px !important; /* Prevent zoom on iOS */
        }
    }
    
    /* Custom pagination styling */
    .custom-pagination nav {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .custom-pagination .page-item {
        display: inline-flex;
    }
    
    .custom-pagination .page-link {
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        color: #475569;
        background: white;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    
    .custom-pagination .active .page-link {
        background: linear-gradient(135deg, #eab308, #f59e0b);
        color: white;
        border-color: transparent;
    }
    
    .custom-pagination .page-link:hover:not(.active .page-link) {
        background: #fef3c7;
        border-color: #fbbf24;
        color: #d97706;
    }
    
    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush