@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a href="{{ url('/ujian-tahsin/tambah') }}" class="btn btn-sm btn-primary float-right">+ Tambah</a>
                <a href="{{ url('/ujian-tahsin/export') }}{{ $_GET?'?'.$_SERVER['QUERY_STRING']: '' }}" class="btn btn-sm btn-success">Export</a>
            </div>
            <div class="card-body">
                <form action="{{ url('/ujian-tahsin') }}">
                    <div class="form-row mb-2">
                        <div class="input-group">
                            <input type="datetime" class="form-control" name="mulai" placeholder="Tanggal Mulai" id="mulai" value="{{ request('mulai') }}">
                            <input type="datetime" class="form-control ml-2" name="akhir" placeholder="Tanggal Akhir" id="akhir" value="{{ request('akhir') }}">
                            <input type="text" class="form-control ml-2" name="siswa" placeholder="Siswa" id="siswa" value="{{ request('siswa') }}">
                            <input type="text" class="form-control ml-2" name="kelas" placeholder="Kelas" id="kelas" value="{{ request('kelas') }}">
                            <input type="text" class="form-control ml-2" name="surat" placeholder="surat" id="surat" value="{{ request('surat') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table table-striped" id="tableresponsive">
                    <thead>
                        <tr>
                            <th>No.</th>    
                            <th>Tanggal</th>
                            <th>Musyrif</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Mulai</th>
                            <th>Akhir</th>
                            <th>Makhroj</th>
                            <th>Tajwid</th>
                            <th>Kelancaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->tanggal }}</td>
                                <td>{{ $d->user->name }}</td>
                                <td>{{ $d->siswa->name }}</td>
                                <td>{{ $d->kelas->name }}</td>
                                <td>{{ $d->from }}</td>
                                <td>{{ $d->to }}</td>
                                <td>{{ $d->makhroj }}</td>
                                <td>{{ $d->tajwid }}</td>
                                <td>{{ $d->kelancaran }}</td>
                                <td>
                                    <a href="{{ url('/ujian-tahsin/edit/'.$d->id) }}" title="Edit" class="btn btn-sm btn-info"><i class="fa fa-solid fa-edit"></i></a>
                                    <form action="{{ url('/ujian-tahsin/delete/'.$d->id) }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger btn-sm btn-circle" title="Delete" onClick="return confirm('Are You Sure')"><i class="fa fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mr-4">
                {{ $data->links() }}
            </div>
        </div>
    </div>
@endsection




