@extends((Auth::user()->role == 'Admin') ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
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
        top: 0.85em;
        z-index: 9;
    }
    .fa
    {
        font-size: 1.1rem;
    }
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
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
                <h4 class="page-title">Change Password</h4>
            </div>
        </div>
    </div>
    <div class="row mt-2 mb-5">
        <div class="col-lg-6 col-md-8 col-sm-12 mb-5" style="margin: 0 auto;"> 
            <div class="card">
                <div class="card-body">
                <form action="{{url('change-password')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="p-4">
                            <div class="form-group row py-4">
                                <div class="col-12 mb-sm-0">
                                    <input type="password" class="form-control form-control-user py-2 yourclass" id="CurrentPassword" name="CurrentPassword" placeholder="Current Password" pattern="[a-zA-Z0-9\s]{3,20}" title="Must contain at least one number, one uppercase letter and 8 or more characters" required>
                                    <button type="button" id="btnToggleCurrent" class="toggle"><i id="eyeIconCurrent" class="fa fa-eye"></i></button>
                                    <span id="StrengthDisp2" class="badge displayBadges text-light py-2 mt-2 w-100"></span>
                                </div>
                            </div>
                            <div class="form-group row py-4">
                                <div class="col-12 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user py-2 yourclass" id="Password" name="Password" placeholder="New Password" pattern="[a-zA-Z0-9\s]{3,20}" title="Must contain at least one number, one uppercase letter and 8 or more characters" required>
                                    <button type="button" id="btnToggle" class="toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                                    <small id="emailHelp" class="form-text text-muted px-2" style="font-size: 11px;">Must contain at least one number one uppercase letter and 8 or more characters.</small>
                                    <span id="StrengthDisp" class="badge displayBadge text-light py-2 mt-2">Your password isn’t strong enough, try making it longer</span>
                                    <span id="StrengthDisp3" class="badge displayBadge text-light py-2 mt-2"></span>
                                </div>
                            </div>	
                            <div class="form-group row py-4">
                                <div class="col-12">
                                    <input type="password" class="form-control form-control-user py-2 yourclass" id="ConfirmPassword" name="ConfirmPassword" placeholder="Confirm Password" required>
                                    <button type="button" id="btnToggleConfirm" class="toggle"><i id="eyeIconConfirm" class="fa fa-eye"></i></button>    
                                    <small id="emailHelp" class="form-text px-2" style="font-size: 11px; color: transparent;">Must contain at least one number one uppercase letter and 8 or more characters.</small>
                                    <span id="StrengthDisp1" class="badge displayBadges text-light py-2 mt-2 w-100"></span>
                                </div>
                            </div>	
                            <div class="form-group row py-3 mb-0 mt-5">
                                <div class="col-sm-12 mb-1 mb-sm-0">
                                    <button type="submit" class="btn w-100 py-1 text-white" style="border: none; font-size: 15px; background: linear-gradient(14deg, #fc5c04 0%, #f96c07);">Change Password</button>
                                </div>
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
    let timeout;
    let password = document.getElementById('Password')
    let strengthBadge = document.getElementById('StrengthDisp')
    let strengthBadge1 = document.getElementById('StrengthDisp1')
    let strengthBadge2 = document.getElementById('StrengthDisp2')
    let strengthBadge3 = document.getElementById('StrengthDisp3')

    let mediumPassword = new RegExp('(?=.*[A-Z])(?=.*[0-9])(?=.{8,})') //one uppercase, at least one digit, at least 8 characters long
    let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})') //at least one uppercase, at least one uppercase, at least one digit, at least 8 characters long
    
    function StrengthChecker(PasswordParameter){
        if(strongPassword.test(PasswordParameter)) {
            strengthBadge.style.backgroundColor = '#52a752'
            strengthBadge.textContent = 'Strong'
        } else if(mediumPassword.test(PasswordParameter)){
            strengthBadge.style.backgroundColor = '#52a752'
            strengthBadge.textContent = 'Strong'
        } else{
            strengthBadge.style.backgroundColor = '#cd3f3f'
            strengthBadge.textContent = 'Your password isn’t strong enough, try making it longer'
        }
    }

    @if(Session::has('error'))
        strengthBadge2.style.backgroundColor = '#cd3f3f'
        strengthBadge2.textContent = 'Your current password does not matches with the password.'
    @endif

    @if(Session::has('error1'))
        strengthBadge3.style.display = 'block'
        strengthBadge3.style.backgroundColor = '#cd3f3f'
        strengthBadge3.textContent = 'New Password cannot be same as your current password.'
    @endif

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

	$('#ConfirmPassword').on('keyup', function() {
  	if($('#Password').val() == $('#ConfirmPassword').val()){
		strengthBadge1.style.backgroundColor = '#52a752'
            strengthBadge1.textContent = 'Password Matched'
  	} 
	else{
		strengthBadge1.style.backgroundColor = '#cd3f3f'
            strengthBadge1.textContent = 'Password No Matching'
	}
});
</script>
<script>
    icon = document.getElementById('eyeIcon');
    toggle = document.getElementById('btnToggle');
    passwordInput = document.getElementById('Password');
    ConfirmInput = document.getElementById('ConfirmPassword');
    CurrentInput = document.getElementById('CurrentPassword');
    Confirmtoggle = document.getElementById('btnToggleConfirm');
    Confirmicon = document.getElementById('eyeIconConfirm');
    Currenticon = document.getElementById('eyeIconCurrent');
    Currenttoggle = document.getElementById('btnToggleCurrent');

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

    function toggleCurrentassword(){
        if(CurrentInput.type === 'password'){
            CurrentInput.type = 'text';
            Currenticon.classList.add("fa-eye-slash");
        }
        else{
            CurrentInput.type = 'password';
            Currenticon.classList.remove("fa-eye-slash");
        }
    }
    toggle.addEventListener('click', togglePassword, false);
    Confirmtoggle.addEventListener('click', toggleConfirmPassword, false);
    Currenttoggle.addEventListener('click', toggleCurrentassword, false);
</script>
@endsection