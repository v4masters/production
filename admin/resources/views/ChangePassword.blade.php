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
    <title>Change Password Form</title>
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


                <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Change Password</h4>

              <!-- Basic Layout & Basic with Icons-->
              <div class="row">
                <!-- Basic Layout -->
                <div class="col-md-7">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Change Password</h5>
                      <small class="text-muted float-end"></small>
                    </div>
                    <div class="card-body">
                        <form id="password_change_form" class="mb-3" action="{{url('/') }}/changePassword" method="POST">
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
                                
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Old Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input
                                      type="password"
                                      id="password"
                                      class="form-control"
                                      name="oldpassword"
                                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                      aria-describedby="password"
                                    />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
    
                            <div class="mb-3 form-password-toggle">
                              <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">New Password</label>
                              </div>
                              <div class="input-group input-group-merge">
                                <input
                                  type="password"
                                  id="password"
                                  class="form-control"
                                  name="newpassword"
                                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                  aria-describedby="password"
                                />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                              </div>
                            </div>
    
                            <div class="mb-3 form-password-toggle">
                              <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Confirm Password</label>
                                
                              </div>
                              <div class="input-group input-group-merge">
                                <input
                                  type="password"
                                  id="password"
                                  class="form-control"
                                  name="confirmpassword"
                                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                  aria-describedby="password"
                                />
                              </div>
                            </div>
                            <button type="submit" class="btn btn-success">Save</button>
                      </form>
                    </div>
                </div>
                </div>
              </div>
            </div>
            
        </div>
        
        
        
        <script>
            const form = document.getElementById('password_change_form');
            const newPasswordInput = document.getElementById('newpassword');
            const confirmPasswordInput = document.getElementById('confirmpassword');

            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
        
                if (newPasswordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.setCustomValidity('Passwords do not match.');
                } else {
                    confirmPasswordInput.setCustomValidity('');
                }
        
                form.classList.add('was-validated');
            });

            newPasswordInput.addEventListener('input', function () {
                confirmPasswordInput.setCustomValidity('');
            });
        
            confirmPasswordInput.addEventListener('input', function () {
                confirmPasswordInput.setCustomValidity('');
            });
        </script>


            <!-- / Content-->
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
