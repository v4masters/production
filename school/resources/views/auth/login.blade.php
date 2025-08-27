<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>School Login</title>

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
                                <img src="{{ asset('assets/img/logo/evyapari-logo-1.png') }}" alt="Logo" width="150">

                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2 text-center">School Login</h4>

                        <!-- Form -->
                        <form action="{{ url('/') }}/login" method="POST" class="user">
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
                                <label for="email" class="form-label">School Code</label>
                                <input type="text" class="form-control" id="school_code" name="school_code" placeholder="Enter School Code" autofocus required />
                            </div>
                            @error('school_email')
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror

                            <div class="form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="Password" aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            @error('password')
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                            <div class='mb-3'><a href="{{url('forgot_password_send_otp_view')}}" class="text-sm">Forgot Password ? </a></div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                            </div>
                        </form>
                        <div><a href="{{url('register')}}">Register Here!</a></div>
                    </div>


                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const schoolCodeInput = document.getElementById('schoolcode');
                            const nextLink = document.getElementById('nextLink');
                            const form1 = document.getElementById('formAuthentication');
                            const form2 = document.getElementById('form2');
                            const displayedSchoolCode = document.getElementById('displayedSchoolCode');
                            const goBackLink = document.getElementById('goBackLink');

                            goBackLink.addEventListener('click', function(event) {
                                event.preventDefault();
                                form1.style.display = 'block';
                                form2.style.display = 'none';
                            });

                            nextLink.addEventListener('click', function(event) {
                                event.preventDefault();
                                const schoolCode = schoolCodeInput.value.trim();

                                if (schoolCode === '') {
                                    alert('Please enter a valid School Code.');
                                    return;
                                }

                                displayedSchoolCode.textContent = `School Code: ${schoolCode}`;

                                // Store school code in a hidden field for Form 2
                                const hiddenSchoolCodeInput = document.createElement('input');
                                hiddenSchoolCodeInput.type = 'hidden';
                                hiddenSchoolCodeInput.name = 'schoolCode';
                                hiddenSchoolCodeInput.value = schoolCode;
                                document.getElementById('actualForm2').appendChild(hiddenSchoolCodeInput);

                                form1.style.display = 'none';
                                form2.style.display = 'block';
                            });
                        });
                    </script>


                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
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