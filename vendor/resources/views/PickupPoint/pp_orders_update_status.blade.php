<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Evyapari.com</title>
    <meta name="description" content="" />
    @include('includes.header_script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        #order_bill{display:none;}
        .table{border:1px solid #1e1e1e;}
        .table:not(.table-dark) th {color: #1e1e1e;}
        .table>:not(caption)>*>* {
        padding: 0.2rem !important;
        border-width: 1px;
        font-size: 12px;
        color: #1e1e1e;
        }
        
        #courier_patner
        {
          display:none;    
            
        }
        /* Hide the default radio button */
.custom-radio input[type="radio"] {
    display: none;
}

/* Style the custom radio button */
.custom-radio .radio-btn {
    width: 40px;  /* Size of the radio button */
    height: 40px;
    border-radius: 50%;  /* Makes it round */
    border: 3px solid #007bff;  /* Border color */
    display: inline-block;
    position: relative;
    margin-right: 10px;
    vertical-align: middle;
    transition: all 0.3s ease;
}

/* When the radio button is checked */
.custom-radio input[type="radio"]:checked + .radio-btn {
    background-color: #007bff;
    border-color: #007bff;
}

/* Add the inner dot when checked */
.custom-radio input[type="radio"]:checked + .radio-btn::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 16px;  /* Size of the inner dot */
    height: 16px;
    background-color: white;
    border-radius: 50%;
    transform: translate(-50%, -50%);
}

/* Hover effect */
.custom-radio:hover .radio-btn {
    border-color: #0056b3;
}

/* Label text styling */
.custom-radio {
    font-size: 18px;  /* Customize the font size */
    cursor: pointer;
    display: flex;
    align-items: center;
}

        
    </style>
</head>
<body>

    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            @include('includes.sidebar')

            <div class="layout-page">

                @include('includes.header')

                <div class="container mt-3">

                    <div class="card mb-4">

                        <div class="card-header d-flex justify-content-between align-items-center">

                            <div class="container">

                            </div>
                        </div>

                        <div class="container">

                            <div class="card border">

                            <h5 class="card-header">Update Order Status</h5>

                               <div class="card-body p-3">
                                   <div class="">
                                   <form method="post" id="myform"  action="{{url('/') }}/update_order_item_status"  enctype="multipart/form-data" novalidate>
                                        @csrf
                                       
                                       <!--msg-->
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
                                        <!--endmsg-->
                                 
                                        
                                        <hr>
                                          <div class="row">
                                                    <div class="col-md-6">
                                                        <p style="padding-left: 0px; margin: 0%">
                                                            <span style="font-weight: bold">Bill Number: </span>
                                                            {{$order->bill_id;}}
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Invoice Date: </span>{{$order->inv_created_at;}}
                                                            14:10:51
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Payment Mode: </span> 
                                                            @if($order->mode_of_payment==1){{'Online';}}@else{{'COD';}}@endif
                                                        </p>
                                                    </div>
                                    
                                                    <div class="col-md-6">
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Order No: </span>
                                                            {{$order->invoice_number;}}
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Order Date: </span> {{$order->transaction_date;}}
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Transaction Id : </span>
                                                            {{$order->transaction_id;}}
                                                        </p>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="invoice_number" value="{{$order->invoice_number;}}">
                                                <input type="hidden" name="vendor_id" value="{{$order->unique_id;}}">
                                                <input type="hidden" name="user_id" value="{{$order->user_id;}}">
                                                <input type="hidden" name="total_item" value="{{$order->total_item;}}">
                                        <hr>
           
                                        <div class="row gx-5">
                                            <div class="col-md-12 my-5">
                                                <div class="card">
                                                    
                                                <table id="mytable" class="table" >
                                                    <tr >
                                                        <th># <button type="button" id="selectAll" class="main btn btn-primary btn-xs"><i class="fa fa-check"></i></button></th>
                                                        <th>Courier No.<br> Status</th>
                                                        <th >SKU</th>
                                                        <th>Des</th>
                                                        <th >Cat</th>
                                                        <th > Price</th>
                                                        <th >Qty</th>
                                                        <th >GST</th>
                                                        <th >GST <br>Amt </th>
                                                        <th>Before<br>tax</th>
                                                    </tr>
                                                    
                                                    
                                                     @php $totalupdateditem=0;@endphp
                                                     @foreach($item_info as  $key => $itemdata)

                                                        <tr>
                                                            <td >{{$key+1}}@if($itemdata['item_trk_status']==0) @php $totalupdateditem++; @endphp<input class="form-check-input" type='checkbox' onclick='selectsinglecheckbox()' name='id_type[]' value="{{$itemdata['id'].','.$itemdata['item_type'].','.$itemdata['weight']*$itemdata['qty']}}" checked>@endif</td>
                                                            <td>{{$itemdata['courier_number'];}}<br>
                                                            @if($itemdata['tracking_status']==0){{'Pending';}}@endif
                                                            @if($itemdata['tracking_status']==1){{'In-process';}}@endif
                                                            @if($itemdata['tracking_status']==2){{'In-production';}}@endif
                                                            @if($itemdata['tracking_status']==3){{'Shipped';}}@endif
                                                            @if($itemdata['tracking_status']==4){{'Out for delivery';}}@endif
                                                            @if($itemdata['tracking_status']==5){{'Deliverd';}}@endif
                                                            </td>
                                                            <td>{{$itemdata['item_id'];}}</td>
                                                            <td >{{$itemdata['itemname'];}}
                                                            <span style="font-size: 10px;">
                                                            @if($itemdata['class']!='')<br><b>Class: </b>{{$itemdata['class']}}@endif
                                                            @if($itemdata['size_medium']!='')<b> , Size/Medium: </b>{{$itemdata['size_medium']}}@endif</span>
                                                            </td>
                                                            <td>{{$itemdata['cat'];}}</td>
                                                            <td>{{$itemdata['discount_rate'];}}</td>
                                                            <td >{{$itemdata['qty'];}}</td>
                                                            <td>{{$itemdata['gst'];}} %</td>
                                                            <td >{{round($itemdata['gst_rate']*$itemdata['qty'],2);}}</td>
                                                            <td>{{round($itemdata['qty']*$itemdata['without_gst_rate'],2);}}</td>
                                                        </tr>

                                                        @endforeach
                                                   
                                                </table>
                                                </div>
                                            </div>
                                            
                                             
                                            <!--0	0=Pending,1=in-process,2=in-production,3=shipped,4=out for delivery,5=deliverd-->
                                            </div>
                                            
                                              @if($order->update_pp_order_status===1)
                                            @if($order->order_status!=4  && $order->order_status!=5)
                                            <div class="row gx-5">
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                                     <div class="input-group">
                                                     <select id="defaultSelect" class="form-select" onchange="selectedorderstatus(this.value)" name="order_item_status" required>
                                                        <option value="1">In-process</option>
                                                        <option value="2">In-production</option>
                                                        <option value="3" >Shipped</option>
                                                        <!--<option value="4"> Out for delivery</option>-->
                                                        <!--<option value="5"> Deliverd</option>-->

                                                    </select>
                                                     <button type="button" id="refreshButton" class="btn btn-secondary">Refresh</button>
                                                   </div>
                                                   
                                                </div>
                                            </div>
                                            
                                           
                                            
                                            
                                           </div>
                                           
                                           @if($courier_data['courier_partner_assign']==1)
                                           <div  id="courier_patner">
                                           <div class="row gx-5">
                                          
                                            <div class="col-sm-12">
                                                
                                                
                                                      <table class="table" style="padding: 0.5rem !important;">
                                                        <thead>
                                                          <tr>
                                                            <th scope="col">Select</th>
                                                            <th scope="col">Delivery Available On</th>
                                                           
                                                            <th scope="col">Price According to Weight</th>
                                                            
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                            
                                                        @if($courier_data['indiapost_pickup']==1 && $courier_data['indiapost_del']==1)       
                                                         <tr>
                                                            <td>
                                                              <label class="custom-radio">
                                                                    <input type="radio" name="courier_patner" value="1"> 
                                                                    <span class="radio-btn"></span>
                                                                    
                                                                </label>  
                                                                <!--<input type="radio" name="courier_patner" value="1"></td>-->
                                                            <td>V4 Parcel</td>
                                                            <td><span id="courier_1"></span></td>
                                                          </tr>
                                                          
                                                           <tr>
                                                            <td>
                                                                 <label class="custom-radio">
                                                                    <input type="radio" name="courier_patner" value="2">
                                                                    <span class="radio-btn"></span>
                                                                    
                                                                </label>  
                                                                <!--<input type="radio" name="courier_patner" value="2"></td>-->
                                                            <td>V4 Book Post </td>
                                                            <td><span id="courier_2"></span></td>
                                                          </tr>
                                                          
                                                           <tr>
                                                            <td>
                                                                 <label class="custom-radio">
                                                                    <input type="radio" name="courier_patner" value="3">
                                                                    <span class="radio-btn"></span>
                                                                    
                                                                </label>  
                                                                <!--<input type="radio" name="courier_patner" value="3-->
                                                                </td>
                                                            <td>V4 Contractual</td>
                                                            <td><span id="courier_3"></span></td>
                                                          </tr>
                                                          @endif
                                                       
                                                          
                                                          @if($courier_data['sr_pickup']==1 && $courier_data['sr_delivery']==1)    
                                                          <tr>
                                                            <td>
                                                                 <label class="custom-radio">
                                                                    <input type="radio" name="courier_patner" value="4">
                                                                    <span class="radio-btn"></span>
                                                                    
                                                                </label>  
                                                                <!--<input type="radio" name="courier_patner" value="4">-->
                                                                </td>
                                                            <td>V4 Rocket </td>
                                                            <td><span id="courier_4"></span></td>
                                                          </tr>
                                                          @endif
                                                          
                                                           @if($courier_data['amz_pickup']==1 && $courier_data['amz_del']==1)    
                                                          <tr>
                                                            <td>
                                                                <label class="custom-radio">
                                                                    <input type="radio" name="courier_patner" value="5">
                                                                    <span class="radio-btn"></span>
                                                                    
                                                                </label> 
                                                                <!--<input type="radio" name="courier_patner" value="5"></td>-->
                                                            <td>V4 A1 Shipping</td>
                                                            <td><span id="courier_5"></span></td>
                                                          </tr>
                                                          @endif
                                                          
                                                        
                                                             
                                                          
                                                        </tbody>
                                                      </table>
                                                  </div>
                                                 </div>
                                                  
                                                  
                                            <div class="row gx-5 mt-5 mb-5">
                                                  

                                              <div class="col-sm-3">
                                                <div class="mb-3">
                                                    <label class="form-label"> Height (In cm) <span class="text-danger">*</span> :</label>
                                                    <input type="number" class="form-control" value="5"  placeholder="In cm" name="parcel_Height" required />
                                                </div>
                                            </div>
                                             <div class="col-sm-3">
                                                <div class="mb-3">
                                                    <label class="form-label"> Length  (In cm) <span class="text-danger">*</span> :</label>
                                                    <input type="number" class="form-control" value="28" placeholder="In cm" name="parcel_length" required />
                                                </div>
                                            </div>
                                             <div class="col-sm-3">
                                                <div class="mb-3">
                                                    <label class="form-label"> Breadth (In cm) <span class="text-danger">*</span> :</label>
                                                    <input type="number" class="form-control" value="22" placeholder="In cm" name="parcel_breadth" required />
                                                </div>
                                            </div>
                                              <div class="col-sm-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Parcel Weight (Dead weight) <span class="text-danger">*</span> :</label>
                                                    <input type="number"  class="form-control" value="" name="parcel_weight" id="parcel_weight" required />
                                                </div>
                                            </div>
                                            <!--<div class="col-sm-3">-->
                                            <!--    <div class="mb-3">-->
                                            <!--        <label class="form-label">Pickup Date <span class="text-danger">*</span> : </label>-->
                                            <!--        <input type="date"  class="form-control" min="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}" name="orderdate" id="orderdate" required />-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            
                                            
                                            
                                           
                                              </div>
                                            </div>
                                           @endif
                                           
                                            <hr>
                                            
                                           
                                        <div class="row gx-5" id="self_courier">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Courier Number :</label>
                                                    <input type="text" class="form-control" name="courier_no"  />
                                                </div>
                                            </div>
                                             
                                             <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Shipper Name :</label>
                                                    <input type="text" class="form-control" name="shipper_name" id="shipper_name" value="" required />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Shipper Address :</label>
                                                    <input type="text" class="form-control" value="{{$order->vendor_username;}},{{$order->vendor_address;}},({{$order->vendor_pincode;}}),{{$order->vendor_phone_no;}}" name="shipper_address" required />
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Comment :</label>
                                                    <textarea class="form-control"  name="comment"  ></textarea>
                                                </div>
                                            </div>
                                            
                                            
                                             <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                                </div>
                                            </div>
                                        </div> 
                                         @endif
                                         @endif
                                        </form>
                                       
                                   
                                   <hr>
                                   @if($order->print_status==0)<button type="button" class="btn btn-danger " onclick="update_print_bill_status(`{{$order->invoice_number;}}`)">Update Print Status </button>@endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button  class="btn btn-success" type="button" onclick="print_bill()">Print Bill</button>
                                   </div>
                                 <div id="order_bill" style="color:#000 !important">
                                    
                                        <div style="width: 200mm;height: 261mm;margin: 0 auto;padding: 20px;box-sizing: border-box;">
                                            <div style="border-bottom: 1px solid black; display: flex">
                                                <div style="flex: 1">
                                                    <h5 style="font-size: small; padding: 0%; margin: 0%">
                                                        Purchase made on
                                                        <span style="text-decoration: dashed">evyapari.com</span>
                                                    </h5>
                                                    <div style="position: absolute">
                                                        <img src="{{Storage::disk('s3')->url('site_img/barcode.png')}}" alt="Barcode" style="height: 30px" />
                                                      
                                                    </div>
                                                </div>
                                    
                                                <div style="flex: 1; padding-right: 40px; text-align: right">
                                                    <h5 style="font-size: small; padding: 0%; margin: 0%">
                                                        UDYAM-HP-03-0000290
                                                    </h5>
                                                   <img src="{{Storage::disk('s3')->url('site_img/evyapari-logo.png')}}" alt="Logo" style="height: 40px"> 
                                                </div>
                                            </div>
                                    
                                            <div style="text-align: center">
                                                <h4 style="margin: 0">Tax Invoice</h4>
                                            </div>
                                            <div style="display: flex;font-size: 15px;border-bottom: 1px solid slategray; ">
                                                <p style="margin-right: 2%; font-size: x-small">
                                                    <strong>Sold By(seller) :</strong> {{$order->vendor_username;}},{{$order->vendor_address;}} ,
                                                   ({{$order->vendor_pincode;}}),{{$order->vendor_phone_no;}} ,GSTIN:{{$order->vendor_gst_no;}}
                                                </p>
                                                <!--<p style="font-size: x-small; ">-->
                                                <!--    <strong>Merchant ID: </strong> {{$order->unique_id;}}-->
                                                <!--</p>-->
                                            </div>
                                             <br>
                                            <main>
                                                <p style="font-size: 8px; line-height: 14px; margin: 0% ;padding-bottom: 1%;">
                                                    <span style="font-weight: bold">BILLING ADDRESS:</span>
                                                    Name: {{$order->name;}},:Father's Name {{$order->fathers_name;}},{{$order->state;}},
                                                    {{$order->district;}}, Village/Ward No. {{$order->village;}},{{$order->address;}} <span style="font-weight: bold">PinCode:-</span>{{$order->pincode;}}
                                                 <span style="font-weight: bold ;">Mobile No. {{$order->phone_no;}}</span>
                                                </p>
                                                
                                    
                                                <div style="margin: 0%; padding-top: 5px;padding-left: 5px; padding-bottom: 5px; font-size: small; line-height: 16px; border: 1px solid slategray;box-shadow:  1px 1px gray; ">
                                                    <p style="font-weight: bold; margin: 0%; padding-top: 0% ; padding-bottom: 10px;"> To,</p>
                                                    
                                                     
                                                     @if($order->ship_address_type==3)
                                                    <span style="font-weight: bold"> PICKUP POINT ADDRESS:</span><br />
                                                    <b>{{$order->name;}}</b><br>
                                                    @else
                                                    <span style="font-weight: bold"> SHIPPING ADDRESS:</span><br />
                                                    @endif
                                                    
                                                    
                                                    
                                                    
                                                    {{$order->ship_name;}}, @if($order->ship_school_name!=NULL || $order->ship_school_code!=NULL){{$order->ship_school_name;}}({{$order->ship_school_code;}})@endif  @if($order->fathers_name!=NULL){{',Fathers Name:'.$order->fathers_name.',';}}@endif
                                                    {{$order->ship_state;}},{{$order->ship_district;}},
                                                    <span style="font-weight: bold">VILLAGE/Appartment/WARD NO.</span> {{$order->ship_village;}}, LANDMARK- {{$order->ship_address;}},
                                                    <span style="font-weight: bold">Post Office:-</span>{{$order->ship_post_office;}}<span style="font-weight: bold">
                                                        PinCode:-</span>{{$order->ship_pincode;}},<br />
                                                    <span style="font-weight: bold;padding-top: 5px;">Mobile No.{{$order->ship_phone_no;}}</span>
                                                </div>
                                    
                                                <p style="font-size: x-small;padding-bottom: 5px;padding-top: 10px;margin: 0%;border-bottom: 1px solid rgb(154, 147, 147); ">
                                                  @if($order->ship_school_name!=NULL){{'SCHOOL : '.$order->ship_school_name;}}@endif   @if($order->classno!==NULL) ,CLASS :{{$order->classno}}@endif
                                                </p>
                                                   <br>
                                                <div style="display: flex;justify-content: space-between;font-size: x-small;">
                                                    <div style="text-align: left">
                                                        <p style="padding-left: 0px; margin: 0%">
                                                            <span style="font-weight: bold">Bill Number: </span>
                                                            {{$order->bill_id;}}
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Invoice Date: </span>{{$order->inv_created_at;}}
                                                            14:10:51
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Payment Mode: </span> 
                                                            @if($order->mode_of_payment==1){{'Online';}}@else{{'COD';}}@endif
                                                        </p>
                                                    </div>
                                    
                                                    <div style="text-align: right">
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Order No: </span>
                                                            {{$order->invoice_number;}}
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Order Date: </span> {{$order->transaction_date;}}
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Transaction Id : </span>
                                                            {{$order->transaction_id;}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </main>
                                    
                                            <div>
                                                <!--<h4 style="text-align: left; margin: 0;padding-top: 5px; padding-bottom: 5px;">-->
                                                <!--    Order Type : School Set-->
                                                <!--</h4>-->
                                                <table border="1" style="text-align: center;border: 1px solid #7b7979;border-collapse: collapse;font-size: x-small;width: 100%;">
                                                    <tr >
                                                        <th style="border:1px solid #000;">#</th>
                                                        <th style="border:1px solid #000;">SKU</th>
                                                        <th style="border:1px solid #000;">Description</th>
                                                        <th style="border:1px solid #000;">Category</th>
                                                        <th style="border:1px solid #000;"> Price</th>
                                                        <th style="border:1px solid #000;">Qty</th>
                                                        <th style="border:1px solid #000;">GST</th>
                                                        <th style="border:1px solid #000;">GST Amt </th>
                                                        <th style="border:1px solid #000;">Total Amt. (Before tax)</th>
                                                    </tr>
                                                     @php
                                                     $weight=0;
                                                     $totalitem=0;
                                                     $total_amount=0;
                                                     $total_dis=0;
                                                     $total_ship=0;
                                                     $gstamount=0;
                                                     $finalamount=0;
                                                     
                                                     @endphp
                                                     @foreach($item_info as  $key => $itemdata)

                                                        <tr>
                                                            <td style="border:1px solid #000;">{{$key+1}}</td>
                                                            <td style="border:1px solid #000;">{{$itemdata['item_id'];}}</td>
                                                            <td >{{$itemdata['itemname'];}}
                                                            <span style="font-size: 10px;">
                                                            @if($itemdata['class']!='')<br><b>Class: </b>{{$itemdata['class']}}@endif
                                                            @if($itemdata['size_medium']!='')<b> , Size/Medium: </b>{{$itemdata['size_medium']}}@endif</span>
                                                            </td>
                                                            <td style="border:1px solid #000;">{{$itemdata['cat'];}}</td>
                                                            <td style="border:1px solid #000;">{{$itemdata['discount_rate'];}}</td>
                                                            <td style="border:1px solid #000;">{{$itemdata['qty'];}}</td>
                                                            <td style="border:1px solid #000;">{{$itemdata['gst'];}} %</td>
                                                            <td style="border:1px solid #000;">{{round($itemdata['gst_rate']*$itemdata['qty'],2);}}</td>
                                                            <td style="border:1px solid #000;">{{round($itemdata['qty']*$itemdata['without_gst_rate'],2);}}</td>
                                                        </tr>
                                                        @php
                                                        $weight+=$itemdata['weight']*$itemdata['qty'];
                                                        $total_amount+=round($itemdata['qty']*$itemdata['without_gst_rate'],2);
                                                        $total_dis+=$itemdata['discount'];
                                                        $total_ship+=$itemdata['item_ship_chr'];
                                                        $gstamount+=$itemdata['gst_rate']*$itemdata['qty'];
                                                        $finalamount+=$itemdata['rate']*$itemdata['qty']+$itemdata['item_ship_chr'];
                                                        $totalitem++;
                                                        @endphp
                                                        @endforeach
                                                        
                                                        @php
                                                        $base_value_ship = $total_ship / (1 + (18 / 100));  
                                                        $gst_value_shp_chr = $total_ship - $base_value_ship; 
                                                        @endphp
                                                   
                                                        <tr>
                                                            <td style="border:1px solid #000;">{{$totalitem+1}}</td>
                                                            <td  style="border:1px solid #000;"></td>
                                                            <td  style="border:1px solid #000;">Shipping Charges</td>
                                                            <td  style="border:1px solid #000;"></td>
                                                            <td style="border:1px solid #000;">{{round($total_ship,2);}}</td>
                                                            <td style="border:1px solid #000;">1</td>
                                                            <td style="border:1px solid #000;">18%</b></td>
                                                            <td style="border:1px solid #000;">{{round($gst_value_shp_chr,2);}} </td>
                                                            <td style="border:1px solid #000;">{{round($base_value_ship,2)}}</td>
                                                        </tr>
                                                      
                                                     @php
                                                      $igstcsgt=($gstamount+$gst_value_shp_chr)/2;
                                                      @endphp
                                                   

                                                </table>
                                                <p style="font-weight: bold; font-size: small">
                                                    Total No. Of Items: {{$totalitem;}}, Total Weight: {{$weight;}} grams
                                                </p>
                                            </div>
                                    
                                            <div style="padding-bottom:8px;text-align: right;border-bottom: 1px solid rgb(189, 180, 180);font-size: small;line-height: 0.6;">
                                                <p><span style="font-weight: bold">T/A (Before tax):</span>{{round($total_amount+$base_value_ship,2)}} </p>
                                                
                                                <!--<p><span style="font-weight: bold">Discount:</span> {{$total_dis}}</p>-->
                                                 <!--{{$total_ship}}-->
                                                 <!--$finalamount-->
                                                
                                                <p><span style="font-weight: bold">CGST:</span> {{round($igstcsgt,2)}}</p>
                                                <p><span style="font-weight: bold">SGST:</span> {{round($igstcsgt,2)}}</p>
                                                <!--<p><span style="font-weight: bold">Shipping Charges:</span> {{$total_ship}}</p>-->
                                                <p><span style="font-weight: bold">Final Price:</span>{{round(($total_amount+$base_value_ship)+($igstcsgt+$igstcsgt),2)}} </p>
                                    
                                                <p style="font-weight: bold; padding-right: 130px; margin: 3px">For:</p>
                                                <br />
                                                <br />
                                                <span style="font-weight: bold; margin: 10px">{{session('username')}}</span>
                                                <br />
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                            
                                            <div style="font-size: small">
                                                <h4 style="text-align: center; margin: 0">www.evyapari.com</h4>
                                                <p><b>Registered Name & Address</b><br>
                                                    <span style="font-weight: bold">V4 Masters Evyapari,</span> Bhagat
                                                    Complex Main Bazar Nadaun, Distt. Hamirpur 177033 (H.P), GSTIN:
                                                    02IKOPS0284N1ZH, Email: evyapari7@gmail.com
                                               ,
                                                    Goods once sold are not returnable. All guarantees & warranty subject
                                                    to seller.
                                                </p>
                                            </div>
                                        </div>
                                    
                                    
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
</div>



        
                     
	

                <footer class="default-footer">

                    @include('includes.footer')</footer>

                <div class="content-backdrop fade"></div>

            </div>

        </div>

    </div>
    <div class="layout-overlay layout-menu-toggle"></div>

    @include('includes.footer_script')

<script>

// Add event listener for the 'Get Selected' button
// document.getElementById("selectAll").addEventListener("click", function() {
//     var selectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');  // Get all checked checkboxes
//     var selectedValues = [];

//     // Loop through selected checkboxes to get their values and IDs
//     selectedCheckboxes.forEach(function(checkbox) {
//         var checkboxValue = checkbox.value;  // This is the value of the checkbox (id, item_type)
//         var checkboxId = checkbox.id;        // This is the id of the checkbox (if present)

//         // Store the checkbox value and id (if needed)
//         selectedValues.push({id: checkboxId, value: checkboxValue});
//     });

//     // Show the selected checkboxes' id and value in the console (or perform other actions as needed)
//     console.log(selectedValues);
// });



function getcheckeditemweight()
{
    var selectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');  // Get all checked checkboxes
    var selectedValues = [];
    var sum = 0;
        selectedCheckboxes.forEach(function(checkbox) {
        var checkboxValue = checkbox.value;  // This is the value of the checkbox (id, item_type)
         var valueParts = checkboxValue.split(',');
          var itemWeight = valueParts[2];  // The second part is the 'item_type'
            if (!isNaN(itemWeight)) {
                sum += parseFloat(itemWeight);  // Sum the numeric values (if itemType represents the price)
            }
    });

   return sum;
}



document.getElementById("refreshButton").addEventListener("click", function() {
    
    var selectElement = document.getElementById("defaultSelect");
    var selectedValue = selectElement.value;
    selectedorderstatus(selectedValue);
});


// selectedorderstatus
function selectedorderstatus(selstatus)
{
    if(selstatus==3)
    {
      
       var item_total_weight=getcheckeditemweight();
        
         $(".loader").css("display","block");
                $.ajax({
                type: "POST",
                url: "{{url('/') }}/get_price_ac_to_item_weight",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "item_total_weight": item_total_weight
                },
                dataType: 'json',
                cache: false,
                success: function(response) {
               
                let itemlength=response.length;
                // alert(itemlength);
                if(response.length==0)
                {
                $.toast({  heading:  "<i class='fa fa-warning' ></i> No shipping rates found for the specified weight", position: 'top-right',stack: false})
                $(".loader").css("display","none");
                }
                else
                { 
                    document.getElementById('parcel_weight').value=item_total_weight;
                    
                    // 	1=V4 Parcel (IndiaPost), 2=V4 Book Post (India Post), 3=V4 Contractual( Indai Post) , 4=V4 Rocket (ShipRocket), 5=V4 A1 Shipping (Amazon),0=Other	
                    for(let i=0;i<itemlength;i++)
                    {
                        
                       $('#courier_' + response[i].type).text(response[i].rate);
                        // $('#courier_'+response[i].type).append(response[i].rate);  
                      
                    }
                    
                    // $.toast({ heading: response.msg, position: 'top-right',stack: false,icon: 'success'})
                    $("#courier_patner").css("display","block");
                    $(".loader").css("display","none");
                
                }

                }
            });
        
        
    }
    else
    {
       $("#courier_patner").css("display","none"); 
    }
}



$(document).ready(function () {
    
  $('body').on('click', '#selectAll', function () {
      if ($(this).hasClass('allChecked')) {
         $('input[type="checkbox"]', '#mytable').prop('checked', false);
         	$("#statusform").css("display","none");
      } else {
          	$("#statusform").css("display","block");
      $('input[type="checkbox"]', '#mytable').prop('checked', true);
      }
      $(this).toggleClass('allChecked');
     })
     
     
function selectsinglecheckbox() {
$("#statusform").css("display","block");
}
});


function print_bill()
{
     var printContents = document.getElementById('order_bill').innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}


   function update_print_bill_status(order_id)
   {
    //   alert(order_id);
       $(".loader").css("display","block");
                $.ajax({
                type: "POST",
                url: "{{url('/') }}/order_print_status",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id
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
                
               setTimeout(function() 
				{
				window.history.back();
				}, 2000);
                
                }

                }
            });
   }
   
   
  $("#myform").on("submit",function(e)
  {    
      e.preventDefault();
        $(".loader").css("display","block");
        $.ajax
        ({
        type: "POST",
        url:  e.target.action,
        data: $('#myform').serialize(),
        success: function (response)
        {
               
        if (response.success ==0)
        {
        // $.toast({  heading:  "<i class='fa fa-warning' ></i> "+response.msg, position: 'top-right',stack: false,duration: 10000 })
        // $(".loader").css("display","none");
        // setTimeout(function(){window.location.reload();}, 10000);
       
       alert(response.msg);
       
               $.toast({
                    heading: "<i class='fa fa-warning'></i> " + response.msg,
                    position: 'top-right',
                    stack: false,
                    timer: 3000 // This sets the toast to disappear after 10 seconds
                });
                
                $(".loader").css("display", "none");
                
                // Set a timeout to reload the page after 10 seconds
                setTimeout(function() {
                    window.location.reload();
                }, 2000);

       
       
        }
        else
        {
        $.toast({ heading: response.msg, position: 'top-right',stack: false,icon: 'success'})
        $(".loader").css("display","none");
        setTimeout(function()
        {
         window.history.back();
            
        }, 2000);
        }
        
        
        }
        }); 

});


//ship_pincode,

</script>
</body>
</html>

