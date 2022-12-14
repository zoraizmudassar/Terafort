@extends((Auth::user()->role == 'Admin') ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<?php
    $id = Auth::user()->id;
    $image = DB::table("users")->where("id", $id)->pluck('image');
    $image = $image[0];
    $tem1 = null;
?>
<link href="plugins/filter/magnific-popup.css" rel="stylesheet" type="text/css" />
<style>
    .btn-outline:active, .btn-outline:visited{
        background: linear-gradient(14deg, #fc5c04 0%, #f96c07);
        border: 1px solid #f96c07 !important;
        color: white;
    }
    .media .media-body.reverse .chat-msg p{
        background-color: #6d81f5;
        color: white;
        display: inline-block;
        margin-bottom: 0;
        border-radius: 20px;
    }
    .media .media-body .chat-msg p{
        background-color: #f8fafd;
        color: #303e67;
        display: inline-block;
        margin-bottom: 0;
        border-radius: 20px;
    }
    #chatcard{
        padding: 20px;
        background-image: url("img/photos/pattern.png");
        background-repeat: repeat;
        background-attachment: fixed;
        height: 570px;
        background-color: #edf0f5;
        overflow: auto;
    }
    .chat-footer{
        border-top: 1px solid #f1f5fa;
        background-color: #fff;
        padding: 20px;
        left: 0;
        bottom: 0;
    }
    .chat-footer .chat-admin{
        position: absolute;
        top: -40px;
        /* border: 2px solid #303e67; */
        border-radius: 50%;
    }
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
    }
    .mfp-container{
        cursor: auto
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="page-content">
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{url('manage-complaint')}}">Manage Complaints</a></li>
                            <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Complaint</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Complaint</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">  
                <div class="card mt-2">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card-body p-5">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="media mb-4">
                                        @if(isset($user['image']) && !empty($user['image'])) 
                                        <img class="d-flex mr-3 rounded-circle thumb-md" src="{{ asset('uploads/appsetting/' . $user['image']) }}" alt="Generic placeholder image">
                                        @else
                                        <img class="d-flex mr-3 rounded-circle thumb-md" src="img/avatars/avatar-2.jpg" alt="Generic placeholder image">
                                        @endif 
                                        <div class="media-body align-self-center">
                                            <h5 class="m-0">{{$user['name']}}</h5>
                                            <p style="letter-spacing: 0.4px;" class="text-muted">{{$user['email']}}</p>
                                            <input type="text" id="complaint" name="complaint" value="{{$C_id}}" hidden>
                                            <input type="text" id="userid" name="userid" value="{{$userid}}" hidden>
                                            <input type="text" id="loginid" name="loginid" value="{{Auth::user()->id}}" hidden>
                                            <input type="text" id="imageUser" name="imageUser" value="{{$image}}" hidden>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="media mb-4 mt-1" style="float: right;">
                                            <div class="media-body align-self-center">
                                                @if($data['status'] == 3)
                                                    <button type="button" data-id="{{$data['id']}}" class="btn btn-outline-success waves-effect waves-light complete">Complete</button>
                                                    <button type="button" data-id="{{$data['id']}}" class="btn btn-outline-danger waves-effect waves-light reject px-4">Re-Open</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="exampleModalCenter5" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: transparent">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Complete Complaint?</h5>
                                                </div>
                                                <div class="modal-body">
                                                    Select "Complete" below if you are ready to Complete Complaint
                                                </div>
                                                <div class="modal-footer" style="background-color: transparent">
                                                    <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                    <button type="button" style="box-shadow: none;" class="btn btn-success complete-user" id="complete-user" data-dismiss="modal">Complete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="exampleModalCenter6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: transparent">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Re-Open Complaint?</h5>
                                                </div>
                                                <div class="modal-body">
                                                    Select "Re-Open" below if you are ready to Re-Open Complaint
                                                </div>
                                                <div class="modal-footer" style="background-color: transparent">
                                                    <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                    <button type="button" style="box-shadow: none;" class="btn btn-danger reject-user" id="reject-user" data-dismiss="modal">Re-Open</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="media mb-4" style="float: right;">
                                            @if($data['status'] == 3)
                                            <div class="media-body align-self-center">
                                                <?php
                                                    date_default_timezone_set("Asia/karachi");
                                                    $time = date("h:i A");
                                                    $hour = date("G");
                                                    $min = date("i");
                                                    $month = $data->created_at;
                                                    $delimiter = ' ';
                                                    $words = explode($delimiter, $month);
                                                    $datetime4 = new DateTime($data->updated_at);
                                                    $delimiter2 = ' ';
                                                    $words = explode($delimiter, $data->updated_at);
                                                    $final = $words[1];                      
                                                    //Start
                                                    $result2 = $data->updated_at; 
                                                    $time2 = $result2->format('Y-m-d G:i:s');
                                                    $words = explode($delimiter2, $result2); 
                                                    $da2y = $result2->format('d-m-Y');
                                                    //End
                                                    $Complaindate = date('Y-m-d G:i:s');
                                                    $date1 = strtotime($Complaindate);
                                                    $static = strtotime('2022-11-30 16:34:19');
                                                    $datetime = new DateTime('tomorrow');
                                                    $today = $datetime->format('Y-m-d');
                                                    $expire = $today." ".$final;
                                                    $date2 = strtotime($expire);
                                                    $diff = abs($date2 - $date1);
                                                    $years = floor($diff / (365*60*60*24));
                                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24) / (60*60*24));
                                                    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
                                                    $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60) / 60);
                                                    $seconds = floor(($diff - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
                                                    $result = $date2 - $date1;
                                                    if($result < 0){
                                                        $update = DB::table('complaints')->where('id', $data->id)->update(['status' => 4]);
                                                    }
                                                ?>
                                                @if($result > 0)
                                                    <h6 class="m-0" style="font-family: system-ui;">Complaint will Autoclose After</h6>
                                                    <h6 class="float-right pl-1"> {{(int)$minutes}} <span style="font-weight: 100;">Minutes </span>&#128344;</h6>
                                                    <h6 class="float-right pl-1">{{(int)$hours}}<span style="font-weight: 100;"> Hour </span>  </h6> 
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h6 class="mt-0">Complaint No: {{$data['id']}}</h6>
                                        <h4 class="mt-1"> <span style="font-weight: 500;">Category:</span> {{$data['category']}}</h4>
                                        <h5 class="mt-0"> <span style="font-weight: 500;">Sub Category:</span> {{$data['subcategory']}}</h5>
                                    </div>
                                    <div class="col text-right">
                                        @if($data['status'] == 1)    
                                        <span class="badge badge-md badge-boxed badge-soft-danger p-2 my-2" style="font-size: small !important;">No Action</span>
                                        @elseif($data['status'] == 2)
                                        <span class="badge badge-md badge-boxed badge-soft-warning p-2 my-2" style="font-size: small !important;">In Process</span>
                                        @elseif($data['status'] == 3)
                                        <span class="badge badge-md badge-boxed badge-soft-secondary p-2 my-2" style="font-size: small !important;">Closed</span>
                                        @elseif($data['status'] == 4)
                                        <span class="badge badge-md badge-boxed badge-soft-success p-2 my-2" style="font-size: small !important;">Complete</span>
                                        @endif
                                        <?php $result = $data['created_at']; $time = $result->format('g:i:s A'); $day = $result->format('d-M-Y'); ?>
                                        <h5 class="mt-1"><i class="mdi mdi-calendar-text-outline"></i> {{$day}}</h5>
                                        <h5 class="mt-0"> <i class="mdi mdi-timer"></i> {{$time}}</h5>   
                                    </div>
                                </div>
                                <br>                                                                      
                                <p style="font-family: system-ui;">{{$data['message']}}</p>                       
                                <hr style="border-top: 1px solid #e6e8eb;"/>
                                @if(isset($data['doc']) && !empty($data['doc']))
                                <div class="row">
                                    <div class="col-lg-2 col-md-4">
                                        <div class="file-box-content">
                                            <div class="file-box" style="border: 1px solid #e6e8eb;">
                                                <div class="row" style="margin-top: -10px">
                                                    <div class="col-12">
                                                        <a href="{{ asset('uploads/appsetting/' . $data['doc']) }}" style="float: right;" download class="download-icon-link">
                                                            <i style="float: left; font-size: 20px;" class="mdi mdi-cloud-download-outline"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <?php $ext = pathinfo($data['doc'], PATHINFO_EXTENSION); ?>
                                                    @if($ext == 'xlsx')
                                                        <img style="border-radius: 20px; width: 65%;" class="item-container p-3" src="{{ asset('uploads/appsetting/download-removebg.png') }}" alt="File" />
                                                        <h6 class="mt-0">XLSX</h6>
                                                    @elseif($ext == 'pdf')
                                                        <img style="border-radius: 20px; width: 60%;" class="item-container p-3" src="{{ asset('uploads/appsetting/PDF_file_icon.svg.png') }}" alt="File" />
                                                        <h6>PDF</h6>
                                                    @else
                                                        <i class="far fa-file-alt text-dark"></i>
                                                        <h6>Attachment</h6>
                                                    @endif
                                                    <div class="row" style="margin-top: -10px">
                                                        <div class="col-12">
                                                            <small hidden class="text-muted px-0">{{$data['doc']}}</small>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row container-grid nf-col-3  projects-wrapper">
                                                                <div class="col-lg-12 col-md-6 p-0 nf-item branding design coffee spacing">
                                                                    <div class="item-box">
                                                                        <a class="cbox-gallary1 mfp-image" href="{{ asset('uploads/appsetting/' . $data['doc']) }}" title="Attachment">
                                                                            @if($ext == 'xlsx')
                                                                            @elseif($ext == 'pdf')
                                                                            @else
                                                                                <img style="border-radius: 20px;" class="item-container p-3" src="{{ asset('uploads/appsetting/' . $data['doc']) }}" alt="File" />
                                                                            @endif
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <span hidden href="#custom-modal" data-toggle="modal" data-animation="bounce" data-target=".compose-modal" class="badge badge-md badge-boxed badge-dark w-50 p-2 my-2" style="font-size: small !important;"><i style="font-size: 20px;" class="mdi mdi-eye"></i></span>
                                                        </div>
                                                    </div>
                                                </div>                                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            @if($data['status'] != 4)
                            <div class="card-body p-4 chatcard1" style="display: none;" id="chatcard">
                            @else
                            <div class="card-body p-4 chatcard1" id="chatcard" style="height: 100% !important; display: none;">
                            @endif
                                <div class="text-center">
                                    <h5 id="date"></h5>                              
                                </div>
                                <span id="msg1">                                
                                </span>
                                <span id="msg2">                        
                                </span>
                            </div>
                            @if($data['status'] != 4)
                            <div class="card-body p-4 chatcard2" id="chatcard">
                            @else
                            <div class="card-body p-4 chatcard2" id="chatcard" style="height: 100% !important;">
                            @endif
                                @foreach($SupportDetail as $value)
                                    <div class="text-center">
                                    <?php             
                                        $result = $data['created_at']; 
                                        $time = $result->format('g:i:s A');
                                        $day = $result->format('d-M-Y'); ?>
                                        @if($tem1 == $day)
                                        @else
                                            <h5>{{$day}}</h5>
                                            <?php $tem1 = $day; ?>
                                        @endif
                                    </div>
                                    @if($value['data']['sender'] == Auth::user()->id)                                        
                                        <div class="media my-2">                                                        
                                            <div class="media-body reverse px-1">
                                                <div class="chat-msg my-1" style="float: right;">
                                                <?php $result = $value['data']['created_at']; $delimiter = ' '; $words = explode($delimiter, $result); $day = $result->format('d-m-Y'); $time = $result->format('g:i A'); ?>
                                                    <small class="text-muted">{{$time}}</small>
                                                    <p class="py-2 px-3">{{$value['data']['message']}}</p>
                                                </div>                                                            
                                            </div>
                                            <div class="media-img mt-1">
                                            @if(isset($value['image']) && !empty($value['image'])) 
                                                <img src="{{ asset('uploads/appsetting/' . $value['image']) }}" alt="user 2" class="rounded-circle thumb-sm">
                                            @else
                                                <img src="img/avatars/avatar-2.jpg" alt="user 2" class="rounded-circle thumb-sm">
                                            @endif 
                                            </div>
                                        </div>
                                    @endif
                                    @if($value['data']['sender'] != Auth::user()->id)
                                       
                                    <div class="media my-2">
                                        <div class="media-img mt-1">
                                        @if(isset($value['image']) && !empty($value['image']))
                                            <img src="{{ asset('uploads/appsetting/' . $value['image']) }}" alt="user" class="rounded-circle thumb-sm">
                                        @else
                                            <img src="img/avatars/avatar-2.jpg" alt="user 1" class="rounded-circle thumb-sm">
                                        @endif
                                        </div>
                                        <div class="media-body px-1">                                                            
                                            <div class="chat-msg my-1">
                                            <?php $result = $value['data']['created_at']; $delimiter = ' '; $words = explode($delimiter, $result); $day = $result->format('d-m-Y'); $time1 = $result->format('g:i A'); ?>
                                                <p class="py-2 px-3">{{$value['data']['message']}}</p>
                                                <small class="text-muted">{{$time1}}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                <span id="Dis2"> 
                                </span>
                            </div>
                            @if($data['status'] != 4)
                            <div class="chat-footer" id="chatfooter">
                                <form id="Chatform">
                                    <div class="row">       
                                        <div class="col-12">
                                            @if(isset($image) && !empty($image)) 
                                                <span class="chat-admin"><img src="{{ asset('uploads/appsetting/' . $image) }}" alt="user" class="rounded-circle thumb-sm"></span>
                                            @else
                                                <span class="chat-admin"><img src="img/avatars/avatar-2.jpg" alt="user" class="rounded-circle thumb-sm"></span>
                                            @endif
                                            <input hidden type="text" name="complaint_id" value="{{$data['id']}}">
                                            <input hidden type="text" name="id" value="{{$data['id']}}">
                                            <input hidden type="text" name="user_id" value="{{$data['user']}}">
                                            <div class="form-group"> 
                                                <div class="input-group">
                                                    <input type="text" class="form-control yourclass" id="message" name="message" placeholder="Type something here..." required>
                                                    <span class="input-group-append">
                                                        <button type="submit" style="box-shadow: none; background: linear-gradient(14deg, #fc5c04 0%, #f96c07); border: 1px solid #f96c07;"  class="btn btn-dark" data-dismiss="modal"><i class="mdi mdi-send"></i></button>
                                                    </span>
                                                </div>                                                    
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>                                                                          
            </div>
        </div>
    </div>                     
</div>
<div class="modal fade compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: transparent;">
                <h5 class="modal-title mt-0" id="exampleModalLabel">Complaint</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-0 p-3">
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col">
                                <img src="{{ asset('uploads/appsetting/' . $data['doc']) }}" alt="user" class="rounded-circle thumb-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function(){ 
        var complaint = $("#complaint").val();
        var userid = $("#userid").val();
        var tem1 = null;
    });
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
    });
    document.onkeydown = function (){
        if(window.event.keyCode == '13'){
            // submitForm();
        }
    }
