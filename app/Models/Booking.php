<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    protected $fillable = [
        'kode_booking',
        'buku_id',
        'nama_peminjam',
        'email_peminjam',
        'telepon_peminjam',
        'no_anggota',
        'tanggal_booking',
        'tanggal_pinjam_rencana',
        'tanggal_kembali_rencana',
        'catatan',
        'status',
        'alasan_penolakan',
    ];

    protected $casts = [
        'tanggal_booking'        => 'date',
        'tanggal_pinjam_rencana' => 'date',
        'tanggal_kembali_rencana'=> 'date',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function statusLabel()
    {
        return match($this->status) {
            'menunggu'  => 'Menunggu Konfirmasi',
            'disetujui' => 'Disetujui',
            'ditolak'   => 'Ditolak',
            'selesai'   => 'Selesai',
            default     => $this->status,
        };
    }
}
