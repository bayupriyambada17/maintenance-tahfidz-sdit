@extends('layouts.login') @section('auth')
<div class="login-logo">
    <img src="{{ url('assets/img/sdit.png') }}" style="width: 150px" />
    <br />
</div>

<div class="card">
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session("success") }}
            <button
                type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif @if(session()->has('loginError'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session("loginError") }}
            <button
                type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card-body login-card-body">
        <p class="login-box-msg"><i class="fa fa-solid fa-key"></i> Sign In</p>

        <form action="{{ url('/login-proses') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Username"
                    name="username"
                />
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input
                    type="password"
                    class="form-control"
                    placeholder="Password"
                    name="password"
                />
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember" />
                        <label for="remember"> Remember Me </label>
                    </div>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        Sign In
                    </button>
                </div>
            </div>
        </form>
        <br />
    </div>
</div>
@endsection
