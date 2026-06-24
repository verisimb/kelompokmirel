<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kriteria;
use App\Models\Alternatif;

class DataAwalSeeder extends Seeder
{
    public function run(): void
    {
        // KRITERIA (Bobot 1,3,5,7,3 = total 19)
        $kriteria = [
            ['kode_kriteria' => 'C1', 'nama_kriteria' => 'Rating Aplikasi', 'bobot' => 7, 'tipe' => 'benefit', 'satuan' => 'Bintang (1-5)'],
            ['kode_kriteria' => 'C2', 'nama_kriteria' => 'Jumlah Pengguna', 'bobot' => 1, 'tipe' => 'benefit', 'satuan' => 'Juta Orang'],
            ['kode_kriteria' => 'C3', 'nama_kriteria' => 'Biaya Tarik Tunai', 'bobot' => 3, 'tipe' => 'cost', 'satuan' => 'Rupiah (Rp)'],
            ['kode_kriteria' => 'C4', 'nama_kriteria' => 'Cashback / Promo', 'bobot' => 5, 'tipe' => 'benefit', 'satuan' => 'Persen (%)'],
            ['kode_kriteria' => 'C5', 'nama_kriteria' => 'Ukuran Aplikasi', 'bobot' => 3, 'tipe' => 'cost', 'satuan' => 'Megabyte (MB)'],
        ];

        foreach ($kriteria as $k) {
            Kriteria::create($k);
        }

        // ALTERNATIF
        $alternatif = [
            ['kode_alternatif' => 'A1', 'nama_ewallet' => 'OVO'],
            ['kode_alternatif' => 'A2', 'nama_ewallet' => 'DANA'],
            ['kode_alternatif' => 'A3', 'nama_ewallet' => 'GoPay'],
            ['kode_alternatif' => 'A4', 'nama_ewallet' => 'ShopeePay'],
            ['kode_alternatif' => 'A5', 'nama_ewallet' => 'iSaku'],
            ['kode_alternatif' => 'A6', 'nama_ewallet' => 'LinkAja'],
            ['kode_alternatif' => 'A7', 'nama_ewallet' => 'Doku'],
        ];

        foreach ($alternatif as $a) {
            Alternatif::create($a);
        }
    }
}