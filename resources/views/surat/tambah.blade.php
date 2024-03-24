@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <center>
            <div class="card col-lg-5">
                <div class="p-3">
                    <form method="post" action="{{ url('/surat/insert') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="float-left">Nama</label>
                            <input type="name" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="first_ayat" class="float-left">Ayat Pertama</label>
                            <input type="number" class="form-control @error('first_ayat') is-invalid @enderror" id="first_ayat" name="first_ayat" value="{{ old('first_ayat') }}">
                            @error('first_ayat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="last_ayat" class="float-left">Ayat Terakhir</label>
                            <input type="number" class="form-control @error('last_ayat') is-invalid @enderror" id="last_ayat" name="last_ayat" value="{{ old('last_ayat') }}">
                            @error('last_ayat')
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
                            <label for="order" class="float-left">Urutan Surat</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order') }}">
                            @error('order')
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
