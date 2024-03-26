@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <center>
            <div class="card col-lg-5">
                <div class="p-3">
                    <form method="post" action="{{ route('kelompok.update', $group->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="name" class="float-left">Nama Kelompok</label>
                            <input type="name" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value=" {{ old('name', $group->name) }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tahunPelajaran" class="float-left">Tahun Pelajaran</label>
                            <select class="form-control selectpicker @error('tahun_pelajaran_id') is-invalid @enderror" id="tahunPelajaran" name="tahun_pelajaran_id" data-live-search="true">
                                <option value="">-- Pilih Tahun Pelajaran --</option>
                                @foreach ($tahunPelajaran as $tahun)
                                    <option value="{{ $tahun->id }}" {{ $group->tahun_pelajaran_id == $tahun->id ? 'selected' : '' }}>{{ $tahun->tahun }}</option>
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
                            <select class="form-control selectpicker @error('siswa_id') is-invalid @enderror" id="siswa" data-live-search="true" name="siswa_id">
                                <option value="">-- Pilih Siswa --</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}" {{ $group->siswa_id == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
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
                                    <option value="{{ $teacher->id }}" {{ $group->guru_id == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
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
                                <option value="tahfidz" {{ $group->kategori == 'tahfidz' ? 'selected' : '' }}>Tahfidz</option>
                                <option value="tahsin" {{ $group->kategori == 'tahsin' ? 'selected' : '' }}>Tahsin </option>
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
