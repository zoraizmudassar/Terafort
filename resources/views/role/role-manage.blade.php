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
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-1">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a  href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Role</li>
                    </ol>
                </div>
                <h4 class="page-title">Manage Role</h4>
            </div>
        </div>
    </div>
    <div class="row mt-3">
		<div class="col-md-12 col-xl-12" style="margin: 0 auto;">
			<div class="card">
				<div class="card-body h-100">
					<div class="text-center mt-5">
						<h2 style="color: #6c757d">Manage Role</h2>
					</div>
                    <form action="{{url('roles-manage-ajax')}}" id="NewRole" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="px-5 mt-5">
						        <div class="form-group row py-2">
                                    <div class="col-sm-3 mb-1 mb-sm-0">
                                        <label for=""><b style="color: #6c757d"> Role Name</b></label>
                                        @if(isset($id))
                                            <input type="text" name="id" value="{{$id}}" id="id" hidden>
                                        @endif
                                            <select id="name" name="name" class="form-control select.custom-select" required>
                                        @foreach($data as $name)
                                            <option value="{{ $name->name }}">{{ $name->name }}</option>
                                        @endforeach
                                        </select>
                                        <button id="btnSupdate" type="submit" class="btn w-100 py-1 mb-0 text-white mt-4" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none; font-size: 15px; display: none;">Update Role</button>
                                    </div>
                                    <input hidden type="text" name="username" id="username">
                                    <div class="col-sm-9">
                                        <label for=""> <b style="color: #6c757d"> Permissions</b></label>
                                        <label for="" id="id" hidden></label>
                                        <input class="form-check-input name d-none" type="checkbox" value="objective-delete" id="delete" name="objective-delete" >
                                        <label for="" id="idd"></label>
                                        <div id="accordion">
                                            <div id="Hides">
                                                <div class="card">
                                                    <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne12">
                                                        Permissions
                                                    </div>
                                                </div>
                                            </div>    
                                            <div id="roles" style="display: none;">
                                                <div class="card">
                                                    <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne1" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                                                        Roles
                                                    </div>
                                                    <div id="collapseOne1" class="collapse" aria-labelledby="headingOne1" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                        <div class="card-body">
                                                            <label class="form-check form-check-inline">
                                                                <input class="form-check-input name Singlecheck1 checkbox-info" id="rolelist1" type="checkbox" name="Role[]">
                                                                <span id="rolelist" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline">
                                                                <input class="form-check-input name Singlecheck1 checkbox-info" id="rolecreate1" type="checkbox" name="Role[]">
                                                                <span id="rolecreate" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline">
                                                                <input class="form-check-input name Singlecheck1 checkbox-info" id="roleedit1" type="checkbox" name="Role[]">
                                                                <span id="roleedit" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline">
                                                                <input class="form-check-input name Singlecheck1 checkbox-dark" id="roledelete1" type="checkbox" name="Role[]">
                                                                <span id="roledelete" class="form-check-label"></span>
                                                            </label>                            
                                                            <label class="form-check form-check-inline" style="float: right;">
                                                                <input class="form-check-input checkbox-info" id="allCheck1" type="checkbox">
                                                                <span class="form-check-label">Mark All</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                            
                                            <div id="Users" style="display: none;">
                                                <div class="card">
                                                    <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne122" data-toggle="collapse" data-target="#collapseOne122" aria-expanded="true" aria-controls="collapseOne">
                                                        Users
                                                    </div>
                                                    <div id="collapseOne122" class="collapse" aria-labelledby="headingOne122" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                        <div class="card-body">
                                                            <label class="form-check form-check-inline">
                                                                <input class="form-check-input name Singlecheck22" id="userlist1" type="checkbox" name="User[]">
                                                                <span id="userlist" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline">
                                                                <input class="form-check-input name Singlecheck22" id="usercreate1" type="checkbox" name="User[]">
                                                                <span id="usercreate" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline">
                                                                <input class="form-check-input name Singlecheck22" id="useredit1" type="checkbox" name="User[]">
                                                                <span id="useredit" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline">
                                                                <input class="form-check-input name Singlecheck22" id="userdelete1" type="checkbox" name="User[]">
                                                                <span id="userdelete" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" style="float: right;">
                                                                <input class="form-check-input" id="allCheck22" type="checkbox">
                                                                <span class="form-check-label">Mark All</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="others" style="display: none;">
                                                <div class="card">
                                                    <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne12211a" data-toggle="collapse" data-target="#headingOne12211" aria-expanded="true" aria-controls="collapseOne">
                                                        Others
                                                    </div>
                                                    <div id="headingOne12211" class="collapse" aria-labelledby="headingOne12211a" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                        <div class="card-body">
                                                            <label class="form-check form-check-inline">
                                                                <input class="form-check-input name Singlecheck221a" id="employee1" type="checkbox" name="Others[]">
                                                                <span id="employee" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline">
                                                                <input class="form-check-input name Singlecheck221a" id="admin1" type="checkbox" name="Others[]">
                                                                <span id="admin" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline">
                                                                <input class="form-check-input name Singlecheck221a" id="s_admin1" type="checkbox" name="Others[]">
                                                                <span id="s_admin" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" style="float: right;">
                                                                <input class="form-check-input" id="allCheck221a" type="checkbox">
                                                                <span class="form-check-label">Mark All</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
