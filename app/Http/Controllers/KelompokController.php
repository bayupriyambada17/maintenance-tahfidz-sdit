<?php

namespace App\Http\Controllers;

use App\Http\Requests\KelompokStoreRequest;
use App\Http\Requests\KelompokUpdateRequest;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Groups;
use App\Models\TahunPelajaran;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sSearch = request()->input('search');
        $user = auth()->user();
        $sTahunPelajaran = request()->input('tahunPelajaran');
        $sKategori = request()->input('kategori');

        $tahunPelajaran = TahunPelajaran::get();
        $groups = Groups::when($sSearch, function ($query) use ($sSearch) {
            $query->where('name', 'LIKE', '%' . $sSearch . '%');
        })->when($sTahunPelajaran, function ($query) use ($sTahunPelajaran) {
            $query->where('tahun_pelajaran_id', $sTahunPelajaran);
        })
            ->when($sKategori, function ($query) use ($sKategori) {
                $query->where('kategori', $sKategori);
            })
            ->orderByDesc('created_at')->paginate(10);
        return view('kelompok.index', [
            'title' => 'Halaman Kelompok',
            'groups' => $groups,
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
        $tahunPelajaran = TahunPelajaran::get();
        $students = Siswa::get();
        $teachers = User::select('id', 'name')->whereHas(
            'roles',
            function ($query) {
                $query->where('name', 'guru');
            }
        )->get();
        return view('kelompok.create', [
            'title' => 'Tambah Kelompok',
            'tahunPelajaran' => $tahunPelajaran,
            'students' => $students,
            'teachers' => $teachers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KelompokStoreRequest $request)
    {
        $siswaIds = $request->siswa_id;

        $groupArr = [];
        foreach ($siswaIds as $siswaId) {
            $data = [
                'name' => $request->name,
                'guru_id' => $request->guru_id,
                'siswa_id' => $siswaId,
                'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
                'kategori' => $request->kategori
            ];
            $groupArr[] = $data;
        }
        Groups::insert($data);
        return redirect(route('kelompok.index'))->with('success', 'Data berhasil ditambahkan');
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
        $group = Groups::find($id);
        $tahunPelajaran = TahunPelajaran::get();
        $students = Siswa::get();
        $teachers = User::select('id', 'name')->whereHas(
            'roles',
            function ($query) {
                $query->where('name', 'guru');
            }
        )->get();
        return view('kelompok.edit', [
            'title' => "Edit Kelompok $group->name",
            'group' => $group,
            'students' => $students,
            'teachers' => $teachers,
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
    public function update(KelompokUpdateRequest $request, $id)
    {
        $data = [
            'name' => $request->name,
            'guru_id' => $request->guru_id,
            'siswa_id' => $request->siswa_id,
            'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
            'kategori' => $request->kategori
        ];
        Groups::find($id)->update($data);
        return redirect(route('kelompok.index'))->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Groups::find($id)->delete();
        return redirect(route('kelompok.index'))->with('success', 'Data Berhasil di Hapus');
    }
}
