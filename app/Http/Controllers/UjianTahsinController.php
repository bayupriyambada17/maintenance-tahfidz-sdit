<?php

namespace App\Http\Controllers;

use App\Exports\UjianTahsinExport;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Surat;
use App\Models\UjianTahsin;
use Illuminate\Http\Request;

class UjianTahsinController extends Controller
{
    public function index()
    {
        $data = UjianTahsin::indexUjian();

        return view('ujian-tahsin.index', [
            'title' => 'Ujian Tahsin',
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

        return view('ujian-tahsin.tambah',[
            "title" => 'Tambah Data Ujian Tahsin',
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

        UjianTahsin::create($validated);

        return redirect('/ujian-tahsin')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        if (auth()->user()->hasRole('admin')) {
            $siswa = Siswa::orderBy('name', 'ASC')->get();
        } else {
            $siswa = Siswa::where('user_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
        }

        $tahsin = UjianTahsin::find($id);

        return view('ujian-tahsin.edit',[
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

        $tahsin = UjianTahsin::find($id);
        $tahsin->update($validated);

        return redirect('/ujian-tahsin')->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id)
    {
        $tahsin = UjianTahsin::find($id);
        $tahsin->delete();
        return redirect('/ujian-tahsin')->with('success', 'Data Berhasil Didelete');
    }

    public function export()
    {
        return (new UjianTahsinExport($_GET))->download('Ujian Tahsin.xlsx');
    }
}
