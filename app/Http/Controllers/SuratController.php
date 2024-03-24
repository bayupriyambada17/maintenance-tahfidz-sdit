<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Harian;
use App\Models\UjianTahsin;
use App\Imports\SuratImport;
use App\Models\TahsinHarian;
use App\Models\UjianTahfidz;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class SuratController extends Controller
{
    public function index()
    {
        $search = request()->input('search');
        $data = Surat::when($search, function ($query) use ($search) {
                    return $query->where('juz', 'LIKE', '%'.$search.'%');
                })
                ->orderBy('order', 'ASC');

        return view('surat.index', [
            'title' => 'Surat',
            'data' => $data->paginate(10)->withQueryString()
        ]);
    }

    public function tambah()
    {
        return view('surat.tambah',[
            "title" => 'Tambah Surat',
        ]);
    }

    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'first_ayat' => 'required',
            'last_ayat' => 'required',
            'juz' => 'required|integer|between:1,30',
            'order' => 'required|unique:surats',
        ]);

        Surat::create($validatedData);

        return redirect('/surat')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv|max:5000'
        ]);
        
        $file = $request->file('file');
        $nama_file = $file->getClientOriginalName();
        $file->move('surat_import', $nama_file);

        Excel::import(new SuratImport, public_path('/surat_import/'.$nama_file));
        return back()->with('success', 'Data Berhasil Di Import');
    }

    public function edit($id)
    {
        $data = Surat::find($id);
        return view('surat.edit',[
            "title" => 'Edit Surat',
            "data" => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'first_ayat' => 'required',
            'last_ayat' => 'required',
            'juz' => 'required|integer|between:1,30',
        ];

        $surat = Surat::find($id);

        if ($request->order != $surat->order) {
            $rules['order'] = 'required|unique:surats';
        }

        $validated = $request->validate($rules);

        $surat->update($validated);

        return redirect('/surat')->with('success', 'Data Berhasil di Update');
    }

    public function delete($id)
    {
        $harian_tahfidz = Harian::where('from_surat', $id)->orWhere('to_surat', $id)->count();
        $ujian_tahfidz = UjianTahfidz::where('from_surat', $id)->orWhere('to_surat', $id)->count();
        
        if ($harian_tahfidz > 0 || $ujian_tahfidz > 0) {
            Alert::error('Failed', 'Terdapat Data Tahfidz Yang Menggunakan Surat Ini!');
            return back();
        } else {
            $surat = Surat::find($id);
            $surat->delete();
            return redirect('/surat')->with('success', 'Data Berhasil di Delete');
        }
    }

}
