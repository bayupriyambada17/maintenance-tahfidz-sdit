@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card col-lg-12">
            <div class="mt-4 p-4">
                <form method="post" action="{{ url('/siswa/update/'.$data->id) }}">
                    @method('put')
                    @csrf
                    <div class="form-row">
                        <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" autofocus value="{{ old('name', $data->name) }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                            <label for="nis">NIS</label>
                            <input type="number" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" value="{{ old('nis', $data->nis) }}">
                            @error('nis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                            <label for="nisn">NISN</label>
                            <input type="number" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ old('nisn', $data->nisn) }}">
                            @error('nisn')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                            <label for="user_id">Musyrif</label>
                            <select class="form-control selectpicker @error('user_id') is-invalid @enderror" data-live-search="true" name="user_id" id="user_id">
                                <option value="">-- Pilih --</option>
                                @foreach ($user as $u)
                                    @if(old('user_id', $data->user_id) == $u->id)
                                        <option value="{{ $u->id }}" selected>{{ $u->name }}</option>
                                    @else
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('user_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
            </div>
        </div>
    </div>
@endsection
