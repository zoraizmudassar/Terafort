<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Terafort</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="img/photos/terafort2.png">
    <link href="plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">    
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/jquery-ui.min.css" rel="stylesheet">
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/metisMenu.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/dropify/css/dropify.min.css" rel="stylesheet">
    <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
    <link href="plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />
    <link href="plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" type="text/css" />
    <link href="plugins/timepicker/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
</head>
<style>
    a:hover {
        text-decoration: none;
    }
    li:hover {
        text-decoration: none;
    }
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: white;
        color: black;
        text-align: center;
    }
    textarea {
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }
    html,
    body {
        margin: 0;
        font-family: Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }
    ::-webkit-scrollbar {
        width: 12px;
        height: 12px;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb {
        background: rgb(197, 197, 197);
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgb(155, 155, 155);
        border-radius: 10px;
    }
    #loader1{  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/giphy (3).gif") 50% 50% no-repeat black; 
    }
</style>
<body>
<div class="topbar">
    <div class="topbar-left">
        <a href="{{url('home')}}">
            <span>
                <img src="img/photos/terafort.jpeg" style="margin-top: 20px;" width="35%" alt="logo-large" class="logo-lg">
            </span>
        </a>
    </div>
    <nav class="navbar-custom px-5">    
        <ul class="list-unstyled topbar-nav float-right mb-0"> 
            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    @if(isset($image) && !empty($image)) 
                    <img src="{{ asset('uploads/appsetting/' . $image) }}" alt="profile-user" class="rounded-circle" /> 
                    @else
                    <img src="img/avatars/avatar-2.jpg" alt="profile-user" class="rounded-circle" /> 
                    @endif                    
                    <span class="ml-1 nav-user-name hidden-sm">{{ Auth::user()->name }}<i class="mdi mdi-chevron-down"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @guest
                        @if(Route::has('login'))
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif
                        @if(Route::has('register'))
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
					@else
                    @endguest
                    <a class="dropdown-item" href="{{route('profile')}}"><i class="ti-user text-muted mr-2"></i> Profile</a>
                    <a class="dropdown-item" href="{{url('user-password')}}"><i class="ti-wallet text-muted mr-2"></i> Change Password</a>
                    <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal" href="#"><i class="ti-power-off text-muted mr-2"></i> {{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
            <ul class="list-unstyled topbar-nav mb-0">                        
                <li>
                    <button class="nav-link button-menu-mobile waves-effect waves-light">
                        <i class="ti-menu nav-icon"></i>
                    </button>
                </li>
            </ul>
        </nav>
    </div>
    <div class="left-sidenav">
         <ul class="metismenu left-sidenav-menu">
            <li class="{{ Request::path() == 'home' ? 'mm-active active' : '' }}">
                <a class="{{ Request::path() == 'home' ? 'active' : '' }}" href="{{url('home')}}"><i class="ti-bar-chart"></i><span>Dashboard</span><span class="menu-arrow"></span></a>
            </li>
            <li>
                <a href="javascript: void(0);"><i class="ti-settings"></i><span>Master Settings</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{url('create')}}"><i class="ti-control-record"></i>Create User</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('manage-user')}}"><i class="ti-control-record"></i>Manage User</a></li>     
                    <li class="nav-item"><a class="nav-link"  href="{{url('master-data')}}"><i class="ti-control-record"></i>Master Data</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);"><i class="ti-target"></i><span>Roles</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{url('role-create')}}"><i class="ti-control-record"></i>Create Role</a></li>  
                    <li class="nav-item"><a class="nav-link" href="{{url('role-manage-new')}}"><i class="ti-control-record"></i>Manage Roles</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);"><i class="ti-user"></i><span>Profile</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{route('profile')}}"><i class="ti-control-record"></i>Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('user-password')}}"><i class="ti-control-record"></i>Change Password</a></li>
                </ul>
            </li>
            <li class="{{ Request::path() == 'complaints-view' ? 'mm-active active' : '' }}">
                <a href="javascript: void(0);" class="{{ Request::path() == 'complaints-view' ? 'active' : '' }}"><i class="ti-desktop"></i><span>Help Desk</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level p-0" aria-expanded="false">
                    <li class="{{ Request::path() == 'complaints-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'complaints-view' ? 'nav-link active' : 'nav-link' }}" href="{{url('manage-complaints')}}"><i class="ti-control-record"></i>Manage Complaints</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('master-settings')}}"><i class="ti-control-record"></i>Master Settings</a></li>          
                </ul>
            </li>                    
        </ul>
    </div>
    <div class="page-wrapper">
        @yield('content')
        <footer class="footer text-center text-sm-left" style="border-top: none;">
            <div class="row">
                <div class="col-6">
                    <span class="float-right">
                    &copy; Developed by <b>Business Technology</b> 
                    </span>
                </div>
                <div class="col-6">
                    <span class="d-none d-sm-inline-block float-left" style="color: black;">Copyright © <span style="font-weight: 600;"> TERAFORT Limited.</span> All rights reserved.</span>
                </div>
            </div>  
        </footer>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: transparent">
                    <h5>Logout?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer" style="background-color: transparent">
                    <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <a href="{{ route('logout') }}" 
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-toggle="modal" data-target="#logoutModal">
                         <button type="button" style="box-shadow: none; background: #202020; border: none;" class="btn btn-danger mx-1 py-2 px-3">Logout</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/metismenu.min.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="assets/pages/jquery.helpdesk-dashboard.init.js"></script>
