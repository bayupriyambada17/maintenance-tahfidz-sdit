@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card" style="border-radius: 20px">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if ($teacher->foto == null)
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ url('assets/img/foto_default.jpg') }}" alt="User profile picture">
                            @else
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ url('storage/' . $teacher->foto) }}" alt="User profile picture">
                            @endif
                        </div>

                        <h3 class="profile-username text-center">{{ $teacher->name }}</h3>

                        <p class="text-muted text-center">{{ $teacher->jabatan }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">{{ $teacher->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Username</b> <a class="float-right">{{ $teacher->username }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Telepon</b> <a class="float-right">{{ $teacher->telepon }}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('guru.update', $teacher->id) }}"
                            enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="form-row">
                                <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                                    <label for="name">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" autofocus value="{{ old('name', $teacher->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                                    <label for="foto" class="form-label">Foto user</label>
                                    <input class="form-control @error('foto') is-invalid @enderror" type="file"
                                        id="foto" name="foto">
                                    @error('foto')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <input type="hidden" name="foto_lama" value="{{ $teacher->foto }}">
                                <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $teacher->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                                    <label for="telepon">Nomor Telfon</label>
                                    <input type="number" class="form-control @error('telepon') is-invalid @enderror"
                                        id="telepon" name="telepon" value="{{ old('telepon', $teacher->telepon) }}">
                                    @error('telepon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-sm-12 col-md-6 mb-4">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username', $teacher->username) }}">
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <input type="hidden" name="password" value="{{ $teacher->password }}">
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
