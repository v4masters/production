<!DOCTYPE html>



<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">



<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

    <title>Office And Stationery Inventory</title>

    <meta name="description" content="" />



    <!-- headerscript -->

    @include('includes.header_script')

    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
      <style>
    
    .modal:nth-of-type(even) {
     z-index: 1052 !important;
     }
     
     .modal-backdrop.show:nth-of-type(even) {
      z-index: 1051 !important;
     }
    
    
        #heading {
            background-color: #E7E7FF;
            border: 1px solid #E7E7FF;
            border-radius: 7px;
            padding: 9px 27px 9px 27px;
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

        #imgAdddes {
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

        .input-group-text {
            padding: 1px 5px 1px 5px !important;
        }


        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            /*display: inline-block;*/
        }

        .imgbtn {
            border: 1px solid #696cff;
            color: #696cff;
            background-color: white;
            padding: 8px 15px;
            font-size: 15px;
            font-weight: bold;
            width: 100%;
        }

        .imgbtnremove {
            border: 1px solid #696cff;
            color: #696cff;
            background-color: white;
            padding: 8px 15px;
            font-size: 15px;
            font-weight: bold;
            width: 20%;
        }

        .upload-btn-wrapper input[type=file] {
            font-size: 80px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }

        .imgremove {
            position: absolute;
            background: blue;
            color: #fff;
            padding: 5px;
            border-radius: 50%;
            margin-top: -12px;
            margin-left: -7px;
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

                                    <h4 class="" id="heading">

                                        Add Product Details

                                    </h4>



                                </div>

                                <div class="card-body">

                                 <form method="post" id="myform" action="{{url('/') }}/add_inventory" enctype="multipart/form-data" novalidate>
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
                                        <input type="hidden" class="form-control" value="{{$categoryid->id}}" name="cat_id" />
                                        <p class="mb-0"><b class="text-primary" id="heading">Product Info</b></p>
                                        <hr>
                                        <div class="row gx-5">

                                            <div class="col-sm-12">

                                                <div class="mb-3">

                                                    <label class="form-label">Product Name:</label>

                                                    <input type="text" class="form-control" name="product_name" required />

                                                </div>

                                            </div>

                                            <div class="col-sm-12">

                                                <div class="mb-3">

                                                    <label class="form-label">Description:</label>

                                                    <div class="input-group input-group-merge">


                                                        <textarea class="form-control" id="editor" name="description" rows="2" cols="50"></textarea>

                                                    </div>

                                                </div>

                                            </div>


                                        </div>

                                        <br><br>
                                        <p class="mb-0"><b class="text-primary" id="heading">Product Details</b></p>
                                        <hr>

                                        <div class="row">

                                          <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label">Brand:</label>
                                                     <div class="input-group">
                                                    <select class="form-select" id="form-select-md-brand" data-placeholder="&#xF4FA;" name="brand">

                                                        <option disabled="disabled" selected="selected">select brand</option>
                                                        <option value="not available">N/A </option>
                                                        @foreach($brand as $key => $brand)

                                                        <option value="{{$brand->id}}">{{$brand->title}}</option>

                                                        @endforeach

                                                    </select>
                                                     <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text"><i class="fa fa-plus"></i></button>
                                                         </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label">Material Type:</label>
                                                    <input type="text" class="form-control" name="material_type"  />
                                                    <!--<select class="form-select" id="form-select-md-materialtype" data-placeholder="&#xF4FA;" name="material_type">-->
                                                    <!--    <option disabled="disabled" selected="selected">select material type</option>-->
                                                    <!--    <option value="Brass">Brass</option>-->
                                                    <!--    <option value="Chrome">Chrome</option>-->
                                                    <!--    <option value="Felt"> Felt</option>-->
                                                    <!--    <option value="Foil">Foil</option>-->
                                                    <!--    <option value="Glass">Glass</option>-->
                                                    <!--    <option value="Laminate"> Laminate</option>-->
                                                    <!--    <option value="Leather"> Leather</option>-->
                                                    <!--    <option value="Linen"> Linen</option>-->
                                                    <!--    <option value="Lucite">Lucite</option>-->
                                                    <!--    <option value="Marble"> Marble</option>-->
                                                    <!--    <option value="Metal">Metal</option>-->
                                                    <!--    <option value="Parchment"> Parchment</option>-->
                                                    <!--    <option value="Plastic"> Plastic</option>-->
                                                    <!--    <option value="Polyurethane"> Polyurethane</option>-->
                                                    <!--    <option value="Rubber">Rubber</option>-->
                                                    <!--    <option value="Steel">Steel</option>-->
                                                    <!--    <option value="Vellum">Vellum</option>-->
                                                    <!--    <option value="Vinyl">Vinyl</option>-->
                                                    <!--    <option value="Wood"> Wood</option>-->
                                                    <!--</select>-->
                                                </div>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label">Paper Finish:</label>
                                                    <input type="text" class="form-control" name="paper_finish"  />
                                                    <!--<select class="form-select" id="form-select-md-paperfinish" data-placeholder="&#xF4FA;" name="paper_finish">-->
                                                    <!--    <option disabled="disabled" selected="selected">select paper finish</option>-->
                                                    <!--    <option value="Coated"> Coated</option>-->
                                                    <!--    <option value="Embossed">Embossed</option>-->
                                                    <!--    <option value="Glossy">Glossy</option>-->
                                                    <!--    <option value="High Gloss"> High Gloss</option>-->
                                                    <!--    <option value="Matte"> Matte</option>-->
                                                    <!--    <option value="Metallic"> Metallic</option>-->
                                                    <!--    <option value="Mirror Coated">Mirror Coated</option>-->
                                                    <!--    <option value="Satin">Satin</option>-->
                                                    <!--    <option value="Semi Gloss"> Semi Gloss</option>-->
                                                    <!--    <option value="Smooth">Smooth</option>-->
                                                    <!--    <option value="Soft Gloss">Soft Gloss</option>-->
                                                    <!--    <option value="Specially Coated"> Specially Coated</option>-->
                                                    <!--    <option value="Texture Laid">Texture Laid</option>-->
                                                    <!--    <option value="Tracing">Tracing</option>-->
                                                    <!--    <option value="Translucent">Translucent</option>-->
                                                    <!--    <option value="Ultra Smooth">Ultra Smooth</option>-->
                                                    <!--    <option value="Uncoated">Uncoated</option>-->
                                                    <!--    <option value="Watercolor">Watercolor</option>-->
                                                    <!--    <option value="Woven"> Woven</option>-->

                                                    <!--</select>-->
                                                </div>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label">Paper Size:</label>
                                                    <input type="text" class="form-control" name="paper_size"  />
                                                    <!--<select class="form-select" id="form-select-md-papersize" data-placeholder="&#xF4FA;" name="paper_size">-->
                                                    <!--    <option disabled="disabled" selected="selected">select paper size</option>-->
                                                    <!--    <option value="1 x 1.5 inch">1 x 1.5 inch</option>-->
                                                    <!--    <option value="1.5 x 2 inch">1.5 x 2 inch</option>-->
                                                    <!--    <option value="11 x 17 inch">11 x 17 inch</option>-->
                                                    <!--    <option value=">11.75 x 16.5 inch">11.75 x 16.5 inch</option>-->
                                                    <!--    <option value="16.5 x 23.375 inch">16.5 x 23.375 inch</option>-->
                                                    <!--    <option value="17 x 22 inch">17 x 22 inch</option>-->
                                                    <!--    <option value="2 x 2.875 inch">2 x 2.875 inch</option>-->
                                                    <!--    <option value="2 x 3 inch">2 x 3 inch</option>-->
                                                    <!--    <option value=">2.875 x 4.125 inch">2.875 x 4.125 inch</option>-->
                                                    <!--    <option value="22 x 34 inch">22 x 34 inch</option>-->
                                                    <!--    <option value="23.375 x 33.125 inch">23.375 x 33.125 inch</option>-->
                                                    <!--    <option value="3 x 5 inchs">3 x 5 inch</option>-->
                                                    <!--    <option value="33.125 x 46.25 inch">33.125 x 46.25 inch</option>-->
                                                    <!--    <option value="34 x 44 inch">34 x 44 inch</option>-->
                                                    <!--    <option value="4.125 x 5.83 inch">4.125 x 5.83 inch</option>-->
                                                    <!--    <option value="4.125 x 5.875 inch">4.125 x 5.875 inch</option>-->
                                                    <!--    <option value="5 x 8 inch"> 5 x 8 inch</option>-->
                                                    <!--    <option value="5.875 x 8.25 inch">5.875 x 8.25 inch</option>-->
                                                    <!--    <option value=" 8.25 x 11.75 inch"> 8.25 x 11.75 inch</option>-->
                                                    <!--    <option value="8.5 x 11 inch">8.5 x 11 inch</option>-->
                                                    <!--    <option value=" 8.5 x 14 inch"> 8.5 x 14 inch</option>-->
                                                    <!--    <option value="A0">A0</option>-->
                                                    <!--    <option value="A1">A1</option>-->
                                                    <!--    <option value="A10"> A10</option>-->
                                                    <!--    <option value="A2"> A2</option>-->
                                                    <!--    <option value="A3"> A3</option>-->
                                                    <!--    <option value="A4"> A4</option>-->
                                                    <!--    <option value="A5"> A5</option>-->
                                                    <!--    <option value="A6"> A6</option>-->
                                                    <!--    <option value="A7"> A7</option>-->
                                                    <!--    <option value="A8">A8</option>-->
                                                    <!--    <option value="A9">A9</option>-->
                                                    <!--    <option value="B0">B0</option>-->
                                                    <!--    <option value="B1">B1</option>-->
                                                    <!--    <option value="B10"> B10</option>-->
                                                    <!--    <option value="B2"> B2</option>-->
                                                    <!--    <option value="B3">B3</option>-->
                                                    <!--    <option value="B4"> B4</option>-->
                                                    <!--    <option value="B5">B5</option>-->
                                                    <!--    <option value="B6">B6</option>-->
                                                    <!--    <option value="B7"> B7</option>-->
                                                    <!--    <option value="B8"> B8</option>-->
                                                    <!--    <option value="B9">B9</option>-->
                                                    <!--    <option value="C0">C0</option>-->
                                                    <!--    <option value="C1"> C1</option>-->
                                                    <!--    <option value="C10"> C10</option>-->
                                                    <!--    <option value="C2"> C2</option>-->
                                                    <!--    <option value="C3"> C3</option>-->
                                                    <!--    <option value="C4"> C4</option>-->
                                                    <!--    <option value="C5"> C5</option>-->
                                                    <!--    <option value="C6"> C6</option>-->
                                                    <!--    <option value="C7">C7</option>-->
                                                    <!--    <option value="C7/6">C7/6</option>-->
                                                    <!--    <option value="C8">C8</option>-->
                                                    <!--    <option value="C9">C9</option>-->
                                                    <!--    <option value="DL"> DL</option>-->
                                                    <!--</select>-->
                                                </div>
                                            </div>

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label">Type:</label>
                                                    <input type="text" class="form-control" name="type"  />
                                                    <!--<select class="form-select" id="form-select-md-type" data-placeholder="&#xF4FA;" name="type">-->
                                                    <!--    <option disabled="disabled" selected="selected">select type</option>-->
                                                    <!--    <option value="Blackboards & Whiteboards"> Blackboards & Whiteboards</option>-->
                                                    <!--    <option value="Calculator">Calculator</option>-->
                                                    <!--    <option value="Coloring Sets">Coloring Sets</option>-->
                                                    <!--    <option value="Coloring pens & Markers">Coloring pens & Markers</option>-->
                                                    <!--    <option value="Dairies & poetry Albums"> Dairies & poetry Albums</option>-->
                                                    <!--    <option value="Diaries">Diaries</option>-->
                                                    <!--    <option value="Drawing"> Drawing</option>-->
                                                    <!--    <option value="Exercise Books"> Exercise Books</option>-->
                                                    <!--    <option value="Geometry box">Geometry box</option>-->
                                                    <!--    <option value="Geometry box kit">Geometry box kit</option>-->
                                                    <!--    <option value="Globes">Globes</option>-->
                                                    <!--    <option value="Glue, Paste & Tape">Glue, Paste & Tape</option>-->
                                                    <!--    <option value="Multipurpose Pouches"> Multipurpose Pouches</option>-->
                                                    <!--    <option value="Paint Brushes">Paint Brushes</option>-->
                                                    <!--    <option value="Painting supplies"> Painting supplies</option>-->
                                                    <!--    <option value="Paper"> Paper</option>-->
                                                    <!--    <option value="Pencil box">Pencil box</option>-->
                                                    <!--    <option value="Pencil box kit"> Pencil box kit</option>-->
                                                    <!--    <option value="Pencil sets">Pencil sets</option>-->
                                                    <!--    <option value="Pens"> Pens</option>-->
                                                    <!--    <option value="Printing & Stamping">Printing & Stamping</option>-->
                                                    <!--    <option value="Rulers & Set square"> Rulers & Set square</option>-->
                                                    <!--    <option value="Sharpners &Erasers">Sharpners &Erasers</option>-->
                                                    <!--    <option value="Sketching &Drawing Books">Sketching &Drawing Books</option>-->
                                                    <!--    <option value="Stickers"> Stickers</option>-->
                                                    <!--    <option value="Others"> Others</option>-->
                                                    <!--</select>-->

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                    <input type="text" class="form-control" name="country_of_origin" />

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label">Manufacturer Details:</label>

                                                    <input type="text" class="form-control phone-mask" name="manufacturer_detail" />

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="mb-3">

                                                    <label class="form-label">Packer Details:</label>

                                                    <input type="text" class="form-control" name="packer_detail" />

                                                </div>

                                            </div>
                                     

                                        </div>

                                        <br><br>
                                        <p class="mb-0"><b class="text-primary" id="heading">Price , Tax and Inventory wise stock</b></p>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mb-3">

                                                    <label class="form-label">Choose:</label><br>


                                                    @foreach($size_list as $key => $size_listdata)
                                                    <input type="radio" class="form-check-input ms-3" onchange="show_size_list({{$size_listdata->id}})" name="size" value="{{$size_listdata->id}}">
                                                    <label class="form-check-label pe-5">{{$size_listdata->title}}</label>
                                                    @endforeach
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <div class="table-responsive text-nowrap">
                                                            <table class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="false" data-show-refresh="false" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="false" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 200, all]" data-show-footer="true" data-response-handler="responseHandler" id="table">
                                                              <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Size</th>
                                                        
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                        <p class="mb-0"><b class="text-primary" id="heading"> Other Attributes</b></p>
                                        <hr>



                                        <div class="row">
                                         
                                         <div class="col-sm-12">

                                                <div class="mb-3">

                                                    <label class="form-label">Importer Details:</label>

                                                    
                                                    <textarea class="form-control" name="importer_detail"></textarea>
                                                </div>

                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Submit Catalog</button>

                                    </form>

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
    
   <!--//add new brand pop up -->
    <div class="modal" id="show_brand_modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white text-center">
                    <h3 class=" text-white">Add New Brand</h3>
                </div>

                <div class="modal-body">
                   <div class="form-group">
                       <input type="text" class="form-control" id="newbrand" required>
                           
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="addnewbrand()" class="btn btn-success" data-bs-dismiss="modal">Add</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- / Layout wrapper -->

    @include('includes.footer_script')

    <!-- footerscrit -->
     <script>
    
     let img=0;
     let row=0;
     let m=0;
        //text editor
        ClassicEditor.create(document.querySelector('#editor')).catch(error => {
            console.error(error);
        });


        var loadFile = function(event, prediv) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById(prediv);
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };



        function add_mul_img(cr,rowclass,name) {
            
         
            img++;
            var list_field=  '<div class="col-md-2" id="'+cr+img+name+'rem">  <div class="img_div mb-5"><i onclick="removeimgrow(`'+cr+img+name+'rem`)" class="imgremove fa fa-remove"></i><img class="imagePreview" id="'+cr+img+name+'" ><div class="upload-btn-wrapper"><button class="imgbtn">Upload </button><input type="file" class="imgupload" multiple name="'+cr+name+'"   onchange="loadFile(event,`'+cr+img+name+'`)"  > </div></div></div>';   
            $('#' + rowclass).append(list_field);
            
            
        }
        

               


