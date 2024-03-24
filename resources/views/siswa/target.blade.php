@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <center>
                        <h4 class="mt-2">Tambah Target</h1>
                    </center>
                    <div class="p-4">
                        <form method="post" action="{{ url('/siswa/target/insert/'.$siswa->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="kelas_id" class="float-left">Kelas</label>
                                <select class="form-control selectpicker @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id" data-live-search="true">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($kelas as $k)
                                        @if(old('kelas_id') == $k->id)
                                            <option value="{{ $k->id }}" selected>{{ $k->name }}</option>
                                        @else
                                            <option value="{{ $k->id }}">{{ $k->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="juz" class="float-left">Juz</label>
                                <select class="form-control selectpicker @error('juz') is-invalid @enderror" id="juz" name="juz" data-live-search="true">
                                    <option value="">-- Pilih --</option>
                                    @for ($i = 1; $i <= 30; $i++)
                                        @if(old('juz') == $i)
                                            <option value="{{{ $i }}}" selected>{{ $i }}</option>
                                        @else
                                            <option value="{{{ $i }}}">{{ $i }}</option>
                                        @endif
                                    @endfor
                                </select>
                                @error('juz')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tahun" class="float-left">Tahun</label>
                                <select class="form-control selectpicker @error('tahun') is-invalid @enderror" id="tahun" name="tahun" data-live-search="true">
                                    <option value="">-- Pilih --</option>
                                    @for ($i = 2000; $i <= (date('Y')+10); $i++)
                                        @if(old('tahun', date('Y')) == $i)
                                            <option value="{{{ $i }}}" selected>{{ $i }}</option>
                                        @else
                                            <option value="{{{ $i }}}">{{ $i }}</option>
                                        @endif
                                    @endfor
                                </select>
                                @error('tahun')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </form>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <center>
                            <h3>{{ $siswa->name }}</h3>
                        </center>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/siswa/target/'.$siswa->id) }}">
                            <div class="form-row">
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
                        <table id="tableresponsive" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kelas</th>
                                    <th>Juz</th>
                                    <th>Tahun</th>
                                    <th>Total Ayat</th>
                                    <th>Target %</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->kelas->name }}</td>
                                        <td>{{ $d->juz }}</td>
                                        <td>{{ $d->tahun }}</td>
                                        <td>{{ $d->total($d->juz) }}</td>
                                        <td>{{ $d->target_persen ? $d->target_persen : 0 }} %</td>
                                        <td>
                                            <a href="{{ url('/siswa/target/edit/'.$d->id.'/'.$siswa->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-solid fa-edit"></i></a>
                                            <form action="{{ url('/siswa/target/delete/'.$d->id.'/'.$siswa->id) }}" method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger btn-sm btn-circle" onClick="return confirm('Are You Sure')"><i class="fa fa-solid fa-trash"></i></button>
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
        </div>
    </div>
    <br>
@endsection
