@extends('layouts.master')

@section('title', 'Edit Peminjaman')
@section('page-title', 'Edit Peminjaman')
@section('page-subtitle', 'Perbarui data peminjaman: ' . $peminjaman->kode_pinjam)

@section('content')
<div class="max-w-2xl">
    <div class="card p-8">

        {{-- Info readonly --}}
        <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-slate-50 rounded-xl">
            <div>
                <p class="text-xs text-slate-400 font-medium">Anggota</p>
                <p class="font-semibold text-slate-800">{{ $peminjaman->anggota->nama ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium">Buku</p>
                <p class="font-semibold text-slate-800">{{ $peminjaman->buku->judul ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium">Tanggal Pinjam</p>
                <p class="font-semibold text-slate-800">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium">Status</p>
                <x-badge :status="$peminjaman->status" />
            </div>
        </div>

        <form method="POST" action="{{ route('peminjaman.update', $peminjaman) }}" class="space-y-6">
            @csrf @method('PUT')

            <div>
                <label class="form-label">Tanggal Kembali Rencana <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_kembali_rencana"
                    value="{{ old('tanggal_kembali_rencana', $peminjaman->tanggal_kembali_rencana->format('Y-m-d')) }}"
                    class="form-input @error('tanggal_kembali_rencana') border-red-400 @enderror">
                @error('tanggal_kembali_rencana') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" rows="3" class="form-input @error('keterangan') border-red-400 @enderror" placeholder="Catatan tambahan">{{ old('keterangan', $peminjaman->keterangan) }}</textarea>
                @error('keterangan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Perbarui
                </button>
                <a href="{{ route('peminjaman.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
