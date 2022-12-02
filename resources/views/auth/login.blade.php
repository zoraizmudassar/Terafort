@extends('layouts.app')
@section('content')
<style>
    *{ 
        font-family: system-ui;
    }
    label{
        font-weight: 400;
        color: #484d6c;
        font-size: 13px;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="top: 40%;">
                <div class="auth-logo-box text-center mt-5">
                    <a class="logo logo-admin"><img src="img/photos/terafort.jpeg" height="70" alt="logo" class="auth-logo"></a>
                </div><br>
                <div class="card-body mb-5">
                    <form action="{{ route('Signupp') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                            <label for="example-input1-group1" style="letter-spacing: 0.3px;"><b style="font-weight: 500;">Login with Email or Username</b></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-user"></i></span>
                                    </div>
                                    <input id="email" name="email" value="{{ old('email') }}" type="text" name="example-input1-group1" class="form-control" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                            <label for="example-input1-group1" style="letter-spacing: 0.3px;"><b style="font-weight: 500;">Password</b></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                                </div>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <div class="row mb-3" hidden>
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">

                            <button type="submit" style="background: linear-gradient(14deg, #fc5c04 0%, #f96c07);" class="btn px-5 py-1 btn-lg btn-block text-white border-0">Login</button>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
