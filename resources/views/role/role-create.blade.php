@extends((Auth::user()->role == 'Admin') ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-1">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Create Role</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Role</h4>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
            <div class="card-body h-100">
					<div class="text-center mt-5">
						<h2 style="color: #6c757d">Create Role</h2>
					</div>
                    <form action="{{url('roles-create')}}" method="post" enctype="multipart/form-data">
                    @csrf
					    <div class="p-5">
						    <div class="form-group row py-2">
                                <div class="col-sm-3 mb-1 mb-sm-0">
                                    <label for=""><b style="color: #6c757d"> Role</b></label>
                                    <input type="text" style="border: 1px solid #bfbfbf;" class="form-control yourclass" id="name" name="name" required placeholder="Role Name">
                                    <span id="StrengthDisp4" style="font-size: 13px !important;" class="badge displayBadgess text-light py-2 mt-2"></span>     
								    <button type="submit" class="btn w-100 py-1 text-white mt-4" style="border: none; background: #fc5c04; border: none; font-size: 15px;">Create</button>
                                </div>
                                <div class="col-sm-9">
                                    <label for=""> <b style="color: #6c757d"> Permissions</b></label><br>                                                     
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #fc5c04 0%, #f96c07); cursor: pointer; border-radius: 4px;" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Role
                                            </div>
                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                <div class="card-body">
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name rolecheck" type="checkbox" value="Role List" name="Role[]">
                                                        <span class="form-check-label">Role List</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name rolecheck" type="checkbox" value="Role Create" name="Role[]">
                                                        <span class="form-check-label">Role Create</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name rolecheck" type="checkbox" value="Role Edit" name="Role[]">
                                                        <span class="form-check-label">Role Edit</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name rolecheck" type="checkbox" value="Role Delete" name="Role[]">
                                                        <span class="form-check-label">Role Delete</span>
                                                    </label>
                                                    <label class="form-check form-check-inline" style="float: right;">
                                                        <input class="form-check-input" id="roleAll" type="checkbox">
                                                        <span class="form-check-label">Mark All</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #fc5c04 0%, #f96c07); cursor: pointer; border-radius: 4px;" id="headingOne11" data-toggle="collapse" data-target="#collapseOne12" aria-expanded="true" aria-controls="collapseOne">
                                                Users
                                            </div>
                                            <div id="collapseOne12" class="collapse" aria-labelledby="headingOne11" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                <div class="card-body">
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name usercheck" type="checkbox" value="User List" name="User[]">
                                                        <span class="form-check-label">User List</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name usercheck" type="checkbox" value="User Create" name="User[]">
                                                        <span class="form-check-label">User Create</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name usercheck" type="checkbox" value="User Edit" name="User[]">
                                                        <span class="form-check-label">User Edit</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name usercheck" type="checkbox" value="User Delete" name="User[]">
                                                        <span class="form-check-label">User Delete</span>
                                                    </label>
                                                    <label class="form-check form-check-inline" style="float: right;">
                                                        <input class="form-check-input" id="userAll" type="checkbox">
                                                        <span class="form-check-label">Mark All</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #fc5c04 0%, #f96c07); cursor: pointer; border-radius: 4px;" id="headingOne11" data-toggle="collapse" data-target="#collapseOne1233" aria-expanded="true" aria-controls="collapseOne">
                                                Administrator
                                            </div>
                                            <div id="collapseOne1233" class="collapse" aria-labelledby="headingOne11" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                <div class="card-body">
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name othercheck" type="checkbox" value="Employee" name="Others[]">
                                                        <span class="form-check-label">Employee</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name othercheck" type="checkbox" value="Admin" name="Others[]">
                                                        <span class="form-check-label">Admin</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name othercheck" type="checkbox" value="Support Administrator (LHR)" name="Others[]">
                                                        <span class="form-check-label">Support Administrator (LHR)</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name othercheck" type="checkbox" value="Support Administrator (ISB)" name="Others[]">
                                                        <span class="form-check-label">Support Administrator (ISB)</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name othercheck" type="checkbox" value="Support Administrator Head" name="Others[]">
                                                        <span class="form-check-label">Support Administrator Head</span>
                                                    </label>
                                                    <label class="form-check form-check-inline" style="float: right;">
                                                        <input class="form-check-input" id="otherAll" type="checkbox">
                                                        <span class="form-check-label">Mark All</span>
                                                    </label>
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
<script src="assets/js/customjquery.min.js"></script>
<script>
    let name = document.getElementById('name')
    let strengthBadge4 = document.getElementById('StrengthDisp4')
    name.addEventListener("input", () => {
        Email(name.value);
        function Email(name){
            $.ajax({
                    type: 'GET',
                    url: 'role/'+name,
                    dataType: "json",
                    success: function(data){
                        if(data){
                            if(data == 1){
                                strengthBadge4.style.display = 'block'
                                strengthBadge4.style.backgroundColor = '#cd3f3f'
                                strengthBadge4.textContent = 'Role Name Already taken'
                            }
                            else if(data == 2){
                                strengthBadge4.style.display = 'block'
                                strengthBadge4.style.backgroundColor = '#52a752'
                                strengthBadge4.textContent = 'Role Name Available'
                            }
                        }
                    }
                });
        }
    });
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
    });
    $("#roleAll").change(function(){
        if(this.checked) {
            $(".rolecheck").each(function(){
                this.checked=true;
            });
        } 
        else{
            $(".rolecheck").each(function(){
                this.checked=false;
            });
        }
    });
    $("#userAll").change(function(){
        if(this.checked) {
            $(".usercheck").each(function(){
                this.checked=true;
            });
        } 
        else{
            $(".usercheck").each(function(){
                this.checked=false;
            });
        }
    });
    $("#otherAll").change(function(){
        if(this.checked) {
            $(".othercheck").each(function(){
                this.checked=true;
            });
        } 
        else{
            $(".othercheck").each(function(){
                this.checked=false;
            });
        }
    });
</script>
@endsection