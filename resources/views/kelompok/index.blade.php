@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('kelompok.create') }}" class="btn btn-sm btn-primary float-right">+ Tambah</a>
            </div>
            <div class="card-body">
                <form action="{{ route('kelompok.index') }}">
                    <div class="form-row mb-2">
                        <div class="col-lg-3-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="search"
                                    id="mulai" value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-lg-3-sm-6">
                            <div class="input-group">
                                <select name="tahunPelajaran" class="form-control selectpicker" data-live-search="true" id="tahunPelajaran"
                                    value="{{ request('tahunPelajaran') }}">
                                    <option value="">-- Pilih Tahun Pelajaran --</option>
                                    @foreach ($tahunPelajaran as $tahun)
                                        <option value="{{ $tahun->id }}">
                                            {{ $tahun->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3-sm-6">
                            <div class="input-group">
                                <select class="form-control" id="kategori"
                                    name="kategori" value="{{ request('kategori') }}">
                                    <option value="">-- Pilih Kategori Kelompok --</option>
                                    <option value="tahfidz">Tahfidz</option>
                                    <option value="tahsin">Tahsin </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3-sm-6">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table table-striped" id="tableresponsive">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tahun Pelajaran</th>
                            <th>Nama Kelompok</th>
                            <th>Guru</th>
                            <th>Siswa</th>
                            <th>Kategori Kelompok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $group->tahunPelajaran->tahun }}</td>
                                <td>{{ $group->name }}</td>
                                <td>{{ $group->guru->name }}</td>
                                <td>{{ $group->siswa->name }}</td>
                                <td>{{ Str::upper($group->kategori) }}</td>
                                <td>
                                    <a href="{{ route('kelompok.edit', $group->id) }}" title="Edit"
                                        class="btn btn-sm btn-info"><i class="fa fa-solid fa-edit"></i></a>
                                    <form action="{{ route('kelompok.destroy', $group->id) }}" method="post"
                                        class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger btn-sm btn-circle" title="Delete"
                                            onClick="return confirm('Are You Sure')"><i
                                                class="fa fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mr-4">
                {{ $groups->links() }}
            </div>
        </div>
    </div>
@endsection
