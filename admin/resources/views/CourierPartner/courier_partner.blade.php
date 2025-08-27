<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Courier Partner</title>
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
        <h5 class="mb-0">View Courier Partner</h5> 
     </div>

      
        <div class="container">
          <div class="card">
            <h5 class="card-header">Courier Partner</h5>
            <div class="table-responsive text-nowrap">
                <table id="mytable" class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">
                                 
                <thead>
                  <tr>
                       <th>#</th>
                        <th>Title</th>
                        <th>URL</th>
                        <th>Status</th>
                        <th>Actions</th>

                  </tr>
                </thead>
                <tbody>
                @foreach($pagedata as $key => $data)
                @php
                $key++;
                @endphp
                    <tr>
                   
                    <td>{{$key}}</td>
                    
                        <td>{{ $data->title }}</td>
                        <td>{{ $data->url }}</td>
                        <td>{{ $data->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>
                             <a href="{{url('view_courier_partner',$data->id)}}" class="btn btn-primary btn-sm mr-3"><i class=" bi bi-pencil-fill"></i> </a>
                                 <br>  <br>
                                  <form class="mb-3" action="{{url('/') }}/destroy_courier_partner" method="POST" type="button" onsubmit="return confirm('This pickup point will be delete')">

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
 