<?php

namespace App\Http\Controllers;

use App\Exports\PencatatanHarianExport;
use App\Models\Harian;
use App\Models\Siswa;
use App\Models\Surat;
use App\Models\Target;
use Illuminate\Http\Request;

class HarianController extends Controller
{
    public function index()
    {
        $data = Harian::indexHarian();

        return view('harian.index', [
            'title' => 'Pencatatan Harian',
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

        return view('harian.tambah',[
            "title" => 'Tambah Pencatatan Harian',
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
            'target_id' => 'required',
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

        Harian::create($validated);

        $target = Target::find($request['target_id']);
        $total_ayat_target = $target->total($target->juz);
        $target->update([
            'target_ayat' => $target->target_ayat + $validated['total_ayat'],
            'target_persen' => (($target->target_ayat + $validated['total_ayat']) / $total_ayat_target) * 100
        ]);

        return redirect('/pencatatan-harian')->with('success', 'Data Berhasil Ditambahkan');
    }
    
    public function edit($id) 
    {
        if (auth()->user()->hasRole('admin')) {
            $siswa = Siswa::orderBy('name', 'ASC')->get();
        } else {
            $siswa = Siswa::where('user_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
        }

        $harian = Harian::find($id);

        return view('harian.edit',[
            "title" => 'Edit Pencatatan Harian',
            "siswa" => $siswa,
            "surat" => Surat::orderBy('order', 'ASC')->get(),
            "data" => $harian
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required',
            'user_id' => 'required',
            'siswa_id' => 'required',
            'target_id' => 'required',
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

        $harian = Harian::find($id);
        $target_before = Target::find($harian->target_id);
        $target = Target::find($request['target_id']);
        $total_ayat_target = $target->total($target->juz);
        
        $target_before->update([
            'target_ayat' => $target_before->target_ayat - $harian->total_ayat,
            'target_persen' => (($target_before->target_ayat - $harian->total_ayat) / $total_ayat_target) * 100
        ]);
        $harian->update($validated);

        $target->update([
            'target_ayat' => $target->target_ayat + $validated['total_ayat'],
            'target_persen' => (($target->target_ayat + $validated['total_ayat']) / $total_ayat_target) * 100
        ]);

        return redirect('/pencatatan-harian')->with('success', 'Data Berhasil Diupdate');
    }
    
    public function delete($id)
    {
        $harian = Harian::find($id);
        $target = Target::find($harian->target_id);

        $total_ayat_target = $target->total($target->juz);
        $target->update([
            'target_ayat' => $target->target_ayat - $harian->total_ayat,
            'target_persen' => (($target->target_ayat - $harian->total_ayat) / $total_ayat_target) * 100
        ]);

        $harian->delete();
        return redirect('/pencatatan-harian')->with('success', 'Data Berhasil Didelete');
    }

    public function export()
    {
        return (new PencatatanHarianExport($_GET))->download('Pencatatan Harian.xlsx');
    }


    public function getDataTarget(Request $request)
    {
        $target = Target::where('siswa_id', $request['id'])->get();
        return $target;
    }

    public function getTargetName(Request $request)
    {
        $target = Target::find($request['id']);
        return $target;
    }

    public function getDataSurat(Request $request)
    {
        $surat = Surat::find($request['id']);
        return $surat;
    }
}
