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
    <!-- <link href="plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"> -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/jquery-ui.min.css" rel="stylesheet">
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/metisMenu.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/dropify/css/dropify.min.css" rel="stylesheet">
    <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" href="plugins/rating/themes/rating.css">
    <link href="plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />
    <link href="plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" type="text/css" />
    <link href="plugins/timepicker/bootstrap-material-datetimepicker.css" rel="stylesheet"> 
    <link href="plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
</head>
<style>
    a:hover{
        text-decoration: none;
    }
    li:hover{
        text-decoration: none;
    }
    .footer{
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: white;
        color: black;
        text-align: center;
    }
    textarea{
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }
    html,
    body{
        margin: 0;
        font-family: Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }
    ::-webkit-scrollbar{
        width: 12px;
        height: 12px;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-track{
        background: #f1f1f1;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb{
        background: rgb(197, 197, 197);
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover{
        background: rgb(155, 155, 155);
        border-radius: 10px;
    }
    body.dark-topbar .navbar-custom{
        background: #292e40;
    }
    #notification:hover{
        background-color: transparent;
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
<?php
    $notification = DB::table("notification_details")->orderBy('id','DESC')->where('assignUsers', Auth::user()->id)->limit(10)->get();
    $unread = DB::table("notification_details")->orderBy('id','DESC')->where('assignUsers', Auth::user()->id)->where('read_at', NULL)->get();
    $count = count($unread); 
	$id = Auth::user()->id;
    $image = DB::table("users")->where("id", $id)->pluck('image');
    $image = str_replace('"', '', $image);
    $image = str_replace('[', '', $image);
    $image = str_replace(']', '', $image);
    $present = array();
    foreach($notification as $data){
        $detail = DB::table("users")->orderBy('id','DESC')->where('id', $data->userid)->get();
        $present[] = [
            'name' => $detail[0]->name,
            'image' => $detail[0]->image,
            'data'  => $data
        ]; 
    }
?>
<body>
<div class="topbar">
    <div class="topbar-left">
        <a href="{{url('home')}}">
            <span>
                <img src="img/photos/terafort.jpeg" width="35%" style="margin-top: 20px;" alt="logo-large" class="logo-lg">
            </span>
        </a>
    </div>
    <nav class="navbar-custom px-5">    
        <ul class="list-unstyled topbar-nav float-right mb-0"> 
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti-bell noti-icon"></i>
                    <span class="badge badge-danger badge-pill noti-icon-badge">{{$count}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">
                    <h6 style="background: linear-gradient(14deg, #fc5c04 0%, #f96c07);" class="dropdown-item-text font-15 m-0 py-3 text-white d-flex justify-content-between align-items-center">Notifications<span class="badge badge-light badge-pill">{{$count}}</span></h6> 
                    <div style="overflow-y: scroll; max-height: 270px;" class="notification-list">
                        @foreach($present as $val)
                            @if($val['data']->event_name == 'Complaint Solved')
                                @if($val['data']->read_at != NULL)
                                <span style="display: inline-flex; background: #d9e3eb7d;" class="w-100">
                                @else
                                <span style="display: inline-flex; background: white;" class="w-100">
                                @endif
                            @elseif($val['data']->event_name == 'Complaint In Process')
                                @if($val['data']->read_at != NULL)
                                <span style="display: inline-flex; background: #d9e3eb7d;" class="w-100">
                                @else
                                <span style="display: inline-flex; background: white;" class="w-100">
                                @endif
                            @else
                                @if($val['data']->read_at != NULL)
                                <span style="display: inline-flex; background: #d9e3eb7d;" class="w-100">
                                @else
                                <span style="display: inline-flex; background: white;" class="w-100">
                                @endif
                            @endif
                                    <a href="#" onclick="myFunction('{{ $val['data']->complaint_id }}');" class="dropdown-item py-3" id="notification">  
                                    <?php
                                        date_default_timezone_set("Asia/karachi");
                                        $time = date("h:i A");
                                        $datetime2 = new DateTime($time);
                                        $month = $val['data']->created_at;
                                        $delimiter = ' ';
                                        $words = explode($delimiter, $month);
                                        $datetime3 = new DateTime($val['data']->created_at);
                                        $interval = $datetime2->diff($datetime3);
                                        $diff = $interval->format('%d day %h hr %i min');
                                        if($diff[0] == 0){
                                            $diff = $interval->format('%h hr %i min');
                                        }
                                        elseif($diff[0] == 1){
                                            $diff = $interval->format('%d day');
                                        }
                                        else{
                                            $diff = $interval->format('%d days');
                                        }
                                    ?>
                                    <small class="float-right pl-2" style="font-size: 75%;">{{$diff}} ago</small>
                                    <div class="media">
                                        @if($val['data']->event_name == 'New Message')
                                            <img style="margin-left: -6px;" src="{{asset('uploads/appsetting/'.$val['image'])}}" alt="user" class="rounded-circle thumb-sm">
                                        @elseif($val['data']->event_name == 'New Complaint')
                                            <img style="margin-left: -6px;" src="img/avatars/avatar-2.jpg" alt="user" class="rounded-circle thumb-sm">
                                        @elseif($val['data']->event_name == 'Complaint In Process')
                                            <img style="margin-left: -6px;" src="img/avatars/avatar-2.jpg" alt="user" class="rounded-circle thumb-sm">
                                        @else
                                            <img style="margin-left: -6px;" src="img/avatars/avatar-2.jpg" alt="user" class="rounded-circle thumb-sm">
                                        @endif
                                        <div class="media-body align-self-center ml-2 text-truncate">
                                                @if($val['data']->read_at != NULL)
                                                <h6 style="font-family: system-ui; text-transform: capitalize;" class="my-0 font-weight-normal text-dark">{{$val['data']->event_name}} </h6>
                                                @else
                                                <h6 style="font-family: system-ui; text-transform: capitalize;" class="my-0 font-weight-normal text-dark"><small class="float-left"><i style="font-size: xx-small;" class="mdi mdi-circle-slice-8 mr-1 text-danger"></i></small>{{$val['data']->event_name}}  </h6>
                                                @endif
                                            @if($val['data']->event_name == 'Complaint Closed')
                                            <small style="font-family: system-ui;" class=" mb-0"> By <span style="font-weight: 600; font-family: system-ui; letter-spacing: 0.3px;"> {{$val['name']}} </span></small>
                                            @elseif($val['data']->event_name == 'Complaint In Process')
                                            <small style="font-family: system-ui;" class=" mb-0"> By <span style="font-weight: 600; font-family: system-ui; letter-spacing: 0.3px;"> {{$val['name']}} </span></small>
                                            @elseif($val['data']->event_name == 'Complaint Solved')
                                            <small style="font-family: system-ui;" class=" mb-0"> By <span style="font-weight: 600; font-family: system-ui; letter-spacing: 0.3px;"> {{$val['name']}} </span></small>
                                            @elseif($val['data']->event_name == 'Complaint Completed')
                                            <small style="font-family: system-ui;" class=" mb-0"> By <span style="font-weight: 600; font-family: system-ui; letter-spacing: 0.3px;"> {{$val['name']}} </span></small>
                                            @elseif($val['data']->event_name == 'Complaint Re-Open')
                                            <small style="font-family: system-ui;" class=" mb-0"> By <span style="font-weight: 600; font-family: system-ui; letter-spacing: 0.3px;"> {{$val['name']}} </span></small>
                                            @else
                                            <small style="font-family: system-ui;" class=" mb-0"> From <span style="font-weight: 600; font-family: system-ui; letter-spacing: 0.3px;"> {{$val['name']}}</span></small>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </span>                       
                        @endforeach
                    </div>
                    <span class="d-none">
                        <a href="all-activity?id={{Auth::user()->id}}" class="dropdown-item text-center text-primary">View all <i class="fi-arrow-right"></i></a>
                        <a onclick="myFunction111();" style="cursor: pointer;" class="dropdown-item text-center text-primary">Mark all read <i class="fi-arrow-right"></i></a>
                    </span>
                </div>
            </li>
            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    @if(isset($image) && !empty($image)) 
                    <img src="{{ asset('uploads/appsetting/' . $image) }}" alt="profile-user" class="rounded-circle" /> 
                    @else
                    <img src="img/avatars/avatar-2.jpg" alt="profile-user" class="rounded-circle" /> 
                    @endif                    
                    <span class="ml-1 nav-user-name hidden-sm">{{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i></span>
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
                    <a class="dropdown-item" href="{{route('profile')}}"><i class="fas fa-user-cog text-muted mr-2"></i> Profile</a>
                    <a class="dropdown-item" href="{{url('user-password')}}"><i class="fas fa-unlock-alt text-muted mr-2"></i> Change Password</a>
                    <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal" href="#"><i class="fas fa-sign-out-alt text-muted mr-2"></i> {{ __('Logout') }}</a>
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
                <a href="javascript: void(0);"><i class="ti-user"></i><span>Profile</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{route('profile')}}"><i class="ti-control-record"></i>Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('user-password')}}"><i class="ti-control-record"></i>Change Password</a></li>
                </ul>
            </li>
            @if(Auth::user()->role != 'Support Administrator')
            <li class="{{ Request::path() == 'complaints-view-user' ? 'mm-active active' : Request::path() == 'complaints-edit-user' ? 'mm-active active' : Request::path() == 'complaints-view' ? 'mm-active active' : '' }}">
                <a href="javascript: void(0);" class="{{ Request::path() == 'complaints-view-user' ? 'active' : Request::path() == 'complaints-edit-user' ? 'active' : Request::path() == 'complaints-view' ? 'active' : '' }}"><i class="ti-desktop"></i><span>Help Desk</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level p-0" aria-expanded="false">
                    <li class="{{ Request::path() == 'complaints-view-user' ? 'nav-item active' : Request::path() == 'complaints-edit-user' ? 'nav-item active' : Request::path() == 'complaints-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'complaints-view-user' ? 'nav-link active' : Request::path() == 'complaints-view' ? 'nav-link active' :  Request::path() == 'complaints-edit-user' ? 'nav-link active' : 'nav-link' }}" href="{{url('manage-complaint')}}"><i class="ti-control-record"></i>Manage Complaints</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('complaint')}}"><i class="ti-control-record"></i>Submit Complaint</a></li>   
                </ul>
            </li>      
            @else
            <li class="{{ Request::path() == 'complaints-view' ? 'mm-active active' : '' }}">
                <a href="javascript: void(0);" class="{{ Request::path() == 'complaints-view' ? 'active' : '' }}"><i class="ti-desktop"></i><span>Help Desk</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level p-0" aria-expanded="false">
                    <li class="{{ Request::path() == 'complaints-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'complaints-view' ? 'nav-link active' : 'nav-link' }}" href="{{url('manage-complaints')}}"><i class="ti-control-record"></i>Manage Complaints</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('master-settings')}}"><i class="ti-control-record"></i>Master Settings</a></li>          
                </ul>
            </li>    
            @endif
        </ul>
    </div>
    <div class="page-wrapper">
        @yield('content')
        <footer class="footer text-center text-sm-left" style="border-top: none;">
            <div class="row">
                <div class="col-6">
                    <span class="float-right">
                    &copy; Powered by <b>Business Technology Team</b> 
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
<script src="plugins/moment/moment.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
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
<script src="plugins/moment/moment.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/select2/select2.min.js"></script>
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="plugins/timepicker/bootstrap-material-datetimepicker.js"></script>
<script src="plugins/rating/jquery.barrating.min.js"></script>
<script src="assets/pages/jquery.rating.init.js"></script> 
<script src="plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
<script src="plugins/tinymce/tinymce.min.js"></script>
<script src="assets/pages/jquery.form-editor.init.js"></script> 
<script src="assets/js/sweetalert.min.js"></script>
<script>
function myFunction(id)
{
    console.log("id");
    console.log(id);
    var user = {!! json_encode((array)auth()->user()->id) !!};
    $.ajax({
            type: 'GET',
            url: 'read_at/'+id,
            dataType: "json",
            success: function(data){
                if(user[0] == 4){
                document.cookie='CID='+id;
                location.href = "complaints-view";
                } 
                else{
                document.cookie='CD='+id;
                location.href = "complaints-view-user";
                }
            }
        });
}
function myFunction111()
{
    $.ajax({
            type: 'GET',
            url: 'mark_all',
            dataType: "json",
            success: function(data){                
                if(data == 1){
                    Swal.fire({
                        icon: 'success',
                        title: 'Done',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    location.reload();
                }
                else if(data == 400){
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    location.reload();
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