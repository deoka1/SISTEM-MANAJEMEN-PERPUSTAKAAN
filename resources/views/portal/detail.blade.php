@extends('layouts.portal')

@section('title', $buku->judul)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-400 mb-8 flex items-center gap-2">
        <a href="{{ route('portal.index') }}" class="hover:text-yellow-600 transition-colors">Katalog</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-600">{{ Str::limit($buku->judul, 40) }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

        {{-- Cover --}}
        <div class="md:col-span-1">
            <div class="aspect-[3/4] bg-gradient-to-br from-yellow-100 to-amber-50 rounded-2xl overflow-hidden shadow-xl max-w-[280px] mx-auto md:mx-0 border border-yellow-200">
                @if($buku->cover && file_exists(public_path('covers/'.$buku->cover)))
                    <img src="{{ asset('covers/'.$buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-center p-8">
                        <i class="fas fa-book text-yellow-400 text-6xl mb-4"></i>
                        <p class="text-amber-600 font-semibold leading-tight">{{ $buku->judul }}</p>
                    </div>
                @endif
            </div>

            {{-- Stok info --}}
            <div class="mt-5 bg-white rounded-2xl border border-gray-200 p-4 max-w-[280px] mx-auto md:mx-0 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-semibold text-gray-700">Ketersediaan</span>
                    @if($buku->stok_tersedia > 0)
                        <span class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">
                            <i class="fas fa-check text-xs mr-0.5"></i> Tersedia
                        </span>
                    @else
                        <span class="bg-gray-400 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                            <i class="fas fa-times text-xs mr-0.5"></i> Stok Habis
                        </span>
                    @endif
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                    @php $pct = $buku->stok > 0 ? ($buku->stok_tersedia / $buku->stok) * 100 : 0; @endphp
                    <div class="h-2 rounded-full {{ $pct > 50 ? 'bg-gradient-to-r from-yellow-500 to-amber-500' : ($pct > 0 ? 'bg-amber-400' : 'bg-gray-400') }}" style="width: {{ $pct }}%"></div>
                </div>
                <p class="text-xs text-gray-400">
                    <i class="fas fa-book text-yellow-500 mr-1"></i>
                    {{ $buku->stok_tersedia }} dari {{ $buku->stok }} eksemplar tersedia
                </p>
            </div>
        </div>

        {{-- Detail & Booking --}}
        <div class="md:col-span-2 space-y-6">

            {{-- Info --}}
            <div>
                <span class="bg-gradient-to-r from-yellow-100 to-amber-100 text-amber-700 text-xs font-semibold px-3 py-1 rounded-full border border-yellow-200">
                    {{ $buku->kategori }}
                </span>
                <h1 class="font-display text-3xl font-bold text-gray-800 mt-3 leading-tight">{{ $buku->judul }}</h1>
                <p class="text-gray-500 text-lg mt-1">{{ $buku->pengarang }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                @foreach([
                    ['Kode Buku', $buku->kode_buku, 'fa-barcode'],
                    ['Penerbit', $buku->penerbit, 'fa-building'],
                    ['Tahun Terbit', $buku->tahun_terbit, 'fa-calendar'],
                    ['ISBN', $buku->isbn ?? '-', 'fa-fingerprint'],
                ] as [$label, $value, $icon])
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-gray-400 text-xs mb-1"><i class="fas {{ $icon }} text-yellow-500 mr-1"></i>{{ $label }}</p>
                    <p class="font-semibold text-gray-700 text-sm">{{ $value }}</p>
                </div>
                @endforeach
            </div>

            @if($buku->deskripsi)
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <h3 class="font-semibold text-gray-700 mb-2 text-sm uppercase tracking-wider">
                    <i class="fas fa-align-left text-yellow-500 mr-2"></i>Deskripsi
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $buku->deskripsi }}</p>
            </div>
            @endif

            {{-- CTA --}}
            <div class="bg-gradient-to-br from-yellow-50 to-amber-50 border border-yellow-200 rounded-2xl p-6 shadow-md">
                <h3 class="font-bold text-gray-800 text-lg mb-1">Ingin meminjam buku ini?</h3>
                <p class="text-gray-500 text-sm mb-4">Booking online sekarang, ambil di perpustakaan sesuai jadwal yang Anda pilih.</p>

                @if($buku->stok_tersedia > 0)
                    <a href="{{ route('portal.booking', $buku) }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md">
                        <i class="fas fa-bookmark"></i> Booking Sekarang
                    </a>
                @else
                    <button disabled class="inline-flex items-center gap-2 bg-gray-300 text-gray-500 px-5 py-2.5 rounded-xl text-sm font-semibold cursor-not-allowed">
                        <i class="fas fa-clock"></i> Stok Sedang Habis
                    </button>
                    <p class="text-gray-400 text-xs mt-2">Coba lagi nanti atau cek buku lain yang tersedia.</p>
                @endif
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <a href="{{ route('portal.index') }}" class="inline-flex items-center gap-2 border-2 border-yellow-500 text-yellow-600 hover:bg-yellow-500 hover:text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-arrow-left"></i> Kembali ke Katalog
                </a>
                <a href="{{ route('portal.cek-booking') }}" class="text-sm text-gray-500 hover:text-yellow-600 transition-colors">
                    <i class="fas fa-magnifying-glass mr-1"></i> Cek Status Booking
                </a>
            </div>
        </div>
    </div>

    {{-- Buku Serupa --}}
    @if($bukuLain->isNotEmpty())
    <div class="mt-16">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-xl flex items-center justify-center shadow-md">
                <i class="fas fa-book-open text-white text-sm"></i>
            </div>
            <h2 class="font-display text-2xl font-bold text-gray-800">Buku Serupa</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
            @foreach($bukuLain as $b)
            <a href="{{ route('portal.detail', $b) }}" class="bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="aspect-[3/4] bg-gradient-to-br from-yellow-100 to-amber-50 flex items-center justify-center">
                    @if($b->cover && file_exists(public_path('covers/'.$b->cover)))
                        <img src="{{ asset('covers/'.$b->cover) }}" alt="{{ $b->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <i class="fas fa-book text-yellow-400 text-3xl"></i>
                    @endif
                </div>
                <div class="p-3">
                    <p class="font-semibold text-gray-800 text-xs line-clamp-2 group-hover:text-yellow-600 transition-colors">{{ $b->judul }}</p>
                    <p class="text-gray-400 text-xs mt-0.5 truncate">{{ $b->pengarang }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection