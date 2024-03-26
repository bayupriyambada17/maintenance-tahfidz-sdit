@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                    <a href="{{ route('tahun-pelajaran.create') }}" class="btn btn-sm btn-primary float-right">+ Tambah</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="{{ url('/roles') }}">
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
                            <th>Tahun</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tahunPelajaran as $tahun)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tahun->tahun }}</td>
                                <td>
                                    <a href="{{ route('tahun-pelajaran.edit', $tahun->id) }}" title="Edit" class="btn btn-sm btn-info"><i class="fa fa-solid fa-edit"></i></a>
                                    <form action="{{ route('tahun-pelajaran.destroy', $tahun->id) }}" method="post" class="d-inline">
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
                {{-- {{ $tahuns->links() }} --}}
            </div>
        </div>
    </div>
@endsection