</script>
<script>
    $(function(){
        $('form').on('submit', function (e){
            function formatAMPM(date){
                var hours = date.getHours();
                var minutes = date.getMinutes();
                var ampm = hours >= 12?'PM':'AM';
                hours = hours % 12;
                hours = hours ? hours:12;
                minutes = minutes < 10?'0'+minutes:minutes;
                var strTime = hours+':'+minutes+' '+ampm;
                return strTime;
            }
            var msg = $("#message").val();
            var img = $("#imageUser").val();
            var timeCurrent = formatAMPM(new Date);
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: 'chats/',
                data: $('form').serialize(),
                success: function(){
                    var complaint = $("#complaint").val();
                    document.getElementById("Chatform").reset();
                    var userid = $("#userid").val();
                    console.log("userid");
                    console.log(userid);
                    console.log("userid");
                    var loginid = $("#loginid").val();
                    var tem1 = null;
                        $.ajax({     
                            type: 'GET',
                            url: 'chat/'+complaint+'/'+userid,
                            dataType: "json",
                            success: function(data){
                                $("#Dis2").append('<div class="media my-2"> '+                                                       
                                                        '<div class="media-body reverse px-1">'+
                                                            '<div class="chat-msg my-1" style="float: right;">'+                                                
                                                            '<small class="text-muted px-1">'+timeCurrent+'</small>'+
                                                                '<p class="py-2 px-3">'+msg+'</p>'+
                                                            '</div> '+                                                           
                                                        '</div>'+
                                                        '<div class="media-img mt-1">'+ 
                                                            '<img src="uploads/appsetting/'+img+'" alt="user 2" class="rounded-circle thumb-sm">'+                                                                                      
                                                        '</div>'+
                                                    '</div>');

                            }
                        });
                }
            });
        });
    });
</script>
<script>
    $(".complete").click(function(){
        var id = $(this).attr("data-id");
        $("#complete-user").attr("data-id", id);
        $('#exampleModalCenter5').modal('show');
    });
    $(".reject").click(function(){
        var id = $(this).attr("data-id");
        $("#reject-user").attr("data-id", id);
        $('#exampleModalCenter6').modal('show');
    });
    $("#complete-user").click(function(){
        var id = $(this).attr("data-id");
        complete(id);
    });
    function complete(id){
        console.log("complete");
        $.ajax({
                type: 'GET',
                url: 'completeComplaint/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Complaint Completed',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            });
        }
    $("#reject-user").click(function(){
        var id = $(this).attr("data-id");
        reject(id);
    });
    function reject(id){
        $.ajax({
                type: 'GET',
                url: 'rejectComplaint/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Complaint Re-Opened',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong',
                        });
                    }
                }
            });
        }
</script>
<script src="plugins/filter/isotope.pkgd.min.js"></script>
<script src="plugins/filter/masonry.pkgd.min.js"></script>
<script src="plugins/filter/jquery.magnific-popup.min.js"></script>
<script src="assets/pages/jquery.gallery.init.js"></script>
@endsection