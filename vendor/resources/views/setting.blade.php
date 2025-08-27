<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />
    <title>settings</title>
    <meta name="description" content="" />

    <!-- headerscript -->
    @include('includes.header_script')
    <style>
        .imagePreview {
            width: 100%;
            height: 200px;
            background-position: center center;
            background: url("<?php echo Storage::disk('s3')->url($documents->folder.'/'.$documents->adhar_card); ?>");
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }


        .imagePreview1 {
            width: 100%;
            height: 200px;
            background-position: center center;
            background: url("<?php echo Storage::disk('s3')->url($documents->folder.'/'.$documents->pan_card); ?>");
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }



        .imagePreview2 {
            width: 100%;
            height: 200px;
            background-position: center center;
            background: url("<?php echo Storage::disk('s3')->url($documents->folder.'/'.$documents->gst_number);  ?>");
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }




        .imagePreview3 {
            width: 100%;
            height: 200px;
            background-position: center center;
            background: url("<?php echo Storage::disk('s3')->url($documents->folder.'/'.$documents->shop_act_number); ?>");
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }




        .imagePreview4 {
            width: 100%;
            height: 200px;
            background-position: center center;
            background: url("<?php echo Storage::disk('s3')->url($documents->folder.'/'.$documents->cancelled_cheque);  ?>");
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }

        .imagePreview5 {
            width: 100%;
            height: 200px;
            background-position: center center;
            background: url("<?php echo Storage::disk('s3')->url($documents->folder.'/'.$documents->site_background_img); ?>");
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }

        .imagePreview6 {
            width: 100%;
            height: 200px;
            background-position: center center;
            background: url("<?php echo Storage::disk('s3')->url($documents->folder.'/'.$documents->website_img); ?>");
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }

        .imagePreview7 {
            width: 100%;
            height: 200px;
            background-position: center center;
            background: url("<?php echo Storage::disk('s3')->url($documents->folder.'/'.$documents->profile_img);  ?>");
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
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profile Setting/</span>edit my profile</h4>
                        <!-- Basic Layout -->
                        <div class="row">

                            <!--1st-->

                            <form id="formAuthentication" class="mb-3" action="{{url('/') }}/settings" method="POST" enctype="multipart/form-data">

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

                                <input type="hidden" name="id" class="form-control" value="{{$vendor->id}}" required />
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="mb-0">Update Profile</h5>{{session('id')}}
                                    </div>
                                    <div class="card-body">

                                        <div class="row ps-4 pe-5">
                                            <div class="col-md-3 mb-4 imgUp">
                                                <div class="form-group">
                                                    <div class="imagePreview5"></div>
                                                    <label class="form-control btn btn-primary"> Site Backgroud Image
                                                        <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="site_background_img" />
                                                        <input type="hidden" class="form-control" name="site_background_img_old" value="{{ $vendor->site_background_img }}" />
                                                    </label>
                                                    <span style="color:red; font-size:12px;">*NOTE: This will overwrite the previous Image.</span>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-4 imgUp">
                                                <div class="form-group">
                                                    <div class="imagePreview6"></div>
                                                    <label class="form-control btn btn-primary">WebSite Image
                                                        <input type="hidden" class="form-control" name="website_img_old" value="{{ $vendor->website_img }}" />
                                                        <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="website_img" />
                                                    </label>
                                                    <span style="color:red; font-size:12px;">*NOTE: This will overwrite the previous Image.</span>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-4 imgUp">
                                                <div class="form-group">
                                                    <div class="imagePreview7"></div>
                                                    <label class="form-control btn btn-primary">Profile Image
                                                        <input type="hidden" class="form-control" name="profile_img_old" value="{{ $vendor->profile_img }}" />
                                                        <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="profile_img" />
                                                    </label>
                                                    <span style="color:red; font-size:12px;">*NOTE: This will overwrite the previous Image.</span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-sm-3">
                                                <div class="form-group mb-3">

                                                    <label class="form-label" for="basic-icon-default-fullname">Website Vendor URL:</label>

                                                    <input type="text" class="form-control" name="website_vendor_url" value="{{ $vendor->website_vendor_url }}" />

                                                </div>
                                            </div>

                                            <div class="col-sm-3">

                                                <div class="form-group mb-3">

                                                    <label class="form-label" for="basic-icon-default-fullname">Vendor Name:</label>

                                                    <input type="text" class="form-control" name="username" value="{{ $vendor->username }}" />

                                                </div>
                                            </div>

                                            <div class="col-sm-3">

                                                <div class="form-group mb-3">

                                                    <label class="form-label" for="basic-icon-default-fullname">Email:</label>

                                                    <input type="text" class="form-control" name="email" value="{{ $vendor->email }}" />

                                                </div>
                                            </div>

                                            <div class="col-sm-3">

                                                <div class="form-group mb-3">

                                                    <label class="form-label" for="basic-icon-default-fullname">Phone No:</label>

                                                    <input type="tel" class="form-control" name="phone_no" value="{{ $vendor->phone_no }}" />

                                                </div>
                                            </div>

                                            <div class="col-sm-3">

                                                <div class="form-group mb-3">

                                                    <label class="form-label" for="basic-icon-default-fullname">Address:</label>

                                                    <input type="text" class="form-control" name="address" value="{{ $vendor->address }}" />

                                                </div>
                                            </div>
                                            <div class="col-sm-3">

                                                <div class="form-group mb-3">

                                                    <label class="form-label" for="basic-icon-default-fullname">Zipcode:</label>

                                                    <input type="number" class="form-control" name="pincode" value="{{ $vendor->pincode }}" />

                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success">update</button>
                                    </div>
                            </form>

                        </div>

                        <!--2nd-->
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="mb-0">Update Bank Detail</h5>
                            </div>
                            <div class="card-body">
                                <form id="formAuthentication" class="mb-3" action="{{url('/') }}/settings" method="POST">

                                    @csrf

                                    <input type="hidden" name="id" class="form-control" value="{{$pagedata->id}}" required />

                                    <div class="row">

                                        <div class="col-sm-3">
                                            <div class="form-group mb-3">

                                                <label class="form-label" for="basic-icon-default-fullname">Bank Name:</label>

                                                <input type="text" class="form-control" name="bank_name" value="{{ $pagedata->bank_name }}" />

                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group mb-3">

                                                <label class="form-label" for="basic-icon-default-fullname">Bank District Name:</label>

                                                <input type="text" class="form-control" name="bank_district" value="{{ $pagedata->bank_district }}" />

                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group mb-3">

                                                <label class="form-label" for="basic-icon-default-fullname">Bank IFSC:</label>

                                                <input type="text" class="form-control" name="ifsc_code" value="{{ $pagedata->ifsc_code }}" />

                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group mb-3">

                                                <label class="form-label" for="basic-icon-default-fullname">Bank Branch:</label>

                                                <input type="text" class="form-control" name="bank_branch" value="{{ $pagedata->bank_branch }}" />

                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group mb-3">

                                                <label class="form-label" for="basic-icon-default-fullname">Bank Address:</label>

                                                <input type="text" class="form-control" name="bank_address" value="{{ $pagedata->bank_address }}" />

                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group mb-3">

                                                <label class="form-label" for="basic-icon-default-fullname">Account Number:</label>

                                                <input type="text" class="form-control" name="acc_number" value="{{ $pagedata->acc_number }}" />

                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group mb-3">

                                                <label class="form-label" for="basic-icon-default-fullname">Account Holder Name:</label>

                                                <input type="text" class="form-control" name="acc_holder_name" value="{{ $pagedata->acc_holder_name }}" />

                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success">update</button>

                                </form>

                            </div>
                        </div>


                        <!--3rd-->

                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="mb-0">Update Documents</h5>
                                <small class="text-muted float-end"></small>
                            </div>
                            <div class="card-body">
                                <form id="formAuthentication" class="mb-3" action="{{url('/') }}/settings" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" class="form-control" value="{{$documents->id}}" required />
                                    <div class="row ps-4 pe-5">
                                        <div class="col-md-3 mb-4 imgUp">
                                            <div class="form-group">
                                                <div class="imagePreview"></div>
                                                <label class="form-control btn btn-primary">Upload Adhar Card
                                                    <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="adhar_card" />
                                                    <input type="hidden" class="form-control" name="adhar_card_old" value="{{ $documents->adhar_card }}" />
                                                </label>
                                                <span style="color:red; font-size:12px;">*NOTE: This will overwrite the previous Image.</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4 imgUp">
                                            <div class="form-group">
                                                <div class="imagePreview1"></div>
                                                <label class="form-control btn btn-primary">Pan Card
                                                    <input type="hidden" class="form-control" name="pan_card_old" value="{{ $documents->pan_card }}" />
                                                    <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="pan_card" />
                                                </label>
                                                <span style="color:red; font-size:12px;">*NOTE: This will overwrite the previous Image.</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4 imgUp">
                                            <div class="form-group">
                                                <div class="imagePreview2"></div>
                                                <label class="form-control btn btn-primary">GST Number
                                                    <input type="hidden" class="form-control" name="gst_number_old" value="{{ $documents->gst_number }}" />
                                                    <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="gst_number" />
                                                </label>
                                                <span style="color:red; font-size:12px;">*NOTE: This will overwrite the previous Image.</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4 imgUp">
                                            <div class="form-group">
                                                <div class="imagePreview3"></div>
                                                <label class="form-control btn btn-primary">Shop Act Number
                                                    <input type="hidden" class="form-control" name="shop_act_number_old" value="{{ $documents->shop_act_number }}" />
                                                    <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="shop_act_number" />
                                                </label>
                                                <span style="color:red; font-size:12px;">*NOTE: This will overwrite the previous Image.</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4 imgUp">
                                            <div class="form-group">
                                                <div class="imagePreview4"></div>
                                                <label class="form-control btn btn-primary">Cancelled Cheque
                                                    <input type="hidden" class="form-control" name="cancelled_cheque_old" value="{{ $documents->cancelled_cheque }}" />
                                                    <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="cancelled_cheque" />
                                                </label>
                                                <span style="color:red; font-size:12px;">*NOTE: This will overwrite the previous Image.</span>
                                            </div>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-success">Submit</button>

                                </form>
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

            $(document).on("change", ".uploadFile", function() {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview1').css("background-image", "url(" + this.result + ")");
                    }
                }

            });


            $(document).on("change", ".uploadFile", function() {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview2').css("background-image", "url(" + this.result + ")");
                    }
                }

            });


            $(document).on("change", ".uploadFile", function() {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview3').css("background-image", "url(" + this.result + ")");
                    }
                }

            });


            $(document).on("change", ".uploadFile", function() {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview4').css("background-image", "url(" + this.result + ")");
                    }
                }

            });

            $(document).on("change", ".uploadFile", function() {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview5').css("background-image", "url(" + this.result + ")");
                    }
                }

            });

            $(document).on("change", ".uploadFile", function() {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview6').css("background-image", "url(" + this.result + ")");
                    }
                }

            });

            $(document).on("change", ".uploadFile", function() {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview7').css("background-image", "url(" + this.result + ")");
                    }
                }

            });
        });
    </script>
</body>

</html>