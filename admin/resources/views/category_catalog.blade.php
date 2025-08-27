<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">



<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Category Catalog</title>

    <meta name="description" content="" />

    @include('includes.header_script')

    <style>
        .card {
            height: 400px ! important;
            cursor: pointer;
            overflow: auto;
        }

        .catlist {
            border-bottom: 1px solid rgba(129, 129, 129, 0.15);
            width: 100%;
            padding: 10px 0px;
        }


        .imagePreview {
            width: 100%;
            height: 100px;
            background-position: center center;
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            display: block;
            border-radius: 0px;
            box-shadow: 0px 4px 6px 2px rgba(0, 0, 0, 0.2);
            margin-top: -5px;
        }

        .imgUp {
            margin-bottom: 15px;
        }

        .del {
            position: absolute;
            top: 0px;
            right: 15px;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background-color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
        }

        .imgAdd {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #696cff;
            color: #fff;
            box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.2);
            text-align: center;
            line-height: 30px;
            margin-top: 0px;
            cursor: pointer;
            font-size: 15px;
        }
    </style>

</head>

<body>

    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            @include('includes.sidebar')

            <div class="layout-page">

                @include('includes.header')

                <div class="container">
                    <div class="row mt-5">
                        <div class="col-sm-3">
                            <div class="card" id="category_card">
                                <div class="card-header py-2 bg-primary text-white"> Categories </div>
                                <div class="card-body pt-2">
                                    @foreach($category as $key => $category)
                                    <ul class="list-unstyled" id="category">
                                        <li class='catlist' onclick="get_cat_one({{$category->id}})">{{$category->name}}</li>
                                    </ul>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card" id="subcategory_card" style="display:none;">
                                <div class="card-header py-2 bg-primary text-white">Sub Cat One </div>
                                <div class="card-body">
                                    <ul class="list-unstyled" id="subcategory">

                                    </ul>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card" id="subsubcategory_card" style="display:none;">
                                <div class="card-header py-2 bg-primary text-white">Sub Cate Two </div>
                                <div class="card-body">
                                    <ul class="list-unstyled" id="subsubcategory">

                                    </ul>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card" id="subsubsubcategory_card" style="display:none;">
                                <div class="card-header py-2 bg-primary text-white">Sub Cat Three</div>
                                <div class="card-body">
                                    <ul class="list-unstyled" id="subsubsubcategory">
                                        <li></li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>




                    <!--modal start-->
                    <div class="modal" id="myModal">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white text-center">
                                    <h5 class=" text-white">Are you sure to add selected category in inventory ? </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <!-- Modal body -->

                                <div class="modal-body">
                                    
                                    <form method="post" action="{{url('/') }}/add_inventory_catalog" enctype='multipart/form-data'>
                                        @csrf

                                        <input type="hidden" id="cat_id" name="cat_id">
                                        <input type="hidden" id="cat_id_two" name="cat_id_two">
                                        <input type="hidden" id="cat_id_three" name="cat_id_three">
                                        <input type="hidden" id="cat_id_four" name="cat_id_four">
                                        <input type="hidden" value="1" name="total_img[]">


                                     <div class="form-group mt-3">
                                            <button type="button" data-bs-dismiss="modal"  class="btn btn-warning">No</button>
                                        
                                            <button type="submit" class="btn btn-success ms-3">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--modal end-->


                    <footer class="default-footer">

                        @include('includes.footer')

                        <div class="content-backdrop fade"></div>


                </div>

            </div>







            <div class="layout-overlay layout-menu-toggle"></div>

            @include('includes.footer_script')



        </div>

    </div>

