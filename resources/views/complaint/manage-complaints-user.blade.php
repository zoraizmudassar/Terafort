@extends((Auth::user()->role == 'Admin') ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    #loader1{  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/giphy (1).gif") 50% 50% no-repeat black;    
    }
    .apexcharts-legend.position-bottom.left, .apexcharts-legend.position-top.left, .apexcharts-legend.position-right, .apexcharts-legend.position-left{
        align-items: flex-start;
        justify-content: flex-start;
    }
    .apexcharts-legend.position-bottom.center, .apexcharts-legend.position-top.center{
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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Complaint</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Complaint</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">  
                <div class="row">
                    <div class="col-lg-3">
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
                    <div class="col-lg-3">
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
                    <div class="col-lg-3">
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
                    <div class="col-lg-3">
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
                    <div class="col-lg-2" hidden>
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
                    <div class="col-lg-2" hidden>
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body">   
                                <div class="row py-2">
                                    <div class="apexchart-wrapper">
                                        <div id="budgets_chart" class="apex-charts mt-2"></div>
                                    </div>
                                </div>      
                            </div>                     
                        </div>                     
                    </div>                      
                </div>                                                                         
            </div>
        </div>
        <div class="row">                        
            <div class="col-lg-12 mb-5">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body table-responsive p-5">
                            <div class="">
                                <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th hidden>#</th>
                                            <th>Complaint No</th>
                                            <th>Employee</th>
                                            <th>Status</th>
                                            <th>Category</th>
                                            <th>Date & Time</th>
                                            <th>Operator</th>
                                            <th>Closing Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($support as $value) 
                                        <tr>
                              
                                            <td hidden>{{$i++}}</td>
                                            <td>{{$value['data']['id']}}</td>
                                            <td>{{$value['name']}}</td>
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
                                            <td>{{$value['data']['category']}}</td>
                                            <td>
                                                <?php $result = $value['data']['created_at']; $time = $result->format('g:i A'); $day = $result->format('d-M-Y'); ?>
                                                <i class="mdi mdi-calendar-text-outline"></i> {{$day}} <br><i class="mdi mdi-timer"></i> {{$time}}
                                            </td>
                                            <td>{{$value['data']['approve_by']}}</td>
                                            <td>
                                                @if(isset($value['data']['updated_at']) && !empty($value['data']['updated_at'])) 
                                                    <?php $result = $value['data']['created_at']; $time = $result->format('g:i A'); $day = $result->format('d-M-Y'); ?>
                                                    <i class="mdi mdi-calendar-text-outline"></i> {{$day}} <br><i class="mdi mdi-timer"></i> {{$time}}
                                                @else
                                                -
                                                @endif                                            
                                            </td>
                                            <td> 
                                                <span data-id="{{$value['data']['id']}}" class="badge btn-sm badge-dark p-0 rounded-circle mx-1 SessionIdC" style="cursor: pointer">
                                                    <i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="eye"></i>
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
<script>
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
        $("body").addClass("enlarge-menu");
    });
    $(".SessionIdC").click(function(){
        var id = $(this).attr("data-id");
        document.cookie='CD='+id; 
        location.href = "complaints-view-user";
    });
</script>
<script src="plugins/moment/moment.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="plugins/chartjs/chart.min.js"></script>
<script src="plugins/chartjs/roundedBar.min.js"></script>
<script src="plugins/lightpick/lightpick.js"></script>
<script src="plugins/moment/moment.js"></script>
@endsection