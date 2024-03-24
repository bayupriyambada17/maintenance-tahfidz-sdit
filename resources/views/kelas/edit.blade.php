@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <center>
            <div class="card col-lg-5">
                <div class="p-3">
                    <form method="post" action="{{ url('/kelas/update/'.$data->id) }}">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="name" class="float-left">Nama Kelas</label>
                            <input type="name" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $data->name) }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                      </form>
                </div>
            </div>
        </center>
    </div>
@endsection
