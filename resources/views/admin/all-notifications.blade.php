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
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
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
    .table_row:hover{
        /* background-color: #435177; */
        background-color: #f1f5fa;
        cursor: pointer;
    }
    #image321:hover{
        transform: scale(1.5);
        transition: transform .5s;
        cursor: pointer;
    }
</style>
<link href="../../plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-2">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Latest Activities</li>
                    </ol>
                </div>
                <h4 class="page-title">Latest Activities</h4>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-8 col-md-12 col-sm-12 mb-5" style="margin: 0 auto;">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive p-5">
                        <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th data-orderable="false" class="sorting_disabled">#</th>
                                    <th data-orderable="false" class="sorting_disabled">Notification</th>
                                    <th data-orderable="false" class="sorting_disabled">Date</th>
                                    <th data-orderable="false" class="sorting_disabled">Time</th>
                                    <th data-orderable="false" class="sorting_disabled">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notification as $val)
                                <?php
                                    date_default_timezone_set("Asia/karachi");
                                    $time = date("h:i A");
                                    $datetime2 = new DateTime($time);
                                    $month = $val->created_at;
                                    $delimiter = ' ';
                                    $words = explode($delimiter, $month);
                                    $datetime3 = new DateTime($val->created_at);
                                    $interval = $datetime2->diff($datetime3);
                                    $diff = $interval->format('%h hr %i min');
                                ?>
                                <a href="{{$val->url}}?id={{$val->complaint}}&userid={{$val->userid}}" target="_blank">
                                <tr onclick="window.open('{{$val->url}}?id={{$val->complaint}}&userid={{$val->userid}}', '_blank')" class="table_row">
                                    <th onclick="window.open('your_html', '_blank')">{{$i++}}</th>
                                    <td class="text-left" style="width: 35%;">
                                    @if($val->event == 'Complaint Solved')
                                            <img id="image321" style="transition: transform .5s;" src="img/avatars/tick.png" alt="user" class="rounded-circle thumb-sm mr-1 ml-3">
                                        @elseif($val->event == 'In Process')
                                            <img id="image321" style="transition: transform .5s;" src="img/avatars/images (1).png" alt="user" class="rounded-circle thumb-sm mr-1 ml-3">
                                        @elseif($val->event == 'New Message')
                                            @if(isset($val->image) && !empty($val->image)) 
                                                <img id="image321" style="transition: transform .5s;" src="{{asset('uploads/appsetting/'.$val->image)}}" alt="user" class="rounded-circle thumb-sm mr-1 ml-3">    
                                            @else
                                                <img id="image321" style="transition: transform .5s;" src="img/avatars/avatar-2.jpg" alt="user" class="rounded-circle thumb-sm mr-1 ml-3">
                                            @endif
                                        @else
                                            @if(isset($val->image) && !empty($val->image)) 
                                                <img id="image321" style="transition: transform .5s;" src="{{asset('uploads/appsetting/'.$val->image)}}" alt="user" class="rounded-circle thumb-sm mr-1 ml-3">    
                                            @else
                                                <img id="image321" style="transition: transform .5s;" src="img/avatars/avatar-2.jpg" alt="user" class="rounded-circle thumb-sm mr-1 ml-3">
                                            @endif
                                        @endif
                                        @if($val->event == 'Complaint Solved')
                                            @if($val->read_at != NULL)
                                                <b style="font-weight: 600;">{{$val->event}}</b> By {{$val->name}}
                                            @else
                                                <b style="font-weight: 600;">{{$val->event}}</b> By {{$val->name}}<i style="font-size: xx-small;" class="mdi mdi-circle-slice-8 mr-1 text-danger"></i>
                                             @endif
                                        @elseif($val->event == 'In Process')
                                            @if($val->read_at != NULL)
                                                <b style="font-weight: 600;">{{$val->event}}</b> By {{$val->name}}
                                            @else
                                                <b style="font-weight: 600;">{{$val->event}}</b> By {{$val->name}}<i style="font-size: xx-small;" class="mdi mdi-circle-slice-8 mr-1 text-danger"></i>
                                            @endif
                                        @else
                                            @if($val->read_at != NULL)
                                                <b style="font-weight: 600;">{{$val->event}}</b> By {{$val->name}}
                                            @else
                                                <b style="font-weight: 600;">{{$val->event}}</b> By {{$val->name}} <span style="color:red; font-size: large;">*</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <i class="mdi mdi-calendar-text-outline" style="font-size: large;"></i> {{$words[0]}}
                                    </td>
                                    <td>
                                        <i class="mdi mdi-timer" style="font-size: large;"></i> {{$words[1]}}
                                    </td>
                                    <td><a href="{{$val->url}}?id={{$val->complaint}}&userid={{$val->userid}}" target="_blank"><i class="align-middle mb-1 mt-1 mx-1" data-feather="eye"></i></a></td>
                                </tr>
                                </a>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
</script>
@endsection