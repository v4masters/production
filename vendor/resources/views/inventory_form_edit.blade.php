<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Edit Inventory</title>

    <meta name="description" content="" />

    <!-- Headerscript -->

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
            height: 200px;
            background-position: center center;
            background: ;
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
            background: ;
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
        
        .removeinvimg {
            position: absolute;
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

            <!-- Menu -->

            <!-- Layout container -->

            <div class="layout-page">

                <!-- Navbar -->

                @include('includes.header')

                <!-- Navbar -->

                <!-- Centered Form -->

                <div class="container mt-3">

                    <div class="card mb-4">
                        <p class="mx-4 mt-5"><b class="text-muted h4" id="heading">Edit Inventory</b></p>
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="btn btn-primary"> Category : {{$cat_detail['cat_one'];}}</h4>
                            <h4 class="btn btn-primary">  Category Two : {{$cat_detail['cat_two'];}}</h4>
                            <h4 class="btn btn-primary">  Category Three : {{$cat_detail['cat_three'];}}</h4>
                            <h4 class="btn btn-primary"> Category Four : {{$cat_detail['cat_four'];}}</h4>
                        </div>
                     
                        <div class="card-body">

                            <form id="formAuthentication" class="mb-3" action="{{url('/') }}/editapproveinventory" method="POST"  enctype="multipart/form-data">

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

                                <input type="hidden" name="id" class="form-control" value="{{ $pagedata->id }}" required />
                                <input type="hidden" name="size" class="form-control" value="{{ $pagedata->size }}" required />
                              
                                
                                <div class="list_wrapper">
                                    <div class="row ps-4 pe-5">
                                      @foreach($inv_images as $key => $images)
                                    <div class="col-md-3 m-3">
                                
                                        <button type="button" class="btn btn-danger btn-sm removeinvimg" onclick="removeinvimge(`{{$images->id}}`)"><i class="fa fa-remove"></i></button>  
                                        
                                        @if($images->dp_status ==1)
                                    <img class="mx-auto d-flex img-fluid border border-3 border-success" src="{{Storage::disk('s3')->url($images->folder.'/' .$images->image)}}">
                                    Active Banner image
                                    @else 
                                    <img class="mx-auto d-flex img-fluid" src="{{Storage::disk('s3')->url($images->folder.'/' .$images->image)}}">
                                    <input type="button" class="btn btn-primary form-control mt-1" value="Set as Main banner" onclick="dp_status_changed(`{{$images->id}}`,`{{$images->item_id}}`)">
                                    @endif
                                    </div>
                                    @endforeach

                                        <div class="col-sm-1">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label"><span class=""></span></label>
                                    <button type="button" class="list_add_button btn btn btn-primary mb-5">Add More<i class="menu-icon tf-icons bx bx-plus"></i></button>
                                </div>


                                <p class="mb-0"><b class="text-primary" id="heading">Product Info</b></p>
                                <hr>
                                <div class="row gx-5">


                                  
                                    <div class="col-sm-12">

                                        <div class="mb-3">

                                            <label class="form-label">Product Name:</label>

                                            <input type="text" class="form-control" name="product_name" value="{{ $pagedata->product_name}}" required />

                                            <div class="invalid-feedback">Please select a valid state.</div>
                                        </div>

                                    </div>
                                 

                                 
                                    <div class="col-sm-12">

                                        <div class="mb-3">

                                            <label class="form-label">Description:</label>

                                            <div class="input-group input-group-merge">

                                                <textarea class="form-control" id="editor" name="description" rows="2" cols="50">{{ $pagedata->description}}</textarea>

                                            </div>

                                        </div>

                                    </div>
                                   

                                </div>
                                <p class="mb-0"><b class="text-primary" id="heading">Product Details</b></p>
                                <hr>
                                
                                 @if($pagedata->form_id==1)
                                <b>Book Details</b>
                                <div id="bookdiv">
                                    <div class="row">

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Author:</label>

                                                <input type="text" class="form-control" name="author" value="{{ $pagedata->author}}" />

                                            </div>

                                        </div>



                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Book Format:</label>

                                                <select class="form-select" name="book_format">
                                                    <option selected disabled value="">Select</option>
                                                    <option value="Audible Audio Edition" @if($pagedata->book_format=='Audible Audio Edition'){{'selected';}}@endif> Audible Audio Edition</option>
                                                    <option value="Audiobook" @if($pagedata->book_format=='Audiobook'){{'selected';}}@endif>Audiobook</option>
                                                    <option value="Board Book" @if($pagedata->book_format=='Board Book'){{'selected';}}@endif>Board Book</option>
                                                    <option value="Bundle" @if($pagedata->book_format=='Bundle'){{'selected';}}@endif> Bundle</option>
                                                    <option value="Hardcover" @if($pagedata->book_format=='Hardcover'){{'selected';}}@endif> Hardcover</option>
                                                    <option value="Kindle eBooks" @if($pagedata->book_format=='Kindle eBooks'){{'selected';}}@endif> Kindle eBooks</option>
                                                    <option value="Paperback" @if($pagedata->book_format=='Paperback'){{'selected';}}@endif>Paperback</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">You Tube Url:</label>

                                                <input type="text" class="form-control" name="youtube_url" value="{{ $pagedata->youtube_url}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Publish Year:</label>
                                                <input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" name="publish_year" value="{{ $pagedata->publish_year}}" />


                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">
                                                <label class="form-label">Publisher:</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="brand">
                                                        <option selected disabled value="">Select</option>
                                                        @foreach($brand as $key => $data)
                                                        @if($data->id==$pagedata->brand){{$sel='selected';}}@else{{$sel='';}} @endif
                                                        <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text btn-default"> <i class="fa fa-plus"> Add </i></button>
                                                </div>

                                            </div>

                                        </div>



                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Stream:</label>
                                                <select class="form-select" name="stream">
                                                    <option selected disabled value="">Select</option>
                                                    @foreach($stream as $key => $data)
                                                    @if($data->id==$pagedata->stream){{$sel='selected';}}@else{{$sel='';}} @endif
                                                    <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                        </div>


                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Printer Details:</label>

                                                <input type="text" class="form-control phone-mask" name="printer_details" value="{{ $pagedata->printer_details}}" />

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                  @endif
                                   @if($pagedata->form_id==2)
                                <b>Bag Details</b>
                                <div id="bagdiv">
                                    <div class="row">


                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Laptop Capacity:</label>
                                                <input type="text" class="form-control" name="laptop_capacity" value="{{ $pagedata->laptop_capacity}}" required />
                                                <!--<select class="form-select" name="laptop_capacity">-->
                                                <!--    <option disabled selected hidden>select</option>-->
                                                <!--    <option value="Upto 13 Inch" @if($pagedata->laptop_capacity=='Upto 13 Inch'){{'selected';}}@endif>Upto 13 Inch</option>-->
                                                <!--    <option value="Upto 14 Inch" @if($pagedata->laptop_capacity=='Upto 14 Inch'){{'selected';}}@endif>Upto 14 Inch</option>-->
                                                <!--    <option value="Upto 15 Inch" @if($pagedata->laptop_capacity=='Upto 15 Inch'){{'selected';}}@endif>Upto 15 Inch</option>-->
                                                <!--    <option value="Upto 16 Inch" @if($pagedata->laptop_capacity=='Upto 16 Inch'){{'selected';}}@endif>Upto 16 Inch</option>-->
                                                <!--    <option value="Upto 17 Inch" @if($pagedata->laptop_capacity=='Upto 17 Inch'){{'selected';}}@endif>Upto 17 Inch</option>-->
                                                <!--    <option value="Upto 18 Inch" @if($pagedata->laptop_capacity=='Upto 18 Inch'){{'selected';}}@endif>Upto 18 Inch</option>-->
                                                <!--</select>-->

                                            </div>

                                        </div>


                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Material:</label>
                                                <input type="text" class="form-control" name="material" value="{{ $pagedata->material}}" required />
                                                <!--<select class="form-select" name="material">-->
                                                <!--    <option disabled selected hidden>select</option>-->
                                                <!--    <option value="Canvas" @if($pagedata->material=='Canvas'){{'selected';}}@endif>Canvas</option>-->
                                                <!--    <option value="Cotton" @if($pagedata->material=='Cotton'){{'selected';}}@endif> Cotton</option>-->
                                                <!--    <option value="Cotton Blend" @if($pagedata->material=='Cotton Blend'){{'selected';}}@endif> Cotton Blend</option>-->
                                                <!--    <option value="Fabric" @if($pagedata->material=='Fabric'){{'selected';}}@endif>Fabric</option>-->
                                                <!--    <option value="Faux Leather/Le" @if($pagedata->material=='Faux Leather/Le'){{'selected';}}@endif>Faux Leather/Le</option>-->
                                                <!--    <option value="Leather" @if($pagedata->material=='Leather'){{'selected';}}@endif>Leather</option>-->
                                                <!--    <option value="Nylon" @if($pagedata->material=='Nylon'){{'selected';}}@endif>Nylon</option>-->
                                                <!--    <option value="Polyester" @if($pagedata->material=='Polyester'){{'selected';}}@endif>Polyester</option>-->
                                                <!--    <option value="Pu" @if($pagedata->material=='Pu'){{'selected';}}@endif>Pu</option>-->
                                                <!--    <option value="Pvc" @if($pagedata->material=='Pvc'){{'selected';}}@endif>Pvc</option>-->
                                                <!--    <option value="Suede" @if($pagedata->material=='Suede'){{'selected';}}@endif> Suede</option>-->
                                                <!--    <option value="Synthetic" @if($pagedata->material=='Synthetic'){{'selected';}}@endif>Synthetic</option>-->
                                                <!--    <option value="Not Present" @if($pagedata->material=='Not Present'){{'selected';}}@endif>Not Present</option>-->
                                                <!--</select>-->

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Type:</label>
                                                 <input type="text" class="form-control" name="type" value="{{ $pagedata->type}}" required />
                                                <!--<select class="form-select" name="type">-->

                                                <!--    <option disabled selected hidden>select</option>-->
                                                <!--    <option value="Laptop Bags" @if($pagedata->type=='Laptop Bags'){{'selected';}}@endif> Laptop Bags</option>-->
                                                <!--    <option value="Laptop Roller Cases" @if($pagedata->type=='Laptop Roller Cases'){{'selected';}}@endif>Laptop Roller Cases</option>-->
                                                <!--    <option value="Sleeves" @if($pagedata->type=='Sleeves'){{'selected';}}@endif> Sleeves</option>-->

                                                <!--</select>-->

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                <input type="text" class="form-control" name="country_of_origin" value="{{ $pagedata->country_of_origin}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Manufacturer Details:</label>

                                                <input type="text" class="form-control" name="manufacturer_detail" value="{{ $pagedata->manufacturer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packer Details:</label>

                                                <input type="text" class="form-control phone-mask" name="packer_detail" value="{{ $pagedata->packer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Brand:</label>
                                                <div class="input-group">

                                                    <select class="form-select" name="brand">
                                                        <option selected disabled value="">Select</option>
                                                        @foreach($brand as $key => $data)
                                                        @if($data->id==$pagedata->brand){{$sel='selected';}}@else{{$sel='';}} @endif
                                                        <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Water resistant:</label>

                                                <select class="form-select" name="water_resistant">
                                                    <option disabled selected hidden>select</option>
                                                    <option value="Yes" @if($pagedata->water_resistant=='Yes'){{'selected';}}@endif>Yes</option>
                                                    <option value="No" @if($pagedata->water_resistant=='No'){{'selected';}}@endif>No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Warranty:</label>

                                                <input type="text" class="form-control" name="warranty" value="{{ $pagedata->warranty}}" />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                                 @endif
                                   @if($pagedata->form_id==3)
                                   
                                <b>Office Details</b>
                                <div id="officediv">
                                    <div class="row">

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Brand:</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="brand">
                                                        <option selected disabled value="">Select</option>
                                                        @foreach($brand as $key => $data)
                                                        @if($data->id==$pagedata->brand){{$sel='selected';}}@else{{$sel='';}} @endif
                                                        <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Material Type:</label>

                                                <select class="form-select" name="material_type">
                                                    <option disabled selected hidden>select</option>
                                                    <option value="Coated" @if($pagedata->material_type=='Coated'){{'selected';}}@endif> Coated</option>
                                                    <option value="Embossed" @if($pagedata->material_type=='Embossed'){{'selected';}}@endif>Embossed</option>
                                                    <option value="Glossy" @if($pagedata->material_type=='Glossy'){{'selected';}}@endif>Glossy</option>
                                                    <option value="High Gloss" @if($pagedata->material_type=='High Gloss'){{'selected';}}@endif> High Gloss</option>
                                                    <option value="Matte" @if($pagedata->material_type=='Matte'){{'selected';}}@endif> Matte</option>
                                                    <option value="Metallic" @if($pagedata->material_type=='Metallic'){{'selected';}}@endif> Metallic</option>
                                                    <option value="Mirror Coated" @if($pagedata->material_type=='Mirror Coated'){{'selected';}}@endif>Mirror Coated</option>
                                                    <option value="Satin" @if($pagedata->material_type=='Satin'){{'selected';}}@endif>Satin</option>
                                                    <option value="Semi Gloss" @if($pagedata->material_type=='Semi Gloss'){{'selected';}}@endif> Semi Gloss</option>
                                                    <option value="Smooth" @if($pagedata->material_type=='Smooth'){{'selected';}}@endif>Smooth</option>
                                                    <option value="Soft Gloss" @if($pagedata->material_type=='Soft Gloss'){{'selected';}}@endif>Soft Gloss</option>
                                                    <option value="Specially Coated" @if($pagedata->material_type=='Specially Coated'){{'selected';}}@endif> Specially Coated</option>
                                                    <option value="Texture Laid" @if($pagedata->material_type=='Texture Laid'){{'selected';}}@endif>Texture Laid</option>
                                                    <option value="Tracing" @if($pagedata->material_type=='Tracing'){{'selected';}}@endif>Tracing</option>
                                                    <option value="Translucent" @if($pagedata->material_type=='Translucent'){{'selected';}}@endif>Translucent</option>
                                                    <option value="Ultra Smooth" @if($pagedata->material_type=='Ultra Smooth'){{'selected';}}@endif>Ultra Smooth</option>
                                                    <option value="Uncoated" @if($pagedata->material_type=='Uncoated'){{'selected';}}@endif>Uncoated</option>
                                                    <option value="Watercolor" @if($pagedata->material_type=='Watercolor'){{'selected';}}@endif>Watercolor</option>
                                                    <option value="Woven" @if($pagedata->material_type=='Woven'){{'selected';}}@endif> Woven</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Type:</label>

                                                <select class="form-select" name="type">
                                                    <option disabled selected hidden>select</option>
                                                    <option value="Drawers" @if($pagedata->type=='Drawers'){{'selected';}}@endif>Drawers</option>
                                                    <option value="Trays" @if($pagedata->type=='Trays'){{'selected';}}@endif>Trays</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Product Weight:</label>
                                                <input type="number" class="form-control" name="product_weight" value="{{ $pagedata->product_weight}}" />

                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Weight Unit:</label>

                                                <select class="form-select" name="weight_unit" value="{{ $pagedata->product_weight}}">
                                                    <option disabled selected hidden>select </option>

                                                    <option value="g" @if($pagedata->weight_unit=='g'){{'selected';}}@endif>g</option>
                                                    <option value="Kg" @if($pagedata->weight_unit=='Kg'){{'selected';}}@endif>Kg</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Paper Size:</label>

                                                <select class="form-select" name="paper_size">
                                                    <option disabled selected hidden>select </option>
                                                    <option value="1 x 1.5 inch" @if($pagedata->paper_size=='1 x 1.5 inch'){{'selected';}}@endif>1 x 1.5 inch</option>
                                                    <option value="1.5 x 2 inch" @if($pagedata->paper_size=='1.5 x 2 inch'){{'selected';}}@endif>1.5 x 2 inch</option>
                                                    <option value="11 x 17 inch" @if($pagedata->paper_size=='11 x 17 inch'){{'selected';}}@endif>11 x 17 inch</option>
                                                    <option value=">11.75 x 16.5 inch" @if($pagedata->paper_size=='11.75 x 16.5 inch'){{'selected';}}@endif>11.75 x 16.5 inch</option>
                                                    <option value="16.5 x 23.375 inch" @if($pagedata->paper_size=='16.5 x 23.375 inch'){{'selected';}}@endif>16.5 x 23.375 inch</option>
                                                    <option value="17 x 22 inch" @if($pagedata->paper_size=='17 x 22 inch'){{'selected';}}@endif>17 x 22 inch</option>
                                                    <option value="2 x 2.875 inch" @if($pagedata->paper_size=='2 x 2.875 inch'){{'selected';}}@endif>2 x 2.875 inch</option>
                                                    <option value="2 x 3 inch" @if($pagedata->paper_size=='2 x 3 inch'){{'selected';}}@endif>2 x 3 inch</option>
                                                    <option value=">2.875 x 4.125 inch" @if($pagedata->paper_size=='2.875 x 4.125 inch'){{'selected';}}@endif>2.875 x 4.125 inch</option>
                                                    <option value="22 x 34 inch" @if($pagedata->paper_size=='22 x 34 inch'){{'selected';}}@endif>22 x 34 inch</option>
                                                    <option value="23.375 x 33.125 inch" @if($pagedata->paper_size=='23.375 x 33.125 inch'){{'selected';}}@endif>23.375 x 33.125 inch</option>
                                                    <option value="3 x 5 inchs" @if($pagedata->paper_size=='3 x 5 inchs'){{'selected';}}@endif>3 x 5 inch</option>
                                                    <option value="33.125 x 46.25 inch" @if($pagedata->paper_size=='33.125 x 46.25 inch'){{'selected';}}@endif>33.125 x 46.25 inch</option>
                                                    <option value="34 x 44 inch" @if($pagedata->paper_size=='34 x 44 inch'){{'selected';}}@endif>34 x 44 inch</option>
                                                    <option value="4.125 x 5.83 inch" @if($pagedata->paper_size=='4.125 x 5.83 inch'){{'selected';}}@endif>4.125 x 5.83 inch</option>
                                                    <option value="4.125 x 5.875 inch" @if($pagedata->paper_size=='4.125 x 5.875 inch'){{'selected';}}@endif>4.125 x 5.875 inch</option>
                                                    <option value="5 x 8 inch" @if($pagedata->paper_size=='5 x 8 inch'){{'selected';}}@endif> 5 x 8 inch</option>
                                                    <option value="5.875 x 8.25 inch" @if($pagedata->paper_size=='5.875 x 8.25 inch'){{'selected';}}@endif>5.875 x 8.25 inch</option>
                                                    <option value=" 8.25 x 11.75 inch" @if($pagedata->paper_size==' 8.25 x 11.75 inch'){{'selected';}}@endif> 8.25 x 11.75 inch</option>
                                                    <option value="8.5 x 11 inch" @if($pagedata->paper_size=='8.5 x 11 inch'){{'selected';}}@endif>8.5 x 11 inch</option>
                                                    <option value=" 8.5 x 14 inch" @if($pagedata->paper_size==' 8.5 x 14 inch'){{'selected';}}@endif> 8.5 x 14 inch</option>
                                                    <option value="A0" @if($pagedata->paper_size=='A0'){{'selected';}}@endif>A0</option>
                                                    <option value="A1" @if($pagedata->paper_size=='A1'){{'selected';}}@endif>A1</option>
                                                    <option value="A10" @if($pagedata->paper_size=='A10'){{'selected';}}@endif> A10</option>
                                                    <option value="A2" @if($pagedata->paper_size=='A2'){{'selected';}}@endif> A2</option>
                                                    <option value="A3" @if($pagedata->paper_size=='A3'){{'selected';}}@endif> A3</option>
                                                    <option value="A4" @if($pagedata->paper_size=='A4'){{'selected';}}@endif> A4</option>
                                                    <option value="A5" @if($pagedata->paper_size=='A5'){{'selected';}}@endif> A5</option>
                                                    <option value="A6" @if($pagedata->paper_size=='A6'){{'selected';}}@endif> A6</option>
                                                    <option value="A7" @if($pagedata->paper_size=='A7'){{'selected';}}@endif> A7</option>
                                                    <option value="A8" @if($pagedata->paper_size=='A8'){{'selected';}}@endif>A8</option>
                                                    <option value="A9" @if($pagedata->paper_size=='A9'){{'selected';}}@endif>A9</option>
                                                    <option value="B0" @if($pagedata->paper_size=='B0'){{'selected';}}@endif>B0</option>
                                                    <option value="B1" @if($pagedata->paper_size=='B1'){{'selected';}}@endif>B1</option>
                                                    <option value="B10" @if($pagedata->paper_size=='B10'){{'selected';}}@endif> B10</option>
                                                    <option value="B2" @if($pagedata->paper_size=='B2'){{'selected';}}@endif> B2</option>
                                                    <option value="B3" @if($pagedata->paper_size=='B3'){{'selected';}}@endif>B3</option>
                                                    <option value="B4" @if($pagedata->paper_size=='B4'){{'selected';}}@endif> B4</option>
                                                    <option value="B5" @if($pagedata->paper_size=='B5'){{'selected';}}@endif>B5</option>
                                                    <option value="B6" @if($pagedata->paper_size=='B6'){{'selected';}}@endif>B6</option>
                                                    <option value="B7" @if($pagedata->paper_size=='B7'){{'selected';}}@endif> B7</option>
                                                    <option value="B8" @if($pagedata->paper_size=='B8'){{'selected';}}@endif> B8</option>
                                                    <option value="B9" @if($pagedata->paper_size=='B9'){{'selected';}}@endif>B9</option>
                                                    <option value="C0" @if($pagedata->paper_size=='C0'){{'selected';}}@endif>C0</option>
                                                    <option value="C1" @if($pagedata->paper_size=='C1'){{'selected';}}@endif> C1</option>
                                                    <option value="C10" @if($pagedata->paper_size=='C10'){{'selected';}}@endif> C10</option>
                                                    <option value="C2" @if($pagedata->paper_size=='C2'){{'selected';}}@endif> C2</option>
                                                    <option value="C3" @if($pagedata->paper_size=='C3'){{'selected';}}@endif> C3</option>
                                                    <option value="C4" @if($pagedata->paper_size=='C4'){{'selected';}}@endif> C4</option>
                                                    <option value="C5" @if($pagedata->paper_size=='C5'){{'selected';}}@endif> C5</option>
                                                    <option value="C6" @if($pagedata->paper_size=='C6'){{'selected';}}@endif> C6</option>
                                                    <option value="C7" @if($pagedata->paper_size=='C7'){{'selected';}}@endif>C7</option>
                                                    <option value="C7/6" @if($pagedata->paper_size=='C7/6'){{'selected';}}@endif>C7/6</option>
                                                    <option value="C8" @if($pagedata->paper_size=='C8'){{'selected';}}@endif>C8</option>
                                                    <option value="C9" @if($pagedata->paper_size=='C9'){{'selected';}}@endif>C9</option>
                                                    <option value="DL" @if($pagedata->paper_size=='DL'){{'selected';}}@endif> DL</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                <input type="text" class="form-control" name="country_of_origin" value="{{ $pagedata->country_of_origin}}" />


                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Manufacturer Details:</label>

                                                <input type="text" class="form-control phone-mask" name="manufacturer_detail" value="{{ $pagedata->manufacturer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packer Details:</label>

                                                <input type="text" class="form-control phone-mask" name="packer_detail" value="{{ $pagedata->packer_detail}}" />

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                
                                 @endif
                                   @if($pagedata->form_id==4)
                                   
                                <b>Grocery Details</b>
                                <div id="grocerydiv">
                                    <div class="row">


                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">FSSAI License Number:</label>

                                                <input type="text" class="form-control" name="fssai_license_number" value="{{ $pagedata->fssai_license_number}}" />

                                            </div>

                                        </div>


                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Shelf life (Best Before):</label>

                                                <input type="text" class="form-control " name="shelf_life" value="{{ $pagedata->shelf_life}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Veg/NonVeg:</label>

                                                <select class="form-select" name="veg_nonveg">
                                                    <option disabled selected hidden>select </option>
                                                    <option value="Veg" @if($pagedata->veg_nonveg=='Veg'){{'selected';}}@endif>Veg</option>
                                                    <option value="Non Veg" @if($pagedata->veg_nonveg=='Non Veg'){{'selected';}}@endif>Non Veg</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                <input type="text" class="form-control" name="country_of_origin" value="{{ $pagedata->country_of_origin}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Manufacturer Details:</label>

                                                <input type="text" class="form-control" name="manufacturer_detail" value="{{ $pagedata->manufacturer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packer Details:</label>

                                                <input type="text" class="form-control" name="packer_detail" value="{{ $pagedata->packer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Brand:</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="brand">
                                                        <option selected disabled value="">Select</option>
                                                        @foreach($brand as $key => $data)
                                                        @if($data->id==$pagedata->brand){{$sel='selected';}}@else{{$sel='';}} @endif
                                                        <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                                 @endif
                                   @if($pagedata->form_id==5)
                                   
                                   
                                <b>Health Details</b>
                                <div id="healthdiv">
                                    <div class="row">

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Sole Material:</label>

                                                <input type="text" class="form-control" name="sole_material" value="{{ $pagedata->sole_material}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                <input type="text" class="form-control" name="country_of_origin" value="{{ $pagedata->country_of_origin}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Manufacturer Details:</label>

                                                <input type="text" class="form-control" name="manufacturer_detail" value="{{ $pagedata->manufacturer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packer Details:</label>

                                                <input type="text" class="form-control" name="packer_detail" value="{{ $pagedata->packer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Brand:</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="brand">
                                                        <option selected disabled value="">Select</option>
                                                        @foreach($brand as $key => $data)
                                                        @if($data->id==$pagedata->brand){{$sel='selected';}}@else{{$sel='';}} @endif
                                                        <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                                 @endif
                                   @if($pagedata->form_id==6)
                                   
                                <b>Kitchen Details</b>
                                <div id="kitchendiv">
                                    <div class="row">

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Add Ons:</label>
                                                <input type="text" class="form-control" name="add_ons" value="{{ $pagedata->add_ons}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Body Material:</label>

                                                <input type="text" class="form-control" name="body_material" value="{{ $pagedata->body_material}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Burner Material:</label>

                                                <input type="text" class="form-control" name="burner_material" value="{{ $pagedata->burner_material}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Number Of Burners:</label>

                                                <input type="text" class="form-control" name="no_of_burners" value="{{ $pagedata->no_of_burners}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packaging Breadth:</label>

                                                <input type="text" class="form-control" name="packaging_breadth" value="{{ $pagedata->packaging_breadth}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packaging Height:</label>

                                                <input type="text" class="form-control" name="packaging_height" value="{{ $pagedata->packaging_height}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packaging Length:</label>

                                                <input type="text" class="form-control" name="packaging_length" value="{{ $pagedata->packaging_length}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packaging Unit:</label>

                                                <input type="text" class="form-control" name="packaging_unit" value="{{ $pagedata->packaging_unit}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Product Height:</label>

                                                <input type="text" class="form-control" name="product_height" value="{{ $pagedata->product_height}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Product Length:</label>

                                                <input type="text" class="form-control" name="product_length" value="{{ $pagedata->product_length}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Product Unit:</label>

                                                <input type="text" class="form-control" name="product_unit" value="{{ $pagedata->product_unit}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                <input type="text" class="form-control" name="country_of_origin" value="{{ $pagedata->country_of_origin}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Manufacturer Details:</label>

                                                <input type="text" class="form-control" name="manufacturer_detail" value="{{ $pagedata->manufacturer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packer Details:</label>

                                                <input type="text" class="form-control" name="packer_detail" value="{{ $pagedata->packer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Brand:</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="brand">
                                                        <option selected disabled value="">Select</option>
                                                        @foreach($brand as $key => $data)
                                                        @if($data->id==$pagedata->brand){{$sel='selected';}}@else{{$sel='';}} @endif
                                                        <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                                 @endif
                                   @if($pagedata->form_id==7)
                                   
                                <b>Kids Details</b>
                                <div id="kidsdiv">
                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Character:</label>

                                                <input type="text" class="form-control" name="character" value="{{ $pagedata->character}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Material:</label>

                                                <input type="text" class="form-control" name="material" value="{{ $pagedata->material}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">No. of Compartments:</label>

                                                <input type="text" class="form-control" name="no_of_compartment" value="{{ $pagedata->no_of_compartment}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                <input type="text" class="form-control" name="country_of_origin" value="{{ $pagedata->country_of_origin}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Manufacturer Details:</label>

                                                <input type="text" class="form-control" name="manufacturer_detail" value="{{ $pagedata->manufacturer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packer Details:</label>

                                                <input type="text" class="form-control" name="packer_detail" value="{{ $pagedata->packer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Brand:</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="brand">
                                                        <option selected disabled value="">Select</option>
                                                        @foreach($brand as $key => $data)
                                                        @if($data->id==$pagedata->brand){{$sel='selected';}}@else{{$sel='';}} @endif
                                                        <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Gender:</label>

                                                <select id="defaultSelect" class="form-select" name="gender">

                                                    <option disabled selected hidden>select </option>
                                                    <option value="Boys" @if($pagedata->gender=='Boys'){{'selected';}}@endif>Boys</option>
                                                    <option value="Girls" @if($pagedata->gender=='Girls'){{'selected';}}@endif>Girls</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Pattern:</label>

                                                <input type="text" class="form-control" name="pattern" value="{{ $pagedata->pattern}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Recommended Age:</label>

                                                <input type="text" class="form-control" name="recommended_age" value="{{ $pagedata->recommended_age}}" />
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Backpack Style:</label>

                                                <input type="text" class="form-control" name="backpack_style" value="{{ $pagedata->backpack_style}}" />
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Bag Capacity:</label>

                                                <input type="text" class="form-control" name="bag_capacity" value="{{ $pagedata->bag_capacity}}" />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                                 @endif
                                   @if($pagedata->form_id==8)
                                   
                                <b>Mens Fashion Details</b>
                                <div id="mensfashiondiv">
                                    <div class="row">

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Fabric:</label>

                                                <input type="text" class="form-control" name="fabric" value="{{ $pagedata->fabric}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Fit/ Shape:</label>

                                                <input type="text" class="form-control" name="fit" value="{{ $pagedata->fit}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Neck:</label>

                                                <input type="text" class="form-control" name="neck" value="{{ $pagedata->neck}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Pattern:</label>

                                                <input type="text" class="form-control" name="pattern" value="{{ $pagedata->pattern}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Sleeve Length:</label>

                                                <input type="text" class="form-control" name="sleeve_length" value="{{ $pagedata->sleeve_length}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                <input type="text" class="form-control" name="country_of_origin" value="{{ $pagedata->country_of_origin}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Manufacturer Details:</label>

                                                <input type="text" class="form-control phone-mask" name="manufacturer_detail" value="{{ $pagedata->manufacturer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packer Details:</label>

                                                <input type="text" class="form-control phone-mask" name="packer_detail" value="{{ $pagedata->packer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Brand:</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="brand">
                                                        <option selected disabled value="">Select</option>
                                                        @foreach($brand as $key => $data)
                                                        @if($data->id==$pagedata->brand){{$sel='selected';}}@else{{$sel='';}} @endif
                                                        <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Size Chart:</label>

                                                <input type="file" class="form-control" name="size_chart" />

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                
                                 @endif
                                   @if($pagedata->form_id==10)
                                   
                                <b>Mobile Details</b>
                                <div id="mobilediv">
                                    <div class="row">

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Connectivity:</label>

                                                <select class="form-select" name="connectivity">
                                                    <option disabled selected hidden>select </option>
                                                    <option value="2G" @if($pagedata->connectivity=='2G'){{'selected';}}@endif> 2G</option>
                                                    <option value="3G" @if($pagedata->connectivity=='3G'){{'selected';}}@endif>3G</option>
                                                    <option value="4G" @if($pagedata->connectivity=='4G'){{'selected';}}@endif>4G</option>
                                                    <option value="4G LTE" @if($pagedata->connectivity=='4G LTE'){{'selected';}}@endif> 4G LTE</option>
                                                    <option value="4G VOLTE" @if($pagedata->connectivity=='4G VOLTE'){{'selected';}}@endif>4G VOLTE</option>
                                                    <option value="5G" @if($pagedata->connectivity=='5G'){{'selected';}}@endif>5G</option>
                                                    <option value="WiFi" @if($pagedata->connectivity=='WiFi'){{'selected';}}@endif>WiFi</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Operating System (OS):</label>

                                                <select class="form-select" name="operating_system">
                                                    <option disabled selected hidden>select </option>
                                                    <option value="Android" @if($pagedata->operating_system=='Android'){{'selected';}}@endif>Android</option>
                                                    <option value="Blackberry OS" @if($pagedata->operating_system=='Blackberry OS'){{'selected';}}@endif>Blackberry OS</option>
                                                    <option value="Brew" @if($pagedata->operating_system=='Brew'){{'selected';}}@endif>Brew</option>
                                                    <option value="KaiOS" @if($pagedata->operating_system=='KaiOS'){{'selected';}}@endif>KaiOS</option>
                                                    <option value="Linux" @if($pagedata->operating_system=='Linux'){{'selected';}}@endif>Linux</option>
                                                    <option value="Proprietary" @if($pagedata->operating_system=='Proprietary'){{'selected';}}@endif>Proprietary</option>
                                                    <option value="Sailfish" @if($pagedata->operating_system=='Sailfish'){{'selected';}}@endif>Sailfish</option>
                                                    <option value="Series 30+" @if($pagedata->operating_system=='Series 30+'){{'selected';}}@endif>Series 30+</option>
                                                    <option value="Symbian" @if($pagedata->operating_system=='Symbian'){{'selected';}}@endif>Symbian</option>
                                                    <option value="Tizen" @if($pagedata->operating_system=='Tizen'){{'selected';}}@endif>Tizen</option>
                                                    <option value="Windows" @if($pagedata->operating_system=='Windows'){{'selected';}}@endif>Windows</option>
                                                    <option value="iOS" @if($pagedata->operating_system=='iOS'){{'selected';}}@endif>iOS</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">RAM:</label>

                                                <input type="text" class="form-control" name="ram" value="{{ $pagedata->ram}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Dual Camera:</label>

                                                <select class="form-select" name="dual_camera">
                                                    <option disabled selected hidden>select</option>
                                                    <option value="Yes" @if($pagedata->dual_camera=='Yes'){{'selected';}}@endif>Yes</option>
                                                    <option value="No" @if($pagedata->dual_camera=='No'){{'selected';}}@endif>No</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Expandable Storage:</label>

                                                <input type="text" class="form-control" name="expandable_storage" value="{{ $pagedata->expandable_storage}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Headphone Jack:</label>

                                                <select class="form-select" name="headphone_jack">
                                                    <option disabled selected hidden>select</option>
                                                    <option value="Yes" @if($pagedata->headphone_jack=='Yes'){{'selected';}}@endif>Yes</option>
                                                    <option value="No" @if($pagedata->headphone_jack=='No'){{'selected';}}@endif>No</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Internal Memory:</label>
                                                <input type="text" class="form-control" name="internal_memory" value="{{ $pagedata->internal_memory}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Material:</label>

                                                <input type="text" class="form-control" name="material" value="{{ $pagedata->material}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">No. of Primiary Cameras:</label>

                                                <input type="number" class="form-control" name="no_of_primary_camera" value="{{ $pagedata->no_of_primary_camera}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">No. of Seconadry Cameras:</label>

                                                <input type="number" class="form-control" name="no_of_secondary_camera" value="{{ $pagedata->no_of_secondary_camera}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Primary Camera:</label>

                                                <input type="text" class="form-control" name="primary_camera" placeholder="Enter MP" value="{{ $pagedata->primary_camera}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Screen Length Size:</label>

                                                <input type="text" class="form-control" name="screen_length_size" value="{{ $pagedata->screen_length_size}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Seconadry Camera:</label>

                                                <input type="text" class="form-control" name="secondary_camera" placeholder="Enter MP" value="{{ $pagedata->secondary_camera}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">SIM:</label>

                                                <select id="defaultSelect" class="form-select" name="sim">
                                                    <option disabled selected hidden>select</option>
                                                    <option value="Dual SIM " @if($pagedata->sim=='Dual SIM '){{'selected';}}@endif>Dual SIM </option>
                                                    <option value="Single SIM" @if($pagedata->sim=='Single SIM'){{'selected';}}@endif>Single SIM</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">SIM Type:</label>

                                                <input type="text" class="form-control" name="sim_type" value="{{ $pagedata->sim_type}}" />
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Warranty Service Type:</label>
                                                <input type="text" class="form-control" name="warranty_service_type" value="{{ $pagedata->warranty_service_type}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                <input type="text" class="form-control" name="country_of_origin" value="{{ $pagedata->country_of_origin}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Manufacturer Details:</label>

                                                <input type="text" class="form-control" name="manufacturer_detail" value="{{ $pagedata->manufacturer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packer Details:</label>

                                                <input type="text" class="form-control" name="packer_detail" value="{{ $pagedata->packer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Brand:</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="brand">
                                                        <option selected disabled value="">Select</option>
                                                        @foreach($brand as $key => $data)
                                                        @if($data->id==$pagedata->brand){{$sel='selected';}}@else{{$sel='';}} @endif
                                                        <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                
                                 @endif
                                   @if($pagedata->form_id==11)
                                   
                                   
                                <b>Musical Instruments Details</b>
                                <div id="musicalinstrumentdiv">
                                    <div class="row">

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                <input type="text" class="form-control" name="country_of_origin" value="{{ $pagedata->country_of_origin}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Manufacturer Details:</label>

                                                <input type="text" class="form-control" name="manufacturer_detail" value="{{ $pagedata->manufacturer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packer Details:</label>

                                                <input type="text" class="form-control" name="packer_detail" value="{{ $pagedata->packer_detail}}" />

                                            </div>

                                        </div>



                                    </div>
                                </div>
                                
                                 @endif
                                   @if($pagedata->form_id==12)
                                   
                                <b>Stationery Details</b>
                                <div id="stationerydiv">
                                    <div class="row">

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Brand:</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="brand">
                                                        <option selected disabled value="">Select</option>
                                                        @foreach($brand as $key => $data)
                                                        @if($data->id==$pagedata->brand){{$sel='selected';}}@else{{$sel='';}} @endif
                                                        <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Material Type:</label>
                                                <input type="text" class="form-control" name="material_type" value="{{ $pagedata->material_type}}"  />
                                                <!--<select class="form-select" name="material_type">-->
                                                <!--    <option disabled selected hidden>select </option>-->
                                                <!--    <option value="Brass" @if($pagedata->material_type=='Brass'){{'selected';}}@endif>Brass</option>-->
                                                <!--    <option value="Chrome" @if($pagedata->material_type=='Chrome'){{'selected';}}@endif>Chrome</option>-->
                                                <!--    <option value="Felt" @if($pagedata->material_type=='Felt'){{'selected';}}@endif> Felt</option>-->
                                                <!--    <option value="Foil" @if($pagedata->material_type=='Foil'){{'selected';}}@endif>Foil</option>-->
                                                <!--    <option value="Glass" @if($pagedata->material_type=='Glass'){{'selected';}}@endif>Glass</option>-->
                                                <!--    <option value="Laminate" @if($pagedata->material_type=='Laminate'){{'selected';}}@endif> Laminate</option>-->
                                                <!--    <option value="Leather" @if($pagedata->material_type=='Leather'){{'selected';}}@endif> Leather</option>-->
                                                <!--    <option value="Linen" @if($pagedata->material_type=='Linen'){{'selected';}}@endif> Linen</option>-->
                                                <!--    <option value="Lucite" @if($pagedata->material_type=='Lucite'){{'selected';}}@endif>Lucite</option>-->
                                                <!--    <option value="Marble" @if($pagedata->material_type=='Marble'){{'selected';}}@endif> Marble</option>-->
                                                <!--    <option value="Metal" @if($pagedata->material_type=='Metal'){{'selected';}}@endif>Metal</option>-->
                                                <!--    <option value="Parchment" @if($pagedata->material_type=='Parchment'){{'selected';}}@endif> Parchment</option>-->
                                                <!--    <option value="Plastic" @if($pagedata->material_type=='Plastic'){{'selected';}}@endif> Plastic</option>-->
                                                <!--    <option value="Polyurethane" @if($pagedata->material_type=='Polyurethane'){{'selected';}}@endif> Polyurethane</option>-->
                                                <!--    <option value="Rubber" @if($pagedata->material_type=='Rubber'){{'selected';}}@endif>Rubber</option>-->
                                                <!--    <option value="Steel" @if($pagedata->material_type=='Steel'){{'selected';}}@endif>Steel</option>-->
                                                <!--    <option value="Vellum" @if($pagedata->material_type=='Vellum'){{'selected';}}@endif>Vellum</option>-->
                                                <!--    <option value="Vinyl" @if($pagedata->material_type=='Vinyl'){{'selected';}}@endif>Vinyl</option>-->
                                                <!--    <option value="Wood" @if($pagedata->material_type=='Wood'){{'selected';}}@endif> Wood</option>-->
                                                <!--</select>-->
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Paper Finish:</label>
                                                <input type="text" class="form-control" name="paper_finish" value="{{ $pagedata->paper_finish}}"  />
                                                <!--<select class="form-select" name="paper_finish">-->
                                                <!--    <option disabled selected hidden>select </option>-->
                                                <!--    <option value="Coated" @if($pagedata->paper_finish=='Coated'){{'selected';}}@endif> Coated</option>-->
                                                <!--    <option value="Embossed" @if($pagedata->paper_finish=='Embossed'){{'selected';}}@endif>Embossed</option>-->
                                                <!--    <option value="Glossy" @if($pagedata->paper_finish=='Glossy'){{'selected';}}@endif>Glossy</option>-->
                                                <!--    <option value="High Gloss" @if($pagedata->paper_finish=='High Gloss'){{'selected';}}@endif> High Gloss</option>-->
                                                <!--    <option value="Matte" @if($pagedata->paper_finish=='Matte'){{'selected';}}@endif> Matte</option>-->
                                                <!--    <option value="Metallic" @if($pagedata->paper_finish=='Metallic'){{'selected';}}@endif> Metallic</option>-->
                                                <!--    <option value="Mirror Coated" @if($pagedata->paper_finish=='Mirror Coated'){{'selected';}}@endif>Mirror Coated</option>-->
                                                <!--    <option value="Satin" @if($pagedata->paper_finish=='Satin'){{'selected';}}@endif>Satin</option>-->
                                                <!--    <option value="Semi Gloss" @if($pagedata->paper_finish=='Semi Gloss'){{'selected';}}@endif> Semi Gloss</option>-->
                                                <!--    <option value="Smooth" @if($pagedata->paper_finish=='Smooth'){{'selected';}}@endif>Smooth</option>-->
                                                <!--    <option value="Soft Gloss" @if($pagedata->paper_finish=='Soft Gloss'){{'selected';}}@endif>Soft Gloss</option>-->
                                                <!--    <option value="Specially Coated" @if($pagedata->paper_finish=='Specially Coated'){{'selected';}}@endif> Specially Coated</option>-->
                                                <!--    <option value="Texture Laid" @if($pagedata->paper_finish=='Texture Laid'){{'selected';}}@endif>Texture Laid</option>-->
                                                <!--    <option value="Tracing" @if($pagedata->paper_finish=='Tracing'){{'selected';}}@endif>Tracing</option>-->
                                                <!--    <option value="Translucent" @if($pagedata->paper_finish=='Translucent'){{'selected';}}@endif>Translucent</option>-->
                                                <!--    <option value="Ultra Smooth" @if($pagedata->paper_finish=='Ultra Smooth'){{'selected';}}@endif>Ultra Smooth</option>-->
                                                <!--    <option value="Uncoated" @if($pagedata->paper_finish=='Uncoated'){{'selected';}}@endif>Uncoated</option>-->
                                                <!--    <option value="Watercolor" @if($pagedata->paper_finish=='Watercolor'){{'selected';}}@endif>Watercolor</option>-->
                                                <!--    <option value="Woven" @if($pagedata->paper_finish=='Woven'){{'selected';}}@endif> Woven</option>-->

                                                <!--</select>-->
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Paper Size:</label>
                                                <input type="text" class="form-control" name="paper_size" value="{{ $pagedata->paper_size}}"  />
                                                <!--<select class="form-select" name="paper_size">-->
                                                <!--    <option disabled selected hidden>select </option>-->
                                                <!--    <option value="1 x 1.5 inch" @if($pagedata->paper_size=='1 x 1.5 inch'){{'selected';}}@endif>1 x 1.5 inch</option>-->
                                                <!--    <option value="1.5 x 2 inch" @if($pagedata->paper_size=='1.5 x 2 inch'){{'selected';}}@endif>1.5 x 2 inch</option>-->
                                                <!--    <option value="11 x 17 inch" @if($pagedata->paper_size=='11 x 17 inch'){{'selected';}}@endif>11 x 17 inch</option>-->
                                                <!--    <option value=">11.75 x 16.5 inch" @if($pagedata->paper_size=='11.75 x 16.5 inch'){{'selected';}}@endif>11.75 x 16.5 inch</option>-->
                                                <!--    <option value="16.5 x 23.375 inch" @if($pagedata->paper_size=='16.5 x 23.375 inch'){{'selected';}}@endif>16.5 x 23.375 inch</option>-->
                                                <!--    <option value="17 x 22 inch" @if($pagedata->paper_size=='17 x 22 inch'){{'selected';}}@endif>17 x 22 inch</option>-->
                                                <!--    <option value="2 x 2.875 inch" @if($pagedata->paper_size=='2 x 2.875 inch'){{'selected';}}@endif>2 x 2.875 inch</option>-->
                                                <!--    <option value="2 x 3 inch" @if($pagedata->paper_size=='2 x 3 inch'){{'selected';}}@endif>2 x 3 inch</option>-->
                                                <!--    <option value=">2.875 x 4.125 inch" @if($pagedata->paper_size=='2.875 x 4.125 inch'){{'selected';}}@endif>2.875 x 4.125 inch</option>-->
                                                <!--    <option value="22 x 34 inch" @if($pagedata->paper_size=='22 x 34 inch'){{'selected';}}@endif>22 x 34 inch</option>-->
                                                <!--    <option value="23.375 x 33.125 inch" @if($pagedata->paper_size=='23.375 x 33.125 inch'){{'selected';}}@endif>23.375 x 33.125 inch</option>-->
                                                <!--    <option value="3 x 5 inchs" @if($pagedata->paper_size=='3 x 5 inchs'){{'selected';}}@endif>3 x 5 inch</option>-->
                                                <!--    <option value="33.125 x 46.25 inch" @if($pagedata->paper_size=='33.125 x 46.25 inch'){{'selected';}}@endif>33.125 x 46.25 inch</option>-->
                                                <!--    <option value="34 x 44 inch" @if($pagedata->paper_size=='34 x 44 inch'){{'selected';}}@endif>34 x 44 inch</option>-->
                                                <!--    <option value="4.125 x 5.83 inch" @if($pagedata->paper_size=='4.125 x 5.83 inch'){{'selected';}}@endif>4.125 x 5.83 inch</option>-->
                                                <!--    <option value="4.125 x 5.875 inch" @if($pagedata->paper_size=='4.125 x 5.875 inch'){{'selected';}}@endif>4.125 x 5.875 inch</option>-->
                                                <!--    <option value="5 x 8 inch" @if($pagedata->paper_size=='5 x 8 inch'){{'selected';}}@endif> 5 x 8 inch</option>-->
                                                <!--    <option value="5.875 x 8.25 inch" @if($pagedata->paper_size=='5.875 x 8.25 inch'){{'selected';}}@endif>5.875 x 8.25 inch</option>-->
                                                <!--    <option value=" 8.25 x 11.75 inch" @if($pagedata->paper_size==' 8.25 x 11.75 inch'){{'selected';}}@endif> 8.25 x 11.75 inch</option>-->
                                                <!--    <option value="8.5 x 11 inch" @if($pagedata->paper_size=='8.5 x 11 inch'){{'selected';}}@endif>8.5 x 11 inch</option>-->
                                                <!--    <option value=" 8.5 x 14 inch" @if($pagedata->paper_size==' 8.5 x 14 inch'){{'selected';}}@endif> 8.5 x 14 inch</option>-->
                                                <!--    <option value="A0" @if($pagedata->paper_size=='A0'){{'selected';}}@endif>A0</option>-->
                                                <!--    <option value="A1" @if($pagedata->paper_size=='A1'){{'selected';}}@endif>A1</option>-->
                                                <!--    <option value="A10" @if($pagedata->paper_size=='A10'){{'selected';}}@endif> A10</option>-->
                                                <!--    <option value="A2" @if($pagedata->paper_size=='A2'){{'selected';}}@endif> A2</option>-->
                                                <!--    <option value="A3" @if($pagedata->paper_size=='A3'){{'selected';}}@endif> A3</option>-->
                                                <!--    <option value="A4" @if($pagedata->paper_size=='A4'){{'selected';}}@endif> A4</option>-->
                                                <!--    <option value="A5" @if($pagedata->paper_size=='A5'){{'selected';}}@endif> A5</option>-->
                                                <!--    <option value="A6" @if($pagedata->paper_size=='A6'){{'selected';}}@endif> A6</option>-->
                                                <!--    <option value="A7" @if($pagedata->paper_size=='A7'){{'selected';}}@endif> A7</option>-->
                                                <!--    <option value="A8" @if($pagedata->paper_size=='A8'){{'selected';}}@endif>A8</option>-->
                                                <!--    <option value="A9" @if($pagedata->paper_size=='A9'){{'selected';}}@endif>A9</option>-->
                                                <!--    <option value="B0" @if($pagedata->paper_size=='B0'){{'selected';}}@endif>B0</option>-->
                                                <!--    <option value="B1" @if($pagedata->paper_size=='B1'){{'selected';}}@endif>B1</option>-->
                                                <!--    <option value="B10" @if($pagedata->paper_size=='B10'){{'selected';}}@endif> B10</option>-->
                                                <!--    <option value="B2" @if($pagedata->paper_size=='B2'){{'selected';}}@endif> B2</option>-->
                                                <!--    <option value="B3" @if($pagedata->paper_size=='B3'){{'selected';}}@endif>B3</option>-->
                                                <!--    <option value="B4" @if($pagedata->paper_size=='B4'){{'selected';}}@endif> B4</option>-->
                                                <!--    <option value="B5" @if($pagedata->paper_size=='B5'){{'selected';}}@endif>B5</option>-->
                                                <!--    <option value="B6" @if($pagedata->paper_size=='B6'){{'selected';}}@endif>B6</option>-->
                                                <!--    <option value="B7" @if($pagedata->paper_size=='B7'){{'selected';}}@endif> B7</option>-->
                                                <!--    <option value="B8" @if($pagedata->paper_size=='B8'){{'selected';}}@endif> B8</option>-->
                                                <!--    <option value="B9" @if($pagedata->paper_size=='B9'){{'selected';}}@endif>B9</option>-->
                                                <!--    <option value="C0" @if($pagedata->paper_size=='C0'){{'selected';}}@endif>C0</option>-->
                                                <!--    <option value="C1" @if($pagedata->paper_size=='C1'){{'selected';}}@endif> C1</option>-->
                                                <!--    <option value="C10" @if($pagedata->paper_size=='C10'){{'selected';}}@endif> C10</option>-->
                                                <!--    <option value="C2" @if($pagedata->paper_size=='C2'){{'selected';}}@endif> C2</option>-->
                                                <!--    <option value="C3" @if($pagedata->paper_size=='C3'){{'selected';}}@endif> C3</option>-->
                                                <!--    <option value="C4" @if($pagedata->paper_size=='C4'){{'selected';}}@endif> C4</option>-->
                                                <!--    <option value="C5" @if($pagedata->paper_size=='C5'){{'selected';}}@endif> C5</option>-->
                                                <!--    <option value="C6" @if($pagedata->paper_size=='C6'){{'selected';}}@endif> C6</option>-->
                                                <!--    <option value="C7" @if($pagedata->paper_size=='C7'){{'selected';}}@endif>C7</option>-->
                                                <!--    <option value="C7/6" @if($pagedata->paper_size=='C7/6'){{'selected';}}@endif>C7/6</option>-->
                                                <!--    <option value="C8" @if($pagedata->paper_size=='C8'){{'selected';}}@endif>C8</option>-->
                                                <!--    <option value="C9" @if($pagedata->paper_size=='C9'){{'selected';}}@endif>C9</option>-->
                                                <!--    <option value="DL" @if($pagedata->paper_size=='DL'){{'selected';}}@endif> DL</option>-->
                                                <!--</select>-->
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Type:</label>
                                                <input type="text" class="form-control" name="type" value="{{ $pagedata->type}}"  />
                                                <!--<select class="form-select" name="type">-->
                                                <!--    <option disabled selected hidden>select </option>-->
                                                <!--    <option value="Blackboards & Whiteboards" @if($pagedata->type=='Blackboards & Whiteboards'){{'selected';}}@endif> Blackboards & Whiteboards</option>-->
                                                <!--    <option value="Calculator" @if($pagedata->type=='Calculator'){{'selected';}}@endif>Calculator</option>-->
                                                <!--    <option value="Coloring Sets" @if($pagedata->type=='Coloring Sets'){{'selected';}}@endif>Coloring Sets</option>-->
                                                <!--    <option value="Coloring pens & Markers" @if($pagedata->type=='Coloring pens & Markers'){{'selected';}}@endif>Coloring pens & Markers</option>-->
                                                <!--    <option value="Dairies & poetry Albums" @if($pagedata->type=='Dairies & poetry Albums'){{'selected';}}@endif> Dairies & poetry Albums</option>-->
                                                <!--    <option value="Diaries" @if($pagedata->type=='Diaries'){{'selected';}}@endif>Diaries</option>-->
                                                <!--    <option value="Drawing" @if($pagedata->type=='Drawing'){{'selected';}}@endif> Drawing</option>-->
                                                <!--    <option value="Exercise Books" @if($pagedata->type=='Exercise Books'){{'selected';}}@endif> Exercise Books</option>-->
                                                <!--    <option value="Geometry box" @if($pagedata->type=='Geometry box'){{'selected';}}@endif>Geometry box</option>-->
                                                <!--    <option value="Geometry box kit" @if($pagedata->type=='Geometry box kit'){{'selected';}}@endif>Geometry box kit</option>-->
                                                <!--    <option value="Globes" @if($pagedata->type=='Globes'){{'selected';}}@endif>Globes</option>-->
                                                <!--    <option value="Glue, Paste & Tape" @if($pagedata->type=='Glue, Paste & Tape'){{'selected';}}@endif>Glue, Paste & Tape</option>-->
                                                <!--    <option value="Multipurpose Pouches" @if($pagedata->type=='Multipurpose Pouches'){{'selected';}}@endif> Multipurpose Pouches</option>-->
                                                <!--    <option value="Paint Brushes" @if($pagedata->type=='Paint Brushes'){{'selected';}}@endif>Paint Brushes</option>-->
                                                <!--    <option value="Painting supplies" @if($pagedata->type=='Painting supplies'){{'selected';}}@endif> Painting supplies</option>-->
                                                <!--    <option value="Paper" @if($pagedata->type=='Paper'){{'selected';}}@endif> Paper</option>-->
                                                <!--    <option value="Pencil box" @if($pagedata->type=='Pencil box'){{'selected';}}@endif>Pencil box</option>-->
                                                <!--    <option value="Pencil box kit" @if($pagedata->type=='Pencil box kit'){{'selected';}}@endif> Pencil box kit</option>-->
                                                <!--    <option value="Pencil sets" @if($pagedata->type=='Pencil sets'){{'selected';}}@endif>Pencil sets</option>-->
                                                <!--    <option value="Pens" @if($pagedata->type=='Pens'){{'selected';}}@endif> Pens</option>-->
                                                <!--    <option value="Printing & Stamping" @if($pagedata->type=='Printing & Stamping'){{'selected';}}@endif>Printing & Stamping</option>-->
                                                <!--    <option value="Rulers & Set square" @if($pagedata->type=='Rulers & Set square'){{'selected';}}@endif> Rulers & Set square</option>-->
                                                <!--    <option value="Sharpners &Erasers" @if($pagedata->type=='Sharpners &Erasers'){{'selected';}}@endif>Sharpners &Erasers</option>-->
                                                <!--    <option value="Sketching &Drawing Books" @if($pagedata->type=='Sketching &Drawing Books'){{'selected';}}@endif>Sketching &Drawing Books</option>-->
                                                <!--    <option value="Stickers" @if($pagedata->type=='Stickers'){{'selected';}}@endif> Stickers</option>-->
                                                <!--    <option value="Others" @if($pagedata->type=='Others'){{'selected';}}@endif> Others</option>-->
                                                <!--</select>-->

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                <input type="text" class="form-control" name="country_of_origin" value="{{ $pagedata->country_of_origin}}" />


                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Manufacturer Details:</label>

                                                <input type="text" class="form-control" name="manufacturer_detail" value="{{ $pagedata->manufacturer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packer Details:</label>

                                                <input type="text" class="form-control" name="packer_detail" value="{{ $pagedata->packer_detail}}" />

                                            </div>

                                        </div>


                                    </div>
                                </div>
                                
                                 @endif
                                   @if($pagedata->form_id==13)
                                   
                                <b>Sports Details</b>
                                <div id="sportsdiv">
                                    <div class="row">

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Material:</label>

                                                <input type="text" class="form-control" name="material" value="{{ $pagedata->material}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Product Length:</label>

                                                <input type="text" class="form-control" name="product_length" value="{{ $pagedata->product_length}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Product Type:</label>

                                                <input type="text" class="form-control" name="product_type" value="{{ $pagedata->product_type}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Product Unit:</label>

                                                <input type="text" class="form-control" name="product_unit" value="{{ $pagedata->product_unit}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Type:</label>

                                                <input type="text" class="form-control" name="type" value="{{ $pagedata->type}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                <input type="text" class="form-control" name="country_of_origin" value="{{ $pagedata->country_of_origin}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Manufacturer Details:</label>

                                                <input type="text" class="form-control" name="manufacturer_detail" value="{{ $pagedata->manufacturer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packer Details:</label>

                                                <input type="text" class="form-control" name="packer_detail" value="{{ $pagedata->packer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Brand:</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="brand">
                                                        <option selected disabled value="">Select</option>
                                                        @foreach($brand as $key => $data)
                                                        @if($data->id==$pagedata->brand){{$sel='selected';}}@else{{$sel='';}} @endif
                                                        <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                                 @endif
                                   @if($pagedata->form_id==14)
                                   
                                <b>Uniform Details</b>
                                <div id="uniformdiv">
                                    <div class="row">

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Material:</label>

                                                <input type="text" class="form-control" name="material" value="{{ $pagedata->material}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                <input type="text" class="form-control" name="country_of_origin" value="{{ $pagedata->country_of_origin}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Manufacturer Details:</label>

                                                <input type="text" class="form-control" name="manufacturer_detail" value="{{ $pagedata->manufacturer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packer Details:</label>

                                                <input type="text" class="form-control phone-mask" name="packer_detail" value="{{ $pagedata->packer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Brand:</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="brand">
                                                        <option selected disabled value="">Select</option>
                                                        @foreach($brand as $key => $data)
                                                        @if($data->id==$pagedata->brand){{$sel='selected';}}@else{{$sel='';}} @endif
                                                        <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">


                                                <label class="form-label">Size Chart:</label>

                                                <input type="file" class="form-control" name="size_chart" />

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                
                                 @endif
                                   @if($pagedata->form_id==9)
                                   
                                <b>Women Fashion Details</b>
                                <div id="womenfashiondiv">
                                    <div class="row">

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Bottom Type:</label>

                                                <input type="text" class="form-control" name="bottom_type" value="{{ $pagedata->bottom_type}}" />

                                            </div>

                                        </div>


                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Bottomwear Color:</label>

                                                <input type="text" class="form-control" name="bottomwear_color" value="{{ $pagedata->bottomwear_color}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Bottomwear Fabric:</label>

                                                <input type="text" class="form-control" name="bottomwear_fabric" value="{{ $pagedata->bottomwear_fabric}}" />

                                            </div>

                                        </div>


                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Fabric:</label>

                                                <input type="text" class="form-control" name="fabric" value="{{ $pagedata->fabric}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Fit/ Shape:</label>

                                                <input type="text" class="form-control" name="fit" value="{{ $pagedata->fit}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Kurta Color:</label>

                                                <input type="text" class="form-control" name="kurta_color" value="{{ $pagedata->kurta_color}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Kurta Fabric:</label>

                                                <input type="text" class="form-control" name="kurta_fabric" value="{{ $pagedata->kurta_fabric}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Length:</label>

                                                <input type="text" class="form-control" name="length" value="{{ $pagedata->length}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Neck:</label>

                                                <input type="text" class="form-control" name="neck" value="{{ $pagedata->neck}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Set Type:</label>

                                                <input type="text" class="form-control" name="set_type" value="{{ $pagedata->set_type}}" />

                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Stitch Type:</label>

                                                <input type="text" class="form-control" name="stitch_type" value="{{ $pagedata->stitch_type}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Occasion:</label>

                                                <input type="text" class="form-control" name="occasion" value="{{ $pagedata->occasion}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Ornamentation:</label>

                                                <input type="text" class="form-control" name="ornamentation" value="{{ $pagedata->ornamentation}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Pattern:</label>

                                                <input type="text" class="form-control" name="pattern" value="{{ $pagedata->pattern}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Print or Pattern Type:</label>

                                                <input type="text" class="form-control" name="pattern_type" value="{{ $pagedata->pattern_type}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Sleeve Length:</label>

                                                <input type="text" class="form-control" name="sleeve_length" value="{{ $pagedata->sleeve_length}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Sleeve Styling:</label>
                                                <input type="text" class="form-control" name="sleeve_styling" value="{{ $pagedata->sleeve_styling}}" />
                                            </div>
                                        </div>


                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">COUNTRY OF ORIGIN:</label>

                                                <input type="text" class="form-control" name="country_of_origin" value="{{ $pagedata->country_of_origin}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Manufacturer Details:</label>

                                                <input type="text" class="form-control" name="manufacturer_detail" value="{{ $pagedata->manufacturer_detail}}" />

                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Packer Details:</label>

                                                <input type="text" class="form-control " name="packer_detail" value="{{ $pagedata->packer_detail}}" />

                                            </div>

                                        </div>


                                        <div class="col-sm-4">

                                            <div class="mb-3">


                                                <label class="form-label">Size Chart:</label>

                                                <input type="file" class="form-control" name="size_chart" />

                                            </div>

                                        </div>


                                        <div class="col-sm-4">

                                            <div class="mb-3">

                                                <label class="form-label">Brand:</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="brand">
                                                        <option selected disabled value="">Select</option>
                                                        @foreach($brand as $key => $data)
                                                        @if($data->id==$pagedata->brand){{$sel='selected';}}@else{{$sel='';}} @endif
                                                        <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='button' data-bs-toggle='modal' data-bs-target='#show_brand_modal' class="input-group-text"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                 @endif
                                
                                <p class="mb-0"><b class="text-primary" id="heading">Price , Tax and Inventory wise stock</b></p>
                                <hr>
                                <div class="row g-2">
                                    @if($pagedata->class!=NULL)
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label">Class List</label>
                                            <select class="form-select" name="inv_class" id="form-select-md-stream" data-placeholder="Select" required>
                                                <option selected disabled value="">Select</option>
                                                @foreach($classes as $key => $data)
                                                @if($data->id==$pagedata->class){{$sel='selected';}}@else{{$sel='';}} @endif
                                                <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    @endif

                                    @if($pagedata->color!=NULL)
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label">Colour List</label>
                                            <select class="form-select" name="color" id="form-select-md-stream" data-placeholder="Select" required>
                                                <option selected disabled value="">Select</option>
                                                @foreach($colour as $key => $data)
                                                @if($data->id==$pagedata->color){{$sel='selected';}}@else{{$sel='';}} @endif
                                                <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label">Qty</label>
                                            <input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $pagedata->net_quantity}}" class="form-control " name="net_quantity">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label">Min Qty</label>
                                            <input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $pagedata->min_qyt}}" class="form-control " name="min_qyt" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label">Qty Unit</label>
                                            <select class="form-select" name="qty_unit">
                                                <option selected disabled value="">Select</option>
                                                @foreach($qty as $key => $data)
                                                @if($data->id==$pagedata->qty_unit){{$sel='selected';}}@else{{$sel='';}} @endif
                                                <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label">Hsncode</label>
                                            <input type="text" class="form-control " name="hsncode" value="{{ $pagedata->hsncode}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label">Barcode</label>
                                            <input type="text" class="form-control " name="barcode" value="{{ $pagedata->barcode}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label">ISBN</label>
                                            <input type="text" class="form-control" name="isbn" value="{{ $pagedata->isbn}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label">Net Weight</label>
                                            <input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control " name="net_weight" value="{{ $pagedata->net_weight}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label">MRP</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rs.</span>
                                                <input type="number" class="form-control " name="mrp" id="price" onkeyup="getPrice()" value="{{ $pagedata->mrp}}">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3 "><label class="form-label">Discount%</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control " onkeyup="getPrice()" id="discount" name="discount" value="{{ $pagedata->discount}}">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3 "><label class="form-label">Discounted price</label>
                                            <div class="input-group"><span class="input-group-text">Rs.</span>
                                                <input type="number" class="form-control" step="2" readonly id="total" name="discounted_price" value="{{ $pagedata->discounted_price}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label">Sales price</label>
                                            <div class="input-group"><span class="input-group-text">Rs.</span>
                                                <input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control " name="sales_price" value="{{ $pagedata->sales_price}}">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">GST</label>
                                            <select class="form-select" name="gst">
                                                <option selected disabled value="">Select</option>
                                                @foreach($gst as $key => $data)
                                                @if($data->id==$pagedata->gst){{$sel='selected';}}@else{{$sel='';}} @endif
                                                <option value="{{$data->id}}" {{$sel}}>{{$data->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Shipping Charges</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rs.</span>
                                                <input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control " name="shipping_charges" value="{{ $pagedata->shipping_charges}}">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    @if($pagedata->class!=NULL)
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">

                                            <label class="form-label">Edition</label>
                                            <input type="text" class="form-control" name="edition" value="{{ $pagedata->edition}}" />

                                        </div>
                                    </div>
                                    @endif
                                    @if($pagedata->class!=NULL)
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Book Pdf</label>
                                            <input type="file" class="form-control" name="book_pdf" accept=".pdf" />
                                            <span style="color:red;font-size:12px">This will overwrite previous pdf</span>
                                            <input type="hidden" class="form-control" name="old_book_pdf" value="{{ $pagedata->book_pdf}}" />

                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <p class="mb-0"><b class="text-primary" id="heading"> Other Attributes</b></p>
                                <hr>
                                <div class="row">


                                    <div class="col-sm-12">

                                        <div class="mb-3">

                                            <label class="form-label">Importer Details:</label>

                                            <textarea class="form-control" name="importer_detail">{{ $pagedata->importer_detail}}</textarea>
                                        </div>

                                    </div>


                                </div>

                                <!--<div class="col-sm-3">-->

                                <!--    <div class="form-group mb-3">-->

                                <!--        <label class="form-label">status</label>-->

                                        <!--<select class="form-select" name="status">-->
                                        <!--    <option value="1" @if($pagedata->status==1){{'selected';}}@endif>Active</option>-->
                                        <!--    <option value="0" @if($pagedata->status==0){{'selected';}}@endif>Inactive</option>-->
                                        <!--</select>-->

                                <!--    </div>-->

                                <!--</div>-->


                                


                                <button type="submit" class="btn btn-success">update</button>

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

    <!-- Footerscript -->
    <script>
        $(document).ready(function() {
            var x = 0; //Initial field counter
            var list_maxField = 10; //Input fields increment limitation
            $('.list_add_button').click(function() {
                if (x < list_maxField) {
                    x++; //Increment field counter
                    var list_fieldHTML = '<div class="row ps-4 pe-5"><div class="col-sm-3 mb-4 imgUp"><div class="form-group"><div class="imagePreview1"><i class="imgremove fa fa-remove list_remove_button"></i></div> <label class="form-control btn btn-primary">upload<input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="image[]" /></label></div> </div><div class="col-sm-1"></div></div> ';
                    $('.list_wrapper').append(list_fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $('.list_wrapper').on('click', '.list_remove_button', function() {
                $(this).closest('.row').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });

        // discounted price
        getPrice = function() {
            var numVal1 = Number(document.getElementById("price").value);
            var numVal2 = Number(document.getElementById("discount").value) / 100;
            var totalValue = numVal1 - (numVal1 * numVal2)
            document.getElementById("total").value = totalValue.toFixed(2);
        }

        
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
                        uploadFile.closest(".imgUp").find('.imagePreview1').css("background-image", "url(" + this.result + ")");
                    }
                }

            });
        });
        
        //text editor
        ClassicEditor.create(document.querySelector('#editor')).catch(error => {
            console.error(error);
        });
        
  //delete image from inventory
  
  
  function removeinvimge(id)
   {
       
       $(".loader").css("display","block");
                $.ajax({
                type: "POST",
                url: "{{url('/') }}/removeinvimg",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                cache: false,
                success: function(response) {
                
                
                     
               if (response.success==0)
                {
                $.toast({  heading:  "<i class='fa fa-warning' ></i> "+response.msg, position: 'top-right',stack: false})
                $(".loader").css("display","none");
                
                }
                else
                {
                $.toast({ heading: response.msg, position: 'top-right',stack: false,icon: 'success'})
                $(".loader").css("display","none");
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
                }

                }
            });
   }
   
function dp_status_changed(image_id,item_id){
     $(".loader").css("display","block");
                $.ajax({
                type: "POST",
                url: "{{url('/') }}/updateappinventorydpstatus",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "image_id": image_id,
                    "item_id": item_id
                },
                dataType: 'json',
                cache: false,
                success: function(response) {
                
                
                     
               if (response.success==0)
                {
                $.toast({  heading:  "<i class='fa fa-warning' ></i> "+response.msg, position: 'top-right',stack: false})
                $(".loader").css("display","none");
                
                }
                else
                {
                $.toast({ heading: response.msg, position: 'top-right',stack: false,icon: 'success'})
                $(".loader").css("display","none");
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
                }

                }
            });
}
    </script>
</body>

</html>