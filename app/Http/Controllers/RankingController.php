<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RankingController extends Controller
{
    public function index()
    {
        // Ambil data
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $alternatif = Alternatif::orderBy('kode_alternatif')->get();

        if ($kriteria->isEmpty() || $alternatif->isEmpty()) {
            return view('ranking.index', [
                'kriteria' => $kriteria,
                'alternatif' => $alternatif,
                'hasil' => [],
                'message' => 'Data kriteria atau alternatif belum lengkap.'
            ]);
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
            return view('ranking.index', [
                'kriteria' => $kriteria,
                'alternatif' => $alternatif,
                'hasil' => [],
                'message' => 'Belum ada data penilaian.'
            ]);
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

        // Hitung hasil
        $hasil = [];
        foreach ($alternatif as $alt) {
            $total = 0;
            foreach ($kriteria as $krit) {
                $utility = $normalisasi[$alt->id][$krit->id] * $bobotNormalisasi[$krit->id];
                $total += $utility;
                $hasil[$alt->id]['detail'][$krit->id] = [
                    'normalisasi' => $normalisasi[$alt->id][$krit->id],
                    'bobot_normalisasi' => $bobotNormalisasi[$krit->id],
                    'utility' => $utility,
                ];
            }
            $hasil[$alt->id]['nilai_akhir'] = $total;
            $hasil[$alt->id]['alternatif'] = $alt;
        }

        usort($hasil, function ($a, $b) {
            return $b['nilai_akhir'] <=> $a['nilai_akhir'];
        });

        $ranking = 1;
        foreach ($hasil as &$item) {
            $item['ranking'] = $ranking++;
        }

        return view('ranking.index', compact('kriteria', 'alternatif', 'hasil'));
    }

    public function exportPdf()
    {
        // Sama seperti index, tapi untuk PDF
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $alternatif = Alternatif::orderBy('kode_alternatif')->get();

        if ($kriteria->isEmpty() || $alternatif->isEmpty()) {
            return redirect()->route('ranking.index')->with('error', 'Data tidak lengkap untuk dicetak.');
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
            return redirect()->route('ranking.index')->with('error', 'Belum ada penilaian untuk dicetak.');
        }

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

        $hasil = [];
        foreach ($alternatif as $alt) {
            $total = 0;
            foreach ($kriteria as $krit) {
                $utility = $normalisasi[$alt->id][$krit->id] * $bobotNormalisasi[$krit->id];
                $total += $utility;
                $hasil[$alt->id]['detail'][$krit->id] = [
                    'normalisasi' => $normalisasi[$alt->id][$krit->id],
                    'bobot_normalisasi' => $bobotNormalisasi[$krit->id],
                    'utility' => $utility,
                ];
            }
            $hasil[$alt->id]['nilai_akhir'] = $total;
            $hasil[$alt->id]['alternatif'] = $alt;
        }

        usort($hasil, function ($a, $b) {
            return $b['nilai_akhir'] <=> $a['nilai_akhir'];
        });

        $ranking = 1;
        foreach ($hasil as &$item) {
            $item['ranking'] = $ranking++;
        }

        $pdf = Pdf::loadView('ranking.pdf', compact('kriteria', 'alternatif', 'hasil'));
        return $pdf->download('ranking_ewallet.pdf');
    }
}