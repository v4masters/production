<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Vendor Pickup Location</title>
  <meta name="description" content="" />

  <!-- Headerscript -->
  @include('includes.header_script')
<style>
     .add_td{
         padding:2px !important;
          white-space: normal !important; 
          word-wrap: break-word;  
        }
        .imgshow
        {
            height:25px;
            width:25px;
        }
        
       
</style>
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
        <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Vendor Pickup Location</h5>
      <a href="{{url('create_vendor_pp')}}" class="btn btn-primary float-end">Add Vendor Pickup Location</a> 
     </div>

      
        <div class="container">
          <div class="card">
            <!--<h5 class="card-header">Vendor Pickup Location</h5>-->
            <div class="table-responsive text-nowrap">
                <table id="mytable" class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">
                                 
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Vendor Id<br>Name<br>Email<br>Phone </th>
                    <th>Pickup Id<br>Pickup Location<br>Name<br>Email<br>Phone</th>
                    <th>Address Type<br>Address<br>Address 2</th>
                    <th>City<br>State<br>Country<br>Pincode</th>
                    <th>Status</th>
                 </tr>
                </thead>
                <tbody>
                
                @foreach($pagedata as $key => $data)
                @php
                $key++;
                $vendor_id='';
                if(isset($data['user_id'])){$vendor_id=$data['user_id'];}
                $vendordata =  App\Models\VendorModel::select('unique_id','username','email','phone_no')->where(['location_id'=>$data['id']])->first();
                
                if($vendordata){$vuid=$vendordata->unique_id;$vname=$vendordata->username;$vemail=$vendordata->email;$vphone=$vendordata->phone_no;}
            else{$vuid="";$vname="";$vemail="";$vphone="";}
                
                @endphp
                    <tr>
                   
                    <td>{{$key}}</td>
                     <td><b>{{$vuid}}</b><br>{{$vname}}<br>{{$vemail}}<br>{{$vphone}}</td>
                      <td class="add_td"><b>{{$data['id']}}</b><br><b>{{$data['pickup_location']}}</b><br>{{$data['name']}}<br>{{$data['email']}}<br>{{$data['phone']}}</td>
                       <td class="add_td"><b>{{$data['address_type']}}</b><br>1- {{$data['address']}} <br>2- {{$data['address_2']}}</td>
                       <td class="">{{$data['city']}} <br> {{$data['state']}}<br>{{$data['country']}}<br><b>{{$data['pin_code']}}</b></td>
                         
                            <td>@if($data['status']==2)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif</td>

                          
                    
                  

                   
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
</body>
</html>
 