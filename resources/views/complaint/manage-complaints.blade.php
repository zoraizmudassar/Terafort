@extends((Auth::user()->role == 'Admin') ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    .apexcharts-legend.position-bottom.left, .apexcharts-legend.position-top.left, .apexcharts-legend.position-right, .apexcharts-legend.position-left {
        align-items: flex-start;
        justify-content: flex-start;
    }
    .apexcharts-legend.position-bottom.center, .apexcharts-legend.position-top.center {
        justify-content: center;
        display: none;
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="page-content">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Manage Complaints</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Manage Complaints</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">  
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body"> 
                                <div class="icon-info mb-3">
                                    <i class="fas fa-ticket-alt bg-soft-danger"></i>
                                </div>
                                <h3 class="text-dark" id="noAction">{{$noAction}}</h3>
                                <h6 class="font-14 text-dark">No Action</h6>                                                                                                                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body"> 
                                <div class="icon-info mb-3">
                                    <i class="dripicons-hourglass card-eco-icon text-warning align-self-center bg-soft-warning"></i>
                                </div>
                                <h3 class="text-dark" id="Process">{{$Process}}</h3>
                                <h6 class="font-14 text-dark">In Process</h6>                                                                                                                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body"> 
                                <div class="icon-info mb-3">
                                    <i class="dripicons-checkmark card-eco-icon text-secondary align-self-center bg-soft-secondary"></i>
                                </div>
                                <h3 class="text-dark" id="final">{{$final}}</h3>
                                <h6 class="font-14 text-dark">Closed</h6>                                                                                                                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body"> 
                                <div class="icon-info mb-3">
                                    <i class="mdi mdi-checkbox-multiple-marked-circle-outline bg-soft-success"></i>
                                </div>
                                <h3 class="text-dark" id="complete">{{$complete}}</h3>
                                <h6 class="font-14 text-dark">Complete</h6>                                                                                                                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body"> 
                                <div class="icon-info mb-3">
                                    <i class="mdi mdi-file-document-box-multiple bg-soft-dark"></i>
                                </div>
                                <h3 class="text-dark" id="total">{{$total}}</h3>
                                <h6 class="font-14 text-dark">Total</h6>                                                                                                                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body"> 
                                <h3 class="text-dark" id="total"></h3>
                                <h6 class="font-14 text-dark">Departments</h6>                                                                                                                            
                            </div>
                        </div>
                    </div>                    
                </div>                                                                         
            </div>
        </div>
        <div class="row" hidden>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="apexchart-wrapper">
                            <div id="budgets_chart" class="apex-charts"></div>
                        </div>
                    </div>                                                                                             
                </div>
            </div>
        </div>
        <div class="row" hidden>                        
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">  
                        <h4 class="header-title mt-0">Complaints Status</h4>                                                                    
                        <div class="">
                            <div id="ana_dash_1" class="apex-charts"></div>
                        </div>  
                    </div>                           
                </div>
            </div>
        </div>
        <div class="row">                        
            <div class="col-lg-12 mb-5">
                <div class="card">
                    <div class="card-body">
                        @if($diff != 'empty')
                        <p class="badge badge-soft-dark font-11 mx-1 p-3 mb-1 float-md-none">
                            Last Complaint {{$diff}} Ago 
                            <span style="font-size: medium;"> &#128344; </span>
                        </p>
                        @endif
                        <div class="card-body table-responsive p-5">
                            <div class="">
                                <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th hidden>#</th>
                                            <th data-orderable="false">Sr. No</th>
                                            <th data-orderable="false">Employee</th>
                                            <th data-orderable="false">Location</th>
                                            <th data-orderable="false">Department</th>
                                            <th data-orderable="false">Status</th>
                                            <th data-orderable="false">File</th>
                                            <th data-orderable="false">Date & Time</th>
                                            <th data-orderable="false">Operator</th>
                                            <th data-orderable="false">Closing Date</th>
                                            <th data-orderable="false">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($support as $value) 
                                        <tr>
                                            <td hidden>{{$i++}}</td>
                                            <td style="width: 5%;">{{$value['data']['id']}}</td>
                                            <td>
                                                <?php $explode = explode(" ",$value['name']); ?>
                                                @foreach($explode as $row)
                                                    {{$row}}<br>
                                                @endforeach
                                            </td>
                                            <td>{{$value['data']['location']}}</td>
                                            <td style="text-transform: capitalize;">
                                                <?php $explode = explode(" ",$value['department']); ?>
                                                @foreach($explode as $row)
                                                    {{$row}}<br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($value['data']['status'] == 1)    
                                                <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-100">No Action</span>
                                                @elseif($value['data']['status'] == 2)
                                                <span class="badge badge-md badge-boxed badge-soft-warning p-2 w-100">In Process</span>
                                                @elseif($value['data']['status'] == 3)
                                                <span class="badge badge-md badge-boxed badge-soft-secondary p-2 w-100">Closed</span>
                                                @elseif($value['data']['status'] == 4)
                                                <span class="badge badge-md badge-boxed badge-soft-success p-2 w-100">Complete</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($value['data']['doc']) && !empty($value['data']['doc']))                                                 
                                                <span style="cursor: pointer; font-size: x-large; font-weight: 500; color: #303e67;">
                                                    <i class="mdi mdi-attachment" style="size:1px;"></i> 
                                                </span>
                                                @endif
                                            </td>
                                            @if($value['data']['updated_at'] == NULL)
                                            <td>
                                                <?php $result = $value['data']['created_at']; $time = $result->format('g:i A'); $day = $result->format('d-M-Y'); ?>
                                                <i class="mdi mdi-calendar-text-outline"></i> {{$day}} <br><i class="mdi mdi-timer"></i> {{$time}}
                                            </td>
                                            @else
                                            <td>
                                                <?php $result = $value['data']['created_at']; $time = $result->format('g:i A'); $day = $result->format('d-M-Y'); ?>
                                                <i class="mdi mdi-calendar-text-outline"></i> {{$day}} <br><i class="mdi mdi-timer"></i> {{$time}}
                                            </td>
                                            @endif                                            
                                            <td>
                                                @if($value['data']['approve_by'] != NULL)
                                                    <?php $explode = explode(" ",$value['data']['approve_by']); ?>
                                                    @foreach($explode as $row)
                                                        {{$row}}<br>
                                                    @endforeach
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($value['data']['updated_at']) && !empty($value['data']['updated_at'])) 
                                                    @if($value['data']['created_at'] != $value['data']['updated_at'])
                                                        <?php $result = $value['data']['updated_at']; $time = $result->format('g:i A'); $day = $result->format('d-M-Y'); ?>
                                                        <i class="mdi mdi-calendar-text-outline"></i> {{$day}} <br><i class="mdi mdi-timer"></i> {{$time}}
                                                    @else
                                                    -
                                                    @endif    
                                                @endif    
                                            </td>
                                            <td> 
                                                <span data-id="{{$value['data']['id']}}" class="badge btn-sm cursor-pointer SessionIdC badge-dark rounded-circle p-0" style="cursor: pointer; font-size: small; font-weight: 500;">
                                                    <i class="align-middle mb-1 mt-1 mx-1 cursor-pointer w-50" style="size:1px;" data-feather="eye"></i>
                                                </span>
                                            </td> 
                                        </tr>
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
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
        $("body").addClass("enlarge-menu");
    });
    $(".viewweye").click(function(){
        var id = $(this).attr("data-id");
        $("#delete-user").attr("data-id", id);
        $('#exampleModalCenter5').modal('show');
    });
    $("#delete-user").click(function(){
        var id = $(this).attr("data-id");
        deleteuser(id);
    })
    $(".SessionIdC").click(function(){
        var id = $(this).attr("data-id");
        document.cookie='CID='+id; 
        location.href = "complaints-view";
    });
    function deleteuser(id){
        $.ajax({
                type: 'GET',
                url: 'delete/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'User Delete Successfully!',
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
</script>
@endsection