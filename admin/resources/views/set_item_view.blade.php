<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta  name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0"/>
    <title>View Set Items</title>
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
                    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage Set Items / View Set Items</span></h5>
                    <!-- Basic Layout & Basic with Icons -->
                    <div class="row justify-content-start">
                    <!-- Basic Layout-->
                        <div class="col-md-xxl">
                            <div class="card mb-4 border mx-auto" >
                                <div  class="card-header border-bottom theambgclr">
                                    <h4 class="ps-5 theamcolor" >Set Items</h4>
                                    </div>
                                     <div class="card-body p-5">

                                     <div class="row ">
                                         
                                            @if($inventory->itemname!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Item Name</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->itemname}}</label>  </div>
                                           @endif
                                           
                                            @if($inventory->item_type!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Item Type</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->item_type}}</label>  </div>
                                               @endif
                                               
                                           @if($inventory->company_name!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Company Name</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->company_name}}</label>  </div>
                                               @endif
                                               
                                           @if($inventory->description!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Description</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->description}}</label>  </div>
                                               @endif
                                               
                                           @if($inventory->edition!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Edition</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->edition}}</label>  </div>
                                               @endif
                                               
                                           @if($inventory->class!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Class</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->class}}</label>  </div>
                                               @endif
                                               
                                           @if($inventory->avail_qty!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Available Qty</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->avail_qty}}</label>  </div>
                                               @endif
                                               
                                                   @if($inventory->uni_qty!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Qty</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->uni_qty}}</label>  </div>
                                               @endif
                                               
                                                @if($inventory->unit_price!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Unit Price</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->unit_price}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->item_weight!=NULL)
                                           <div class="col-md-6 border p-2"> <label class="fw-bold" >Item Weight</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->item_weight}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->gst!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Gst</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->gst}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->uni_gst!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Gst</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->uni_gst}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->discount!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Discount</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->discount}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->barcode!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Barcode</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->barcode}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->hsncode!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Hsncode</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->hsncode}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->uni_barcode!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Barcode</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->uni_barcode}}</label>  </div>
                                           @endif
                                           
                                           @if($inventory->uni_hsncode!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Hsncode</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->uni_hsncode}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->size!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Size</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->size}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->weight!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Weight</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->weight}}</label>  </div>
                                           @endif
                                           
                                             @if($inventory->price_per_size!=NULL)
                                          <div class="col-md-6 border p-2"> <label class="fw-bold" >Price per size</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >{{$inventory->price_per_size}}</label>  </div>
                                           @endif
                                         
                                         <div class="col-md-6 border p-2"> <label class="fw-bold" >Status</label> </div>
                                          <div class="col-md-6 border p-2 ">  <label class="" >
                                           @if($inventory->status==1)
                                          <span class='btn btn-success'>Active</span>
                                           @endif 
                                            @if($inventory->status==0)
                                          <span class='btn btn-warning'>Inactive</span>
                                           @endif 
                                           </label>  </div>
                                   
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