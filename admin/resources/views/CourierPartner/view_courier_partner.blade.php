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
    <title>Edit Courier Partner</title>
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage  Courier Partner/</span>Edit Courier Partner</h4>
              <!-- Basic Layout & Basic with Icons -->
              <div class="row justify-content-start">
                <!-- Basic Layout-->
                <div class="col-md-xxl">
                  <div class="card mb-4  mx-auto" >
                    <div class="card-header d-flex justify-content-between align-items-center">
                     
                    <div class="card-body">
                        
                        
                             <form id="formAuthentication" class="mb-3" action="{{url('/') }}/update_courier_partner" enctype="multipart/form-data" method="POST">
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
                                
                                 <input type="hidden" name="id" value="{{ $courierPartner->id }}">
                                     
                                
                            <div class="row">
                                
                                 <div class="col-md-6 mb-3">
                                <label for="title">Title <span class='text-danger'>*</span></label>
                                <input type="text"  class="form-control" name="title" value="{{ $courierPartner->title }}" required><br>
                                </div>
                                
                          
                                
                                <div class="col-md-6 mb-3">
                                <label for="courier_partner">Courier Partner <span class='text-danger'>*</span></label>
                                <select name="courier_partner" class="form-control"  required>
                                    <option value="1" {{ $courierPartner->courier_partner == 1 ? 'selected' : '' }}>Amazon</option>
                                    <option value="2" {{ $courierPartner->courier_partner == 2 ? 'selected' : '' }}>IndiaPost</option>
                                    <option value="3" {{ $courierPartner->courier_partner == 3 ? 'selected' : '' }}>ShipRocket</option>
                                </select><br>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                <label for="username">Username </label>
                                <input type="text"  class="form-control" name="username" value="{{ $courierPartner->username }}" ><br>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                <label for="password">Password</label>
                                <input type="password"  class="form-control" name="password" value="{{ $courierPartner->password }}" ><br>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                <label for="token">Token</label>
                                
                                
                                @if($courierPartner->courier_partner == 3)
                                <input type="text"  class="form-control" name="token" value="{{ $courierPartner->ship_rocket_token }}" ><br>
                                @else
                                <input type="text"  class="form-control" name="token" value="{{ $courierPartner->token }}" ><br>
                                @endif
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                <label for="access_key">Access Key</label>
                                <input type="text" class="form-control" name="access_key" value="{{ $courierPartner->access_key }}" ><br>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                <label for="secret_key">Secret Key</label>
                                <input type="text" class="form-control" name="secret_key" value="{{ $courierPartner->secret_key }}" ><br>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                <label for="status">Status <span class='text-danger'>*</span></label>
                                <select name="status"  class="form-control"  required>
                                    <option value="1" {{ $courierPartner->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $courierPartner->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select><br>
                                </div>
                                
                               
                              </div>
                                
                              <!-- Submit Button -->
                              <div class="form-group mb-3">
                                       <button type="submit" class=" btn btn btn-primary">Update </button>
                                       </div>
                               
                             
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
   

  </body>
</html>





  