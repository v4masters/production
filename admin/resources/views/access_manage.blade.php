<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Admin access</title>
  <meta name="description" content="" />

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
        <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Add Access</h5>
     <!-- <small class="text-muted float-end">Add Access Data</small> -->
     </div>
        <div class="card-body">
          <div class="row d-flex justify-content-start">
            <div class="col-md-6">
              
            <form id="formAuthentication" class="mb-3" action="{{url('/') }}/manage_access" method="POST">
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


                    <div class="mb-3">
                      <label class="form-label" for="basic-default-category">Feature: *</label>
                      <input type="text" name="feature" class="form-control" id="basic-default-category" placeholder="Enter Title" required />
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="basic-default-company">Controller:</label>
                      <input type="text" name="controller" class="form-control" id="basic-default-company" placeholder="Enter Market Place Fees" required />
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <div class="card">
            <h5 class="card-header">Display Category</h5>
            <div class="table-responsive text-nowrap">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>feature</th>
                    <th>controller</th>
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
                  <td>{{$data->feature}}</td>
                  <td>{{$data->controller}}</td>
                  <td>@if($data->status==1)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif</td>
                  <td><a href="{{url('edit',$data->id)}}" class='btn btn-primary btn-sm ' >Edit</a> 
                  <form action="{{url('delete',$data->id)}}" class="btn btn-danger btn-sm" method="POST" type="button"  onsubmit="return confirm('Delete?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger m-0">Delete</button>
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
  <!-- Footerscript -->
</body>
</html>
