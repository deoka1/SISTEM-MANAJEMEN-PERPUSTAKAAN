<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_pinjam',
        'anggota_id',
        'buku_id',
        'user_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'denda',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hitungDenda()
    {
        if ($this->status === 'dikembalikan' && $this->tanggal_kembali_aktual) {
            $terlambat = $this->tanggal_kembali_aktual->diffInDays($this->tanggal_kembali_rencana, false);
            if ($terlambat < 0) {
                return abs($terlambat) * 1000; // Rp 1.000 per hari
            }
        } elseif ($this->status === 'dipinjam') {
            $terlambat = now()->diffInDays($this->tanggal_kembali_rencana, false);
            if ($terlambat < 0) {
                return abs($terlambat) * 1000;
            }
        }
        return 0;
    }

    public function isTerlambat()
    {
        return $this->status === 'dipinjam' && now()->gt($this->tanggal_kembali_rencana);
    }
}
