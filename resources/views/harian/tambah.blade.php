@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card col-lg-12">
            <div class="mt-4 p-4">
                <form method="post" action="{{ url('/pencatatan-harian/insert') }}">
                    @csrf
                    <div class="form-row">
                        <div class="col-lg-4 col-sm-12 col-md-4 mb-4">
                            <label for="tanggal">Tanggal</label>
                            <input type="datetime" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}">
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
                                    @if(old('siswa_id') == $s->id)
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
                            <label for="target_id">Target</label>
                            <select class="form-control selectpicker @error('target_id') is-invalid @enderror" data-live-search="true" name="target_id" id="target_id">
                                <option value="">-- Pilih --</option>
                                @if(old('target_id'))
                                    <option value="{{ old('target_id') }}" selected>{{ old('target_name') }}</option>
                                @endif
                            </select>
                            @error('target_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                            <label for="from_surat">Surat Awal</label>
                            <select class="form-control selectpicker @error('from_surat') is-invalid @enderror" data-live-search="true" name="from_surat" id="from_surat">
                                <option value="">-- Pilih --</option>
                                @foreach ($surat as $sur)
                                    @if(old('from_surat') == $sur->id)
                                        <option value="{{ $sur->id }}" selected>{{ $sur->name }}</option>
                                    @else
                                        <option value="{{ $sur->id }}">{{ $sur->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('from_surat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                            <label for="from_ayat">Ayat Awal</label>
                            <select class="form-control selectpicker @error('from_ayat') is-invalid @enderror" data-live-search="true" name="from_ayat" id="from_ayat">
                                <option value="">-- Pilih --</option>
                                @if(old('from_ayat'))
                                    <option value="{{ old('from_ayat') }}" selected>{{ old('from_ayat') }}</option>
                                @endif
                            </select>
                            @error('from_ayat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                            <label for="to_surat">Surat Akhir</label>
                            <select class="form-control selectpicker @error('to_surat') is-invalid @enderror" data-live-search="true" name="to_surat" id="to_surat">
                                <option value="">-- Pilih --</option>
                                @foreach ($surat as $sur)
                                    @if(old('to_surat') == $sur->id)
                                        <option value="{{ $sur->id }}" selected>{{ $sur->name }}</option>
                                    @else
                                        <option value="{{ $sur->id }}">{{ $sur->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('to_surat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                            <label for="to_ayat">Ayat Akhir</label>
                            <select class="form-control selectpicker @error('to_ayat') is-invalid @enderror" data-live-search="true" name="to_ayat" id="to_ayat">
                                <option value="">-- Pilih --</option>
                                @if(old('to_ayat'))
                                    <option value="{{ old('to_ayat') }}" selected>{{ old('to_ayat') }}</option>
                                @endif
                            </select>
                            @error('to_ayat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        {{-- <div class="col-lg-4 col-sm-12 col-md-4 mb-4">
                            <label for="makhroj">Makhroj</label>
                            <input type="number" class="form-control @error('makhroj') is-invalid @enderror" id="makhroj" name="makhroj" value="{{ old('makhroj') }}">
                            @error('makhroj')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4 mb-4">
                            <label for="tajwid">Tajwid</label>
                            <input type="number" class="form-control @error('tajwid') is-invalid @enderror" id="tajwid" name="tajwid" value="{{ old('tajwid') }}">
                            @error('tajwid')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-4 mb-4">
                            <label for="kelancaran">Kelancaran</label>
                            <input type="number" class="form-control @error('kelancaran') is-invalid @enderror" id="kelancaran" name="kelancaran" value="{{ old('kelancaran') }}">
                            @error('kelancaran')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div> --}}
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="target_name" id="target_name" value="{{ old('target_name') }}">
                        <input type="hidden" name="from_order" id="from_order" value="{{ old('from_order') }}">
                        <input type="hidden" name="to_order" id="to_order" value="{{ old('to_order') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            $(function(){
                $('#siswa_id').on('change', function(){
                    let id = $('#siswa_id').val();
                    $.ajax({
                        type : 'GET',
                        url : "{{ url('/pencatatan-harian/getDataTarget') }}",
                        data :  {id:id},
                        cache : false,
                        success: function(data){
                            $('#target_id').selectpicker('destroy');
                            $('#target_id').empty();
                            $('#target_name').val(null);
                            if (data.length == 0 || data == null) {
                                $('#target_id').append('<option value="">-- Pilih --</option>');
                                $('#target_id').selectpicker();
                            } else {
                                var options = '<option value="">-- Pilih --</option>';
                                $.each(data, function(index, target) {
                                    options += '<option value="' + target.id + '">Juz ' + target.juz + ' - Tahun ' + target.tahun + '</option>';
                                });
                                $('#target_id').html(options);
                                $('#target_id').selectpicker();
                            }
                        },
                        error: function(data){
                            console.log('error:' ,data);
                        }
                    })
                })

                $('#from_surat').on('change', function(){
                    let id = $('#from_surat').val();
                    let to_order = $('#to_order').val();
                    $.ajax({
                        type : 'GET',
                        url : "{{ url('/pencatatan-harian/getDataSurat') }}",
                        data :  {id:id},
                        cache : false,
                        success: function(data){
                            $('#from_order').val(data.order);
                            if (data.order > to_order && to_order !== '') {
                                $('#from_surat').selectpicker('destroy');
                                $('#from_surat').val(null);
                                $('#from_surat').selectpicker();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Urutan Surat Awal Tidak Boleh Lebih Kecil Dari Surat Akhir',
                                });
                                setTimeout(function() {
                                    Swal.close();
                                }, 2000);
                            } else {
                                $('#from_ayat').selectpicker('destroy');
                                $('#from_ayat').empty();
                                if (data.length == 0 || data == null) {
                                    $('#from_ayat').append('<option value="">-- Pilih --</option>');
                                    $('#from_ayat').selectpicker();
                                } else {
                                    var options = '<option value="">-- Pilih --</option>';
                                    for (let i = data.first_ayat; i <= data.last_ayat; i++) {
                                        options += '<option value="' + i + '">' + i+ '</option>';
                                    };
                                    $('#from_ayat').html(options);
                                    $('#from_ayat').selectpicker();
                                }
                            }
                        },
                        error: function(data){
                            console.log('error:' ,data);
                        }
                    })
                })

                $('#to_surat').on('change', function(){
                    let id = $('#to_surat').val();
                    let from_order = $('#from_order').val();
                    $.ajax({
                        type : 'GET',
                        url : "{{ url('/pencatatan-harian/getDataSurat') }}",
                        data :  {id:id},
                        cache : false,
                        success: function(data){
                            $('#to_order').val(data.order);
                            if (from_order > data.order && from_order !== '') {
                                $('#to_surat').selectpicker('destroy');
                                $('#to_surat').val(null);
                                $('#to_surat').selectpicker();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Urutan Surat Awal Tidak Boleh Lebih Kecil Dari Surat Akhir',
                                });
                                setTimeout(function() {
                                    Swal.close();
                                }, 2000);
                            } else {
                                $('#to_ayat').selectpicker('destroy');
                                $('#to_ayat').empty();
                                if (data.length == 0 || data == null) {
                                    $('#to_ayat').append('<option value="">-- Pilih --</option>');
                                    $('#to_ayat').selectpicker();
                                } else {
                                    var options = '<option value="">-- Pilih --</option>';
                                    for (let i = data.first_ayat; i <= data.last_ayat; i++) {
                                        options += '<option value="' + i + '">' + i+ '</option>';
                                    };
                                    $('#to_ayat').html(options);
                                    $('#to_ayat').selectpicker();
                                }
                            }
                        },
                        error: function(data){
                            console.log('error:' ,data);
                        }
                    })
                })

                $('#target_id').on('change', function(){
                    let id = $('#target_id').val();
                    $.ajax({
                        type : 'GET',
                        url : "{{ url('/pencatatan-harian/getTargetName') }}",
                        data :  {id:id},
                        cache : false,
                        success: function(data){
                            $('#target_name').val("Juz " + data.juz + " - Tahun " + data.tahun);
                        },
                        error: function(data){
                            console.log('error:' ,data);
                        }
                    })
                })
            })
        </script>
    @endpush
@endsection
