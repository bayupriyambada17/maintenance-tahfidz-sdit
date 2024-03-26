@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <center>
            <div class="card col-lg-5">
                <div class="p-3">
                    <form method="post" action="{{ route('kelompok.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="float-left">Nama Kelompok</label>
                            <input type="name" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tahunPelajaran" class="float-left">Tahun Pelajaran</label>
                            <select class="form-control selectpicker @error('tahun_pelajaran_id') is-invalid @enderror" data-live-search="true" id="tahunPelajaran" name="tahun_pelajaran_id">
                                <option value="">-- Pilih Tahun Pelajaran --</option>
                                @foreach ($tahunPelajaran as $tahun)
                                    <option value="{{ $tahun->id }}">{{ $tahun->tahun }}</option>
                                @endforeach
                            </select>
                            @error('tahun_pelajaran_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="siswa" class="float-left">Siswa</label>
                            <select class="form-control selectpicker @error('siswa_id') is-invalid @enderror" data-live-search="true" id="siswa" name="siswa_id[]" multiple>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                            @error('siswa_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="guru" class="float-left">guru</label>
                            <select class="form-control selectpicker @error('guru_id') is-invalid @enderror" data-live-search="true" id="guru" name="guru_id">
                                <option value="">-- Pilih Guru --</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            @error('guru_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kategori" class="float-left">Kategori Kelompok</label>
                            <select class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori">
                                <option value="">-- Pilih Kategori Kelompok --</option>
                                <option value="tahfidz">Tahfidz</option>
                                <option value="tahsin">Tahsin </option>
                            </select>
                            @error('kategori')
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
