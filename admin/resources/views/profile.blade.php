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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">My Profile/</span>Profile Setting</h4>
              <!-- Basic Layout & Basic with Icons -->
              <div class="row justify-content-start">
                <!-- Basic Layout-->
                <div class="col-md-7">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">My Profile</h5>
                      <small class="text-muted float-end">Profile Setting</small>
                    </div>
                    <div class="card-body">
                      <form id="formAuthentication" class="mb-3" action="{{url('/') }}/profile" method="POST" enctype="multipart/form-data">
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
                                            <input type="hidden" name="id" class="form-control" value="{{$pagedata->id}}" required />
                                            
                                          <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="basic-icon-default-fullname"
                                    placeholder="John Doe"
                                    name="name"
                                    value="{{$pagedata->name}}"
                                    aria-label="John Doe"
                                    aria-describedby="basic-icon-default-fullname2"
                                    pattern="^[a-zA-Z\s]+$"
                                    title="Please enter a valid name using letters and spaces only."
                                    required
                                />
                            </div>
                            <div class="invalid-feedback">
                                Please enter a valid name using letters and spaces only.
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        const form = document.getElementById('profile-form');
                        const nameInput = document.getElementById('basic-icon-default-fullname');
                    
                        form.addEventListener('submit', function (event) {
                            if (!form.checkValidity()) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        });
                    
                        nameInput.addEventListener('input', function () {
                            nameInput.setCustomValidity('');
                        });
                    
                        nameInput.addEventListener('invalid', function () {
                            if (nameInput.validity.valueMissing) {
                                nameInput.setCustomValidity('Please enter your name.');
                            } else {
                                nameInput.setCustomValidity('Please enter a valid name using letters and spaces only.');
                            }
                        });
                    </script>
                    
                                            
                                            <div class="row mb-3 justify-content-end">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Email</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input
                                    type="email"
                                    id="basic-icon-default-email"
                                    name="email"
                                    value="{{$pagedata->email}}"
                                    class="form-control"
                                    placeholder="john.doe"
                                    aria-label="john.doe"
                                    aria-describedby="basic-icon-default-email2"
                                    required
                                />
                                <span id="basic-icon-default-email2" class="input-group-text">@example.com</span>
                            </div>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-end">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Username</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input
                                    type="text"
                                    id="basic-icon-default-username"
                                    name="username"
                                    value="{{$pagedata->username}}"
                                    class="form-control"
                                    placeholder="Ram@2323"
                                    aria-label="Ram@2323"
                                    aria-describedby="basic-icon-default-username2"
                                    required
                                />
                            </div>
                            <div class="invalid-feedback">
                                Please enter a valid username.
                            </div>
                        </div>
                    </div>
                    
                        <script>
                        const form4 = document.getElementById('profile-form');
                        const emailInput = document.getElementById('basic-icon-default-email');
                        const usernameInput = document.getElementById('basic-icon-default-username');
                    
                        form.addEventListener('submit', function (event) {
                            if (!form.checkValidity()) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        });
                    
                        emailInput.addEventListener('input', function () {
                            emailInput.setCustomValidity('');
                        });
                    
                        emailInput.addEventListener('invalid', function () {
                            if (emailInput.validity.valueMissing) {
                                emailInput.setCustomValidity('Please enter an email address.');
                            } else {
                                emailInput.setCustomValidity('Please enter a valid email address.');
                            }
                        });
                    
                        usernameInput.addEventListener('input', function () {
                            usernameInput.setCustomValidity('');
                        });
                    
                        usernameInput.addEventListener('invalid', function () {
                            if (usernameInput.validity.valueMissing) {
                                usernameInput.setCustomValidity('Please enter a username.');
                            } else {
                                usernameInput.setCustomValidity('Please enter a valid username.');
                            }
                        });
</script>
                    
                        <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="basic-icon-default-phone">Phone No</label>
                            <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                                <input
                                    type="text"
                                    id="basic-icon-default-phone"
                                    name="phone"
                                    value="{{$pagedata->contact}}"
                                    class="form-control phone-mask"
                                    placeholder="658 799 8941"
                                    aria-label="658 799 8941"
                                    aria-describedby="basic-icon-default-phone2"
                                    pattern="\d{3} \d{3} \d{4}"
                                    title="Please enter a phone number in the format: 123 456 7890"
                                    required
                                />
                            </div>
                            <div class="invalid-feedback">
                                Please enter a valid phone number in the format: 123 456 7890.
                            </div>
                        </div>
                         </div>
                    
                            <script>
                        const form2 = document.getElementById('profile-form');
                        const phoneInput = document.getElementById('basic-icon-default-phone');
                    
                        form.addEventListener('submit', function (event) {
                            if (!form.checkValidity()) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        });
                    
                        phoneInput.addEventListener('input', function () {
                            phoneInput.setCustomValidity('');
                        });
                    
                        phoneInput.addEventListener('invalid', function () {
                            if (phoneInput.value === '') {
                                phoneInput.setCustomValidity('Please enter a phone number.');
                            } else {
                                phoneInput.setCustomValidity('Please enter a valid phone number in the format: 123 456 7890.');
                            }
                        });
</script>
                    
                            <div class="row justify-content-end">
                              <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                              </div>
                            </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <script>
    // JavaScript for form validation
    const form1 = document.getElementById('profile-form');
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
</script>


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
