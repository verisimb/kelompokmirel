<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
        try {
            // Validasi: semua nilai wajib diisi dan numerik
            $rules = [];
            $messages = [];
            $nilaiArray = $request->input('nilai', []);

            foreach ($nilaiArray as $altId => $kriteriaValues) {
                foreach ($kriteriaValues as $kritId => $nilai) {
                    $fieldName = "nilai.{$altId}.{$kritId}";
                    $rules[$fieldName] = 'required|numeric';
                    $messages[$fieldName . '.required'] = "Nilai untuk alternatif ID {$altId} dan kriteria ID {$kritId} wajib diisi.";
                    $messages[$fieldName . '.numeric'] = "Nilai harus berupa angka.";
                }
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Proses simpan
            $count = 0;
            foreach ($nilaiArray as $alternatifId => $kriteriaValues) {
                foreach ($kriteriaValues as $kriteriaId => $nilai) {
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

            return redirect()->route('penilaian.index')
                ->with('success', $count . ' penilaian berhasil disimpan!');

        } catch (\Exception $e) {
            Log::error('Error saat menyimpan penilaian: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}