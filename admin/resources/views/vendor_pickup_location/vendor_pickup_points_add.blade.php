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
    <title>Add Vendor Pickup Location</title>
    <meta name="description" content="" />

    <!-- headerscript -->
    @include('includes.header_script')
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkXHcTsdrUyZ3Rbt8J8u5SD0lSp7Md4AI&libraries=places"></script>
<style>
    .form-label{font-weight:600;}
         .imagePreview {
            width: 100%;
            height: 200px;
            background-position: center center;
            background: url(https://tamilnaducouncil.ac.in/wp-content/uploads/2020/04/dummy-avatar.jpg);
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }

        .imgUp {
            margin-bottom: 15px;
        }
</style>
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage  Vendor Pickup Location/</span>Add Vendor Pickup Location</h4>
              <!-- Basic Layout & Basic with Icons -->
              <div class="row justify-content-start">
                <!-- Basic Layout-->
                <div class="col-md-xxl">
                  <div class="card mb-4  mx-auto" >
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Add Vendor Pickup Location</h5>
                       <a href="{{url('get_vendor_pp') }}" class="btn btn-primary float-end">View Vendor Pickup Location</a> 
                    </div>
                    <div class="card-body">
                        
                        
                             <form id="formAuthentication" class="mb-3" action="{{url('/') }}/store_vendor_pp" enctype="multipart/form-data" method="POST">
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
                           
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                <label for="street_building">Select Vendor <span class="text-danger">*</span></label>
                                                <select class="form-select" id="form-select-md-brand" data-placeholder="Select" name="vendor_id" required>

                                                         <option selected disabled value="">Select</option>
                                                        @foreach($vendors as $key => $vendor)

                                                        <option value="{{$vendor->unique_id}},{{$vendor->username}}">{{$vendor->username}}</option>

                                                        @endforeach

                                                    </select>
                                             </div>
                                              </div>
                                             
                                            <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="street_building">Pickup Location <span class="text-danger">*</span></label>
                                                <input type="text" placeholder='Pickup Location' class="form-control" name="pickup_location" required>
                                            </div>
                                             </div>
                                             
                                              <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="street_building">Name <span class="text-danger">*</span></label>
                                                <input type="text" placeholder='Name' class="form-control" name="name" required>
                                            </div>
                                             </div>
                                             
                                              <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="street_building">Email <span class="text-danger">*</span></label>
                                                <input type="email" placeholder='Email' class="form-control" name="email" required>
                                            </div>
                                             </div>
                                             
                                            <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="state">Phone No <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="phone_no" required>
                                            </div>
                                             </div>

                                            <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="street_building">Address <span class="text-danger">*</span></label>
                                                <input type="text" placeholder='Address Line 1 must contain House No., Flat No., or Road No.' min="8"  class="form-control" name="address" required>
                                            </div>
                                             </div>
                                             
                                             <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="locality">Address 2 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" min="8" name="addresstwo" required>
                                            </div>
                                             </div>
                                             
                                            <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="city_town_vill">City/Town/Village <span class="text-danger">*</span></label>
                                                <input type="text" placeholder='Enter City or Town or Village' class="form-control" name="city_town_vill" required>
                                            </div>
                                             </div>
                                           
                                              <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="state">State <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="state" required>
                                            </div>
                                             </div>
                                            <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="pincode">Pincode <span class="text-danger">*</span></label>
                                                <input type="text" placeholder='Enter 6 digit pincode' class="form-control" name="pincode" required maxlength="6">
                                            </div>
                                             </div>
                                            <div class="col-md-6 mb-3">
                                     </div>        
                                
                           
                            
                              <!-- Submit Button -->
                              <div class="form-group mb-3">
                                       <button type="submit" class=" btn btn btn-primary">Add Location </button>
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
   <!-- footerscrit -->
 
  </body>
</html>





  