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
                         <div class="card-header justify-content-between align-items-center">


                        <h5 class="card-header ">Display  Set Item </h5>
                        
                  
                  
                          <h4 style="text-align: left;" class="btn btn-primary text-left">
                          <b>Organisation : </b>{{$organisation->name}} <br>
                          <b>School : </b>{{$school->school_name}} <br>
                          <b>Set Id : </b>{{$school->set_id}} <br>
                          <b>Set Cat : </b>{{$school->cat_title}}<br>
                          <b>Set Class : </b>{{$school->setclass}}</h4>
                        
                        </div>
                        <div class="card-body">
                            
                        
                        <div class="table-responsive text-nowrap">
                            <table id="table" class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">
                                <thead>
                                    <tr>
                                        
                                        <th>#</th>
                                        <th>Itemname </th>
                                        <th>ItemCode</th>
                                        <th>Unit Price</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $key => $data)
                                  
                                    @php

                                    $key++;

                                    @endphp
                                    <tr>
                                        
                                        <td>{{$key}}</td>
                                         <!--<td>{{$data['cover_photo']}}</td>-->
                                        <td>{{$data['itemname']}}</td>
                                          <td>{{$data['itemcode']}}</td>
                                            <td>{{$data['unit_price']}}</td>
                                              <td>{{$data['qty']}}</td>
                                      
                                      
                                      
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
</body>

</html>

	
