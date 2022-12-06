@extends((Auth::user()->role == 'Admin') ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<link href="plugins/filter/magnific-popup.css" rel="stylesheet" type="text/css" />
<?php
    $id = Auth::user()->id;
    $image = DB::table("users")->where("id", $id)->pluck('image');
    $image = $image[0];
    $tem1 = null;
?>
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
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{url('manage-complaints')}}">Manage Complaints</a></li>
                            <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Manage Complaint</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Manage Complaint</h4>
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
                                    <div class="col-9">
                                        <div class="media mb-4">
                                        @if(isset($user['image']) && !empty($user['image'])) 
                                            <img class="d-flex mr-3 rounded-circle thumb-md" src="{{ asset('uploads/appsetting/' . $user['image']) }}" alt="Generic placeholder image">
                                        @else
                                            <img class="d-flex mr-3 rounded-circle thumb-md" src="img/avatars/avatar-2.jpg" alt="Generic placeholder image">
                                        @endif 
                                            <div class="media-body align-self-center">
                                                <h5 class="m-0">{{$user['name']}}</h5>
                                                <p style="letter-spacing: 0.4px; font-family: 'Poppins';" class="text-muted">{{$user['email']}}</p>
                                                <input type="text" id="loginid" name="loginid" value="{{Auth::user()->id}}" hidden>
                                                <input type="text" id="imageUser" name="imageUser" value="{{$image}}" hidden>
                                            </div>
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
                                        <span class="badge badge-md badge-boxed badge-danger p-2 my-2" style="font-size: small !important;">No Action</span>
                                        @elseif($data['status'] == 2)
                                        <span class="badge badge-md badge-boxed badge-warning p-2 my-2" style="font-size: small !important;">In Process</span>
                                        @elseif($data['status'] == 3)
                                        <span class="badge badge-md badge-boxed badge-secondary p-2 my-2" style="font-size: small !important;">Closed</span>
                                        @elseif($data['status'] == 4)
                                        <span class="badge badge-md badge-boxed badge-success p-2 my-2" style="font-size: small !important;">Complete</span>
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
                                <br>
                                @if($data['status'] != 4)
                                <a href="#custom-modal" style="border:none; background: linear-gradient(14deg, #fc5c04 0%, #f96c07);" class="btn waves-effect text-white" data-toggle="modal" data-animation="bounce" data-target=".compose-modal"><i class="mdi mdi-reply"></i> Reply</a>
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
                                <?php $month = $value['data']['updated_at']; $delimiter = ' '; $words = explode($delimiter, $month); ?>
                                    @if($tem1 == $words[0])
                                    @else
                                        <h5>{{$words[0]}}</h5>
                                        <?php $tem1 = $words[0]; ?>
                                    @endif
                                </div>
                                @if($value['data']['sender'] == Auth::user()->id)  
                                    <div class="media my-2">                                                        
                                        <div class="media-body reverse px-1">
                                            <div class="chat-msg my-1" style="float: right;">
                                            <?php $result = $value['data']['created_at']; $delimiter = ' '; $words = explode($delimiter, $result); ?>
                                                <small class="text-muted">{{$value['time']}}</small>
                                                <p class="py-2 px-3">{{$value['data']['message']}}</p>
                                            </div>                                                           
                                        </div>
                                        <div class="media-img mt-1">
                                        @if(isset($value['image']) && !empty($value['image'])) 
                                        <img src="{{ asset('uploads/appsetting/' . $value['image']) }}" alt="user" class="rounded-circle thumb-sm">
                                        @else
                                        <img src="img/avatars/avatar-2.jpg" alt="admin" class="rounded-circle thumb-sm">
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
                                        <?php $result = $value['data']['created_at']; $delimiter = ' '; $words = explode($delimiter, $result); ?>
                                            <p class="py-2 px-3">{{$value['data']['message']}}</p>
                                            <small class="text-muted">{{$value['time']}}</small>
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
                                <form id="Chatform" class="adminForm">
                                    @csrf
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
                                                        <button type="submit" style="box-shadow: none; background: linear-gradient(14deg, #fc5c04 0%, #f96c07); border: 1px solid #f96c07;" class="btn btn-dark" data-dismiss="modal"><i class="mdi mdi-send"></i></button>
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
                <h5 class="modal-title mt-0" id="exampleModalLabel">Response to Complainant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="card mb-0 p-3">
                    <form action="{{url('support')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col" hidden>
                                    <input hidden style="border: 1px solid #d1cccc;" value="{{$user['id']}}" type="text" class="form-control" id="id" name="id">
                                    <input hidden style="border: 1px solid #d1cccc;" value="{{$data['id']}}" type="text" class="form-control" id="complaint" name="complaint">
                                    <input hidden style="border: 1px solid #d1cccc;" value="{{$user['name']}}" type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="col">
                                    <label><b style="color: #6c757d">Status</b></label>
                                    <select style="border: 1px solid #bfbfbf;" id="status" name="status" class="form-control select.custom-select" required>
                                        <option value = 1 <?php if ($data['status'] == 1) echo "selected"; ?> disabled>No Action</option>
                                        <option value = 2 <?php if ($data['status'] == 2) echo "selected"; ?>>In Process</option>
                                        <option value = 3 <?php if ($data['status'] == 3) echo "selected"; ?>>Closed</option>                                        
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <textarea style="border: 1px solid #d1cccc;" class="form-control yourclass" rows="5" id="message" name="message" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <div class="pull-right">
                                <button style="border: none; background: linear-gradient(14deg, #fc5c04 0%, #f96c07);" class="btn waves-effect waves-light text-white"><span>Send</span><i class="far fa-paper-plane ml-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
    });
    document.onkeydown = function (){
        if(window.event.keyCode == '13'){
            // submitForm();
        }
    }
    setInterval(function()
    {
        
    }, 1000);
</script>
<script>
    $(function(){
        $('.adminForm').on('submit', function (e){
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
                url: 'chats1/',
                data: $('#Chatform').serialize(),
                success: function(){
                    var complaint = $("#complaint").val();
                    document.getElementById("Chatform").reset();
                    var userid = $("#id").val();
                    var loginid = $("#loginid").val();
                    var d = new Date();
                    var tem1 = null;
                        $.ajax({     
                            type: 'GET',
                            url: 'chat1/'+complaint+'/'+userid,
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
<script src="plugins/filter/isotope.pkgd.min.js"></script>
<script src="plugins/filter/masonry.pkgd.min.js"></script>
<script src="plugins/filter/jquery.magnific-popup.min.js"></script>
<script src="assets/pages/jquery.gallery.init.js"></script>
@endsection