<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Harian;
use App\Models\Target;
use App\Models\UjianTahsin;
use App\Imports\SiswaImport;
use App\Models\TahsinHarian;
use App\Models\UjianTahfidz;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class SiswaController extends Controller
{
    public function index()
    {
        $search = request()->input('search');
        $data = Siswa::when($search, function ($query) use ($search) {
                    return $query->where('name', 'LIKE', '%'.$search.'%')
                                ->orWhere('nis', 'LIKE', '%'.$search.'%')
                                ->orWhere('nisn', 'LIKE', '%'.$search.'%')
                                ->orWhereHas('user', function ($query) use ($search) {
                                    $query->where('name', 'LIKE', '%'.$search.'%');
                                });
                })
                ->orderBy('id', 'ASC');

        return view('siswa.index', [
            'title' => 'Siswa',
            'data' => $data->paginate(10)->withQueryString()
        ]);
    }

    public function tambah()
    {
        return view('siswa.tambah',[
            "title" => 'Tambah Siswa',
            "user" => User::orderBy('name')->get(),
        ]);
    }

    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'nis' => 'required|unique:siswas',
            'nisn' => 'required|unique:siswas',
            'user_id' => 'required',
        ]);

        Siswa::create($validatedData);

        return redirect('/siswa')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv|max:5000'
        ]);
        
        $file = $request->file('file');
        $nama_file = $file->getClientOriginalName();
        $file->move('siswa_import', $nama_file);

        Excel::import(new SiswaImport, public_path('/siswa_import/'.$nama_file));
        return back()->with('success', 'Data Berhasil Di Import');
    }

    public function edit($id)
    {
        $data = Siswa::find($id);
        return view('siswa.edit',[
            "title" => 'Edit Siswa',
            "user" => User::orderBy('name')->get(),
            "data" => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'user_id' => 'required',
        ];

        $siswa = Siswa::find($id);

        if ($request->nis != $siswa->nis) {
            $rules['nis'] = 'required|unique:siswas';
        }

        if ($request->nisn != $siswa->nisn) {
            $rules['nisn'] = 'required|unique:siswas';
        }

        $validatedData = $request->validate($rules);
        $siswa->update($validatedData);

        return redirect('/siswa')->with('success', 'Data Berhasil di Update');
    }

    public function delete($id)
    {
        $target = Target::where('siswa_id', $id)->count();
        $harian_tahfidz = Harian::where('siswa_id', $id)->count();
        $ujian_tahfidz = UjianTahfidz::where('siswa_id', $id)->count();
        $tahsin_harian = TahsinHarian::where('siswa_id', $id)->count();
        $ujian_tahsin = UjianTahsin::where('siswa_id', $id)->count();
        if ($target > 0 || $harian_tahfidz > 0 || $ujian_tahfidz > 0 || $tahsin_harian > 0 || $ujian_tahsin > 0) {
            Alert::error('Failed', 'Terdapat Data Target / Data Tahfidz / Data Tahsin Yang Menggunakan Siswa Ini!');
            return back();
        } else {
            $siswa = Siswa::find($id);
            $siswa->delete();
            return redirect('/siswa')->with('success', 'Data Berhasil di Delete');
        }
    }

    public function target($id)
    {
        $siswa = Siswa::find($id);
        $search = request()->input('search');
        $data = Target::where('siswa_id', $id)
                        ->when($search, function ($query) use ($search) {
                            return $query->where('juz', 'LIKE', '%'.$search.'%')
                                        ->orWhere('tahun', 'LIKE', '%'.$search.'%')
                                        ->orWhereHas('kelas', function ($query) use ($search) {
                                            $query->where('name', 'LIKE', '%'.$search.'%');
                                        })
                                        ->orderBy('tahun', 'ASC');
                        });
        return view('siswa.target',[
            "title" => 'Target Siswa',
            "siswa" => $siswa,
            "data" => $data->paginate(10)->withQueryString(),
            "kelas" => Kelas::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function insertTarget(Request $request, $id)
    {
        $validated = $request->validate([
            'siswa_id' => 'required',
            'kelas_id' => 'required',
            'juz' => 'required|integer|between:1,30',
            'tahun' => 'required',
        ]);

        Target::create($validated);
        return redirect('/siswa/target/'.$id)->with('success', 'Data Berhasil Ditambahkan');
    }

    public function editTarget($target_id, $siswa_id)
    {
        $siswa = Siswa::find($siswa_id);
        $data = Target::find($target_id);
        return view('siswa.edit-target',[
            "title" => 'Edit Siswa',
            "siswa" => $siswa,
            "data" => $data,
            "kelas" => Kelas::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function updateTarget(Request $request, $target_id, $siswa_id)
    {
        $validated = $request->validate([
            'siswa_id' => 'required',
            'kelas_id' => 'required',
            'juz' => 'required|integer|between:1,30',
            'tahun' => 'required',
        ]);

        $target = Target::find($target_id);
        $target->update($validated);
        return redirect('/siswa/target/'.$siswa_id)->with('success', 'Data Berhasil Diupdate');
    }

    public function deleteTarget($target_id, $siswa_id)
    {
        $harian_tahfidz = Harian::where('target_id', $target_id)->count();
        if ($harian_tahfidz > 0) {
            Alert::error('Failed', 'Terdapat Data Tahfidz Harian Yang Menggunakan Target Ini!');
            return back();
        } else {
           
            $target = Target::find($target_id);
            $target->delete();
            return redirect('/siswa/target/'.$siswa_id)->with('success', 'Data Berhasil Didelete');
        }
    }

}
