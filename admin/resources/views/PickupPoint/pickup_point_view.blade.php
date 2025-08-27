<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta  name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0"/>
    <title>View Pickup Point Details</title>
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
.img-fluid
{
    /*height:150px !important;*/
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
                    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage Pickup Point / View Pickup Point Details</span></h5>
                    <!-- Basic Layout & Basic with Icons -->
                    <div class="row justify-content-start">
                    <!-- Basic Layout-->
                        <div class="col-md-xxl">
                            <div class="card mb-4 border mx-auto" >
                                <div  class="card-header border-bottom theambgclr">
                                    <h4 class="ps-5 theamcolor" >View Pickup Point Details</h4>
                                    </div>
                                     <div class="card-body p-5">
                                         
                                     
                                        <div class="row">  
                                     
                                        <div class="col-md-3 border m-3">
                                        <h4 class="btn btn-primary form-control"> Profile Pic</h4>
                                        <img class="mx-auto d-flex img-fluid" src="{{Storage::disk('s3')->url($inventory->folder.'/user_doc/' .$inventory->profile_pic)}}">
                                        </div>
                                        
                                        <div class="col-md-3 border m-3">
                                        <h4 class="btn btn-primary form-control">  Aadhaar Card</h4>
                                        <img class="mx-auto d-flex img-fluid" src="{{Storage::disk('s3')->url($inventory->folder.'/user_doc/' .$inventory->addhar_card)}}">
                                        </div>
                                        
                                        <div class="col-md-3 border m-3">
                                        <h4 class="btn btn-primary form-control">  Pan Card</h4>
                                        <img class="mx-auto d-flex img-fluid" src="{{Storage::disk('s3')->url($inventory->folder.'/user_doc/' .$inventory->pan_card)}}">
                                        </div>
                                       
                                        </div> 
                                        
                                        


                                     <div class="row ">
                                         
                                            @if($inventory->uid!=NULL)
                                           <div class="col-md-4 border p-2"> <label class="fw-bold" >Unique Id</label> </div>
                                          <div class="col-md-8 border p-2 ">  <label class="" >{{$inventory->uid}}</label>  </div>
                                               @endif
                                               
                                            @if($inventory->name!=NULL)
                                          <div class="col-md-4 border p-2"> <label class="fw-bold" >User Name</label> </div>
                                          <div class="col-md-8 border p-2 ">  <label class="" >{{$inventory->name}}</label>  </div>
                                           @endif
                                           
                                            @if($inventory->email!=NULL)
                                          <div class="col-md-4 border p-2"> <label class="fw-bold" >Email</label> </div>
                                          <div class="col-md-8 border p-2 ">  <label class="" >{{$inventory->email}}</label>  </div>
                                               @endif
                                               
                                        
                                           @if($inventory->address!=NULL)
                                           <div class="col-md-4 border p-2"> <label class="fw-bold" >address</label> </div>
                                          <div class="col-md-8 border p-2 ">  <label class="" >{{$inventory->address}}</label>  </div>
                                               @endif
                                                @if($inventory->pincode!=NULL)
                                           <div class="col-md-4 border p-2"> <label class="fw-bold" >pincode</label> </div>
                                          <div class="col-md-8 border p-2 ">  <label class="" >{{$inventory->pincode}}</label>  </div>
                                               @endif
                                               
                                                   @if($inventory->contact_number!=NULL)
                                           <div class="col-md-4 border p-2"> <label class="fw-bold" >Contact Number</label> </div>
                                          <div class="col-md-8 border p-2 ">  <label class="" >{{$inventory->contact_number}}</label>  </div>
                                               @endif
                                               
                                            
                                      
                                   
                                     </div>
                                     
                                     
                                      <div class="row ">
                                    
                                     
                                            @if($inventory->pickup_point_name!=NULL)
                                           <div class="col-md-4 border p-2"> <label class="fw-bold" >Pickup Point</label> </div>
                                          <div class="col-md-8 border p-2 ">  <label class="" >{{$inventory->pickup_point_name}}</label>  </div>
                                               @endif
                                               
                                            @if($inventory->google_location!=NULL)
                                          <div class="col-md-4 border p-2"> <label class="fw-bold" > Google Location</label> </div>
                                          <div class="col-md-8 border p-2 ">  <label class="" >{{$inventory->google_location}}</label>  </div>
                                           @endif
                                           
                                            @if($inventory->opening_time!=NULL)
                                          <div class="col-md-4 border p-2"> <label class="fw-bold" >Opening Time</label> </div>
                                          <div class="col-md-8 border p-2 ">  <label class="" >{{$inventory->opening_time}}</label>  </div>
                                               @endif
                                               
                                        
                                           @if($inventory->closing_time!=NULL)
                                           <div class="col-md-4 border p-2"> <label class="fw-bold" >Closing Time</label> </div>
                                          <div class="col-md-8 border p-2 ">  <label class="" >{{$inventory->closing_time}}</label>  </div>
                                               @endif
                                               
                                                   @if($inventory->notes!=NULL)
                                           <div class="col-md-4 border p-2"> <label class="fw-bold" >Notes</label> </div>
                                          <div class="col-md-8 border p-2 ">  <label class="" >{{$inventory->notes}}</label>  </div>
                                               @endif
                                               
                                                @if($inventory->created_at!=NULL)
                                           <div class="col-md-4 border p-2"> <label class="fw-bold" >Created At</label> </div>
                                          <div class="col-md-8 border p-2 ">  <label class="" >{{$inventory->created_at}}</label>  </div>
                                               @endif
                                               
                                         <div class="col-md-4 border p-2"> <label class="fw-bold" >Status</label> </div>
                                          <div class="col-md-8 border p-2 ">  <label class="" >  @if($inventory->status==1) <span class='btn btn-success'>Active</span> @endif 
                                            @if($inventory->status==0) <span class='btn btn-warning'>Inactive</span>@endif  </label>  </div>
                                   
                                   
                                           <div class="col-md-12 border p-2">
                                               
                                               <h4>Pickup Point Images</h4>
                                               <div class="row">  
                                               @php
                                               $ppimages=explode(',',$inventory->images);
                                               @endphp
                                               @foreach($ppimages as $key => $image)
                                               @if($image!="")
                                                <div class="col-md-3 m-3">
                                                <img class="mx-auto d-flex img-fluid" src="{{Storage::disk('s3')->url($inventory->folder.'/' .$image)}}">
                                                </div>
                                                @endif
                                                @endforeach
                                                </div> 
                                             </div> 
        
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