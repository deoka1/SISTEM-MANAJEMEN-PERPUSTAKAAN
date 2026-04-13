<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';

    protected $fillable = [
        'no_anggota',
        'nama',
        'email',
        'telepon',
        'alamat',
        'jenis_kelamin',
        'tanggal_daftar',
        'tanggal_expired',
        'status',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'tanggal_expired' => 'date',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function peminjamanAktif()
    {
        return $this->peminjaman()->where('status', 'dipinjam');
    }

    public function isAktif()
    {
        return $this->status === 'aktif' && $this->tanggal_expired >= now();
    }
}
