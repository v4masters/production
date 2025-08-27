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
        
        .main-heading {
            background-color: #E7E7FF;
            border: 1px solid #E7E7FF;
            border-radius: 7px;
            padding: 9px 27px 9px 27px;
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
                    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">View Vendor Detail</span></h5>
                    <!-- Basic Layout & Basic with Icons -->
                    <div class="row justify-content-start">
                    <!-- Basic Layout-->
                        <div class="col-md-xxl">
                            <div class="card mb-1 border mx-auto" >
                                <div  class="card-header ">
                                    <h4 class="main-heading">Bank Detail</h4>
                                    </div>
                                     <div class="card-body px-5">
                                        <div class="table-responsive">
                                            <table class="table table-hover responsive">
                                               <thead>
                                                    <tr>
                                                        <th>Bank Detail</th>
                                                        <th>Vendor Infomation</th>
                                                    </tr>
                                                    </thead>
                                                     <tbody>
                                                    <tr>
                                                        <td>Bank Name : {{ $bankdetail->bank_name }} </td>
                                                        <td>Vendor Name :{{ $pagedata->username }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bank District Name: {{ $bankdetail->bank_district }}</td>
                                                        <td>Email Id :{{ $pagedata->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>IFSC Code: {{ $bankdetail->ifsc_code }}</td>
                                                        <td>Address : {{ $pagedata->address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bank Branch : {{ $bankdetail->bank_branch }}</td>
                                                        <td>Contact No : {{ $pagedata->phone_no }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bank Address : {{ $bankdetail->bank_address }}</td>
                                                        <td>GST No : {{ $pagedata->gst_no }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bank Acc Number : {{ $bankdetail->acc_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Acc Holder Name : {{ $bankdetail->acc_holder_name }}</td>
                                                    </tr>
                                                 
                                                </tbody>
                                            </table>
                                        </div>
                                     </div>
                                     <div  class="card-header">
                                    <h4 class="main-heading">View Vendor Documents</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row ps-4 pe-5">
                                            <div class="col-sm-3 mb-4 imgUp">
                                                <h6>Adhar Card Image</h6>
                                                <div class="imagePreview"></div>
                                            </div>
                                            <div class="col-sm-3 mb-4 imgUp"><h6>Pan Card Image</h6><div class="imagePreview1"></div></div>
                                            <div class="col-sm-3 mb-4 imgUp"><h6>GST No Image</h6><div class="imagePreview2"></div></div>
                                            <div class="col-sm-3 mb-4 imgUp"><h6>Cheque Image</h6><div class="imagePreview3"></div></div>
                                            <div class="col-sm-3 mb-4 imgUp"><h6>Shop Act Doc</h6><div class="imagePreview4"></div></div>
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