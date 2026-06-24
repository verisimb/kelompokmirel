<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahKriteria = Kriteria::count();
        $jumlahAlternatif = Alternatif::count();
        $jumlahPenilaian = Penilaian::count();

        // Data untuk grafik
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $alternatif = Alternatif::orderBy('kode_alternatif')->get();
        
        // Hitung ranking untuk grafik
        $chartData = $this->calculateChartData($kriteria, $alternatif);

        return view('dashboard.index', compact(
            'jumlahKriteria',
            'jumlahAlternatif',
            'jumlahPenilaian',
            'chartData'
        ));
    }

    private function calculateChartData($kriteria, $alternatif)
    {
        if ($kriteria->isEmpty() || $alternatif->isEmpty()) {
            return [
                'labels' => [],
                'data' => [],
                'colors' => []
            ];
        }

        $totalBobot = $kriteria->sum('bobot');
        $bobotNormalisasi = [];
        foreach ($kriteria as $k) {
            $bobotNormalisasi[$k->id] = $totalBobot > 0 ? $k->bobot / $totalBobot : 0;
        }

        $nilaiMatrix = [];
        foreach ($alternatif as $alt) {
            foreach ($kriteria as $krit) {
                $nilai = Penilaian::where('alternatif_id', $alt->id)
                    ->where('kriteria_id', $krit->id)
                    ->first();
                $nilaiMatrix[$alt->id][$krit->id] = $nilai ? $nilai->nilai : 0;
            }
        }

        // Normalisasi
        $normalisasi = [];
        foreach ($kriteria as $krit) {
            $values = [];
            foreach ($alternatif as $alt) {
                $values[] = $nilaiMatrix[$alt->id][$krit->id];
            }
            $min = min($values);
            $max = max($values);

            if ($min == $max) {
                foreach ($alternatif as $alt) {
                    $normalisasi[$alt->id][$krit->id] = 1;
                }
            } else {
                foreach ($alternatif as $alt) {
                    $nilai = $nilaiMatrix[$alt->id][$krit->id];
                    if ($krit->tipe == 'benefit') {
                        $normalisasi[$alt->id][$krit->id] = ($nilai - $min) / ($max - $min);
                    } else {
                        $normalisasi[$alt->id][$krit->id] = ($max - $nilai) / ($max - $min);
                    }
                }
            }
        }

        // Hitung nilai akhir
        $hasil = [];
        foreach ($alternatif as $alt) {
            $total = 0;
            foreach ($kriteria as $krit) {
                $utility = $normalisasi[$alt->id][$krit->id] * $bobotNormalisasi[$krit->id];
                $total += $utility;
            }
            $hasil[] = [
                'nama' => $alt->nama_ewallet,
                'nilai' => $total * 100
            ];
        }

        // Urutkan
        usort($hasil, function ($a, $b) {
            return $b['nilai'] <=> $a['nilai'];
        });

        $labels = array_column($hasil, 'nama');
        $data = array_column($hasil, 'nilai');
        $colors = ['#4F46E5', '#6366F1', '#8B5CF6', '#A78BFA', '#C4B5FD', '#DDD6FE', '#EDE9FE'];

        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => $colors
        ];
    }
}