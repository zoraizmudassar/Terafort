@extends('layouts.admin-layout')
@section('content')
<link href="plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
<link href="plugins/lightpick/lightpick.css" rel="stylesheet" />
<style>
    .file-upload .file-upload-select{
        display: block;
        color: black;
        cursor: pointer;
        text-align: left;
        background: #bdc2c7;
        overflow: hidden;
        position: relative;
        border-radius: 6px;
    }
    .file-upload .file-upload-select .file-select-button{
        background: #bdc2c7;
        padding: 10px;
        display: inline-block;
    }
    .file-upload .file-upload-select .file-select-name{
        display: inline-block;
        padding: 10px;
    }
    .file-upload .file-upload-select:hover .file-select-button{
        background: #324759;
        color: #ffffff;
        transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -webkit-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
    }
    .file-upload .file-upload-select input[type="file"]{
        display: none;
    }
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
    .lightpick{
        box-shadow: none;
    }
    .lightpick.lightpick--inlined{
        z-index: auto;
    }
    #loader1 
    {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        /* background: url("/img/photos/terafort.jpeg") 50% 50% no-repeat black;    */
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Dashboard</h4>
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
                                @if(isset($complain['null']))
                                <h3 class="text-dark" id="noAction">{{$complain['null']}}</h3>
                                @else
                                <h3 class="text-dark" id="noAction">0</h3>
                                @endif
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
                                @if(isset($complain['process']))
                                <h3 class="text-dark" id="Process">{{$complain['process']}}</h3>
                                @else
                                <h3 class="text-dark" id="noAction">0</h3>
                                @endif
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
                                @if(isset($complain['final']))
                                <h3 class="text-dark" id="Process">{{$complain['final']}}</h3>
                                @else
                                <h3 class="text-dark" id="noAction">0</h3>
                                @endif
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
                                @if(isset($complain['complete']))
                                <h3 class="text-dark" id="Process">{{$complain['complete']}}</h3>
                                @else
                                <h3 class="text-dark" id="noAction">0</h3>
                                @endif
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
                                <h3 class="text-dark" id="complete">0</h3>
                                <h6 class="font-14 text-dark">total</h6>                                                                                                                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body">   
                                <div class="row py-2">
                                    <div class="apexchart-wrapper">
                                        <div id="ana_device" class="apex-charts mt-2"></div>
                                    </div>
                                </div>      
                            </div>                     
                        </div>                     
                    </div>    
                </div>
            </div>
        </div>
        <div class="row">
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
        <div class="row mb-5">
            <div class="col-lg-4 mb-5">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-datepick">
                            <input type="hidden" id="light_datepick"/>
                        </div>
                    </div>
                </div>                                                                                          
            </div>
        </div>               
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script src="plugins/moment/moment.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="plugins/chartjs/chart.min.js"></script>
<script src="plugins/chartjs/roundedBar.min.js"></script>
<script src="plugins/lightpick/lightpick.js"></script>
<script src="assets/pages/jquery.sales_dashboard.init.js"></script>
<script>
$(document).ready(function(){ 
	$("#loader1").fadeOut(500);
});
@if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            Swal.fire({
            icon: 'info',
            title: "Error!",
            text: "{{ session('message') }}",
        });
        break;
        case 'warning':
            Swal.fire({
            icon: 'warning',
            text: "{{ session('message') }}",
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
        });
        break;
    }
@endif
</script>
<script>
    $(document).ready(function(){ 
        $.ajax({
            type: 'GET',
            url: 'count',
            dataType: "json",
            success: function(data){
                if(data){
                    console.log("Complain Data");
                    console.log(data);
                    var Complete = new Array();
                    var InProcess = new Array();
                    var NoAction = new Array();
                    var Closed = new Array();
                    var Month = new Array();
                    for(i=0;i<data.length;i++){
                        Complete[i] = data[i].Complete,
                        InProcess[i] = data[i].InProcess,
                        NoAction[i] = data[i].NoAction,
                        Closed[i] = data[i].Closed,
                        Month[i] = data[i].Month
                    }
                    var options = {
                        chart: {
                            height: 340,
                            type: 'bar',
                            toolbar: {
                                show: false
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                endingShape: 'rounded',
                                columnWidth: '30%',
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 3,
                            colors: ['transparent'],
                        },
                        colors: ["#f14b4b", "#1eca7b", "#ffb822", "#0dc8de"],
                        series: [{
                            name: 'No Action',
                            data: NoAction
                        }, {
                            name: 'Complete',
                            data: Complete
                        },{
                            name: 'In Process',
                            data: InProcess
                        },{
                            name: 'Closed',
                            data: Closed
                        },],
                        xaxis: {
                        categories: Month,
                        axisBorder: {
                            show: true,
                            color: '#f7f8f9',
                        },  
                        axisTicks: {
                            show: true,
                            color: '#bec7e0',
                        },    
                        },
                        yaxis: {
                            labels:{
                            formatter: (val) => {
                                return val 
                            }
                            },
                            title: {
                                text: 'Complaints',
                            }
                        },
                        legend: {    
                            offsetY: -10
                        },
                        
                        fill: {
                            opacity: 1

                        },
                        grid: {
                            row: {
                                colors: ['transparent', 'transparent'],
                                opacity: 0.2
                            },
                            borderColor: '#f1f3fa'
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val 
                                }
                            }
                        }
                    }
                    var chart = new ApexCharts(document.querySelector("#budgets_chartt"), options);
                    chart.render();        
                }
            }
        });
    }) 
</script>
@endsection