<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Pickup Points</title>
  <meta name="description" content="" />

  <!-- Headerscript -->
  @include('includes.header_script')
<style>
     .add_td{
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
        <h5 class="mb-0">View Pickup Points</h5>
      <a href="{{url('pickup_points')}}" class="btn btn-primary float-end">Add Pickup Points</a> 
     </div>

      
        <div class="container">
          <div class="card">
            <h5 class="card-header">Pickup Points</h5>
            <div class="table-responsive text-nowrap">
                <table id="mytable" class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">
                                 
                <thead>
                  <tr>
                    <th>Id</th>
                    <!--<th>Images</th>-->
                    <th>UID<br>Name
                    <br>Email<br>Contact </th>
                    <th>Pickup Point</th>
                    <!--<th>Google Map Location</th>-->
                    <th>Timing</th>
                    <!--<th>Note</th>-->
                    <th>Status</th>
                     <th> Action Buttons</th>

                  </tr>
                </thead>
                <tbody>
                @foreach($pagedata as $key => $data)
                @php
                $key++;
                @endphp
                    <tr>
                   
                    <td>{{$key}}</td>
                    
                     <td><b>{{$data->uid}}</b><br>{{$data->name}}<br>{{$data->email}}<br>{{$data->contact_number}}</td>
                      <td class="add_td">{{$data->pickup_point_name}}</td>
                       <!--<td class="add_td">{{$data->google_location}}</td>-->
                        <td>From-<b>{{date("g:i A", strtotime($data->opening_time))}} </b><br> To-<b> {{date("g:i A", strtotime($data->closing_time))}}</b></td>
                         <!--<td class="add_td">{{$data->notes}}</td>-->
                         
                            <td>@if($data->status==1)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif</td>

                            <td>
                                
                                  <a href="{{url('view_pickup_point',$data->id)}}" class="btn btn-primary btn-sm mr-3"><i class="bi bi-eye-fill "></i></a>
                                  <a href="{{url('edit_pickup_point',$data->id)}}" class="btn btn-primary btn-sm mr-3"><i class=" bi bi-pencil-fill"></i></a>
                                 
                                  <form class="mb-3" action="{{url('/') }}/delete_pickup_point_data" method="POST" type="button" onsubmit="return confirm('This pickup point will be delete')">

                                                        @csrf

                                                        <input type="hidden" name="id" class="form-control" value="{{ $data->id }}" />

                                                        <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>

                                                    </form>
                                
                            </td>
                    
                  

                   
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
 