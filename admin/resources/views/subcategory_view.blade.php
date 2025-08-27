<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">



<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>View Sub Category</title>

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



                            <h5 class="mb-0 btn btn-primary btn-md"><b>Category : </b>{{$category->name}} </h5>



                        </div>

                        <div class="container">

                            <div class="card">

                                <h5 class="card-header"> Sub Categories</h5>

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

                                                <th>Id</th>

                                                <th>Name</th>

                                                <th>Des</th>

                                                <th>Image</th>

                                                <th>Market Fee</th>

                                                <th>Status</th>

                                                <th>Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach($view as $key => $data)

                                            @php

                                            $key++;

                                            @endphp

                                            <tr>

                                                <td>{{$key}}</td>

                                                <td>{{$data->name}}</td>

                                                <td>{{$data->des}}</td>

                                                <td><a href="{{Storage::disk('s3')->url($data->folder.'/' .$data->img)}}" target="blank"><img class="table_img" src="{{Storage::disk('s3')->url($data->folder.'/' .$data->img)}}"></a></td>

                                                <td>{{$data->market_fee}}</td>

                                                <td>@if($data->status==1)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif</td>

                                                <td><a href="#myModal" class="btn btn-primary btn-sm add_sub_cat" data-id="{{$data->id}}" data-bs-toggle="modal" data-title="{{$data->name}}">Add Sub Cat</a>





                                                    <a href="{{url('managesubsubCategory',[$category->id,$data->id])}}" class="btn btn-primary btn-sm">View Sub Cat</a>



                                                    <a href="{{url('edit_sub_category',[$data->cat_id,$data->id])}}" class="btn btn-primary btn-sm"><i class=" bx bx-pencil"></i></a>

                                                    <form class="mb-3" action="{{url('/') }}/delete_sub_category" method="POST" type="button" onsubmit="return confirm('This category will be delete')">

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

                            <div class="modal-dialog modal-lg">

                                <div class="modal-content">



                                    <!-- Modal Header -->

                                    <div class="modal-header">

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                                    </div>



                                    <!-- Modal body -->

                                    <div class="modal-body">
                                        <h5 class="mb-5 btn btn-primary btn-md"><b>Category : </b>{{$category->name}} </h5>
                                        <h4 class="mb-5 btn btn-primary btn-md" id="sub_id_title"></h4>
                                        <form method="post" action="{{url('/') }}/managesubCategory">

                                            @csrf



                                            <input type="hidden" name="cat_id" class="form-control" value="{{$category->id}} " required />

                                            <input type="hidden" name="sub_id" id="sub_id" class="form-control" required />



                                            <div class="list_wrapper">

                                                <div class="row">



                                                    <div class="col-sm-10">

                                                        <div class="form-group mb-3">

                                                            <label class="form-label">Title <span class="">*</span></label>

                                                            <input type="text" class="form-control" name="sub_title[]">

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








                     

                    </div>

                </div>



                <footer class="default-footer">

                    @include('includes.footer')</footer>

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
    $(document).on("click", ".add_sub_cat", function() {

        var eventId = $(this).data('id');
        var eventtitle = $(this).data('title');

        document.getElementById("sub_id").value = eventId;
        document.getElementById('sub_id_title').innerHTML="Sub Category : "+eventtitle;

    });





    $(document).ready(function() {

        var x = 0; //Initial field counter

        var list_maxField = 10; //Input fields increment limitation

        $('.list_add_button').click(function() {

            if (x < list_maxField) {

                x++; //Increment field counter

                var list_fieldHTML = '<div class="row"><div class="col-sm-10"><div class="form-group mb-3"><label class="form-label">Title</label><input type="text" class="form-control" name="sub_title[]" required> </div> </div><div class="col-sm-1"><label class="form-label">Remove<span class="required"></span></label><button type="button" class="list_remove_button btn btn-danger"><i class="menu-icon tf-icons bx bx-minus"></i></button></div></div> ';

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