<script src="assets/js/customjquery.min.js"></script>
<script>               
$(document).ready(function(){ 
    $("#loader1").fadeOut(1200);
});                                                                         
$('#name').on('change', function(){
    var name = $(this).val();
    $("#username").val(name);
    $.ajax({
    type: 'GET',
    url: 'ajax/'+name,
    dataType: "json",
    success: function (data){
        if(data){

            //Role
            if(data.role.length === 0){
                $("#rolelist").html("Role-List");
                $("#rolelist1").attr('value', "Role-List");         
                $("#rolecreate").html("Role-Create");
                $("#rolecreate1").attr('value', "Role-Create");
                $("#roleedit").html("Role-Edit");
                $("#roleedit1").attr('value', "Role-Edit");
                $("#roledelete").html("Role-Delete");
                $("#roledelete1").attr('value', "Role-Delete");
                $("#roles").show();
            }
            else{
                $("#rolelist").html(data.role[0].permission_name);
                $("#rolelist1").attr('value', data.role[0].permission_name);
                if(data.role[0].permission_value == 1){
                    $("#rolelist1").attr('checked', true);
                } 
                else{
                    $("#rolelist1").attr('checked', false);
                }
                $("#rolecreate").html(data.role[1].permission_name);
                $("#rolecreate1").attr('value', data.role[1].permission_name);
                if(data.role[1].permission_value == 1){
                    $("#rolecreate1").attr('checked', true);
                } 
                else{
                    $("#rolecreate1").attr('checked', false);
                }
                $("#roleedit").html(data.role[2].permission_name);
                $("#roleedit1").attr('value', data.role[2].permission_name);
                if(data.role[2].permission_value == 1){
                    $("#roleedit1").attr('checked', true);
                } 
                else{
                    $("#roleedit1").attr('checked', false);
                }
                $("#roledelete").html(data.role[3].permission_name);
                $("#roledelete1").attr('value', data.role[3].permission_name);
                if(data.role[3].permission_value == 1){
                    $("#roledelete1").attr('checked', true);
                }
                else{
                    $("#roledelete1").attr('checked', false);
                }
                $("#roles").show();
            }

            //User
            if(data.user.length === 0){
                $("#userlist").html("User-List");
                $("#userlist1").attr('value', "User-List");
                $("#usercreate").html("User-Create");
                $("#usercreate1").attr('value', "User-Create");
                $("#useredit").html("User-Edit");
                $("#useredit1").attr('value', "User-Edit");
                $("#userdelete").html("User-Delete");
                $("#userdelete1").attr('value', "User-Delete");
                $("#Users").show();
            }
            else{
                $("#userlist").html(data.user[0].permission_name);
                $("#userlist1").attr('value', data.user[0].permission_name);
                if(data.user[0].permission_value == 1){
                    $("#userlist1").attr('checked', true);
                } 
                else{
                    $("#userlist1").attr('checked', false);
                }
                $("#usercreate").html(data.user[1].permission_name);
                $("#usercreate1").attr('value', data.user[1].permission_name);
                if(data.user[1].permission_value == 1){
                    $("#usercreate1").attr('checked', true);
                } 
                else{
                    $("#usercreate1").attr('checked', false);
                }
                $("#useredit").html(data.user[2].permission_name);
                $("#useredit1").attr('value', data.user[2].permission_name);
                if(data.user[2].permission_value == 1){
                    $("#useredit1").attr('checked', true);
                } 
                else{
                    $("#useredit1").attr('checked', false);
                }
                $("#userdelete").html(data.user[3].permission_name);
                $("#userdelete1").attr('value', data.user[3].permission_name);
                if(data.user[3].permission_value == 1){
                    $("#userdelete1").attr('checked', true);
                }
                else{
                    $("#userdelete1").attr('checked', false);
                }
                $("#Users").show();
            }

            //Others
            if(data.others.length === 0){
                console.log("Other If");
                console.log(data.others.length);
                $("#employee").html("Employee");
                $("#employee1").attr('value', "Employee"); 
                $("#admin").html("Admin");
                $("#admin1").attr('value', "Admin");
                $("#others").show();
            }
            else{
                console.log("Other Else");
                console.log(data.others.length);
                $("#employee").html(data.others[0].permission_name);
                $("#employee1").attr('value', data.others.permission_name);
                if(data.others[0].permission_value == 1){
                    $("#employee1").attr('checked', true);
                } 
                else{
                    $("#employee1").attr('checked', false);
                }
                $("#admin").html(data.others[1].permission_name);
                $("#admin1").attr('value', data.others[1].permission_name);
                if(data.others[1].permission_value == 1){
                    $("#admin1").attr('checked', true);
                } 
                else{
                    $("#admin1").attr('checked', false);
                }
                $("#admin").html(data.others[1].permission_name);
                $("#admin1").attr('value', data.others[1].permission_name);
                if(data.others[1].permission_value == 1){
                    $("#admin1").attr('checked', true);
                } 
                else{
                    $("#admin1").attr('checked', false);
                }
                $("#s_admin").html(data.others[2].permission_name);
                $("#s_admin1").attr('value', data.others[2].permission_name);
                if(data.others[2].permission_value == 1){
                    $("#s_admin1").attr('checked', true);
                } 
                else{
                    $("#s_admin1").attr('checked', false);
                }
                $("#others").show();
            }
            $("#btnSupdate").show();
            $("#Hides").hide();
            }
        }
    });
});    
</script>
@endsection