<script src="plugins/moment/moment.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
<script src="assets/pages/jquery.analytics_dashboard.init.js"></script>
<script src="plugins/dropify/js/dropify.min.js"></script>
<script src="assets/pages/jquery.form-upload.init.js"></script>
<script src="assets/js/app.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables/dataTables.responsive.min.js"></script>
<script src="plugins/datatables/responsive.bootstrap4.min.js"></script>
<script src="assets/pages/jquery.datatable.init.js"></script>
<script src="plugins/datatables/dataTables.buttons.min.js"></script>
<script src="plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="plugins/datatables/jszip.min.js"></script>
<script src="plugins/datatables/pdfmake.min.js"></script>
<script src="plugins/datatables/vfs_fonts.js"></script>
<script src="plugins/datatables/buttons.html5.min.js"></script>
<script src="plugins/datatables/buttons.print.min.js"></script>
<script src="plugins/datatables/buttons.colVis.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/select2/select2.min.js"></script>
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="plugins/timepicker/bootstrap-material-datetimepicker.js"></script>
<script src="plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script src="plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
<script src="assets/pages/jquery.forms-advanced.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script src="assets/pages/jquery.projects_overview.init.js"></script>
<script>
function myFunction(id)
{
    $.ajax({
        type: 'GET',
        url: 'read_at/'+id,
        dataType: "json",
        success: function(data){
            if(data == 1){
                Swal.fire({
                    icon: 'success',
                    showConfirmButton: false,
                });
                location.reload();
            }
            else if(data == 400){
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong!',
                    showConfirmButton: false,
                });
            }
        }
    });
}
</script>
<script>
@if(Session::has('message'))
var type = "{{ Session::get('alert-type', 'info') }}";
switch (type) {
case 'info':
    Swal.fire({
        icon: 'info',
        title: "{{ session('message') }}",
        showConfirmButton: false,
        timer: 2000
    });
    break;
case 'warning':
    Swal.fire({
        icon: 'warning',
        title: "{{ session('message') }}",
        showConfirmButton: false,
        timer: 2000
    });
    break;
case 'success':
    Swal.fire({
        icon: 'success',
        title: "{{ session('message') }}",
        showConfirmButton: false,
        timer: 2000
    });
    break;
case 'error':
    Swal.fire({
        icon: 'error',
        title: "{{ session('message') }}",
        showConfirmButton: false,
        timer: 2000
    });
    break;
}
@endif
</script>