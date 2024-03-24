@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a href="{{ url('/siswa/tambah') }}" class="btn btn-sm btn-primary float-right">+ Tambah</a>
                <button type="button" class="btn btn-sm btn-success float-right mr-2" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-file-excel mr-1"></i> Import
                </button>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-file-excel mr-1"></i> Import Excel</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ url('/siswa/import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="file">File Excel</label>
                                        <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
                                        @error('file')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('/siswa') }}">
                    <div class="form-row mb-2">
                        <div class="col-lg-3-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="search" id="mulai" value="{{ request('search') }}">
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
                            <th>Name</th>
                            <th>NIS</th>
                            <th>NISN</th>
                            <th>Musyrif</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->name }}</td>
                                <td>{{ $d->nis }}</td>
                                <td>{{ $d->nisn }}</td>
                                <td>{{ $d->user ? $d->user->name : '-' }}</td>
                                <td>
                                    <a href="{{ url('/siswa/target/'.$d->id) }}" class="btn btn-sm btn-primary" title="Target"><i class="fas fa-bullseye"></i></a>
                                    <a href="{{ url('/siswa/edit/'.$d->id) }}" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-solid fa-edit"></i></a>
                                    <form action="{{ url('/siswa/delete/'.$d->id) }}" method="post" class="d-inline">
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




