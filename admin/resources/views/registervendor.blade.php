<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Register Basic Evyapari</title>

  <meta name="description" content="" />
   @include('includes.header_script')
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />

    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/css//theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css//theme-default.css') }} ../assets/css/demo.css" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }} " />
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }} "></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="../assets/js/config.js"></script>
</head>

<body>
  <!-- Content -->

 <div class="container-xxl flex-grow-1 container-p-y">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">

                </span>
                <img src="{{Storage::disk('s3')->url('site_img/evyapari-logo.png')}}" alt="Logo" width="150">
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-3 text-center">Vendor Signup</h4>
            <form id="formAuthentication" class="mb-3" action="{{url('/') }}/register"  method="POST">
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
                <label class="form-label">User Name</label>
                <input type="text" class="form-control" id="username" name="username"  placeholder="User Name" autofocus required />
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required/>
              </div>
              <div class="mb-3">
                <label class="form-label">Mobile No.</label>
                <input type="number" class="form-control" id="phone_no" name="phone_no" placeholder="Mobile No." required/>
              </div>
              <div class="mb-3">
                <label class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state" placeholder="State" required/>
              </div>
                  <div class="mb-3">
                 <label class="form-label">Zipcode</label>
                 <input type="number" class="form-control" name="pincode" id="pincode" placeholder="Zipcode" required/>
              </div>
                 <div class="mb-3">
                  <label class="form-label">Address</label>
                  <input type="text" class="form-control" name="address" id="address" placeholder="Address" required/>
              </div>
                  <div class="mb-3">
                    <label class="form-label">GST No.</label>
                  <input type="text" class="form-control" name="gst_no" id="gst_no" placeholder="GST No." required/>
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required/>
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Confirm Password</label>
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" id="confirmed" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Register</button>
              </div>
            </form>
            <div><a href="login">Login Here!</a></div>

          </div>
        </div>
      
      </div>
    </div>
  </div>

    @include('includes.footer_script')
</body>

</html>