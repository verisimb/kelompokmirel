<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'penilaian';

    // Field yang boleh diisi massal
    protected $fillable = [
        'alternatif_id',
        'kriteria_id',
        'nilai'
    ];

    // Casting tipe data
    protected $casts = [
        'nilai' => 'decimal:2',
    ];

    /**
     * Relasi ke tabel alternatif (Many to One / Inverse)
     * Sebuah penilaian dimiliki oleh satu alternatif
     */
    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'alternatif_id');
    }

    /**
     * Relasi ke tabel kriteria (Many to One / Inverse)
     * Sebuah penilaian dimiliki oleh satu kriteria
     */
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}