function removeimgrow(rowid) {
img--;
document.getElementById(rowid).remove();
}

q=0;
let checkrow=0;
let checkrowname=0;
function add_mul_color_qty(imgrow,currow,rowid,imgnameid,myImgModal,totalrow,rowclass,classtitle,clr_qty,clr_min_qyt,clr_qty_unit,clr_hsncode,clr_barcode,clr_isbn,clr_netweight,clr_mrp,clr_discount,clr_discounted_price,clr_sales_price,clr_gst,clr_shipping_charges)
{

// alert(checkrow);
if(checkrow!=currow){checkrowname=1;}else{checkrowname++;}
checkrow=currow;

// alert(checkrow+','+checkrowname);


row++;
q++;
var list_field = '<div class="row" id="'+rowclass+q+'"><div class="col-sm-11 border border-1 my-3 p-2"><div class="row g-2" style="padding: 5px;background: #f8f6fb;"><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Colour List</label><input type="hidden" name="'+totalrow+'" ><select class="form-select" name="'+classtitle+'"><option disabled selected hidden>select</option><option value="0">N/A </option>@foreach($colour as $key => $data)<option value="{{$data->id}}">{{$data->title}}</option>@endforeach</select></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Qty</label><input type="number"   onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control " name="'+clr_qty+'"></div></div> <div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Min Qty</label><input type="number"   onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control " name="'+clr_min_qyt+'"/></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Qty Unit</label><select class="form-select " name="'+clr_qty_unit+'"><option disabled selected hidden>select</option>@foreach($qtyunit as $key => $data)<option value="{{$data->id}}">{{$data->title}}</option> @endforeach</select></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Hsncode</label><input type="text" class="form-control " name="'+clr_hsncode+'"></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Barcode</label><input type="text" class="form-control " name="'+clr_barcode+'"></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">ISBN</label><input type="text" class="form-control" name="'+clr_isbn+'" /></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Net Weight</label><input type="number"   onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control " name="'+clr_netweight+'" /></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">MRP</label><div class="input-group"><span class="input-group-text">Rs.</span><input type="number"   class="form-control " name="'+clr_mrp+'" id="'+q+clr_mrp+'" onkeyup="discounted_price(this.id,`'+q+clr_discount+'`,`'+q+clr_discounted_price+'`)"><span class="input-group-text">.00</span></div></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Discount%</label><div class="input-group"><input type="number"   class="form-control "  onkeyup="discounted_price(`'+q+clr_mrp+'`,this.id,`'+q+clr_discounted_price+'`)" id="'+q+clr_discount+'" name="'+clr_discount+'"><span class="input-group-text">%</span></div></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Discounted price</label><div class="input-group"><span class="input-group-text">Rs.</span><input type="number"    class="form-control" step="2"  readonly id="'+q+clr_discounted_price+'"  name="'+clr_discounted_price+'" ></div></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Sales price</label><div class="input-group"><span class="input-group-text">Rs.</span><input type="number"   onkeypress="return event.charCode >= 48 && event.charCode <= 57"  class="form-control " name="'+clr_sales_price+'" ><span class="input-group-text">.00</span></div></div></div><div class="col-sm-3"><div class="form-group mb-3"><label class="form-label mb-0">GST</label><select class="form-select" name="'+clr_gst+'"><option disabled selected hidden>select</option><option value="0">N/A </option>@foreach($gst as $key => $data)<option value="{{$data->id}}">{{$data->title}}%</option> @endforeach</select></div></div><div class="col-sm-3"><div class="form-group mb-3"><label class="form-label mb-0 mb-0">Shipping Charges</label><div class="input-group"><span class="input-group-text">Rs.</span><input type="number"   onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control " name="'+clr_shipping_charges+'" ><span class="input-group-text">.00</span></div></div></div><div class="col-sm-12"><div class="row" id="'+rowid+currow+row+'">                                                                              <div class="col-md-2">  <i class="mt-3 fa fa-plus btn btn-primary" onclick="add_mul_img(`'+currow+'`,`'+rowid+currow+row+'`,`'+checkrowname+'pro_img[]`)"> Add Img </i></div>                                                                                                   </div></div></div></div><div class="col-sm-1"><div class="form-group mt-5"><label class="form-label mb-0">&nbsp;</label><button type="button" onclick="reset_color_qty_row(`'+rowclass+q+'`)" class="btn btn-warning"><i class="fa fa-refresh"></i></button></div>                                                                                                                                                               </div></div>';



// <button type="button" onclick="rmv_color_qty_row(`'+rowclass+q+'`)" class="btn btn-danger"><i class="fa fa-remove"></i></button>

$('.' + rowclass).append(list_field);

}

