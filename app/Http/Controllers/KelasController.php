<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Target;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KelasController extends Controller
{
    public function index()
    {
        $search = request()->input('search');
        $data = Kelas::when($search, function ($query) use ($search) {
                    return $query->where('name', 'LIKE', '%'.$search.'%');
                })
                ->orderBy('name', 'ASC');

        return view('kelas.index', [
            'title' => 'Kelas',
            'data' => $data->paginate(10)->withQueryString()
        ]);
    }

    public function tambah()
    {
        return view('kelas.tambah',[
            "title" => 'Tambah Kelas',
        ]);
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        Kelas::create($validated);
        return redirect('/kelas')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $data = Kelas::find($id);
        return view('kelas.edit',[
            "title" => 'Edit Kelas',
            "data" => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        $data = Kelas::find($id);
        $data->update($validated);

        return redirect('/kelas')->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id)
    {
        $check = Target::where('kelas_id', $id)->count();
        if ($check > 0) {
            Alert::error('Failed', 'Masih Ada Siswa Yang Menggunakan Kelas Ini!');
            return back();
        } else {
            $data = Kelas::find($id);
            $data->delete();
        }

        return redirect('/kelas')->with('success', 'Data Berhasil Didelete');
    }
}
