<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlternatifController extends Controller
{
    public function index()
    {
        $alternatif = Alternatif::orderBy('kode_alternatif')->get();
        return view('alternatif.index', compact('alternatif'));
    }

    public function create()
    {
        return view('alternatif.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_alternatif' => 'required|string|max:10|unique:alternatif,kode_alternatif',
            'nama_ewallet' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Alternatif::create($request->all());

        return redirect()->route('alternatif.index')
            ->with('success', 'Alternatif berhasil ditambahkan!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $alternatif = Alternatif::findOrFail($id);
        return view('alternatif.edit', compact('alternatif'));
    }

    public function update(Request $request, $id)
    {
        $alternatif = Alternatif::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode_alternatif' => 'required|string|max:10|unique:alternatif,kode_alternatif,' . $id,
            'nama_ewallet' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $alternatif->update($request->all());

        return redirect()->route('alternatif.index')
            ->with('success', 'Alternatif berhasil diupdate!');
    }

    public function destroy($id)
    {
        $alternatif = Alternatif::findOrFail($id);

        if ($alternatif->penilaian()->count() > 0) {
            return redirect()->route('alternatif.index')
                ->with('error', 'Alternatif tidak bisa dihapus karena sudah memiliki data penilaian!');
        }

        $alternatif->delete();

        return redirect()->route('alternatif.index')
            ->with('success', 'Alternatif berhasil dihapus!');
    }
}