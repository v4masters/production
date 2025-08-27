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

                                                <th>Image</th>

                                                <th>Item Code</th>

                                                <th>Item Name</th>

                                                <th data-visible="false" data-sortable="true">Barcode</th>

                                                <th data-visible="false" data-sortable="true">Hsncode</th>

                                                <th data-visible="false" data-sortable="true">Item Type</th>

                                                <th>Class</th>

                                                <th data-visible="false" data-sortable="true">Gst(%)</th>

                                                <th data-visible="false" data-sortable="true">Discount</th>

                                                <th>Company Name</th>

                                                <th>Avail Qty</th>

                                                <th>Unit Price</th>

                                                <th>Item Weight</th>

                                                <th data-visible="false" data-sortable="true">Medium</th>

                                                <th data-visible="false" data-sortable="true">Description</th>
                                                
                                                <th data-visible="false" data-sortable="true">Updated on</th>
                                                
                                                <th>Edit</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach($pagedata as $key => $data)

                                            @php

                                            $key++;
                                            @endphp
                                            <tr>

                                                <td>{{$key}}</td>
                                                
                                                <td><a href="{{Storage::disk('s3')->url($data->folder.'/' .$data->cover_photo)}}" target="blank"><img class="table_img" src="{{Storage::disk('s3')->url($data->folder.'/' .$data->cover_photo)}}"></a></td>

                                                <td> {{$data->itemcode}}</td>
                                                
                                                <td> {{$data->itemname}}</td>

                                                <td>{{$data->barcode}}</td>

                                                <td>{{$data->hsncode}}</td>
                                                
                                                <td> @if($data->item_type==1){{$item='School Set Item';}}@else {{$item='Inventory Item';}} @endif</td>
                                                
                                                <td>{{$data->class_title}}</td>
                                                
                                                <td>{{$data->gst_title}}</td>
                                                
                                                <td>{{$data->discount}}</td>
                                                
                                                <td>{{$data->company_name}}</td>
                                                
                                                <td>{{$data->avail_qty}}</td>
                                                
                                                <td>{{$data->unit_price}}</td>
                                                
                                                <td>{{$data->item_weight}}</td>

                                                <td>{{$data->medium}}</td>

                                                <td> {{$data->description}}</td>
                                                
                                                 <td> {{$data->updated_at}}</td>
                                                 
                                                <td>
                                                    <ul class="list-inline">
                                                        
                                                       
                                                        <li class="list-inline-item"> <a href="{{url('edit_book_set_item',$data->id)}}" class="btn btn-primary btn-sm">Edit</a> </li>
                                                       
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
      
    </script>
</body>

</html>