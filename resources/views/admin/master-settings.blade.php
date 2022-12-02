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
    #loader1 {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/giphy (1).gif") 50% 50% no-repeat black;    
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-2">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Master Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">Master Settings</h4>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-2 col-md-0 col-sm-0 mb-5">
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Category</h3>
                    </div>
                    <form action="{{url('add-category')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Category</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #d9d8d8;" id="category" name="category" placeholder="Category" required>
                            </div>
                        </div>
                        <div class="form-group row py-1">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Category Description</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #d9d8d8;" id="category_desc" name="category_desc" placeholder="Category Description" required>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #fc5c04 0%, #f96c07);" class="btn px-5 py-1 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenter" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #fc5c04 0%, #f96c07);" class="btn px-5 py-1 btn-lg btn-block text-white">Show All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Sub Category</h3>
                    </div>
                    <form action="{{url('add-sub-category')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Category</b></label>
                                <select style="border: 1px solid #d9d8d8;" id="category" name="category" class="form-control select.custom-select" required>
                                    <option selected disabled>Select Category</option>                                            
                                    @foreach($category as $name)
                                        <option value="{{ $name->category }}">{{ $name->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-1">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Sub Category Description</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #d9d8d8;" id="category_desc" name="category_desc" placeholder="Sub Category Description" required>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #fc5c04 0%, #f96c07);" class="btn px-5 py-1 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenter1" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #fc5c04 0%, #f96c07);" class="btn px-5 py-1 btn-lg btn-block text-white">Show All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-0 col-sm-0 mb-5">
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
@include('model/subcategory')
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="datatable2" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                     <thead>
                        <tr>
                            <th>No</th>
                            <th>Category</th>
                            <th>Category Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category as $num)
                        <tr>
                            <td>{{$j++}}</td>
                            <td>{{$num->category}}</td>
                            <td>{{$num->category_desc}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>     
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
    });
</script>
@endsection