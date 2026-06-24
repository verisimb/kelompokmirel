<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        return view('kriteria.index', compact('kriteria'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_kriteria' => 'required|string|max:10|unique:kriteria,kode_kriteria',
            'nama_kriteria' => 'required|string|max:100',
            'bobot' => 'required|integer|min:1|max:10',
            'tipe' => 'required|in:benefit,cost',
            'satuan' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Kriteria::create($request->all());

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode_kriteria' => 'required|string|max:10|unique:kriteria,kode_kriteria,' . $id,
            'nama_kriteria' => 'required|string|max:100',
            'bobot' => 'required|integer|min:1|max:10',
            'tipe' => 'required|in:benefit,cost',
            'satuan' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kriteria->update($request->all());

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil diupdate!');
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);

        if ($kriteria->penilaian()->count() > 0) {
            return redirect()->route('kriteria.index')
                ->with('error', 'Kriteria tidak bisa dihapus karena sudah memiliki data penilaian!');
        }

        $kriteria->delete();

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil dihapus!');
    }
}