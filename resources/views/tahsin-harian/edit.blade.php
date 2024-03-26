@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card col-lg-12">
            <div class="mt-4 p-4">
                <form method="post" action="{{ url('/tahsin-harian/update/'.$data->id) }}">
                    @method('put')
                    @csrf
                    <div class="form-row">
                        <div class="col-lg-4 col-sm-12 col-md-4 mb-4">
                            <label for="tanggal">Tanggal</label>
                            <input type="datetime" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $data->tanggal) }}">
                            @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4 mb-4">
                            <label for="siswa_id">Siswa</label>
                            <select class="form-control selectpicker @error('siswa_id') is-invalid @enderror" data-live-search="true" name="siswa_id" id="siswa_id">
                                <option value="">-- Pilih --</option>
                                @foreach ($siswa as $s)
                                    @if(old('siswa_id', $data->siswa_id) == $s->id)
                                        <option value="{{ $s->id }}" selected>{{ $s->name }}</option>
                                    @else
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('siswa_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4 mb-4">
                            <label for="kelas_id">Kelas</label>
                            <select class="form-control selectpicker @error('kelas_id') is-invalid @enderror" data-live-search="true" name="kelas_id" id="kelas_id">
                                <option value="">-- Pilih --</option>
                                @foreach ($kelas as $k)
                                    @if(old('kelas_id', $data->kelas_id) == $k->id)
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
                        <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                            <label for="from">Mulai</label>
                            <input type="text" class="form-control @error('from') is-invalid @enderror" id="from" name="from" value="{{ old('from', $data->from) }}">
                            @error('from')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                            <label for="to">Akhir</label>
                            <input type="text" class="form-control @error('to') is-invalid @enderror" id="to" name="to" value="{{ old('to', $data->to) }}">
                            @error('to')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        {{-- <div class="col-lg-4 col-sm-12 col-md-4 mb-4">
                            <label for="makhroj">Makhroj</label>
                            <input type="number" class="form-control @error('makhroj') is-invalid @enderror" id="makhroj" name="makhroj" value="{{ old('makhroj', $data->makhroj) }}">
                            @error('makhroj')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4 mb-4">
                            <label for="tajwid">Tajwid</label>
                            <input type="number" class="form-control @error('tajwid') is-invalid @enderror" id="tajwid" name="tajwid" value="{{ old('tajwid', $data->tajwid) }}">
                            @error('tajwid')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4 mb-4">
                            <label for="kelancaran">Kelancaran</label>
                            <input type="number" class="form-control @error('kelancaran') is-invalid @enderror" id="kelancaran" name="kelancaran" value="{{ old('kelancaran', $data->kelancaran) }}">
                            @error('kelancaran')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div> --}}
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
            </div>
        </div>
    </div>
@endsection
