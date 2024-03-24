@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <center>
            <div class="card col-lg-5">
                <div class="p-3">
                    <form method="post" action="{{ url('/siswa/target/update/'.$data->id.'/'.$siswa->id) }}">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="kelas_id" class="float-left">Kelas</label>
                            <select class="form-control selectpicker @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id" data-live-search="true">
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
                        <div class="form-group">
                            <label for="juz" class="float-left">Juz</label>
                            <select class="form-control selectpicker @error('juz') is-invalid @enderror" id="juz" name="juz" data-live-search="true">
                                <option value="">-- Pilih --</option>
                                @for ($i = 1; $i <= 30; $i++)
                                    @if(old('juz', $data->juz) == $i)
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
                                    @if(old('tahun', $data->tahun) == $i)
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
                </div>
            </div>
        </center>
    </div>
@endsection
