<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />
    <title>manage Inventory</title>
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
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Manage Inventory</h5>
                                <small class="text-muted float-end"></small>
                            </div>
                            <div class="card-body">
                                <form action="{{url('/') }}/uniform_set_inventory" method="POST" enctype="multipart/form-data">
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
                                                <label class="form-control btn btn-primary">Upload Size Chart Image
                                                    <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="size_chart" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="basic-default-phone">Item Type:</label>
                                                <select id="defaultSelect" class="form-select" name="item_type">
                                                    <option value="1">School Set Item</option>
                                                    <option value="0">Inventory Item</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="itemname">Item Name:</label>
                                                <input type="text" class="form-control" name="itemname" />
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="company_name">Company Name:</label>
                                                <input type="text" class="form-control" name="company_name" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="mb-3">
                                                <label for="Class" class="form-label">Class:</label>
                                                <select class="form-select" name="class_name" id="form-select-md-stream" data-placeholder="Select" required>
                                                    <option selected disabled value="">Select</option>
                                                    @foreach($classes as $key => $data)
                                                    <option value="{{$data->id}}">{{$data->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Description:<span class="required"></span></label>
                                                <textarea class="form-control" name="description"></textarea>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="card mt-5 mb-4">
                                        <div class="card-body">
                                            <div class="list_wrapper">
                                                <div class="row">

                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="barcode">Size:</label>
                                                            <input type="text" class="form-control" id="basic-default-company" name="size[]" />
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="barcode">Unit Price Per Size:</label>
                                                            <input type="text" class="form-control" id="basic-default-company" name="price_per_size[]" />
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="barcode">Item Weight:</label>
                                                            <input type="text" class="form-control" id="basic-default-company" name="weight[]" />
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="barcode">BARCODE:</label>
                                                            <input type="text" class="form-control" id="basic-default-company" name="uni_barcode[]" />
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="hsncode">HSNCODE:</label>
                                                            <input type="text" class="form-control" id="basic-default-company" name="uni_hsncode[]" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="gst" class="form-label">GST:</label>
                                                            <select class="form-select" name="uni_gst[]" id="form-select-md-gst" data-placeholder="Select" required>
                                                                <option selected disabled value="">Select</option>
                                                                @foreach($gst as $key => $data)
                                                                <option value="{{$data->id}}">{{$data->title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Quantity:</label>
                                                            <input type="number" class="form-control" name="uni_qty[]" />

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-1">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label"><span class=""></span></label>
                                                <button type="button" class="list_add_button btn btn btn-primary mb-5">Add More <i class="menu-icon tf-icons bx bx-plus"></i></button>
                                            </div>


                                            <div class="row ps-4 pe-5">
                                                <div class="col-md-3 mb-4 imgUp">
                                                    <div class="form-group">
                                                        <div class="imagePreview"></div>
                                                        <label class="form-control btn btn-primary">Main Cover Photo
                                                            <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="cover_photo" />
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-4 imgUp">
                                                    <div class="form-group">
                                                        <div class="imagePreview"></div>
                                                        <label class="form-control btn btn-primary">Main Cover Photo 2
                                                            <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="cover_photo_2" />
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-4 imgUp">
                                                    <div class="form-group">
                                                        <div class="imagePreview"></div>
                                                        <label class="form-control btn btn-primary">Main Cover Photo 3
                                                            <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="cover_photo_3" />
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-4 imgUp">
                                                    <div class="form-group">
                                                        <div class="imagePreview"></div>
                                                        <label class="form-control btn btn-primary">Main Cover Photo 4
                                                            <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="cover_photo_4" />
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success">Save </button>

                                        </div>
                                    </div>



                                </form>

                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <footer class="default-footer">
                        @include('includes.footer')
                        <!-- Footer -->
                        <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- Layout page -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
        <!-- Layout wrapper -->
        @include('includes.footer_script')
        <!-- Footerscript-->
    </div>
    </div>
    </div>
    </div>

</body>
<script>
    $(document).ready(function() {
        var x = 0; //Initial field counter
        var list_maxField = 10; //Input fields increment limitation
        $('.list_add_button').click(function() {
            if (x < list_maxField) {
                x++; //Increment field counter
                var list_fieldHTML = '<div class="row"> <div class="col-sm-3"><div class="mb-3"><label class="form-label">Size:</label><input type="text" class="form-control" name="size[]" /></div></div><div class="col-sm-3"><div class="mb-3"><label class="form-label">Unit Price Per Size:</label><input type="text" class="form-control" name="price_per_size[]" /></div></div><div class="col-sm-3"><div class="mb-3"><label class="form-label">Item Weight:</label><input type="text" class="form-control" name="weight[]" /></div></div><div class="col-sm-3"><div class="form-group mb-3"><label class="form-label">BARCODE:</label><input type="text" class="form-control" name="uni_barcode[]" /> </div> </div><div class="col-sm-3"><div class="form-group mb-3"> <label class="form-label" >HSNCODE:</label><input type="text" class="form-control" name="uni_hsncode[]" /></div></div> <div class="col-sm-3"><div class="mb-3"><label  class="form-label">GST:</label><select id="form-select-md-gst" data-placeholder="Select" class="form-select" name="uni_gst[]" required><option selected disabled value="">Select</option>@foreach($gst as $key => $data)<option value="{{$data->id}}">{{$data->title}}</option>@endforeach</select></div></div> <div class="col-sm-2"><div class="mb-3"><label class="form-label">Quantity:</label> <input type="number" class="form-control" name="uni_qty[]" /></div></div><div class="col-sm-1"><label class="form-label">Remove<span class="required"></span></label><button type="button" class="list_remove_button btn btn-danger"><i class="menu-icon tf-icons bx bx-minus"></i></button></div></div> ';
                $('.list_wrapper').append(list_fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $('.list_wrapper').on('click', '.list_remove_button', function() {
            $(this).closest('.row').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });

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


</html>