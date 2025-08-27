<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta  name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0"/>
    <title>View Inventory</title>
    <meta name="description" content="" />
    <!-- headerscript -->
       @include('includes.header_script')

    <style>
       
  
.imagePreview {
    width: 100%;
    height: 200px;
    background-position: center center;
  background:url(https://tamilnaducouncil.ac.in/wp-content/uploads/2020/04/dummy-avatar.jpg);
  background-color:#fff;
    background-size: cover;
  background-repeat:no-repeat;
    display: inline-block;
  box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);
}

.imgUp
{
  margin-bottom:15px;
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
                <!-- Content wrapper-->
                <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage Inventory / View Inventory</span></h5>
                    <!-- Basic Layout & Basic with Icons -->
                    <div class="row justify-content-start">
                    <!-- Basic Layout-->
                        <div class="col-md-xxl">
                            <div class="card mb-4 border mx-auto" >
                                <div  class="card-header border-bottom theambgclr">
                                    <h4 class="ps-5 theamcolor" >View Inventory</h4>
                                    </div>
                                     <div class="card-body p-5">
                                         
                                       <div class="row">  
                                       @foreach($inv_images as $key => $images)
                                        <div class="col-md-3 border m-3">
                                        <img class="mx-auto d-flex img-fluid" src="{{Storage::disk('s3')->url($images->folder.'/' .$images->image)}}">
                                        </div>
                                        @endforeach
                                        </div> 
                                         
                                        <h4 class="btn btn-primary"> Category : {{$cat_detail['cat_one'];}}</h4>
                                        <h4 class="btn btn-primary">  Category Two : {{$cat_detail['cat_two'];}}</h4>
                                        <h4 class="btn btn-primary">  Category Three : {{$cat_detail['cat_three'];}}</h4>
                                        <h4 class="btn btn-primary"> Category Four : {{$cat_detail['cat_four'];}}</h4>

                                     <div class="row ">
                                         
                                            @if($inventory->product_name!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Product Name</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->product_name}}</label>  </div>
                                               @endif
                                               
                                            @if($inventory->net_weight!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Net Weight</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->net_weight}}</label>  </div>
                                           @endif
                                           
                                            @if($inventory->min_qyt!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Min Qyt</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->min_qyt}}</label>  </div>
                                               @endif
                                               
                                           @if($inventory->size!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Size</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->size}}</label>  </div>
                                               @endif
                                               
                                           @if($inventory->barcode!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Barcode</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->barcode}}</label>  </div>
                                               @endif
                                               
                                           @if($inventory->mrp!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >MRP</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->mrp}}</label>  </div>
                                               @endif
                                               
                                                   @if($inventory->discount!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Discount</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->discount}}</label>  </div>
                                               @endif
                                               
                                                @if($inventory->discounted_price!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Discounted Price</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->discounted_price}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->sales_price!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Sales Price</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->sales_price}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->shipping_charges!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Shipping Charges</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->shipping_charges}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->hsncode!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Hsncode</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->hsncode}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->gst!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >GST</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->gst_title}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->country_of_origin!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Country of Origin</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->country_of_origin}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->color!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Colour</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->color}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->type!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Type</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->type}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->manufacturer_detail!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Manufacturer Detail</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->manufacturer_detail}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->packer_detail!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Packer Detail</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->packer_detail}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->manufacturing_date!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Manufacturing Date</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->manufacturing_date}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->brand!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Brand</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->brand_title}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->material_type!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Material Type</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->material_type}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->material!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Material</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->material}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->paper_finish!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Paper Finish</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->paper_finish}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->paper_size!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Paper Size</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->paper_size}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->author!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Author</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->author}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->edition!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Edition</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->edition}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->stream!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Stream</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->stream}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->class!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Class</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->class_title}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->printer_details!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Printer Details</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->printer_details}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->publish_year!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Publish Year</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->publish_year}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->language!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Language</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->language}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->youtube_url!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Youtube Url</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->youtube_url}}</label>  </div>
                                           @endif
                                           

                                             @if($inventory->isbn!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >ISBN</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->isbn}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->book_format!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Book Format</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->book_format}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->net_quantity!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Net Quantity</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->net_quantity}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->qty_unit!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Qty Unit</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->qty_unit_title}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->product_type!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Product Type</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->product_type}}</label>  </div>
                                           @endif
                                          
                                             @if($inventory->product_unit!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Product Unit</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->product_unit}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->product_length!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Product Length</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->product_length}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->product_breadth!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Product Breadth</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->product_breadth}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->product_weight!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Product Weight</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->product_weight}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->product_height!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Product Height</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->product_height}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->weight_unit!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Weight Unit</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->weight_unit}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->warranty!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Warranty</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->warranty}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->water_resistant!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Water Resistant</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->water_resistant}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->laptop_capacity!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Laptop Capacity</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->laptop_capacity}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->character!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Character</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->character}}</label>  </div>
                                           @endif
                                          
                                             @if($inventory->no_of_compartment!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >No of Compartment</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->no_of_compartment}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->backpack_style!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Backpack Style</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->backpack_style}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->bag_capacity!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Bag Capacity</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->bag_capacity}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->gender!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Gender</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->gender}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->pattern!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Pattern</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->pattern}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->recommended_age!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Recommended Age</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->recommended_age}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->fssai_license_number!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Fssai License Number</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->fssai_license_number}}</label>  </div>
                                           @endif
                                      
                                             @if($inventory->shelf_life!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Shelf Life</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->shelf_life}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->veg_nonveg!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Veg Nonveg</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->veg_nonveg}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->connectivity!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Connectivity</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->connectivity}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->operating_system!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Operating System</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->operating_system}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->ram!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Ram</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->ram}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->warranty_service_type!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Warranty Service Type</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->warranty_service_type}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->dual_camera!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Dual Camera</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->dual_camera}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->expandable_storage!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Expandable Storage</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->expandable_storage}}</label>  </div>
                                           @endif
                                      
                                              @if($inventory->headphone_jack!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Headphone Jack</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->headphone_jack}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->internal_memory!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Internal Memory</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->internal_memory}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->primary_camera!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Primary Camera</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->primary_camera}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->no_of_primary_camera!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >No. Of Primary Camera</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->no_of_primary_camera}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->secondary_camera!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Secondary Camera</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->secondary_camera}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->no_of_secondary_camera!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >no_of Secondary Camera</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->no_of_secondary_camera}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->screen_length_size!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Screen Length Size</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->screen_length_size}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->sim!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Sim</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->sim}}</label>  </div>
                                           @endif
                                 
                                              @if($inventory->sim_type!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Sim Type</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->sim_type}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->add_ons!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Add Ons</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->add_ons}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->body_material!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >body Material</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->body_material}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->burner_material!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Burner Material</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->burner_material}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->no_of_burners!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >No of Burners</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->no_of_burners}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->packaging_breadth!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Packaging Breadth</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->packaging_breadth}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->packaging_height!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Packaging Height</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->packaging_height}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->packaging_length!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Packaging Length</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->packaging_length}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->packaging_unit!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Packaging Unit</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->packaging_unit}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->sole_material!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Sole Material</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->sole_material}}</label>  </div>
                                           @endif
                                     
                                              @if($inventory->fabric!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Fabric</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->fabric}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->fit!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Fit</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->fit}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->neck!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Neck</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->neck}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->sleeve_length!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Sleeve Length</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->sleeve_length}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->sleeve_styling!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Sleeve Styling</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->sleeve_styling}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->occasion!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Occasion</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->occasion}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->ornamentation!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >ornamentation</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->ornamentation}}</label>  </div>
                                           @endif
                                   
                                              @if($inventory->pattern_type!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Pattern Type</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->pattern_type}}</label>  </div>
                                           @endif
                                           
                                            @if($inventory->bottom_type!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Bottom Type</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->bottom_type}}</label>  </div>
                                           @endif
                                           
                                            @if($inventory->bottomwear_color!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Bottomwear Colour</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->bottomwear_color}}</label>  </div>
                                           @endif
                                           
                                            @if($inventory->bottomwear_fabric!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Bottomwear Fabric</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->bottomwear_fabric}}</label>  </div>
                                           @endif
                                           
                                            @if($inventory->kurta_color!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Kurta Colour</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->kurta_color}}</label>  </div>
                                           @endif
                                           
                                            @if($inventory->kurta_fabric!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Kurta Fabric</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->kurta_fabric}}</label>  </div>
                                           @endif
                                           
                                            @if($inventory->length!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Length</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->length}}</label>  </div>
                                           @endif
                                           
                                            @if($inventory->set_type!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Set Type</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->set_type}}</label>  </div>
                                           @endif
                                           
                                            @if($inventory->stitch_type!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Stitch Type</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->stitch_type}}</label>  </div>
                                           @endif
                                           
                                              @if($inventory->sale_rate!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Sale Rate</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->sale_rate}}</label>  </div>
                                           @endif
                                           
                                                @if($inventory->description!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Description</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->description}}</label>  </div>
                                               @endif
                                               
                                             @if($inventory->importer_detail!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Importer Detail</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->importer_detail}}</label>  </div>
                                           @endif
                                           
                                         <div class="col-md-6 border p-2"> <label class="fw-bold" >Status</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >  @if($inventory->status==1) <span class='btn btn-success'>Active</span> @endif 
                                            @if($inventory->status==0) <span class='btn btn-warning'>Inactive</span>@endif  </label>  </div>
                                   
                                     </div>
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
    </body>
</html>


<script>


</script>