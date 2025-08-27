<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta  name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0"/>
    <title>My Profile(settings)</title>
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
        <!-- Content wrapper-->
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage Sub Admin/</span>Add Sub Admin</h4>
              <!-- Basic Layout & Basic with Icons -->
              <div class="row justify-content-start">
                <!-- Basic Layout-->
                <div class="col-md-xxl">
                  <div class="card mb-4  mx-auto" >
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Add Sub Admin</h5>
                      <!-- <small class="text-muted float-end">Add Sub Admin</small> -->
                    </div>
                    <div class="card-body">

          <form id="formAuthentication" class="mb-3" action="{{url('/') }}/add_sub_admin" method="POST">
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
            <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label" for="basic-default-category">Name: </label>
                <input type="text" name="name" class="form-control" id="basic-default-category" placeholder="Enter Title" required />
            </div>
            <div class="col-md-6">
                <label class="form-label" for="basic-default-company">Email:</label>
                <input type="text" name="email" class="form-control" id="basic-default-company" placeholder="Enter Email" required />
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label" for="basic-default-company">Username:</label>
                <input type="text" name="username" class="form-control" id="basic-default-company" placeholder="Enter Username" required/>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="basic-default-company">Password:</label>
                <input type="password" name="password" class="form-control" id="basic-default-company" placeholder="Enter Password" required/>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label" for="basic-default-company">Contact:</label>
                <input type="text" name="contact" class="form-control" id="basic-default-company" placeholder="Enter Contact" required />
            </div>
            <div class="col-md-6">
                <label class="form-label" for="basic-default-company">Address:</label>
                <input type="text" name="address" class="form-control" id="basic-default-company" placeholder="Enter Address" required />
            </div>
        </div>
            
                    <button type="submit" class="btn btn-success">Save</button>
                  </form>
                </div>
              </div>
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
</html>
