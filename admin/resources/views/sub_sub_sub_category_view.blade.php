<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">



<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>View Sub Sub sub Category</title>

    <meta name="description" content="" />

    @include('includes.header_script')


    <style>
        .subcats {
            border: 4px solid #E7E7FF;
            background-color: #E7E7FF;
            color: #696CFF;
        }

        .subcats:hover {
            border: 4px solid #E7E7FF;
            background-color: #E7E7FF;
            color: #696CFF;
        }
    </style>

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

                            <div class="container">

                                <div class="row">

                                    <div class="col-md-12">
                                        <h5 class="mb-0 btn subcats btn-md"><b>Category : </b>{{$category->name}}</h5>
                                    </div>

                                </div>

                                <br>

                                <div class="row">

                                    <div class="col-md-12 ">
                                        <h5 class="mb-0 btn btn-primary btn-md"><b>Sub Category : {{$subcategory->name}}</b></h5>
                                    </div>

                                </div> <br>

                                <div class="row">

                                    <div class="col-md-12 ">
                                        <h5 class="mb-0 btn subcats  btn-md"><b>Sub Sub Category : </b>{{$subcategory_two->title}}</h5>
                                    </div>

                                </div>

                            </div>

                        </div>



                        <div class="container">

                            <div class="card">

                                <h5 class="card-header">Sub Categories</h5>

                                <div class="table-responsive text-nowrap">

                                    <table class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 200, 500, 1000 all]" data-show-footer="true" data-response-handler="responseHandler">

                                        <thead>

                                            <tr>

                                                <th>Id</th>

                                                <th> Title</th>


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

                                                <td>{{$data->title}}</td>


                                                <td>@if($data->status==1)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif</td>

                                                <td>
                                                    <a href="{{url('viewsubsubsubCategorysize',[$data->cat_id,$data->sub_cat_id,$data->sub_cat_id_two,$data->id])}}" class="btn btn-primary btn-sm">View Size</a>

                                                    <a href="{{url('edit_sub_sub_sub_category',[$data->cat_id,$data->sub_cat_id,$data->sub_cat_id_two,$data->id])}}" class="btn btn-primary btn-sm"><i class=" bx bx-pencil"></i></a>

                                                    <form class="mb-3" action="{{url('/') }}/delete_sub_sub_sub_category" method="POST" type="button" onsubmit="return confirm('This category will be delete')">

                                                        @csrf

                                                        <input type="hidden" name="id" class="form-control" value="{{$data->id}}" />

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

                    </div>

                    <footer class="default-footer">

                        @include('includes.footer')</footer>

                    <div class="content-backdrop fade"></div>

                </div>

            </div>

        </div>

        <div class="layout-overlay layout-menu-toggle"></div>

        @include('includes.footer_script')



</body>

<script>
    $(document).on("click", ".edit_sub_cat", function() {


        var id = $(this).data('editid');
        var edittitle = $(this).data('edittitle');
        var edit_status = $(this).data('edit_status');

        document.getElementById("editid").value = id;
        document.getElementById("edittitle").value = edittitle;

        var statusoption = $('#edit_status').children('option[value="' + edit_status + '"]');
        statusoption.attr('selected', true);

    });
</script>

</html>