<!DOCTYPE html>



<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">



<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

    <title>Add Inventory</title>

    <meta name="description" content="" />

    <!-- headerscript -->

    @include('includes.header_script')

    <style>
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

                <!-- Centered Form -->

                <div class="container mt-3">

                    <div class="row d-flex justify-content-center">

                        <div class="col-xl">

                            <div class="card mb-4">

                                <div class="card-header d-flex justify-content-between align-items-center">

                                    <h5 class="mb-0">Manage Inventory</h5>

                                    <small class="text-muted float-end">Add new inventory</small>

                                </div>

                                <div class="card-body">

                                    <form method="post" action="{{url('/') }}/inventory" enctype="multipart/form-data">
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

                                        <div class="row ps-4 pe-5">
                                            <div class="col-md-3 mb-4 imgUp">
                                                <div class="form-group">
                                                    <div class="imagePreview"></div>
                                                    <label class="form-control btn btn-primary"> Cover Photo
                                                        <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="cover_photo" />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label">Item Type:</label>

                                                    <select id="defaultSelect" class="form-select" name="item_type">
                                                        <option value="1">School Set Item</option>
                                                        <option value="0">Inventory Item</option>

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label" for="barcode">BARCODE:</label>

                                                    <input type="text" class="form-control" id="basic-default-company" name="barcode" />

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label" for="hsncode">HSNCODE:</label>

                                                    <input type="text" class="form-control" id="basic-default-company" name="hsncode" />

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label" for="itemname">Item Name:</label>

                                                    <input type="text" class="form-control" id="basic-default-company" name="itemname" required />

                                                </div>

                                            </div>

                                            <!--<div class="col-sm-4">-->

                                            <!--    <div class="mb-3">-->

                                            <!--        <label class="form-label" for="basic-default-phone">Set Category:</label>-->

                                            <!--        <select id="defaultSelect" class="form-select" name="set_category">-->
                                            <!--           @foreach($setcategory as $key => $data)-->

                                            <!--            <option value="{{$data->id}}">{{$data->title}}</option>-->

                                            <!--            @endforeach-->

                                            <!--        </select>-->

                                            <!--    </div>-->

                                            <!--</div>-->

                                            <!--    <div class="col-sm-4">-->

                                            <!--    <div class="mb-3">-->

                                            <!--        <label class="form-label" for="basic-default-phone">Set Type:</label>-->

                                            <!--        <select id="defaultSelect" class="form-select" name="set_type">-->
                                            <!--          @foreach($settype as $key => $data)-->

                                            <!--            <option value="{{$data->id}}">{{$data->title}}</option>-->

                                            <!--            @endforeach-->

                                            <!--        </select>-->

                                            <!--    </div>-->

                                            <!--</div>-->

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label" for="company_name">Company Name:</label>

                                                    <input type="text" class="form-control" name="company_name" />

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label for="Class" class="form-label">Class:</label>

                                                    <select class="form-select" name="class_name"  id="form-select-md-stream" data-placeholder="Select" required>
                                                        <option selected disabled value="">Select</option>

                                                        @foreach($classes as $key => $data)
                                                        <option value="{{$data->id}}">{{$data->title}}</option>
                                                        @endforeach

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label" for="avail_qty">Available Quantity:</label>

                                                    <input type="number" class="form-control" name="avail_qty" />

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label" for="unit_price">Unit Price:</label>

                                                    <input type="number" class="form-control phone-mask" name="unit_price" />

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label" for="unit_price">Item Weight:</label>

                                                    <input type="text" class="form-control phone-mask" name="item_weight" />

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label" for="medium">Medium:</label>

                                                    <input type="text" class="form-control phone-mask" name="medium" />

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label for="gst" class="form-label">GST:</label>

                                                    <select class="form-select" name="gst" id="form-select-md-gst" data-placeholder="Select" required>

                                                        <option selected disabled value="">Select</option>

                                                        @foreach($gst as $key => $data)

                                                        <option value="{{$data->id}}">{{$data->title}}</option>

                                                        @endforeach

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="col-sm-12">

                                                <div class="mb-3">

                                                    <label class="form-label" for="basic-icon-default-message">Description:</label>

                                                    <textarea id="basic-icon-default-message" class="form-control" name="description"></textarea>

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