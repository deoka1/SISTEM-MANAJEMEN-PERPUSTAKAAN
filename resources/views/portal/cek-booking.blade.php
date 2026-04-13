@extends('layouts.portal')

@section('title', 'Cek Status Booking')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

    <div class="text-center mb-10">
        <div class="w-16 h-16 bg-gradient-to-br from-yellow-100 to-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-md">
            <i class="fas fa-magnifying-glass text-yellow-600 text-2xl"></i>
        </div>
        <h1 class="font-display text-3xl font-bold text-gray-800 mb-2">Cek Status Booking</h1>
        <p class="text-gray-400">Masukkan kode booking yang Anda terima setelah melakukan pemesanan.</p>
    </div>

    {{-- Form Cek --}}
    <form method="GET" action="{{ route('portal.cek-booking') }}" class="bg-white border border-gray-100 rounded-2xl shadow-lg p-6 mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kode Booking</label>
        <div class="flex gap-3">
            <input type="text" name="kode" value="{{ request('kode') }}"
                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all font-mono uppercase tracking-wider bg-gray-50"
                placeholder="Contoh: BKG20240001"
                autofocus>
            <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md">
                <i class="fas fa-search"></i> Cek
            </button>
        </div>
    </form>

    {{-- Hasil --}}
    @if(request()->filled('kode'))
        @if($booking)

        {{-- Status Banner --}}
        @php
        $statusConfig = [
            'menunggu'  => ['bg' => 'bg-yellow-50 border-yellow-200', 'text' => 'text-yellow-800', 'icon' => 'fa-clock text-yellow-500', 'label' => 'Menunggu Konfirmasi Petugas'],
            'disetujui' => ['bg' => 'bg-emerald-50 border-emerald-200', 'text' => 'text-emerald-800', 'icon' => 'fa-circle-check text-emerald-500', 'label' => 'Booking Disetujui! Silakan ambil buku'],
            'ditolak'   => ['bg' => 'bg-red-50 border-red-200', 'text' => 'text-red-800', 'icon' => 'fa-circle-xmark text-red-500', 'label' => 'Booking Ditolak'],
            'selesai'   => ['bg' => 'bg-gray-50 border-gray-200', 'text' => 'text-gray-700', 'icon' => 'fa-circle-check text-gray-400', 'label' => 'Selesai'],
        ];
        $sc = $statusConfig[$booking->status] ?? $statusConfig['menunggu'];
        @endphp

        <div class="border rounded-2xl {{ $sc['bg'] }} p-5 mb-5 flex items-center gap-3 shadow-sm">
            <i class="fas {{ $sc['icon'] }} text-2xl flex-shrink-0"></i>
            <div>
                <p class="font-bold {{ $sc['text'] }} text-base">{{ $sc['label'] }}</p>
                @if($booking->status === 'disetujui')
                    <p class="text-emerald-600 text-sm mt-0.5">Ambil buku pada: <strong>{{ $booking->tanggal_pinjam_rencana->format('d M Y') }}</strong></p>
                @endif
                @if($booking->alasan_penolakan)
                    <p class="text-red-600 text-sm mt-0.5">Alasan: {{ $booking->alasan_penolakan }}</p>
                @endif
            </div>
        </div>

        {{-- Detail --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-lg overflow-hidden">
            {{-- Buku --}}
            <div class="p-6 border-b border-gray-100 flex gap-4 bg-gradient-to-r from-gray-50 to-white">
                <div class="w-14 h-18 bg-gradient-to-br from-yellow-100 to-amber-100 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden shadow-sm">
                    @if($booking->buku->cover && file_exists(public_path('covers/'.$booking->buku->cover)))
                        <img src="{{ asset('covers/'.$booking->buku->cover) }}" alt="cover" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-book text-yellow-500 text-xl"></i>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Buku yang Dipesan</p>
                    <p class="font-bold text-gray-800">{{ $booking->buku->judul }}</p>
                    <p class="text-gray-500 text-sm">{{ $booking->buku->pengarang }}</p>
                </div>
            </div>

            {{-- Info --}}
            <div class="divide-y divide-gray-100">
                @foreach([
                    ['Kode Booking', $booking->kode_booking, true],
                    ['Nama', $booking->nama_peminjam, false],
                    ['No. Anggota', $booking->no_anggota, true],
                    ['Tanggal Booking', $booking->tanggal_booking->format('d M Y'), false],
                    ['Rencana Ambil', $booking->tanggal_pinjam_rencana->format('d M Y'), false],
                    ['Rencana Kembali', $booking->tanggal_kembali_rencana->format('d M Y'), false],
                ] as [$label, $value, $mono])
                <div class="px-6 py-3 flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <span class="text-gray-400 text-sm">{{ $label }}</span>
                    @if($mono)
                        <span class="font-mono bg-gradient-to-r from-yellow-50 to-amber-50 text-yellow-700 px-2 py-0.5 rounded text-sm font-semibold">{{ $value }}</span>
                    @else
                        <span class="font-medium text-gray-700 text-sm">{{ $value }}</span>
                    @endif
                </div>
                @endforeach

                @if($booking->catatan)
                <div class="px-6 py-3 bg-yellow-50/30">
                    <p class="text-gray-400 text-sm mb-1">
                        <i class="fas fa-pen text-yellow-500 mr-1"></i> Catatan
                    </p>
                    <p class="text-gray-700 text-sm italic">{{ $booking->catatan }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex flex-col sm:flex-row gap-3 mt-6 justify-center">
            <a href="{{ route('portal.index') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-md text-sm">
                <i class="fas fa-book"></i> Lihat Katalog Buku
            </a>
            <a href="{{ route('portal.cek-booking') }}" class="inline-flex items-center justify-center gap-2 border border-gray-300 hover:border-yellow-500 text-gray-600 hover:text-yellow-600 font-semibold px-5 py-2.5 rounded-xl transition-all text-sm bg-white">
                <i class="fas fa-redo-alt"></i> Cek Lagi
            </a>
        </div>

        @else
        {{-- Not Found --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-lg p-10 text-center">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-face-frown text-red-400 text-4xl"></i>
            </div>
            <h3 class="font-semibold text-gray-600 text-lg mb-1">Kode Booking Tidak Ditemukan</h3>
            <p class="text-gray-400 text-sm max-w-xs mx-auto">Pastikan kode yang Anda masukkan sudah benar. Kode booking dikirim setelah Anda melakukan pemesanan.</p>
            <a href="{{ route('portal.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-md mt-5">
                <i class="fas fa-book"></i> Lihat Katalog Buku
            </a>
        </div>
        @endif
    @else
    {{-- Info / Empty State --}}
    <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-100 rounded-2xl p-8 text-center shadow-sm">
        <div class="w-16 h-16 bg-gradient-to-br from-yellow-100 to-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-ticket text-yellow-500 text-2xl"></i>
        </div>
        <p class="text-gray-500 text-sm">Masukkan kode booking di atas untuk melihat status pemesanan Anda.</p>
        <div class="flex items-center justify-center gap-2 mt-4 text-xs text-gray-400">
            <i class="fas fa-info-circle text-yellow-500"></i>
            <span>Kode booking dikirim via email setelah booking</span>
        </div>
    </div>
    @endif

    <div class="text-center mt-8">
        <a href="{{ route('portal.index') }}" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium transition-colors">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Katalog
        </a>
    </div>

</div>
@endsection