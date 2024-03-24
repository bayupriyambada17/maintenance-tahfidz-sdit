<?php

namespace App\Http\Controllers;

use App\Imports\TeacherImport;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->input('search');

        $teachers = User::whereHas('roles', function ($query) use ($search) {
            $query->where('name', 'guru');
        })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('email', 'LIKE', '%' . $search . '%')
                        ->orWhere('telepon', 'LIKE', '%' . $search . '%')
                        ->orWhere('username', 'LIKE', '%' . $search . '%');
                });
            })
            ->orderBy('name', 'ASC')
            ->paginate(10);
        return view('guru.index', [
            'title' => "Halaman Guru",
            "teachers" => $teachers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guru.create', [
            'title' => "Tambah Guru",
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
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'foto' => 'image|file|max:10240',
            'email' => 'required|email:dns|unique:users',
            'telepon' => 'required',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6|max:255',
        ]);

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('foto');
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        $roleTeacher = Role::where('name', 'guru')->first();
        $user->assignRole($roleTeacher);

        return redirect()->route('guru.index')->with('success', 'Data Berhasil di Tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teacher = User::findOrFail($id);
        return view('guru.edit', [
            'title' => "Edit Guru",
            'teacher' => $teacher
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
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'foto' => 'image|file|max:10240',
            'email' => 'required|email:dns|unique:users,email,' . $id,
            'telepon' => 'required',
            'username' => 'required|max:255|unique:users,username,' . $id,
        ]);

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('foto');
        }

        $user = User::findOrFail($id);
        $user->update($validatedData);

        return redirect()->route('guru.index')->with('success', 'Data Berhasil di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher = User::findOrFail($id);
        Storage::delete($teacher->foto);
        $teacher->delete();
        return redirect()->route('guru.index')->with('success', 'Data Berhasil di Hapus');
    }

    public function showPassword($id)
    {
        return view('guru.edit-password', [
            'title' => 'Halaman Edit Password',
            'teacher' => User::findOrFail($id)
        ]);
    }

    public function changePassword(Request $request, $id)
    {
        $validatedData = $request->validate([
            'password' => 'required|min:6|max:255',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        User::where('id', $id)->update($validatedData);
        $request->session()->flash('success', 'Password Berhasil Diganti');
        return redirect()->route('guru.index');
    }

    public function importTeacher(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv|max:5000'
        ]);

        $file = $request->file('file');
        $nameExcelFile = $file->getClientOriginalName();
        $file->move('teacher', $nameExcelFile);

        Excel::import(new TeacherImport, public_path('/teacher/' . $nameExcelFile));
        return back()->with('success', 'Data Berhasil Di Import');
    }
}
