<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

    <title>Manage User Student</title>

    <meta name="description" content="" />

    <!-- headerscript -->

    @include('includes.header_script')

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

                        <div class="table-responsive text-nowrap">

                            <table class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-show-footer="true" data-response-handler="responseHandler">

                                <thead>

                                    <tr>

                                        <th>#</th>
                                        <th>Student info</th>
                                        
                                        <th>School Code</th>
                                        
                                        <th>Address</th>
                                        
                                        <th data-visible="false" data-sortable="true">Registered On</th>

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

                                        <td>{{$data->unique_id}}<br>
                                        {{$data->name}}<br>
                                        {{$data->email}}<br>
                                       <i class="tf-icons bx bx-phone"></i>{{$data->phone_no}}<br>
                                       @if($data->user_type==1)Customer @else Student @endif
                                       </td>

                                        
                                        <td>{{$data->school_code}}<br>{{$data->school_name}}<br>{{$data->school_address}}</td>

                                        <td>{{$data->country}}<br>
                                            {{$data->state}}<br>
                                            {{$data->district}}<br>
                                            {{$data->city}}<br>
                                            {{$data->address}}<br>
                                            {{$data->landmark}}<br>
                                            ( {{$data->pincode}} )</td>
                                        
                                         <td>{{$data->created_at}}</td>

                                        <td>@if($data->status==1)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif</td>

                                        <td>

                                            <ul class="list-inline">

                                                <li class="list-inline-item"><a href="{{url('edit_user_student',$data->id)}}" class="btn btn-primary btn-sm"><i class=" bx bx-pencil"></i></a></li>
                                                <li class="list-inline-item">

                                                    <form class="mb-3" action="{{url('/') }}/deleteuser_student" method="POST" type="button" onsubmit="return confirm('This Student will be delete')">

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

</html>