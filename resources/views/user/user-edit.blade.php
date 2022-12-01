@extends((Auth::user()->role == 'Admin') ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    #loader1 
    {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/3dgifmaker.gif") 50% 50% no-repeat black;  
    }
    .dropify-wrapper{
        height: 100%;
        margin-bottom: 2%;
    }
    .yourclass::-webkit-input-placeholder
    {
        color: #6c757d;
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-2">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('user-manage')}}">Manage User</a></li>
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit User</h4>
            </div>
        </div>
    </div>
    <div class="row mt-3 mb-5">
        <div class="col-lg-7 col-md-8 col-sm-12 mb-5" style="margin: 0 auto;">
            <div class="card">
                <div class="card-body p-5">
                    <form action="{{url('edit-user')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-12 col-md-12 py-0">
                                <div class="form-group row py-0">
                                    <div class="col-md-12 col-md-12 col-md-12 py-0">                                        
                                        <label><b style="color: #6c757d">Profile Photo</b></label>
                                        @if(isset($userImage) && !empty($userImage)) 
                                        <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="{{ asset('uploads/appsetting/' . $userImage) }}"/>
                                        @else
                                        <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="img/photos/upload.jpg"/>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row py-0 mt-5">
                                    <div class="col-sm-6 col-sm-6 col-sm-6 py-1">
                                        <label><b style="color: #6c757d;">Name</b></label>
                                        <input id="name" name="name" type="text" class="form-control yourclass" style="border: 1px solid #d9d8d8;" placeholder="Name" required value="{{$user->name}}">
                                        <input hidden name="id" type="text" value="{{$user->id}}">
                                    </div>
                                    <div class="col-sm-6 col-sm-6 col-sm-6 py-1">
                                        <label><b style="color: #6c757d">First Name</b></label>
                                        <input id="firstname" name="firstname" type="text" class="form-control yourclass" style="border: 1px solid #d9d8d8;" placeholder="First Name" required value="{{$user->firstname}}">
                                    </div>
                                </div>
                                <div class="form-group row py-0">
                                    <div class="col-sm-6 col-sm-6 col-sm-6 py-1">
                                        <label><b style="color: #6c757d">Last Name</b></label>
                                        <input id="lastname" name="lastname" type="text" class="form-control yourclass" style="border: 1px solid #d9d8d8;" placeholder="Last Name" required value="{{$user->lastname}}">
                                    </div>
                                    <div class="col-sm-6 col-sm-6 col-sm-6 py-1">
                                        <label><b style="color: #6c757d">Username</b></label>
                                        <input id="username" name="username" type="text" class="form-control yourclass" style="border: 1px solid #d9d8d8;" placeholder="Username" required value="{{$user->username}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-sm-6 col-sm-6 py-1">
                                        <label><b style="color: #6c757d;">Email</b></label>
                                        <input id="email" name="email" type="text" class="form-control yourclass" style="border: 1px solid #d9d8d8;" placeholder="Email" required value="{{$user->email}}">
                                    </div>
                                    <div class="col-sm-6 col-sm-6 col-sm-6 py-1">
                                        <label><b style="color: #6c757d">Department</b></label>
                                        <select style="border: 1px solid #d9d8d8;" id="department" name="department" class="form-control select.custom-select" required>
                                        @foreach($department as $data)
                                            <option <?php if($data['name'] == $user->department) echo 'selected="selected"'; ?> value="{{$data['name']}}">{{$data['name']}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-sm-6 col-sm-6 py-1">
                                        <label><b style="color: #6c757d">Designation</b></label>
                                        <select style="border: 1px solid #d9d8d8;" id="designation" name="designation" class="form-control select.custom-select" required>
                                        @foreach($designation as $data)
                                            <option <?php if($data['name'] == $user->designation) echo 'selected="selected"'; ?> value="{{$data['name']}}">{{$data['name']}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-sm-6 col-sm-6 py-1">
                                        <label><b style="color: #6c757d">Role</b></label>
                                        <select style="border: 1px solid #d9d8d8;" id="role" name="role" class="form-control select.custom-select" required> 
                                        @foreach($role as $data)
                                            <option <?php if($data['name'] == $user->role) echo 'selected="selected"'; ?> value="{{$data['name']}}">{{$data['name']}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <button type="submit" style="background: linear-gradient(14deg, #fc5c04 0%, #f96c07);" class="btn px-5 py-1 btn-lg btn-block text-white border-0">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script>
$(document).ready(function(){ 
	$("#loader1").fadeOut(1200);
});
</script>
@endsection