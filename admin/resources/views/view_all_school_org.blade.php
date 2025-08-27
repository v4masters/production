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
                        <div class="card-header  justify-content-between align-items-center">

                            <h4 class="">Display School </h4>
                            <h5 class="btn btn-primary "><b>Organisation : </b>{{$organisation->name}} </h5>

                        </div>
                        
                       
                       
                        <div class="table-responsive text-nowrap">
                            <table id="table" class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>School </th>
                                        <th>Code</th>
                                        <th>Address</th>
                                        <th>Set Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($school as $key => $data)

                                    @php
                                    $key++;
                                    
                                    $updated = DB::table('school_set_vendor')->where('org', $organisation->id)->where('school_id',$data->id)->get(); 
                                    $totalupdated=count($updated);
                                    
                                    $totalschoolset = DB::table('school_set')->where('org', $organisation->id)->where('school_id',$data->id)->get(); 
                                    $allschoolset=count($totalschoolset);

                                    @endphp
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$data->school_name}}</td>
                                        <td>{{$data->school_code}}</td>
                                        <td>{{$data->school_address}}</td>
                                        <td>
                                            @if($allschoolset - $totalupdated == 0)
                                           
                                            @else
                                            <p class="btn btn-sm btn-danger">{{$allschoolset - $totalupdated}} pending</p>
                                            @endif
                                            </td>
                                        <td><a href="{{url('view_all_schoolset',[$organisation->id,$data->id])}}" class="btn btn-primary">View All Set</a></td>
                                    
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

	