</body>
<script>
    $(".imgAdd").click(function() {
        $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-2 imgUp"><div class="imagePreview"></div><label class="btn btn-primary">Upload<input type="file"  name="pro_image[]" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"><input type="hidden" value="1"  name="total_img[]" ></label><i class="fa fa-times del"></i></div>');
    });
    $(document).on("click", "i.del", function() {
        $(this).parent().remove();
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





    function get_cat_one(cat_id) {
        // Get Available Stock
        $.ajax({
            url: "{{url('/')}}/catalog_cat_one",
            data: {
                "id": cat_id,
                _token: '{{csrf_token()}}'
            },
            type: 'post',
            cache: false,
            success: function(response) {
                $("#subcategory_card").css("display", "block");
                $("#subsubcategory_card").css("display", "none");
                $("#subsubsubcategory_card").css("display", "none");
                $("#subsubcategory").html('');
                $("#subsubsubcategory").html('');
                document.getElementById('cat_id').value = cat_id;
                document.getElementById('cat_id_two').value = "";
                document.getElementById('cat_id_three').value = "";
                document.getElementById('cat_id_four').value = "";



                var x = JSON.parse(response);
                var count = x.length;
                var content = "";
                if (count != 0) {
                    var i = 0;
                    for (i = 0; i < count; i++) {
                        content += "<li class='catlist' onclick='get_cat_two(" + cat_id + "," + x[i].id + ")'>" + x[i].name + "</li>";
                    }
                    $("#subcategory").html(content);
                } else {
                    content += "<li class='catlist'>Not available</li>";
                    content += "<li><button type='button' data-bs-target='#myModal' data-bs-toggle='modal' class='mt-3 btn btn-primary'>Continue</button></li>";
                    $("#subcategory").html(content);
                }

            }
        });
    }

    //  get_cat_two 
    function get_cat_two(cat_id, sub_id) {
        // Get Available Stock
        $.ajax({
            url: "{{url('/')}}/catalog_cat_two",
            data: {
                "id": cat_id,
                'sub_id': sub_id,
                _token: '{{csrf_token()}}'
            },
            type: 'post',
            cache: false,
            success: function(response) {
                $("#subsubcategory_card").css("display", "block");
                $("#subsubsubcategory_card").css("display", "none");
                $("#subsubsubcategory").html('');
                document.getElementById('cat_id_two').value = sub_id;
                document.getElementById('cat_id_three').value = "";
                document.getElementById('cat_id_four').value = "";



                var x = JSON.parse(response);
                var count = x.length;
                var content = "";
                if (count != 0) {
                    var i = 0;
                    for (i = 0; i < count; i++) {
                        content += "<li class='catlist' onclick='get_cat_three(" + cat_id + "," + sub_id + "," + x[i].id + ")'>" + x[i].title + "</li>";
                    }
                    $("#subsubcategory").html(content);
                } else {
                    content += "<li class='catlist'>Not available</li>";
                    content += "<li><button type='button' data-bs-target='#myModal' data-bs-toggle='modal' class='mt-3 btn btn-primary'>Continue</button></li>";
                    $("#subsubcategory").html(content);
                }

            }
        });
    }



    //  get_cat_three 
    function get_cat_three(cat_id, sub_id, csub_id) {
        // Get Available Stock
        $.ajax({
            url: "{{url('/')}}/catalog_cat_three",
            data: {
                "id": cat_id,
                'sub_id': sub_id,
                'csub_id': csub_id,
                _token: '{{csrf_token()}}'
            },
            type: 'post',
            cache: false,
            success: function(response) {
                $("#subsubsubcategory_card").css("display", "block");
                document.getElementById('cat_id_three').value = csub_id;
                document.getElementById('cat_id_four').value = "";




                var x = JSON.parse(response);
                var count = x.length;
                var content = "";
                if (count != 0) {

                    var i = 0;
                    for (i = 0; i < count; i++) {
                        content += "<li class='catlist' onclick='get_cat_four(" + x[i].id + ")' >" + x[i].title + "</li>";
                    }
                    $("#subsubsubcategory").html(content);

                } else {
                    content += "<li class='catlist'>Not available</li>";
                    content += "<li><button type='button' data-bs-target='#myModal' data-bs-toggle='modal' class='mt-3 btn btn-primary'>Continue</button></li>";
                    $("#subsubsubcategory").html(content);
                }
            }
        });
    }


    function get_cat_four(cat_id) {
        document.getElementById('cat_id_four').value = cat_id;
        $("#myModal").modal('show')
    }
</script>

</html>