<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenilaianController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $alternatif = Alternatif::orderBy('kode_alternatif')->get();

        $matriks = [];
        foreach ($alternatif as $alt) {
            foreach ($kriteria as $krit) {
                $nilai = Penilaian::where('alternatif_id', $alt->id)
                    ->where('kriteria_id', $krit->id)
                    ->first();
                $matriks[$alt->id][$krit->id] = $nilai ? $nilai->nilai : null;
            }
        }

        return view('penilaian.index', compact('kriteria', 'alternatif', 'matriks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nilai.*.*' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $nilaiArray = $request->input('nilai', []);

        if (empty($nilaiArray)) {
            return redirect()->back()
                ->with('error', 'Tidak ada data penilaian yang dikirim!')
                ->withInput();
        }

        $count = 0;
        foreach ($nilaiArray as $alternatifId => $kriteriaValues) {
            foreach ($kriteriaValues as $kriteriaId => $nilai) {
                if ($nilai === null || $nilai === '') {
                    continue;
                }

                $penilaian = Penilaian::where('alternatif_id', $alternatifId)
                    ->where('kriteria_id', $kriteriaId)
                    ->first();

                if ($penilaian) {
                    $penilaian->update(['nilai' => $nilai]);
                } else {
                    Penilaian::create([
                        'alternatif_id' => $alternatifId,
                        'kriteria_id' => $kriteriaId,
                        'nilai' => $nilai
                    ]);
                }
                $count++;
            }
        }

        if ($count === 0) {
            return redirect()->back()
                ->with('warning', 'Tidak ada nilai yang valid untuk disimpan!');
        }

        return redirect()->route('penilaian.index')
            ->with('success', $count . ' penilaian berhasil disimpan!');
    }
}