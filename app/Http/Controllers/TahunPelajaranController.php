<?php

namespace App\Http\Controllers;

use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class TahunPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahunPelajaran = TahunPelajaran::get();
        return view('tahun-pelajaran.index', [
            'title' => "Halaman Tahun Pelajaran",
            'tahunPelajaran' => $tahunPelajaran
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tahun-pelajaran.create', [
            'title' => 'Tambah Tahun Pelajaran',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'tahun' => 'required'
        ]);

        TahunPelajaran::create($validation);
        return redirect()->route('tahun-pelajaran.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tahunPelajaran = TahunPelajaran::find($id);
        return view('tahun-pelajaran.edit', [
            'title' => "Edit Tahun Pelajaran",
            'tahunPelajaran' => $tahunPelajaran
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tahunPelajaran = TahunPelajaran::find($id);
        $validation = $request->validate([
            'tahun' => 'required'
        ]);

        $tahunPelajaran->update($validation);
        return redirect()->route('tahun-pelajaran.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tahunPelajaran = TahunPelajaran::find($id);
        $tahunPelajaran->delete();
        return redirect()->route('tahun-pelajaran.index')->with('success', 'Data Berhasil Dihapus');
    }
}
