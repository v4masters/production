<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <title>Manage Set Items</title>
    <meta name="description" content="">
    <!-- Headerscript -->
    @include('includes.header_script')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('includes.sidebar')
            <!-- Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('includes.header')
                <!-- Navbar -->

                <!-- Centered Form -->
                <div class="container mt-3">
                    <div class="card">
                        <h5 class="card-header">Display Set Items</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Size Chart</th>
                                        <th data-visible="false" data-sortable="true">Item Type</th>
                                        <th data-visible="false" data-sortable="true">Item Code</th>
                                        <th>Item Name</th>
                                        <th>Class</th>
                                        <th>Company Name</th>
                                        <th data-visible="false" data-sortable="true">Cover Photo</th>
                                        <th data-visible="false" data-sortable="true">Cover Photo 2</th>
                                        <th data-visible="false" data-sortable="true">Cover photo 3</th>
                                        <th data-visible="false" data-sortable="true">Cover photo 4</th>
                                        <th data-visible="false" data-sortable="true">Discount(%)</th>
                                        <th data-visible="false" data-sortable="true">Updated On</th>
                                        <th>Weight/Size/Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventory as $key => $data)

                                    @php

                                    $key++;

                                    @endphp
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td><a href="{{Storage::disk('s3')->url($data->folder.'/' .$data->size_chart)}}" target="blank"><img class="table_img" src="{{Storage::disk('s3')->url($data->folder.'/' .$data->size_chart)}}"></a></td>
                                        <td> @if($data->item_type==1){{$item='School Set Item';}}@else {{$item='Inventory Item';}} @endif</td>
                                        <td>{{$data->itemcode}}</td>
                                        <td>{{$data->itemname}}</td>
                                        <td>{{$data->class_title}}</td>
                                        <td>{{$data->company_name}}</td>
                                        <td><a href="{{Storage::disk('s3')->url($data->folder.'/' .$data->cover_photo)}}" target="blank"><img class="table_img" src="{{Storage::disk('s3')->url($data->folder.'/' .$data->cover_photo)}}"></a></td>
                                        <td><a href="{{Storage::disk('s3')->url($data->folder.'/' .$data->cover_photo_2)}}" target="blank"><img class="table_img" src="{{Storage::disk('s3')->url($data->folder.'/' .$data->cover_photo_2)}}"></a></td>
                                        <td><a href="{{Storage::disk('s3')->url($data->folder.'/' .$data->cover_photo_3)}}" target="blank"><img class="table_img" src="{{Storage::disk('s3')->url($data->folder.'/' .$data->cover_photo_3)}}"></a></td>
                                        <td><a href="{{Storage::disk('s3')->url($data->folder.'/' .$data->cover_photo_4)}}" target="blank"><img class="table_img" src="{{Storage::disk('s3')->url($data->folder.'/' .$data->cover_photo_4)}}"></a></td>
                                        <td>{{$data->discount}}</td>
                                        <td>{{$data->updated_at}}</td>
                                        <td><a href="#" class="btn btn-primary btn-sm " onclick="view_size_data({{$data->id}})">View</a></td>
                                        <td>
                                            <ul class="list-inline">
                                                <li class="list-inline-item"><a href="{{url('edit_uniform_set_item',$data->id)}}" class="btn btn-success btn-sm"><i class=" bx bx-pencil"></i></a></li>

                                            </ul>

                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="myModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title"></h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <div id="uniformdata">


                                </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>





                <!-- Centered Form -->

                <!-- Footer -->
                <footer class="default-footer">
                    @include('includes.footer')
                </footer>
                <!-- / Footer -->
                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- Layout page -->
    </div>

    <!-- Overlay and Footer Script -->
    <div class="layout-overlay layout-menu-toggle"></div>
    @include('includes.footer_script')
    <!-- Footerscript -->


    <script>
        function view_size_data(item_id) {
            // Get Available Stock
            $.ajax({

                url: "{{url('/')}}/uni_set_detail",
                data: {
                    "id": item_id,
                    _token: '{{csrf_token()}}'
                },
                type: 'post',
                cache: false,
                success: function(response) {

                    // var x = JSON.parse(response);
                    //  alert(item_id);
                    var count = response.length;
                    var content = "";
                    content += "<table class='table'><thead><tr><th>S.No.</th><th>Size</th><th>Weight</th><th> UnitPrice<br>(Inc GST)</th><th>Barcode</th><th>Hsncode</th><th>GST</th><th>Qty</th><tr></thead><tbody>";

                    if (count != 0) {
                        var i = 0;
                        for (i = 0; i < count; i++) {
                            x = i + 1;
                            content += "<tr><td>" + x + "</td><td>" + response[i].size + "</td><td>" + response[i].weight + "gm</td><td>" + response[i].price_per_size + "</td><td>" + response[i].uni_barcode + "</td><td>" + response[i].uni_hsncode + "</td><td>" + response[i].gst_title + "</td><td>" + response[i].uni_qty + "</td></tr>";
                        }
                    }

                    content += "</tbody>	</table>";
                    $("#uniformdata").html(content);
                    $("#myModal").modal("show");

                }
            });
        }
    </script>
</body>

</html>