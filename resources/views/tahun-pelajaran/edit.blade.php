@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <center>
            <div class="card col-lg-5">
                <div class="p-3">
                    <form method="post" action="{{ route('tahun-pelajaran.update', $tahunPelajaran->id) }}">
                        @method('put')
                        @csrf
                            <div class="form-group">
                                <label for="tahun" class="float-left">Tahun Pelajaran</label>
                                <input type="tahun" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', $tahunPelajaran->tahun) }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        <br>
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                      </form>
                </div>
            </div>
        </center>
    </div>
@endsection
