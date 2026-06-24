<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class SmartController extends Controller
{
    public function index()
    {
        // Ambil data
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $alternatif = Alternatif::orderBy('kode_alternatif')->get();

        if ($kriteria->isEmpty() || $alternatif->isEmpty()) {
            return view('smart.index', [
                'kriteria' => $kriteria,
                'alternatif' => $alternatif,
                'bobotNormalisasi' => [],
                'hasil' => [],
                'message' => 'Data kriteria atau alternatif belum lengkap.'
            ]);
        }

        // ==========================================
        // 1. NORMALISASI BOBOT (Sesuai Jurnal)
        // ==========================================
        $totalBobot = $kriteria->sum('bobot');
        $bobotNormalisasi = [];
        foreach ($kriteria as $k) {
            $bobotNormalisasi[$k->id] = $totalBobot > 0 ? $k->bobot / $totalBobot : 0;
        }

        // ==========================================
        // 2. AMBIL NILAI PENILAIAN (Data Real)
        // ==========================================
        $nilaiMatrix = [];
        foreach ($alternatif as $alt) {
            foreach ($kriteria as $krit) {
                $nilai = Penilaian::where('alternatif_id', $alt->id)
                    ->where('kriteria_id', $krit->id)
                    ->first();
                $nilaiMatrix[$alt->id][$krit->id] = $nilai ? floatval($nilai->nilai) : 0;
            }
        }

        // Cek apakah semua nilai 0
        $allZero = true;
        foreach ($nilaiMatrix as $altId => $kritValues) {
            foreach ($kritValues as $nilai) {
                if ($nilai > 0) {
                    $allZero = false;
                    break 2;
                }
            }
        }

        if ($allZero) {
            return view('smart.index', [
                'kriteria' => $kriteria,
                'alternatif' => $alternatif,
                'bobotNormalisasi' => $bobotNormalisasi,
                'hasil' => [],
                'message' => 'Belum ada data penilaian. Silakan input penilaian terlebih dahulu.'
            ]);
        }

        // ==========================================
        // 3. HITUNG NILAI MAX DAN MIN (Sesuai Jurnal)
        // ==========================================
        $maxValues = [];
        $minValues = [];
        foreach ($kriteria as $krit) {
            $values = [];
            foreach ($alternatif as $alt) {
                $values[] = $nilaiMatrix[$alt->id][$krit->id];
            }
            $maxValues[$krit->id] = max($values);
            $minValues[$krit->id] = min($values);
        }

        // ==========================================
        // 4. HITUNG UTILITY VALUE (Sesuai Jurnal)
        //    Benefit: (nilai - min) / (max - min)
        //    Cost: (max - nilai) / (max - min)
        // ==========================================
        $utility = [];
        foreach ($alternatif as $alt) {
            foreach ($kriteria as $krit) {
                $nilai = $nilaiMatrix[$alt->id][$krit->id];
                $max = $maxValues[$krit->id];
                $min = $minValues[$krit->id];
                
                // Hindari division by zero
                if ($max == $min) {
                    $utility[$alt->id][$krit->id] = 1;
                } else {
                    if ($krit->tipe == 'benefit') {
                        $utility[$alt->id][$krit->id] = ($nilai - $min) / ($max - $min);
                    } else {
                        $utility[$alt->id][$krit->id] = ($max - $nilai) / ($max - $min);
                    }
                }
            }
        }

        // ==========================================
        // 5. HITUNG NILAI AKHIR (Sesuai Jurnal)
        //    V = Σ (utility × bobot_normalisasi)
        // ==========================================
        $hasil = [];
        foreach ($alternatif as $alt) {
            $total = 0;
            $detail = [];
            foreach ($kriteria as $krit) {
                $u = $utility[$alt->id][$krit->id];
                $w = $bobotNormalisasi[$krit->id];
                $total += $u * $w;
                $detail[$krit->id] = [
                    'utility' => $u,
                    'bobot_normalisasi' => $w,
                    'normalisasi' => $u, // Utility sama dengan normalisasi di SMART
                ];
            }
            $hasil[$alt->id] = [
                'alternatif' => $alt,
                'nilai_akhir' => $total,
                'detail' => $detail,
            ];
        }

        // ==========================================
        // 6. RANKING (Urutkan dari tertinggi)
        // ==========================================
        usort($hasil, function ($a, $b) {
            return $b['nilai_akhir'] <=> $a['nilai_akhir'];
        });

        $ranking = 1;
        foreach ($hasil as &$item) {
            $item['ranking'] = $ranking++;
        }

        return view('smart.index', compact(
            'kriteria',
            'alternatif',
            'bobotNormalisasi',
            'hasil',
            'maxValues',
            'minValues'
        ));
    }
}