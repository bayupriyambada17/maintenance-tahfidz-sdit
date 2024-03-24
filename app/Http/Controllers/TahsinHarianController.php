<?php

namespace App\Http\Controllers;

use App\Exports\TahsinHarianExport;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Surat;
use App\Models\TahsinHarian;
use Illuminate\Http\Request;

class TahsinHarianController extends Controller
{
    public function index()
    {
        $data = TahsinHarian::indexHarian();

        return view('tahsin-harian.index', [
            'title' => 'Tahsin Harian',
            'data' => $data->paginate(10)->withQueryString()
        ]);
    }

    public function tambah()
    {
        if (auth()->user()->hasRole('admin')) {
            $siswa = Siswa::orderBy('name', 'ASC')->get();
        } else {
            $siswa = Siswa::where('user_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
        }

        return view('tahsin-harian.tambah',[
            "title" => 'Tambah Data Tahsin Harian',
            "siswa" => $siswa,
            "surat" => Surat::orderBy('order', 'ASC')->get(),
            "kelas" => Kelas::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required',
            'user_id' => 'required',
            'siswa_id' => 'required',
            'kelas_id' => 'required',
            'from' => 'required',
            'to' => 'required',
            'makhroj' => 'required',
            'tajwid' => 'required',
            'kelancaran' => 'required',
        ]);

        TahsinHarian::create($validated);

        return redirect('/tahsin-harian')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        if (auth()->user()->hasRole('admin')) {
            $siswa = Siswa::orderBy('name', 'ASC')->get();
        } else {
            $siswa = Siswa::where('user_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
        }

        $tahsin = TahsinHarian::find($id);

        return view('tahsin-harian.edit',[
            "title" => 'Edit Data Tahsin Harian',
            "siswa" => $siswa,
            "surat" => Surat::orderBy('order', 'ASC')->get(),
            "kelas" => Kelas::orderBy('name', 'ASC')->get(),
            "data" => $tahsin,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required',
            'user_id' => 'required',
            'siswa_id' => 'required',
            'kelas_id' => 'required',
            'from' => 'required',
            'to' => 'required',
            'makhroj' => 'required',
            'tajwid' => 'required',
            'kelancaran' => 'required',
        ]);

        $tahsin = TahsinHarian::find($id);
        $tahsin->update($validated);

        return redirect('/tahsin-harian')->with('success', 'Data Berhasil Diupdate');
    }
    
    public function delete($id)
    {
        $tahsin = TahsinHarian::find($id);
        $tahsin->delete();
        return redirect('/tahsin-harian')->with('success', 'Data Berhasil Didelete');
    }

    public function export()
    {
        return (new TahsinHarianExport($_GET))->download('Tahsin Harian.xlsx');
    }
}
