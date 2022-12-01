@extends('layouts.app')
@section('content')
<style>
    *{ 
        font-family: system-ui;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="top: 50%;">
                <div class="auth-logo-box text-center mt-5">
                    <a class="logo logo-admin"><img src="img/photos/terafort.jpeg" height="70" alt="logo" class="auth-logo"></a>
                </div><br><br>
                <div class="card-body">
                    <form action="{{ route('Signupp') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Usermane Or Email</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email / Username" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="badge displayBadges py-2 mt-2 text-light" style="background: #cd3f3f; display: block; font-size: 13px !important;">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="badge displayBadges py-2 mt-2 text-light" style="background: #cd3f3f; display: block; font-size: 13px !important;">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary px-5" style="background: linear-gradient(14deg, #fc5c04 0%, #f96c07);">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
