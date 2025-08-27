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
                                        <th>Item Type</th>
                                        <th>Item Name</th>
                                        <th>Barcode</th>
                                        <th>Hsncode</th>
                                        <th>Description</th>
                                        <th>Status</th>
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
                                        <td>{{$data->item_type}}</td>
                                        <td>{{$data->itemname}}</td>
                                        <td>{{$data->barcode}}</td>
                                        <td>{{$data->hsncode}}</td>
                                        <td>{{$data->item_type}}</td>
                                        <td>@if($data->status==1)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif</td>
                                        <td>

                                            <ul class="list-inline">
                                                <li class="list-inline-item"><a href="{{url('set_items_view',$data->id)}}" class="btn btn-primary btn-sm "><i class="bi bi-eye-fill " title="View"></i></a></li>
                                                <li class="list-inline-item"><a href="{{url('#',$data->id)}}" class="btn btn-success btn-sm"><i class=" bx bx-pencil"></i></a></li>
                                                <li class="list-inline-item">

                                                    <form class="mb-3" action="{{url('/') }}/#" method="POST" type="button" onsubmit="return confirm('This Set Item will be delete')">

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
</body>

</html>