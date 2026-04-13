<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->foreignId('buku_id')->constrained('buku')->onDelete('cascade');
            $table->string('nama_peminjam');
            $table->string('email_peminjam');
            $table->string('telepon_peminjam')->nullable();
            $table->string('no_anggota');
            $table->date('tanggal_booking');
            $table->date('tanggal_pinjam_rencana');
            $table->date('tanggal_kembali_rencana');
            $table->text('catatan')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
