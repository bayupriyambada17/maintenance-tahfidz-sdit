@extends('layouts.login') @section('auth')
<div class="login-logo">
    <img src="{{ url('assets/img/sdit.png') }}" style="width: 150px" />
    <br />
</div>

@php
    $title = 'Page Not Found';
@endphp

<div class="card">
   
    <div class="card-body login-card-body">
        <h2 class="login-box-msg">Page Not Found !</h2>

        <center>
            <a  href="javascript:void(0);" onclick="goBack()" class="btn btn-default mt-1" style="border-radius: 8px"><i class="fas fa-arrow-left mr-1"></i> Back</a>
        </center>
        
    </div>
</div>
@endsection
