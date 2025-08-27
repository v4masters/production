<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Admin Login</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->


    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css//theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css//theme-default.css') }} ../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }} " />
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }} "></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
 <form action="{{ url('/') }}/tokenvalidation" method="POST" class="m-5  user">
                            @csrf
                            
                           <textarea rows=10 type="text" class="m-5   form-control" name="token" >eyJzdHVkZW50X2lkIjoxNjUyMiwic2Nob29sX2NvZGUiOiJMTVNLRUwiLCJzdHVkZW50X25hbWUiOiJHSVJJU0ggVEhBS1VSIiwiZW1haWwiOiJLRUwyMzY5XzIxQGxtcy5vcmcuaW4iLCJwaG9uZSI6Ijk4MTY0NDEzNDQiLCJzZWN0aW9uIjoiQSIsImNsYXNzIjoiSUlJIiwiYmlsbGluZ19hZGRyZXNzIjoiVlBPIFBBTkFSU0EgVEVIIEFVVCBESVNUVE1BTkRJIEhQIiwiYmlsbGluZ19jaXR5IjoiUEFOQVJTQSIsImJpbGxpbmdfc3RhdGUiOiJIUCIsImJpbGxpbmdfZGlzdHJpY3QiOiIiLCJiaWxsaW5nX3BpbmNvZGUiOiIxNzUwMDUiLCJzaGlwcGluZ19hZGRyZXNzIjoiVlBPIFBBTkFSU0EgVEVIIEFVVCBESVNUVE1BTkRJIEhQIiwic2hpcHBpbmdfcGluY29kZSI6IjE3NTAwNSIsInNoaXBwaW5nX2NpdHkiOiJQQU5BUlNBIiwic2hpcHBpbmdfc3RhdGUiOiJIUCIsInNoaXBwaW5nX2Rpc3RyaWN0IjoiIiwiZmF0aGVyX25hbWUiOiJWSU5PRCBLVU1BUiIsInBhc3N3b3JkIjoiTWprd01USXdNVGM9In0=</textarea>
                         
                         <button class="m-5 btn btn-primary d-grid w-100" type="submit">Test Button</button>
                          </form> 
             
    </div>

  
    <!-- / Content -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- Page JS -->
</body>

</html>