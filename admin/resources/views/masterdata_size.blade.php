<!DOCTYPE html>



<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">



<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

    <title>Manage Size</title>

    <meta name="description" content="" />



    <!-- headerscript -->

    @include('includes.header_script')

    <style>
        .imagePreview {
            width: 100%;
            height: 200px;
            background-position: center center;
            background: url(https://tamilnaducouncil.ac.in/wp-content/uploads/2020/04/dummy-avatar.jpg);
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }

        .imgUp {
            margin-bottom: 15px;
        }
    </style>

</head>



<body>



    <!-- Layout wrapper -->

    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            @include('includes.sidebar')

            <!-- / Menu -->

            <!-- Layout container -->

            <div class="layout-page">

                <!-- Navbar -->

                @include('includes.header')

                <!-- / Navbar -->

                <!-- Content wrapper -->

                <div class="content-wrapper">

                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">



                        <div class="card mb-4">

                            <div class="card-header d-flex justify-content-between align-items-center">

                                <h5 class="mb-0">Add Sizes</h5>

                                <small class="text-muted float-end"></small>

                            </div>

                            <div class="card-body">

                                <form action="{{url('/') }}/managesize" method="POST" enctype="multipart/form-data">

                                    @csrf

                                    @if ($errors->any())

                                    <div class="alert alert-danger">

                                        <ul>

                                            @foreach ($errors->all() as $error)

                                            <li>{{ $error }}</li>

                                            @endforeach

                                        </ul>

                                    </div>

                                    @endif

                                    @if(session('success'))

                                    <div class="alert alert-primary">

                                        {{ session('success') }}

                                    </div>

                                    @endif

                                    <div class="row ps-4 pe-5">
                                        <div class="col-md-3 mb-4 imgUp">
                                            <div class="form-group">
                                                <div class="imagePreview"></div>
                                                <label class="form-control btn btn-primary">Size Chart
                                                    <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="chart" />
                                                </label>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group mb-3">

                                                <label class="form-label">Title: <span class="required">*</span></label>

                                                <input type="text" class="form-control" name="title" required />

                                            </div>

                                        </div>
                                    
                                    </div>

                                    <div class="list_wrapper">

                                        <div class="row">

                                            <div class="col-sm-3">

                                                <div class="form-group mb-3">

                                                    <label class="form-label">Add Size <span class="">*</span></label>

                                                    <input type="text" class="form-control" name="sub_title[]" placeholder="size">

                                                </div>

                                            </div>

                                            <div class="col-sm-1">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group mb-3">

                                        <label class="form-label"><span class=""></span></label>

                                        <button type="button" class="list_add_button btn btn btn-primary">Add More <i class="menu-icon tf-icons bx bx-plus"></i></button>

                                        <br><br><br><br>

                                        <button type="submit" class="btn btn-success">Save </button>

                                    </div>



                                </form>

                            </div>

                        </div>



                        <div class="table-responsive text-nowrap">

                            <table class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-show-footer="true" data-response-handler="responseHandler">

                                <thead>

                                    <tr>

                                        <th>#</th>
                                        <th>chart</th>
                                        <th>Title</th>

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
                                        <td><a href="{{Storage::disk('s3')->url($data->folder.'/' .$data->chart)}}" target="blank"><img class="table_img" src="{{Storage::disk('s3')->url($data->folder.'/' .$data->chart)}}"></a></td>
                                        <td>{{$data->title}}</td>

                                        <td>@if($data->status==1)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif</td>

                                        <td>

                                            <a href="#myModal" class="btn btn-primary btn-sm add_sub_size" data-bs-toggle="modal" data-id="{{$data->id}}" data-title="{{$data->title}}"> <i class="bx bx-plus"></i> Add </a>

                                            <a href="{{url('view_sizelist',$data->id)}}" class="btn btn-primary btn-sm">View</a>

                                            <a href="{{url('editmastersize',$data->id)}}" class="btn btn-primary btn-sm"><i class=" bx bx-pencil"></i></a>

                                            <form class="mb-3" action="{{url('/') }}/deletesize" method="POST" type="button" onsubmit="return confirm('This size will be delete')">

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



                    <div class="modal" id="myModal">

                        <div class="modal-dialog modal-xl">

                            <div class="modal-content">



                                <!-- Modal Header -->

                                <div class="modal-header">

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                                </div>

                                <!-- Modal body -->

                                <div class="modal-body">
                                    <h4 class="mb-5 btn btn-primary btn-md" id="size_title"></h4>

                                    <form method="post" action="{{url('/') }}/add_sizelist_again" enctype="multipart/form-data">

                                        @csrf

                                        <input type="hidden" name="size_id" id="size_id" class="form-control" required />

                                        <div class="list_wrapper">

                                            <div class="row">

                                                <div class="col-sm-3">

                                                    <div class="form-group mb-3">

                                                        <label class="form-label">Add Size<span class="">*</span></label>

                                                        <input type="text" class="form-control" name="sub_title[]" placeholder="size">
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




                    <!-- Footer -->

                    <footer class="default-footer">

                        @include('includes.footer')

                        <!-- Footer -->

                        <div class="content-backdrop fade"></div>

                </div>

                <!-- Content wrapper -->

            </div>

            <!-- Layout page -->

        </div>

        <!-- Overlay -->

        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Layout wrapper -->

        @include('includes.footer_script')

        <!-- Footerscript-->

    </div>

    </div>

    </div>

    </div>



</body>

<script>
    $(document).on("click", ".add_sub_size", function() {

        var eventId = $(this).data('id');
        var eventtitle = $(this).data('title');

        document.getElementById("size_id").value = eventId;
        document.getElementById('size_title').innerHTML = "Category:" + eventtitle;

    });






    $(document).ready(function() {

        var x = 0; //Initial field counter

        var list_maxField = 10; //Input fields increment limitation

        $('.list_add_button').click(function() {

            if (x < list_maxField) {

                x++; //Increment field counter

                var list_fieldHTML = '<div class="row"> <div class="col-sm-3"><div class="form-group mb-3"><input type="text" class="form-control"  placeholder="size" name="sub_title[]" value="" required> </div> </div><div class="col-sm-1"><label class="form-label">Remove<span class="required"></span></label><button type="button" class="list_remove_button btn btn-danger"><i class="menu-icon tf-icons bx bx-minus"></i></button></div></div> ';

                $('.list_wrapper').append(list_fieldHTML); //Add field html

            }

        });



        //Once remove button is clicked

        $('.list_wrapper').on('click', '.list_remove_button', function() {

            $(this).closest('.row').remove(); //Remove field html

            x--; //Decrement field counter

        });

    });

    $(function() {
        $(document).on("change", ".uploadFile", function() {
            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function() { // set image data as background of div
                    //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                    uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + this.result + ")");
                }
            }

        });
    });
</script>



</html>