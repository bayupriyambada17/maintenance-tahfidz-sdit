<?php

namespace App\Http\Controllers;

use App\Exports\UjianTahfidzExport;
use App\Models\Siswa;
use App\Models\Surat;
use App\Models\UjianTahfidz;
use Illuminate\Http\Request;

class UjianTahfidzController extends Controller
{
    public function index()
    {
        $data = UjianTahfidz::indexUjian();

        return view('ujian.index', [
            'title' => 'Ujian Tahfidz',
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

        return view('ujian.tambah',[
            "title" => 'Tambah Data Ujian Tahfidz',
            "siswa" => $siswa,
            "surat" => Surat::orderBy('order', 'ASC')->get(),
        ]);
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required',
            'user_id' => 'required',
            'siswa_id' => 'required',
            'juz' => 'required',
            'from_surat' => 'required',
            'from_ayat' => 'required',
            'to_surat' => 'required',
            'to_ayat' => 'required',
            'makhroj' => 'required',
            'tajwid' => 'required',
            'kelancaran' => 'required',
        ]);

        $first_surat = Surat::find($request['from_surat']);
        $last_surat = Surat::find($request['to_surat']);
        $sum_ayat = 0;

        $total_from_ayat = $first_surat->last_ayat - $request['from_ayat'] +  1;
        $total_to_ayat = $request['to_ayat'] - $last_surat->first_ayat + 1;

        $arr_order = [];
        for ($i = $first_surat->order + 1; $i < $last_surat->order; $i++) {
            $arr_order[] = $i;
        }

        $surats = Surat::whereIn('order', $arr_order)->get();
        foreach ($surats as $surat) {
            $total_ayat = $surat->last_ayat - $surat->first_ayat + 1;
            $sum_ayat += $total_ayat;
        }

        if ($request['from_surat'] !== $request['to_surat'] || $first_surat->name !== $last_surat->name) {
            $validated['total_ayat'] = $sum_ayat + $total_from_ayat + $total_to_ayat;
        } else {
            $validated['total_ayat'] = $request['to_ayat'] - $request['from_ayat'] + 1;
        }

        UjianTahfidz::create($validated);

        return redirect('/ujian-tahfidz')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        if (auth()->user()->hasRole('admin')) {
            $siswa = Siswa::orderBy('name', 'ASC')->get();
        } else {
            $siswa = Siswa::where('user_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
        }

        $ujian = UjianTahfidz::find($id);

        return view('ujian.edit',[
            "title" => 'Tambah Data Ujian Tahfidz',
            "siswa" => $siswa,
            "surat" => Surat::orderBy('order', 'ASC')->get(),
            "data" => $ujian,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required',
            'user_id' => 'required',
            'siswa_id' => 'required',
            'juz' => 'required',
            'from_surat' => 'required',
            'from_ayat' => 'required',
            'to_surat' => 'required',
            'to_ayat' => 'required',
            'makhroj' => 'required',
            'tajwid' => 'required',
            'kelancaran' => 'required',
        ]);

        $first_surat = Surat::find($request['from_surat']);
        $last_surat = Surat::find($request['to_surat']);
        $sum_ayat = 0;

        $total_from_ayat = $first_surat->last_ayat - $request['from_ayat'] +  1;
        $total_to_ayat = $request['to_ayat'] - $last_surat->first_ayat + 1;

        $arr_order = [];
        for ($i = $first_surat->order + 1; $i < $last_surat->order; $i++) {
            $arr_order[] = $i;
        }

        $surats = Surat::whereIn('order', $arr_order)->get();
        foreach ($surats as $surat) {
            $total_ayat = $surat->last_ayat - $surat->first_ayat + 1;
            $sum_ayat += $total_ayat;
        }

        if ($request['from_surat'] !== $request['to_surat'] || $first_surat->name !== $last_surat->name) {
            $validated['total_ayat'] = $sum_ayat + $total_from_ayat + $total_to_ayat;
        } else {
            $validated['total_ayat'] = $request['to_ayat'] - $request['from_ayat'] + 1;
        }

        $ujian = UjianTahfidz::find($id);
        $ujian->update($validated);

        return redirect('/ujian-tahfidz')->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id)
    {
        $ujian = UjianTahfidz::find($id);
        $ujian->delete();
        return redirect('/ujian-tahfidz')->with('success', 'Data Berhasil Diupdate');
    }

    public function export()
    {
        return (new UjianTahfidzExport($_GET))->download('Ujian Tahfidz.xlsx');
    }
}
