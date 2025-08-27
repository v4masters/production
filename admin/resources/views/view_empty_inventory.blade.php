<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta  name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0"/>
    <title>Manage Category</title>
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


          <div class="container mt-3">
          <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Manage Inventory</h5>
          <small class="text-muted float-end">View empty Inventory</small>
        </div>
            <div class="table-responsive text-nowrap">
            <table class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true">
                 <thead>
                  <tr>
                    <th>#</th>
                    <th>Product ID</th>
                    <th>Vendor</th>
                    <th>Product Name</th>
                    <th>cat<hr>sub cat<hr>sub sub cat<hr>sub sub sub cat</th>
                    <th>Stream</th>
                    <th>Class</th>
                    <th>Available Qty</th>
                    <th>Unit Price ( Inc GST )</th>
                    <th>GST ( % )</th>
                    <!--<th>Re-Stock</th>-->
                  </tr>
                </thead>
                <tbody>
                     @foreach($pagedata as $key => $data)
                        @php
                        $key++;
                        $qty_available="1001".$key;
                        
                        $class = DB::table('master_classes')->where('id',$data->class)->where('del_status',0)->first(); 
                        if($class) { $classtitle = $class->title; } else { $classtitle = ''; } 
                        
                        $stream = DB::table('master_stream')->where('id',$data->stream)->where('del_status',0)->first(); 
                        if($stream) { $streamtitle = $stream->title; } else { $streamtitle = ''; } 
                        
                        $gst = DB::table('master_taxes')->where('id',$data->gst)->where('del_status',0)->first(); 
                        if($gst) { $gsttitle = $gst->title; } else { $gsttitle = ''; } 
                                            
                        @endphp
                  <tr>
                    <td>{{$key}}</td>
                    <td>{{$data->product_id}}</td>
                    <td>@if($data->vendor_id==1) Admin @else {{$data->vendor_info->unique_id}} <br> {{$data->vendor_info->username}} <br> {{$data->vendor_info->email}} @endif</td>
                    <td>{{$data->product_name}}</td>
                    <td>{{$data->cat_one->name}}<hr>{{$data->cat_two->name}}<hr>{{$data->cat_three->title}}<hr>{{$data->cat_four->title}}</td>
                    <!--cat_three-->
                    <td>{{$streamtitle}}</td>
                    <td>{{$classtitle}}</td>
                    <td>
                    <div class="input-group">
                        <input type="number" class="form-control w-75" name="qty_available" id="{{$qty_available}}" value="{{$data->qty_available}}" />
                            <i class=" bx bx-check btn btn-primary btn-sm" onclick="restock_qty_available({{$data->id}},{{$qty_available}})"></i>
                  
                    </div></td>
                    <td></td>
                    <td>{{$gsttitle}}%</td>
                  
                  </tr>
                   @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>


 <!-- Footer -->
 <footer class="default-footer">
 @include('includes.footer')     
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    @include('includes.footer_script')
   <!-- footerscrit -->
  </body>
  <script>
      
        function restock_qty_available(id, qty_available_id) {
            var qty_available = document.getElementById(qty_available_id).value;

            $.ajax({
                type: "POST",
                url: "{{url('/') }}/restock_qty_available",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "qty_available": qty_available
                },
                cache: false,
                success: function(response) {
                    window.location.reload();
                }
            });
        }
  </script>
</html>