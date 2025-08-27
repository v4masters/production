<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">



<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>View Inventory</title>

    <meta name="description" content="" />

    @include('includes.header_script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .input-group-text {
            padding: 0px 0px 0px 0px !important;
        }

        .input-group {
            width: 150px !important;
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

                            </div>

                        </div>

                        <div class="container">

                            <div class="card">

                                <h5 class="card-header">View All</h5>

                                <div class="table-responsive text-nowrap">

                                    <table class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">

                                        <thead>

                                            <tr>

                                                <th>Id</th>

                                                <!--<th data-visible="false" data-sortable="true">Image</th>-->

                                                <th>Product ID</th>

                                                <th>Product Name</th>

                                                <th data-visible="false" data-sortable="true">HSN Code</th>

                                                <th data-visible="false" data-sortable="true">Brand</th>

                                                <th data-visible="false" data-sortable="true">Class</th>

                                                <th data-visible="false" data-sortable="true">Colour</th>

                                                <th data-visible="false" data-sortable="true">Stream</th>

                                                <th data-visible="false" data-sortable="true">Edition</th>

                                                <th data-visible="false" data-sortable="true">Net Qty</th>

                                                <th data-visible="false" data-sortable="true">Qty Unit</th>

                                                <th data-visible="false" data-sortable="true">Min Qty</th>

                                                <th data-visible="false" data-sortable="true">Barcode</th>

                                                <th data-visible="false" data-sortable="true">Discount</th>

                                                <th data-visible="false" data-sortable="true">GST%</th>

                                                <th data-visible="false" data-sortable="true">Discounted Price</th>

                                                <th data-visible="false" data-sortable="true">Sales Rate</th>

                                                <th>Status</th>

                                                <th>Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach($pagedata as $key => $data)

                                            @php

                                            $key++;
                                            $sale_id="1001".$key;
                                            $net_quantity="1001".$key;
                                            
                                            $color = DB::table('master_colour')->where('id',$data->color)->where('del_status',0)->first(); 
                                            if($color) { $colortitle = $color->title;} else { $colortitle = '';}  
                                            
                                            $class = DB::table('master_classes')->where('id',$data->class)->where('del_status',0)->first(); 
                                            if($class) { $classtitle = $class->title; } else { $classtitle = ''; } 
                                            
                                            $brand = DB::table('master_brand')->where('id',$data->brand)->where('del_status',0)->first(); 
                                            if($brand) { $brandtitle = $brand->title; } else { $brandtitle = ''; } 
                                            
                                            $stream = DB::table('master_stream')->where('id',$data->stream)->where('del_status',0)->first(); 
                                            if($stream) { $streamtitle = $stream->title; } else { $streamtitle = ''; } 
                                            
                                            $qtyunit = DB::table('master_qty_unit')->where('id',$data->qty_unit)->where('del_status',0)->first(); 
                                            if($qtyunit) { $qtyunittitle = $qtyunit->title; } else { $qtyunittitle = ''; } 
                                            
                                            $gst = DB::table('master_taxes')->where('id',$data->gst)->where('del_status',0)->first(); 
                                            if($gst) { $gsttitle = $gst->title; } else { $gsttitle = ''; } 
                                            
                                            @endphp
                                            <tr>

                                                <td>{{$key}}</td>

                                                <!--<td> </td>-->

                                                <td>{{$data->product_id}}</td>

                                                <td>{{$data->product_name}}</td>

                                                <td>{{$data->hsncode}}</td>

                                                <td>{{$brandtitle}}</td>

                                                <td>{{$classtitle}}</td>

                                                <td>{{$colortitle}}</td>

                                                <td>{{$streamtitle}}</td>

                                                <td>{{$data->edition}}</td>

                                                <td>

                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="net_quantity" id="{{$net_quantity}}" value="{{$data->net_quantity}}" />

                                                        <span class="input-group-text">
                                                            <i class=" bx bx-check btn btn-primary btn-sm" onclick="update_net_quantity({{$data->id}},{{$net_quantity}})"></i>
                                                        </span>
                                                    </div>

                                                </td>

                                                <td>{{$qtyunittitle}}</td>

                                                <td>{{$data->min_qyt}}</td>

                                                <td>{{$data->barcode}}</td>

                                                <td>{{$data->discount}}</td>

                                                <td>{{$gsttitle}}%</td>

                                                <td><span class="me-3"><s>{{$data->mrp}}</s></span><span><b>{{$data->discounted_price}}</b></span></td>

                                                <td>
                                                    <div class="input-group">

                                                        <input type="number" class="form-control" name="sale_rate" id="{{$sale_id}}" value="{{$data->sale_rate}}" />

                                                        <span class="input-group-text">
                                                            <i class="bx bx-check btn btn-primary btn-sm" onclick="update_sale_rate({{$data->id}},{{$sale_id}})"></i>
                                                        </span>
                                                    </div>
                                                </td>

                                                <td>@if($data->status==1)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif</td>

                                                <td>
                                                    <ul class="list-inline">
                                                        
                                                         <li class="list-inline-item"><a href="{{url('inventory_detail',$data->id)}}" class="btn btn-primary btn-sm "><i class="bi bi-eye-fill " title="View"></i></a></li>
                                                        <li class="list-inline-item"> <a href="{{url('editapproveinventory',$data->id)}}" class="btn btn-primary btn-sm"><i class=" bx bx-pencil"></i></a> </li>
                                                        <li class="list-inline-item">
                                                            <form class="mb-3" action="{{url('/') }}/deleteform" method="POST" type="button" onsubmit="return confirm('This inventory will be delete')">

                                                                @csrf

                                                                <input type="hidden" name="id" class="form-control" value="{{ $data->id }}" />

                                                                <button type="submit" class="btn btn-danger btn-sm"><i class=" bx bx-trash"></i></button>
                                                        </li>
                                                        </form>
                                                    </ul>
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

                <footer class="default-footer">

                    @include('includes.footer')</footer>

                <div class="content-backdrop fade"></div>

            </div>

        </div>

    </div>

    <div class="layout-overlay layout-menu-toggle"></div>

    @include('includes.footer_script')

    <script>
        function update_sale_rate(id, sale_rate_id) {
            var sale_rate = document.getElementById(sale_rate_id).value;

            $.ajax({
                type: "POST",
                url: "{{url('/') }}/update_web_sale_rate",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "sale_rate": sale_rate
                },
                cache: false,
                success: function(response) {
                    window.location.reload();
                }
            });
        }

        function update_net_quantity(id, net_quantity_id) {
            var net_quantity = document.getElementById(net_quantity_id).value;

            $.ajax({
                type: "POST",
                url: "{{url('/') }}/update_web_net_quantity",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "net_quantity": net_quantity
                },
                cache: false,
                success: function(response) {
                    window.location.reload();
                }
            });
        }
    </script>
</body>

</html>