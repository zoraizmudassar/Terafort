@extends((Auth::user()->role == 'Admin') ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<?php
	$id = Auth::user()->id;
    $image = DB::table("users")->where("id", $id)->pluck('image');
    $image = str_replace('"', '', $image);
    $image = str_replace('[', '', $image);
    $image = str_replace(']', '', $image);
?>
<style>
    .file-upload .file-upload-select
    {
        display: block;
        color: black;
        cursor: pointer;
        text-align: left;
        background: #bdc2c7;
        overflow: hidden;
        position: relative;
        border-radius: 6px;
    }
    .file-upload .file-upload-select .file-select-button
    {
        background: #bdc2c7;
        padding: 10px;
        display: inline-block;
    }
    .file-upload .file-upload-select .file-select-name
    {
        display: inline-block;
        padding: 10px;
    }
    .file-upload .file-upload-select:hover .file-select-button
    {
        background: #324759;
        color: #ffffff;
        transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -webkit-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
    }
    .file-upload .file-upload-select input[type="file"]
    {
        display: none;
    }
    .displayBadge
    {
        display: none; 
        text-align :center;
    }
    .displayBadges
    {
        text-align :center;
    }
    .toggle
    {
        background: none;
        border: none;
        color: grey;
        font-weight: 400;
        position: absolute;
        right: 1.30em;
        top: 2.85em;
        z-index: 9;
    }
    .fa
    {
        font-size: 1.1rem;
    }
    #settings_detail .dropify-wrapper 
    {
        width: 100%;
        height: 205px;
        margin-bottom: 20px;
    }
    #loader1 
    {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/giphy (1).gif") 50% 50% no-repeat black; 
    }
    p
    {
        font-family: "Poppins", sans-serif;
    }
    /* #settings_detail .dropify-wrapper 
    {
        width: 100%;
        margin-bottom: 2%;
    } */
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-2">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Profile</li>
                    </ol>
                </div>
                <h4 class="page-title">Profile</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body bg-dark">
                    <div class="met-profile">
                        <div class="row">
                            <div class="col-lg-4 align-self-center mb-3 mb-lg-0 p-4">
                                <div class="met-profile-main">
                                    <div class="met-profile-main-pic">
                                        @if(isset($image) && !empty($image)) 
                                        <img src="{{ asset('uploads/appsetting/' . $image) }}" style="width: 100%;" alt="profile-user" class="rounded-circle" />
                                        @else
                                        <img src="img/avatars/avatar-2.jpg" style="width: 100%;" alt="profile-user" class="rounded-circle" />
                                        @endif
                                        <span class="fro-profile_main-pic-change">
                                            <i class="fas fa-camera"></i>
                                        </span>
                                    </div>
                                    <div class="met-profile_user-detail">
                                        <h5 class="met-user-name" style="letter-spacing: 0.6px;">{{$data->name}}</h5>
                                        <p class="mb-0 met-user-name-post text-white" style="letter-spacing: 0.6px; text-transform: capitalize;">{{$data->department}}</p>
                                        <p class="mb-0 met-user-name-post text-white" style="letter-spacing: 0.6px;">{{$data->designation}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills mb-0" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="general_detail_tab" data-toggle="pill" href="#general_detail">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings_detail_tab" data-toggle="pill" href="#settings_detail">Edit Profile</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-12 mb-5">
            <div class="tab-content detail-list" id="pills-tabContent">
                <div class="tab-pane fade show active" id="general_detail">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="activity">
                                        <div class="activity-info">
                                            <div class="icon-info-activity">
                                                <i class="mdi mdi mdi-google-street-view bg-soft-success"></i>
                                            </div>
                                            <div class="activity-info-text">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="m-0 w-75">Name</h6>
                                                </div>
                                                <p class="mb-0 met-user-name-post py-1">{{$data->name}}</p><br>
                                            </div>
                                        </div> 
                                        <div class="activity-info">
                                            <div class="icon-info-activity">
                                                <i class="mdi mdi-account-circle bg-soft-secondary"></i>
                                            </div>
                                            <div class="activity-info-text">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="m-0  w-75">User Name</h6>
                                                </div>
                                                <p class="mb-0 met-user-name-post py-1">{{$data->username}}</p><br> 
                                            </div>
                                        </div>                                                                                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="activity">
                                        <div class="activity-info">
                                            <div class="icon-info-activity">
                                                <i class="mdi mdi-email-mark-as-unread bg-soft-purple"></i>
                                            </div>
                                            <div class="activity-info-text">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="m-0  w-75">Email</h6>
                                                </div> 
                                                <p class="mb-0 met-user-name-post py-1">{{$data->email}}</p><br> 
                                            </div>
                                        </div>  
                                        <div class="activity-info">
                                            <div class="icon-info-activity">
                                                <i class="mdi mdi-briefcase-check bg-soft-pink"></i>
                                            </div>
                                            <div class="activity-info-text">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="m-0  w-75">Designation</h6>
                                                </div>
                                                <p class="mb-0 met-user-name-post py-1">{{$data->designation}}</p><br> 
                                            </div>
                                        </div>                                                                                                              
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="activity">
                                        <div class="activity-info">
                                            <div class="icon-info-activity">
                                                <i class="mdi mdi-checkbox-intermediate bg-soft-purple"></i>
                                            </div>
                                            <div class="activity-info-text">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="m-0  w-75">Department</h6>
                                                </div> 
                                                <p class="mb-0 met-user-name-post py-1">{{$data->department}}</p><br> 
                                            </div>
                                        </div>
                                        <div class="activity-info">
                                            <div class="icon-info-activity">
                                                <i class="mdi mdi-cellphone-android bg-soft-warning"></i>
                                            </div>
                                            <div class="activity-info-text">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="m-0 w-75">Phone No</h6>
                                                </div>
                                                <p class="mb-0 met-user-name-post py-1">{{$data->phone}}</p><br>
                                            </div>
                                        </div>                                                             
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="settings_detail">
                    <div class="row">
                        <div class="col-lg-12 col-xl-12 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{url('update-profile')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        <div class="form-group row p-2">
                                            <div class="col-xl-6 mb-0">
                                                <div class="card mb-0" style="box-shadow: none;">
                                                    <div class="card-body mb-0">
                                                        <label><b style="color: #6c757d">Profile Photo</b></label>
                                                        @if(isset($image) && !empty($image)) 
                                                        <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="{{ asset('uploads/appsetting/' . $image) }}"/>
                                                        @else
                                                        <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="img/avatars/avatar-2.jpg" />
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 mb-0">
                                                <div class="form-group row mb-0">
                                                    <div class="col-xl-6">
                                                        <div class="card mb-0" style="box-shadow: none;">
                                                            <div class="card-body mb-0">
                                                                <label><b style="color: #6c757d">First Name</b></label>
                                                                <input type="text" value="{{$data->firstname}}" class="form-control py-2" style="border: 1px solid #bfbfbf;" id="firstname" name="firstname" placeholder="Phone No" required>
                                                                <label class="mt-3"><b style="color: #6c757d">Phone</b></label>
                                                                <input type="text" value="{{$data->phone}}" class="form-control py-2" style="border: 1px solid #bfbfbf;" id="phone" name="phone" placeholder="Phone No" required>
                                                                <label class="mt-3"><b style="color: #6c757d">Email</b></label>
                                                                <input type="email" value="{{$data->email}}" class="form-control py-2" style="border: 1px solid #bfbfbf;" id="email" name="email" placeholder="User Name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="card mb-0" style="box-shadow: none;">
                                                            <div class="card-body">
                                                                <label><b style="color: #6c757d">Last Name</b></label>
                                                                <input type="text" value="{{$data->lastname}}" class="form-control py-2" style="border: 1px solid #bfbfbf;" id="lastname" name="lastname" placeholder="Phone No" required>
                                                                <label class="mt-3"><b style="color: #6c757d">Username</b></label>
                                                                <input type="text" value="{{$data->username}}" class="form-control py-2" style="border: 1px solid #bfbfbf;" id="username" name="username" placeholder="Phone No" required>
                                                                <label class="mt-3"><b style="color: #6c757d">Name</b></label>
                                                                <input type="text" value="{{$data->name}}" class="form-control py-2" style="border: 1px solid #bfbfbf;" id="name" name="name" placeholder="Name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row justify-content-center">
                                            <div class="col-lg-4 col-md-4 col-sm-12 mb-0">
                                                <div class="card mb-0" style="box-shadow: none;">
                                                    <div class="card-body py-0">
                                                        <button type="submit" style="background: linear-gradient(14deg, #fc5c04 0%, #f96c07);" class="btn px-5 py-1 btn-lg btn-block text-white">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){ 
	$("#loader1").fadeOut(1200);
});
</script>
@endsection