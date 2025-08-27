<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />
    <title>Sales Report Item Wise</title>
    <meta name="description" content="" />
    <!-- Include header scripts -->
    @include('includes.header_script')
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('includes.sidebar')
            <div class="layout-page">
                @include('includes.header')
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card mb-4">
                            <div class="card-header justify-content-between align-items-center"></div>
                            <div class="card-body">
                                <form id="formAuthentication" class="mb-3" action="{{ url('/') }}/saleReportView" method="POST" enctype="multipart/form-data">

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
                                           

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">

                                                        <label class="form-label">From</label>
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-vendorname2" class="input-group-text"><i class="bx bx-buildings"></i></span>
                                                            <input type="date" class="form-control" name="from_date" placeholder="" value="{{$date_from}}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">

                                                        <label class="form-label">To</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                                            <input type="date" class="form-control" placeholder="" name="to_date" value="{{$date_to}}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                 <div class="col-sm-4">
                                                    <div class="form-group mb-3">

                                                        <label class="form-label">&nbsp;</label>
                                                        <div class="input-group input-group-merge">
                                                         
                                                            <button type="submit" class="btn btn-success">Get</button>        
                                                       </div>
                                                    </div>
                                                </div>
                                             
                                             
                                                 </div>
                                                   
                                               
                                        </form>
                        
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
                            data-show-pagination-switch="true" z
                            data-pagination="true" 
                            data-id-field="id" 
                            data-page-list="[10, 25, 50, 100, all]"
                            data-show-footer="true" 
                            data-response-handler="responseHandler">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>SKU No.</th>
                                        <th>Item Name</th>
                                        <th>Publisher</th>
                                        <th>Class</th>
                                        <th>Price </th>
                                        <th>Qty Sold</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    
                                     @php
                                   
                                    $totalsale=0;
                                    @endphp
                                    @foreach($itemdata as $key => $data)
                                    @php
                                    $key++;
                                    $totalsale+=$data['total_amount'];
                                    @endphp
                                    <tr>
                                  
                                        <td>{{$key}}</td>
                                        <td>{{$data['itemcode']}} </td>
                                        
                                        <td>{{$data['itemname']}} </td>
                                        <td>{{$data['brand_title']}} </td>
                                        <td>{{$data['class']}} </td>
                                        <td>{{$data['unit_price']}} </td>
                                        <td>{{$data['qty_sold']}} </td>
                                        <td>{{$data['total_amount']}} </td>
                                        </tr>
                                        
                                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <h2>Total Sales : {{$totalsale;}}</h2>
                        
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
</html>