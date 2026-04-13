@extends('layouts.master')

@section('title', $anggota->nama)
@section('page-title', 'Detail Anggota')
@section('page-subtitle', $anggota->nama)

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- Anggota Info --}}
    <div class="xl:col-span-1 space-y-5">
        <div class="card p-6">
            <div class="text-center mb-6">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-white font-bold text-3xl mx-auto mb-3
                    {{ $anggota->jenis_kelamin === 'L' ? 'bg-blue-500' : 'bg-pink-500' }}">
                    {{ strtoupper(substr($anggota->nama, 0, 1)) }}
                </div>
                <h2 class="font-bold text-slate-800 text-lg">{{ $anggota->nama }}</h2>
                <p class="text-slate-400 text-sm">{{ $anggota->email }}</p>
                <div class="mt-3">
                    <x-badge :status="$anggota->status" />
                </div>
            </div>

            @php
                $jenisKelamin  = $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
                $telepon       = $anggota->telepon ?? '-';
                $tglDaftar     = $anggota->tanggal_daftar->format('d M Y');
                $tglExpired    = $anggota->tanggal_expired->format('d M Y');
                $pinjamanAktif = $anggota->peminjamanAktif()->count() . ' buku';

                $infos = [
                    ['label' => 'No. Anggota',    'value' => $anggota->no_anggota, 'mono' => true],
                    ['label' => 'Jenis Kelamin',  'value' => $jenisKelamin,        'mono' => false],
                    ['label' => 'Telepon',        'value' => $telepon,             'mono' => false],
                    ['label' => 'Tanggal Daftar', 'value' => $tglDaftar,           'mono' => false],
                    ['label' => 'Masa Berlaku',   'value' => $tglExpired,          'mono' => false],
                    ['label' => 'Pinjaman Aktif', 'value' => $pinjamanAktif,       'mono' => false],
                ];
            @endphp

            <div class="space-y-3 text-sm">
                @foreach($infos as $info)
                <div class="flex justify-between gap-3">
                    <span class="text-slate-400 flex-shrink-0">{{ $info['label'] }}</span>
                    @if($info['mono'])
                        <span class="font-mono bg-slate-100 text-slate-600 px-2 py-0.5 rounded text-xs">{{ $info['value'] }}</span>
                    @else
                        <span class="font-medium text-slate-700 text-right">{{ $info['value'] }}</span>
                    @endif
                </div>
                @endforeach
            </div>

            @if($anggota->alamat)
            <div class="mt-4 pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-2">Alamat</p>
                <p class="text-slate-600 text-sm">{{ $anggota->alamat }}</p>
            </div>
            @endif
        </div>

        <div class="flex gap-3">
            <a href="{{ route('anggota.edit', $anggota) }}" class="btn-primary flex-1 justify-center">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('anggota.index') }}" class="btn-secondary flex-1 justify-center">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Riwayat Peminjaman --}}
    <div class="xl:col-span-2 card">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Riwayat Peminjaman</h3>
            <p class="text-slate-400 text-xs mt-0.5">{{ $anggota->peminjaman->count() }} total peminjaman</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Buku</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Tgl Pinjam</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Tgl Kembali</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Denda</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($riwayat as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-3 font-medium text-slate-800">
                            {{ $p->buku->judul ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-slate-500">
                            {{ $p->tanggal_pinjam->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-slate-500">
                            {{ $p->tanggal_kembali_rencana->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            @if($p->denda > 0)
                                Rp {{ number_format($p->denda, 0, ',', '.') }}
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <x-badge :status="$p->status" />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12 text-slate-400">
                            <i class="fas fa-inbox text-3xl mb-2 block"></i>
                            <p>Belum ada riwayat peminjaman</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($riwayat->hasPages())
        <div class="px-6 py-3 border-t border-slate-100">
            {{ $riwayat->links() }}
        </div>
        @endif
    </div>

</div>
@endsection