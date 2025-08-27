<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />
    <title>Vendor Profile settings</title>
    <meta name="description" content="" />
    <!-- headerscript -->
    @include('includes.header_script')
    <style>
        .imagePreview {
            width: 100%;
            height: 300px;
            background-position: center center;
            background: url("<?php echo Storage::disk('s3')->url('school/'.$pagedata->school_banner);?>");
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
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profile Setting /</span> Edit Vendor profile</h4>

                        <!-- Basic Layout -->
                        <div class="row">
                            <div class="col-xl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Update Vendor Profile</h5>
                                        <small class="text-muted float-end"></small>
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

                                    <div class="row ps-4 pe-5">
                                             <div class="col-md-3 mb-4 imgUp">
                                                <div class="form-group">
                                                     <div class="imagePreview"></div>
                                                        <label class="form-control btn btn-primary">Upload Vendor Banner
                                                            <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="site_background_img" />
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">

                                                        <label class="form-label">unique_id</label>
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-vendorname2" class="input-group-text"><i class="bx bx-user me-2"></i></span>
                                                            <input type="text" class="form-control" name="unique_id" placeholder="Unique Id" value="{{$pagedata->unique_id}}" readonly  />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Username</label>
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-vendorname2" class="input-group-text"><i class="bx bx-buildings"></i></span>
                                                            <input type="text" class="form-control" name="username" placeholder="Name" value="{{ $pagedata->username }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">

                                                        <label class="form-label">Email</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                                            <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $pagedata->email }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">

                                                        <label class="form-label">Employee Email</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                                            <input type="email" class="form-control" placeholder="Employee Email" name="e_email" value="{{ $pagedata->e_email }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Phone No</label>
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                                                            <input type="text" class="form-control phone-mask" placeholder="Phone No" name="phone_no" value="{{ $pagedata->phone_no }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">State:</label>
                                                        <input class="form-control" type="text" name="state" placeholder="Enter state" value="{{ $pagedata->state }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">distt:</label>
                                                        <input class="form-control" type="text" name="distt" placeholder="Enter distt" value="{{ $pagedata->distt }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">City:</label>
                                                        <input class="form-control" type="text" name="city" placeholder="Enter City" value="{{ $pagedata->city }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Land Mark:</label>
                                                        <input class="form-control" type="text" name="landmark" placeholder="landmark" value="{{ $pagedata->landmark }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">PinCode:</label>
                                                        <input class="form-control" type="number" name="pincode" placeholder="Enter PinCode" value="{{ $pagedata->pincode }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Address</label>
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-buildings"></i></span>
                                                            <textarea class="form-control" placeholder="School Address" name="address">{{ $pagedata->pincode }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                         
                                        
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--/ Content-->
                    <!-- Footer -->
                    <footer class="default-footer">
                        @include('includes.footer')
                        <!-- / Footer -->
                        <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper-->
            </div>
            <!-- / Layout page -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    @include('includes.footer_script')
    <!-- footerscrit -->
    
    <script>
        $(function() {
            $(document).on("change", ".uploadFile", function() {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + this.result + ")");
                    }
                }

            });
        });
    </script>
    
</body>

</html>