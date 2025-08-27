<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">



<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>View Category</title>

    <meta name="description" content="" />

    @include('includes.header_script')

</head>

<body>

    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            @include('includes.sidebar')

            <div class="layout-page">

                @include('includes.header')

                <div class="container mt-3">

                    <div class="card mb-4">

                        <div class="card-header d-flex justify-content-between align-items-center">

                            <h5 class="mb-0">View category</h5>



                        </div>

                        <div class="container">

                            <div class="card">

                               

                                <div class="table-responsive text-nowrap">

                                <table class="table table-striped" 
                            data-toggle="table" 
                            data-toolbar="#toolbar" 
                            data-search="true" 
                            data-show-refresh="true" 
                            data-show-toggle="true" 
                            data-show-fullscreen="false"
                            data-show-columns="true" 
                            data-show-columns-toggle-all="true"
                            data-detail-view="false"
                            data-show-export="true"
                            data-click-to-select="true" 
                            data-detail-formatter="detailFormatter" 
                            data-minimum-count-columns="2"
                            data-show-pagination-switch="true" 
                            data-pagination="true" 
                            data-id-field="id" 
                            data-page-list="[10, 25, 50, 100, 200, 500, 1000 all]"
                            data-show-footer="true" 
                            data-response-handler="responseHandler">

                                        <thead>

                                            <tr>

                                                <th>#</th>

                                                <th> Name</th>

                                                <th>Des</th>

                                                <th> Image</th>

                                                <th>Market Fee</th>

                                                <th>Status</th>

                                                <th>Action</th>

                                            </tr>

                                        </thead>



                                        <tbody>

                                            @foreach($pagedata as $key => $data)

                                            @php

                                            $key++;

                                            @endphp

                                            <tr>

                                                <td>{{$key}}</td>

                                                <td>{{$data->name}}</td>

                                                <td>{{$data->des}}</td>

                                                <td><a href="{{Storage::disk('s3')->url($data->folder.'/'.$data->img)}}" target="blank"><img class="table_img" src="{{Storage::disk('s3')->url($data->folder.'/'.$data->img)}}"></a></td>

                                                <td>{{$data->market_fee}}</td>

                                                <td>@if($data->status==1)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif</td>

                                                <td>

                                                    <a href="#myModal" class="btn btn-primary btn-sm add_sub_cat" data-bs-toggle="modal" data-id="{{$data->id}}" data-title="{{$data->name}}" > <i class="bx bx-plus"></i> Add  </a>

                                                    <a href="{{url('managesubCategory',$data->id)}}" class="btn btn-primary btn-sm">  View</a>

                                                    <a href="{{url('edit_category',$data->id)}}" class="btn btn-primary btn-sm"><i class=" bx bx-pencil"></i></a>

                                                    <form class="mb-3" action="{{url('/') }}/delete_category" method="POST" type="button" onsubmit="return confirm('This category will be delete')">

                                                        @csrf

                                                        <input type="hidden" name="id" class="form-control" value="{{ $data->id }}" />

                                                        <button type="submit" class="btn btn-danger btn-sm"><i class=" bx bx-trash"></i></button>

                                                    </form>

                                                </td>

                                            </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                        

                        <div class="modal" id="myModal">

                            <div class="modal-dialog modal-xl">

                                <div class="modal-content">



                                    <!-- Modal Header -->

                                    <div class="modal-header">

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                                    </div>



                                    <!-- Modal body -->

                                    <div class="modal-body">
                                    <h4 class="mb-5 btn btn-primary btn-md" id="cat_title"></h4>

                                        <form method="post" action="{{url('/') }}/view_Category" enctype="multipart/form-data">

                                            @csrf



                                            <input type="hidden" name="cat_id" id="cat_id" class="form-control"  required />



                                            <div class="list_wrapper">

                                                <div class="row">

                                                    <div class="col-sm-3">

                                                        <div class="form-group mb-3">

                                                            <label class="form-label">Icon<span class=""></span></label>

                                                            <input type="file" class="form-control" name="sub_img[]" >

                                                        </div>

                                                    </div>

                                                    <div class="col-sm-3">

                                                        <div class="form-group mb-3">

                                                            <label class="form-label">Name<span class="">*</span></label>

                                                            <input type="text" class="form-control" name="sub_name[]" >

                                                        </div>

                                                    </div>

                                                    <div class="col-sm-3">

                                                        <div class="form-group mb-3">

                                                            <label class="form-label"> Description<span class=""></span></label>

                                                            <input type="text" class="form-control" id="disablecopypast" name="sub_des[]" >

                                                        </div>

                                                    </div>

                                                    <div class="col-sm-2">

                                                        <div class="form-group mb-3">

                                                            <label class="form-label"> Market Fee<span class="">*</span></label>

                                                            <input type="number" class="form-control" name="sub_market_fee[]" >

                                                        </div>

                                                    </div>



                                                    <div class="col-sm-1">

                                                    </div>

                                                </div>

                                            </div>



                                            <div class="form-group mb-3">

                                                <label class="form-label"></label>

                                                <button type="button" class="list_add_button btn btn btn-primary">Add More <i class="menu-icon tf-icons bx bx-plus"></i></button>

                                                <br><br><br><br>

                                                <button type="submit" class="btn btn-success">Save</button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                        

                        

                        

                        

                        <footer class="default-footer">

                            @include('includes.footer')

                            <div class="content-backdrop fade"></div>

                    </div>

                </div>

            </div>

            <div class="layout-overlay layout-menu-toggle"></div>

            @include('includes.footer_script')



        </div>

    </div>

</body>

<script>







$(document).on("click", ".add_sub_cat", function () {

     var eventId = $(this).data('id');
     var eventtitle = $(this).data('title');
     
     document.getElementById("cat_id").value=eventId;
     document.getElementById('cat_title').innerHTML="Size:"+eventtitle;

});







    $(document).ready(function() {

        var x = 0; //Initial field counter

        var list_maxField = 10; //Input fields increment limitation

        $('.list_add_button').click(function() {

            if (x < list_maxField) {

                x++; //Increment field counter

                var list_fieldHTML = '<div class="row"> <div class="col-sm-3"><div class="form-group mb-3"><label class="form-label"> Icon</label><input type="file" class="form-control" name="sub_img[]" value="" > </div> </div><div class="col-sm-3"><div class="form-group mb-3"><label class="form-label"> Name<span class="required">*</span></label><input type="text" class="form-control"  placeholder="" name="sub_name[]" value="" required> </div> </div><div class="col-sm-3"><div class="form-group mb-3"><label class="form-label"> Description<span class="required"></span></label><input type="text" class="form-control" id="disablecopypast"  placeholder="" name="sub_des[]" value="" ></div> </div> <div class="col-sm-2"> <div class="form-group mb-3"> <label class="form-label"> Market Fee<span class="required">*</span></label><input type="number" class="form-control"  placeholder="" name="sub_market_fee[]" value="" required></div></div>	<div class="col-sm-1"><label class="form-label">Remove<span class="required"></span></label><button type="button" class="list_remove_button btn btn-danger"><i class="menu-icon tf-icons bx bx-minus"></i></button></div></div> ';

                $('.list_wrapper').append(list_fieldHTML); //Add field html

            }

        });



        //Once remove button is clicked

        $('.list_wrapper').on('click', '.list_remove_button', function() {

            $(this).closest('.row').remove(); //Remove field html

            x--; //Decrement field counter

        });

    });

</script>



</html>