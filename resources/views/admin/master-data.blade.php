@extends((Auth::user()->role == 'Admin') ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    .displayBadge{
        display: none; 
        text-align :center;
    }
    .displayBadges{
        text-align :center;
    }
    .toggle{
        background: none;
        border: none;
        color: grey;
        font-weight: 400;
        position: absolute;
        right: 1.30em;
        top: 2.85em;
        z-index: 9;
    }
    .fa{
        font-size: 1.1rem;
    }
    #loader1 {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/giphy (1).gif") 50% 50% no-repeat black;   
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
                        <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Create User</li>
                    </ol>
                </div>
                <h4 class="page-title">Master Settings</h4>
            </div>
        </div>
    </div>
    <div class="row mt-2 mb-3">
        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Change User Password</h3>
                    </div>
                    <form action="{{url('change-password-admin')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-12 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">First Name</b></label>
                                <select id="name" name="name" class="form-control select.custom-select" required>
                                    <option selected disabled>Select User</option>                                            
                                    @foreach($user as $name)
                                        <option value="{{ $name->id }}">{{ $name->firstname }} {{ $name->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Password</b></label>
                                <input type="password" class="form-control py-2 yourclass" id="password" name="password" placeholder="Password" pattern="[a-zA-Z0-9\s]{3,20}" title="Must contain at least one number, one uppercase letter and 8 or more characters" required>
                                <button type="button" id="btnToggle" class="toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                                <small id="emailHelp" class="form-text text-muted px-2">At least one number one uppercase letter, 8 or more characters.</small>
                                <span id="StrengthDisp" class="badge displayBadge text-light py-2 mt-2">Your password isn't strong enough, try making it longer</span>                              
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Confirm Password</b></label>
                                <input type="password" class="form-control py-2 yourclass" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                                <button type="button" id="btnToggleConfirm" class="toggle"><i id="eyeIconConfirm" class="fa fa-eye"></i></button>    
                                <span id="StrengthDisp1" class="badge displayBadges text-light py-2 mt-2 w-100"></span>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                            <small id="emailHelp" class="form-text text-muted px-2">&nbsp;</small>
                                <button type="submit" style="border: none; font-size: 15px; background: #fc5c04;" class="btn px-5 py-1 btn-lg btn-block text-white border-0">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Change User Status</h3>
                    </div>
                    <form action="{{url('change-status-admin')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Select User</b></label>
                                <select id="id" name="id" class="form-control select.custom-select" required>
                                    <option selected disabled>Select User</option>  
                                    @foreach($user as $name)
                                        <option value="{{ $name->id }}">{{ $name->firstname }} {{ $name->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-1">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Select Status</b></label>
                                <select id="status" name="status" class="form-control select.custom-select" required>
                                    <option selected disabled>Select Status</option>   
                                    <option value="1">Active</option>
                                    <option value="2">Deactive</option>
                                    <option value="3">Terminate</option>
                                    <option value="4">Delete</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: #fc5c04;" class="btn px-5 py-1 btn-lg btn-block text-white border-0">Change Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Add Department</h3>
                    </div>
                    <form action="{{url('add-department')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Department</b></label>
                                <input type="text" class="form-control py-2 yourclass" id="department" name="department" placeholder="Department" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: #fc5c04;" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Department</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $j=1; ?>
                                    @foreach($department as $data)
                                    <tr class="text-center">
                                        <td>{{$j++}}</td>
                                        <td>{{$data['name']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCentershape" style="margin-top: 5px; border: none; font-size: 15px; background: #fc5c04;" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2 mb-5">
        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Add Designation</h3>
                    </div>
                    <form action="{{url('add-designation')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Designation</b></label>
                                <input type="text" class="form-control py-2 yourclass" id="designation" name="designation" placeholder="Designation" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: #fc5c04;" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Designation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $k=1; ?>
                                    @foreach($designation as $data)
                                    <tr class="text-center">
                                        <td>{{$k++}}</td>
                                        <td>{{$data['name']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCentershape1" style="margin-top: 5px; border: none; font-size: 15px; background: #fc5c04;" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCentershape" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Department</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($department as $data)
                        <tr class="py-0">
                            <td class="text-center py-0">{{$i++}}</td>
                            <td><input readonly type="text" class="form-control py-0 yourclass text-center" style="border: 1px solid transparent; background: transparent;" id="dep" name="dep" value="{{$data['name']}}"></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$data['id']}}" class="mr-1 shapeEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$data['id']}}" class="mr-1 shapeDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Save&nbsp;&nbsp;" data-id="{{$data['id']}}" class="mr-1 shapeSave" style="cursor: pointer; display: none;" id="shapeSave"><i class="fas fa-check text-success font-13"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCentershape1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Designation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Designation</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($designation as $data)
                        <tr class="py-0">
                            <td class="text-center py-0">{{$i++}}</td>
                            <td><input readonly type="text" class="form-control py-0 yourclass text-center" style="border: 1px solid transparent; background: transparent;" id="des" name="des" value="{{$data['name']}}"></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$data['id']}}" class="mr-1 desEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$data['id']}}" class="mr-1 desDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Save&nbsp;&nbsp;" data-id="{{$data['id']}}" class="mr-1 desSave" style="cursor: pointer; display: none;" id="desSave"><i class="fas fa-check text-success font-13"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script>     
    $(document).on('click', '.shapeEdit', function(){
        var id = $(this).attr("data-id"); 
        $("#dep").css("border","1px solid #bfbfbf");
        $("#dep").css("background","white");
        $("#dep").removeAttr("readonly");
        $("#shapeSave").css("display","unset");
    });
    $(document).on('click', '.shapeSave', function(){
        var id = $(this).attr("data-id"); 
        var value = $("#dep").val();
        console.log(value,id);
        $.ajax({     
            type: 'GET',
            url: 'update-department/'+value+'/'+id,
            dataType: "json",
            success: function(data){
                console.log(data);
                if(data.message == 'Department Updated'){
                    $("#exampleModalCentershape").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Department Updated',
                    });
                    location.reload();
                }
            }
        });
    });
    $(document).on('click', '.desEdit', function(){
        var id = $(this).attr("data-id"); 
        $("#des").css("border","1px solid #bfbfbf");
        $("#des").css("background","white");
        $("#des").removeAttr("readonly");
        $("#desSave").css("display","unset");
    });
    $(document).on('click', '.desSave', function(){
        var id = $(this).attr("data-id"); 
        var value = $("#des").val();
        console.log(value,id);
        $.ajax({     
            type: 'GET',
            url: 'update-designation/'+value+'/'+id,
            dataType: "json",
            success: function(data){
                console.log(data);
                if(data.message == 'Designation Updated'){
                    $("#exampleModalCentershape").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Designation Updated',
                    });
                    location.reload();
                }
            }
        });
    });

    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
    });
    let timeout;
    let password = document.getElementById('password')
    let strengthBadge = document.getElementById('StrengthDisp')
    let strengthBadge1 = document.getElementById('StrengthDisp1')
    let mediumPassword = new RegExp('(?=.*[A-Z])(?=.*[0-9])(?=.{8,})') //one uppercase, at least one digit, at least 8 characters long
    let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})') //at least one uppercase, at least one uppercase, at least one digit, at least 8 characters long
    
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
            strengthBadge.textContent = 'Your password isn’t strong enough, try making it longer'
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

	$('#confirm-password').on('keyup', function() {
  	if($('#password').val() == $('#confirm-password').val()){
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