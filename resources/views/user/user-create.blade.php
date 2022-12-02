@extends((Auth::user()->role == 'Admin') ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    .file-upload .file-upload-select{
        display: block;
        color: black;
        cursor: pointer;
        text-align: left;
        background: #bdc2c7;
        overflow: hidden;
        position: relative;
        border-radius: 6px;
    }
    .file-upload .file-upload-select .file-select-button{
        background: #bdc2c7;
        padding: 10px;
        display: inline-block;
    }
    .file-upload .file-upload-select .file-select-name{
        display: inline-block;
        padding: 10px;
    }
    .file-upload .file-upload-select:hover .file-select-button{
        background: #324759;
        color: #ffffff;
        transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -webkit-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
    }
    .file-upload .file-upload-select input[type="file"]{
        display: none;
    }
    .displayBadge{
        display: none; 
        text-align :center;
    }
    .displayBadges{
        text-align :center;
    }
    .displayBadgess{
        text-align :center;
    }
    .toggle{
        background: none;
        border: none;
        color: grey;
        font-weight: 400;
        position: absolute;
        right: 1.30em;
        top: 3.90em;
        z-index: 9;
    }
    .fa{
        font-size: 1.1rem;
    }
    .select2-container--default .select2-selection--single{
        background-color: #fff;
        border: 1px solid #aaa;
        border-radius: 4px;
        height: 36px;
    }
    #loader1{  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/giphy (1).gif") 50% 50% no-repeat black;  
    }
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
    }
    .dropify-wrapper{
        height: 100%;
        margin-bottom: 2%;
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-2">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Create User</li>
                    </ol>
                </div>
                <h4 class="page-title">Create User</h4>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-9 col-md-12 col-sm-12 mb-5" style="margin: 0 auto;">
            <div class="card">
                <div class="card-body p-5">
                    <form action="{{url('user-create')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row py-0">
                        <div class="col-md-12">                                        
                            <label><b style="color: #6c757d">Profile Photo</b></label>
                            <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="img/photos/upload.jpg"/>
                        </div>
                    </div>
                    <div class="form-group row mt-5 mb-0">
                        <div class="col-lg-12 mb-5">                           
                        <div class="form-group row py-1 mb-0">
                            <div class="col-sm-4 py-1">
                                <label class="mt-3"><b style="color: #6c757d">Name</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #d9d8d8; text-transform: capitalize;" id="name" name="name" placeholder="Name">
                                @if($errors->has('name'))
                                    <span class="badge displayBadges py-2 mt-2 text-light" style="background: #cd3f3f; display: block; font-size: 13px !important;">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="col-sm-4 py-1">
                                <label class="mt-3"><b style="color: #6c757d">First Name</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #d9d8d8; text-transform: capitalize;" id="firstname" name="firstname" placeholder="First Name" required>
                                @if($errors->has('firstname'))
                                    <span class="badge displayBadges py-2 mt-2 text-light" style="background: #cd3f3f; display: block; font-size: 13px !important;">{{ $errors->first('firstname') }}</span>
                                @endif
                            </div>
                            <div class="col-sm-4 py-1">
                                <label class="mt-3"><b style="color: #6c757d">Last Name</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #d9d8d8; text-transform: capitalize;" id="lastname" name="lastname" placeholder="Last Name" required>
                                @if($errors->has('lastname'))
                                    <span class="badge displayBadges py-2 mt-2 text-light" style="background: #cd3f3f; display: block; font-size: 13px !important;">{{ $errors->first('lastname') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row py-1 mb-0">
                            <div class="col-sm-4 py-1">
                                <label class="mt-3"><b style="color: #6c757d">Username</b></label>
                                <input type="text" class="form-control py-2 formfield w0 yourclass" style="border: 1px solid #d9d8d8;" id="username" name="username" placeholder="Username" required pattern="[a-zA-Z0-9\.?s]{3,20}">
                                @if($errors->has('lastname'))
                                    <span class="badge displayBadges py-2 mt-2 text-light" style="background: #cd3f3f; display: block; font-size: 13px !important;">{{ $errors->first('lastname') }}</span>
                                @endif
                                <span id="StrengthDisp2" style="font-size: 13px !important;" class="badge displayBadgess text-light py-2 mt-2"></span>                                                          
                            </div>
                            <div class="col-sm-4 py-1">
                                <label class="mt-3"><b style="color: #6c757d">Email</b></label>
							    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #d9d8d8;" id="email" name="email" placeholder="Email Address" required>
                                @if($errors->has('email'))
                                    <span class="badge displayBadges py-2 mt-2 text-light" style="background: #cd3f3f; display: block; font-size: 13px !important;">{{ $errors->first('email') }}</span>
                                @endif
                                <span id="StrengthDisp4" style="font-size: 13px !important;" class="badge displayBadgess text-light py-2 mt-2"></span>     
                            </div>
                            <div class="col-sm-4 py-1">
                                <label class="mt-3"><b style="color: #6c757d">Phone No</b></label>
							    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #d9d8d8;" id="phone" name="phone" placeholder="Phone No" required>
                                @if($errors->has('phone'))
                                    <span class="badge displayBadges py-2 mt-2 text-light" style="background: #cd3f3f; display: block; font-size: 13px !important;">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row py-0">
                            <div class="col-sm-4 py-0">
                                <label class="mt-3"><b style="color: #6c757d">User Role</b></label>
                                <select style="border: 1px solid #d9d8d8;" id="role" name="role" class="form-control select.custom-select" required>
                                @foreach($role as $data)
                                    <option value="{{$data['name']}}">{{$data['name']}}</option>
                                @endforeach
                                </select>
                                @if($errors->has('role'))
                                    <span class="badge displayBadges py-2 mt-2 text-light" style="background: #cd3f3f; display: block; font-size: 13px !important;">{{ $errors->first('userrole') }}</span>
                                @endif
                            </div>
                            <div class="col-sm-4 py-0">
                                <label class="mt-3"><b style="color: #6c757d">Password</b></label>
                                <input type="password" class="form-control py-2 yourclass" style="border: 1px solid #d9d8d8;" id="password" name="password" placeholder="Password" pattern="[a-zA-Z0-9\s]{3,20}" title="Must contain at least one number, one uppercase letter and 8 or more characters" required>
                                <button type="button" id="btnToggle" class="toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                                <small id="emailHelp" class="form-text text-muted px-2">Must Contain at least one number one uppercase letter, 8 or more characters.</small>
                                <span id="StrengthDisp" style="font-size: 13px !important;" class="badge displayBadge text-light py-2 mt-2">Your password isn’t strong enough</span>
                                @if($errors->has('password'))
                                    <span class="badge displayBadges py-2 mt-2 text-light" style="background: #cd3f3f; display: block; font-size: 13px !important;">{{ $errors->first('password') }}</span>
                                @endif                              
                            </div>
                            <div class="col-sm-4 py-0">
                                <label class="mt-3"><b style="color: #6c757d">Confirm Password</b></label>
                                <input type="password" class="form-control py-2 yourclass" style="border: 1px solid #d9d8d8;" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                                <button type="button" id="btnToggleConfirm" class="toggle"><i id="eyeIconConfirm" class="fa fa-eye"></i></button>    
                                <small id="emailHelp" class="form-text text-white px-2">Must Contain at least one number one uppercase letter, 8 or more characters.</small>
                                <span id="StrengthDisp1" style="font-size: 13px !important;" class="badge displayBadges text-light py-2 mt-2 w-100"></span>
                            </div>
                        </div>
                        <div class="form-group row py-0">
                            <div class="col-sm-4">
                                <label class="mt-3"><b style="color: #6c757d">Department</b></label>
                                <select style="border: 1px solid #d9d8d8;" id="department" name="department" class="form-control select.custom-select" required>
                                @foreach($department as $data)
                                    <option value="{{$data['name']}}">{{$data['name']}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="mt-3"><b style="color: #6c757d">Designation</b></label>
                                <select style="border: 1px solid #d9d8d8;" id="designation" name="designation" class="form-control select.custom-select" required>
                                @foreach($designation as $data)
                                    <option value="{{$data['name']}}">{{$data['name']}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="mt-3"><b style="color: #6c757d">Status</b></label>
                                <select style="border: 1px solid #d9d8d8;" id="status" name="status" class="form-control select.custom-select" required>
                                    <option value="1">Active</option>
                                    <option value="2">Deactive</option>
                                    <option value="3">Terminate</option>
                                    <option value="4">Delete</option>
                                </select>
                            </div>
                        </div> 
                        </div>
                    </div>
                        <div class="form-group row">
                            <div class="col-sm-4 mb-1 mb-sm-0">
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" style="background: linear-gradient(14deg, #fc5c04 0%, #f96c07);" class="btn px-5 py-1 btn-lg btn-block text-white border-0">Create</button>
                            </div>
                            <div class="col-sm-4">
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
    let fileInput = document.getElementById("file-upload-input");
    let fileSelect = document.getElementsByClassName("file-upload-select")[0];
    fileSelect.onclick = function(){
        fileInput.click();
    }
    fileInput.onchange = function(){
        let filename = fileInput.files[0].name;
        let selectName = document.getElementsByClassName("file-select-name")[0];
        selectName.innerText = filename;
    }
    $('#username').on('keypress', function(e){
        if(e.which == 32){
            return false;
        }
    });
</script>
<script>     
    let timeout;
    let password = document.getElementById('password')
    let confirmpassword = document.getElementById('confirm-password')
    let username = document.getElementById('username')
    let email = document.getElementById('email')
    let strengthBadge = document.getElementById('StrengthDisp')
    let strengthBadge1 = document.getElementById('StrengthDisp1')
    let strengthBadge2 = document.getElementById('StrengthDisp2')
    let strengthBadge3 = document.getElementById('StrengthDisp3')
    let strengthBadge4 = document.getElementById('StrengthDisp4')
    let mediumPassword = new RegExp('(?=.*[A-Z])(?=.*[0-9])(?=.{8,})')
    let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})')
    
    function StrengthChecker(PasswordParameter){
        if(strongPassword.test(PasswordParameter)){
            strengthBadge.style.backgroundColor = '#52a752'
            strengthBadge.textContent = 'Strong'
        }
        else if(mediumPassword.test(PasswordParameter)){
            strengthBadge.style.backgroundColor = '#52a752'
            strengthBadge.textContent = 'Strong'
        }
        else{
            strengthBadge.style.backgroundColor = '#cd3f3f'
            strengthBadge.textContent = 'Your password isn’t strong enough'
        }
    }

    password.addEventListener("input", () => {
        strengthBadge.style.display= 'block'
        clearTimeout(timeout);
        timeout = setTimeout(() => StrengthChecker(password.value), 500);
        if(password.value.length !== 0){
            strengthBadge.style.display != 'block'
        } 
        else{
            strengthBadge.style.display = 'none'
        }
    });

    username.addEventListener("input", () => {
        Username(username.value);
        function Username(username){
            $.ajax({
                    type: 'GET',
                    url: 'username/'+username,
                    dataType: "json",
                    success: function(data){
                        if(data){
                            if(data == 1){
                                strengthBadge2.style.display = 'block'
                                strengthBadge2.style.backgroundColor = '#cd3f3f'
                                strengthBadge2.textContent = 'Username Already taken'
                            }
                            else if(data == 2){
                                strengthBadge2.style.display = 'block'
                                strengthBadge2.style.backgroundColor = '#52a752'
                                strengthBadge2.textContent = 'Username Available'
                            }
                        }
                    }
                });
        }
    });

    email.addEventListener("input", () => {
        Email(email.value);
        function Email(email){
            $.ajax({
                    type: 'GET',
                    url: 'email/'+email,
                    dataType: "json",
                    success: function(data){
                        if(data){
                            if(data == 1){
                                strengthBadge4.style.display = 'block'
                                strengthBadge4.style.backgroundColor = '#cd3f3f'
                                strengthBadge4.textContent = 'Email Address Already taken'
                            }
                            else if(data == 2){
                                strengthBadge4.style.display = 'block'
                                strengthBadge4.style.backgroundColor = '#52a752'
                                strengthBadge4.textContent = 'Email Address Available'
                            }
                        }
                    }
                });
        }
    });

	confirmpassword.addEventListener("input", () => {
        if(password.value == confirmpassword.value){
            strengthBadge1.style.backgroundColor = '#52a752'
            strengthBadge.style.display != 'block'
            strengthBadge1.textContent = 'Password Matched'
        } 
        else{
            strengthBadge1.style.backgroundColor = '#cd3f3f'
            strengthBadge1.textContent = 'Password No Matching'
        }
    });
    icon = document.getElementById('eyeIcon');
    toggle = document.getElementById('btnToggle');
    passwordInput = document.getElementById('password');
    ConfirmInput = document.getElementById('confirm-password');
    Confirmtoggle = document.getElementById('btnToggleConfirm');
    Confirmicon = document.getElementById('eyeIconConfirm');
    function togglePassword(){
        if(passwordInput.type === 'password'){
            passwordInput.type = 'text';
            icon.classList.add("fa-eye-slash");
        }
        else{
            passwordInput.type = 'password';
            icon.classList.remove("fa-eye-slash");
        }
    }
    function toggleConfirmPassword(){
        if(ConfirmInput.type === 'password'){
            ConfirmInput.type = 'text';
            Confirmicon.classList.add("fa-eye-slash");
        }
        else{
            ConfirmInput.type = 'password';
            Confirmicon.classList.remove("fa-eye-slash");
        }
    }
    toggle.addEventListener('click', togglePassword, false);
    Confirmtoggle.addEventListener('click', toggleConfirmPassword, false);
</script>
@endsection