function rmv_color_qty_row(rowid) {
document.getElementById(rowid).remove()
}


function reset_color_qty_row(rowid) {
 var container = document.getElementById(rowid);
    var children = container.getElementsByTagName('select');
    for (var i = 0; i < children.length; i++) {
        children[i].selectedIndex = 0;
    }
    
     var childrentwo = container.getElementsByTagName('input');
    for (var i = 0; i < childrentwo.length; i++) {
        childrentwo[i].value = '';
    }


}
      


function deleteRowtable(tr) {
   var rem_row = tr.parentNode.parentNode.rowIndex;
    document.getElementById("table").deleteRow(rem_row);
}



        //ajaxs
        function show_size_list(id) {

            $("#table  tbody").empty();
            $.ajax({
                type: "POST",
                url: "{{url('/') }}/get_size_list",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                cache: false,
                success: function(response) {
                    const totallength = response.length;
                    var totalrow = "";
                  


                    for (var i = 0; i < totallength; i++) {

                        totalrow +='<tr><td><button type="button" class="btn btn-danger btn-sm" onclick="deleteRowtable(this)"><i class=" bx bx-trash"></i></button></td><td><span style="font-size: 0.75rem;text-transform: uppercase;letter-spacing: inherit;font-weight: 500;">' + response[i].title + '</span><input type="hidden" name="size[]"  readonly value="' + response[i].id + '" /><input type="hidden" name="size_id[]"  readonly value="' +i + '" /></td><td><input type="button" class="btn btn-primary btn-sm"  id="" value="choose" data-bs-toggle="modal" data-bs-target="#colourModal'+i+'" required/>                                                                                                                                                                                                                                                                                                                            <div class="modal" id="colourModal'+i+'"><div class="modal-dialog modal-xl"><div class="modal-content"><div class="modal-body"> <div class="list_wrapper'+i+'"><div class="row" style="border: 1px solid #ddd;padding: 5px;background: #f8f6fb;"> <div class="col-sm-11"><div class="row g-2"><div class="col-sm-3"><div class="form-group mb-3"><label class="form-label mb-0">Colour List</label><input type="hidden"  name="totalrow[][]" value="1"><select class="form-select" name="class_title'+i+'[]"><option disabled selected hidden>select</option><option value="0">N/A </option>@foreach($colour as $key => $data)<option value="{{$data->id}}">{{$data->title}}</option>@endforeach</select></div></div><div class="col-sm-3"><div class="form-group mb-3  "><label class="form-label mb-0">Qty</label><input type="number"   onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" name="quantity_'+i+'[]"></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Min Qty</label><input type="number"   onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control " name="min_qyt'+i+'[]"/></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Qty Unit</label><select class="form-select " name="qty_unit'+i+'[]" ><option disabled selected hidden>select</option>@foreach($qtyunit as $key => $data)<option value="{{$data->id}}">{{$data->title}}</option> @endforeach</select></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Hsncode</label><input type="text" class="form-control" name="hsncode'+i+'[]"></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Barcode</label><input type="text" class="form-control" name="barcode_'+i+'[]"></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">ISBN</label><input type="text" class="form-control " name="isbn'+i+'[]" /></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Net Weight</label><input type="number"   onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" name="net_weight'+i+'[]" /></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">MRP</label> <div class="input-group"><span class="input-group-text">Rs.</span><input type="number"   class="form-control" id="mrp'+i+'[]" onkeyup="discounted_price(this.id,`discount'+i+'[]`,`dis_price'+i+'[]`)" name="mrp'+i+'[]" /><span class="input-group-text">.00</span></div></div></div> <div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Discount%</label><div class="input-group"><input type="number"    id="discount'+i+'[]" onkeyup="discounted_price(`mrp'+i+'[]`,this.id,`dis_price'+i+'[]`)" class="form-control " name="discount'+i+'[]"><span class="input-group-text">%</span></div></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Discounted price</label><div class="input-group"><span class="input-group-text">Rs.</span><input type="number" step="2"   id="dis_price'+i+'[]" readonly  class="form-control " name="dis_price'+i+'[]"></div></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Sales price</label><div class="input-group"><span class="input-group-text">Rs.</span><input type="number"   onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control " name="sales_price'+i+'[]"></div></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">GST</label><select class="form-select" name="gst'+i+'[]"><option disabled selected hidden>select</option><option value="0">N/A </option>@foreach($gst as $key => $data)<option value="{{$data->id}}">{{$data->title}}%</option> @endforeach</select></div></div><div class="col-sm-3"><div class="form-group mb-3 "><label class="form-label mb-0">Shipping Charges</label><div class="input-group"><span class="input-group-text">Rs.</span><input type="number"   onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control " name="shipping_charges'+i+'[]"><span class="input-group-text">.00</span></div></div></div><div class="col-sm-12"><div class="row" id="addmulimagesrow'+i+row+'">                                                                          <div class="col-md-2">                                   <i class="mt-3 fa fa-plus btn btn-primary" onclick="add_mul_img(`'+i+'`,`addmulimagesrow'+i+row+'`,`'+checkrowname+'pro_img[]`)"> Add Img </i></div>                                                                                                 </div></div></div></div><div class="col-sm-1"></div></div></div><div class="form-group mt-3"><label class="form-label mb-0"></label><button type="button" onclick="add_mul_color_qty(`imgrow'+i+'[]`,`'+i+'`,`addmulimagesrow`,`pro_img[]`,`myImgModal'+i+'`,`totalrow[][]`,`list_wrapper'+i+'`,`class_title'+i+'[]`,`quantity_'+i+'[]`,`min_qyt'+i+'[]`,`qty_unit'+i+'[]`,`hsncode'+i+'[]`,`barcode_'+i+'[]`,`isbn'+i+'[]`,`net_weight'+i+'[]`,`mrp'+i+'[]`,`discount'+i+'[]`,`dis_price'+i+'[]`,`sales_price'+i+'[]`,`gst'+i+'[]`,`shipping_charges'+i+'[]`)" class="btn btn btn-primary">Add More <i class="menu-icon tf-icons bx bx-plus"></i></button></div></div><div class="modal-footer"><button type="button" class="btn btn-md btn-success" data-bs-dismiss="modal">Ok</button></div></div></div></div>                                                                                                                                                                                                                                                                                                                                                                                                                                         </td></tr>';
                    }
                    $('#table').append(totalrow);
                }
            });
        }





        // var mqi = 1;

        // function show_min_qty_modal(qtid) {
        //     if (mqi == 1) {
        //         $('#show_minqty_modal').modal('show');
        //         var qtybox = document.getElementById(qtid);
        //         qtybox.removeAttribute("onfocus");
        //     }
        // }


        // var qty = 1;

        // function show_qty_modal(qtid) {
        //     if (qty == 1) {
        //         $('#show_quantity_modal').modal('show');
        //         var quantitybox = document.getElementById(qtid);
        //         quantitybox.removeAttribute("onfocus");
        //     }
        // }


        function discounted_price(tmrp,tdiscount,dis_price) {

            let mrp = Number(document.getElementById(tmrp).value);
            let discount = Number(document.getElementById(tdiscount).value) / 100;
            let dis_total = mrp - (mrp * discount);
            
            // alert(mrp);
            // alert(discount);
            document.getElementById(dis_price).value = dis_total.toFixed(2);
        }



function addnewbrand()
{
var newbrand=document.getElementById('newbrand').value
$("#form-select-md-brand").append(new Option(newbrand, newbrand));
}

    </script>
</body>



</html>