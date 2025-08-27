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

                            <h5 class="card-header"> Order Details</h5>

                               <div class="card-body p-3">
                                   <div class="">
                                 
                                        
                                        <hr>
                                          <div class="row">
                                                    <div class="col-md-6">
                                                        
                                                          <p style="padding-left: 0px; margin: 0%">
                                                    <span style="font-weight: bold">BILLING ADDRESS:</span><br>
                                                    Name: {{$order->name;}}<br>Father's Name {{$order->fathers_name;}},{{$order->state;}},
                                                    {{$order->district;}}, Village/Ward No. {{$order->village;}},{{$order->address;}} <br><span style="font-weight: bold">PinCode:-</span>{{$order->pincode;}}
                                                 <br><span style="font-weight: bold ;">Mobile No. {{$order->phone_no;}}</span>
                                                </p>
                                                
                                                       
                                                    </div>
                                    
                                                    <div class="col-md-6">
                                                     <p style="padding-left: 0px; margin: 0%"> 
                                                    <span style="font-weight: bold"> SHIPPING ADDRESS:</span>   <button type='button' onclick="editShipAdd()" class="btn btn-info">Edit</button><br />
                                                    {{$order->ship_name;}}, @if($order->ship_school_name!=NULL || $order->ship_school_code!=NULL){{$order->ship_school_name;}}({{$order->ship_school_code;}})@endif  @if($order->fathers_name!=NULL){{',Fathers Name:'.$order->fathers_name.',';}}@endif
                                                    {{$order->ship_state;}},{{$order->ship_district;}},{{$order->ship_city;}},
                                                    <span style="font-weight: bold">VILLAGE/Appartment/WARD NO.</span> {{$order->ship_village;}}, LANDMARK- {{$order->ship_address;}},
                                                    <span style="font-weight: bold">Post Office:-</span>{{$order->ship_post_office;}}<span style="font-weight: bold">
                                                        PinCode:-</span>{{$order->ship_pincode;}},<br />
                                                    <span style="font-weight: bold;padding-top: 5px;">Mobile No.{{$order->ship_phone_no;}}</span>
                                                    </p>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                               
                                        <hr>
                                              <p >
                                                  @if($order->ship_school_name!=NULL){{'SCHOOL : '.$order->ship_school_name;}}@endif   @if($order->classno!==NULL) ,CLASS :{{$order->classno}}@endif
                                                </p>
                                                
                                         <div class="row">
                                                    <div class="col-md-6">
                                                        
                                                    <p style="padding-left: 0px; margin: 0%">
                                                            <span style="font-weight: bold">Bill Number: </span>
                                                            {{$order->bill_id;}}
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Invoice Date: </span>{{$order->inv_created_at;}}
                                                          
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Payment Mode: </span> 
                                                            @if($order->mode_of_payment==1){{'Online';}}@else{{'COD';}}@endif
                                                        </p>
                                                        <br>
                                                        
                                                          <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">School Code: </span> 
                                                           {{$order->school_code}}
                                                        </p>
                                                         <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">School Name: </span> 
                                                           {{$order->school_name}}
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
                                                         <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Order Status : </span>
                                                            @if($order->order_status==1){{'Pending'}}
                                                            @elseif($order->order_status==2){{'placed'}}
                                                            @elseif($order->order_status==3){{'InProcess'}}
                                                            @elseif($order->order_status==4){{'deliverd'}}
                                                            @elseif($order->order_status==5){{'cancled'}}
                                                            @else{{''}}
                                                            @endif
                                                        </p>
                                                        
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Order In : </span>
                                                            @if($order->order_status==1){{'Not Placed'}}
                                                            @elseif($order->order_status==2){{'New Order'}}
                                                            @elseif($order->order_status==3){{'Order Under Proccess'}}
                                                            @elseif($order->order_status==4){{'Deliverd Order'}}
                                                            @elseif($order->order_status==5){{'Cancled Order'}}
                                                            @else{{''}}
                                                            @endif
                                                        </p>
                                                        
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Batch Id : </span>
                                                            @if($order->batch_id==0){{''}}
                                                            @else{{$order->batch_id}}
                                                            @endif
                                                        </p>
                                                        
                                                       
                                                    </div>
                                                </div>
                                                
           
                                        <div class="row gx-5">
                                            <div class="col-md-12 my-5">
                                                <div class="card">
                                                    
                                                <table id="mytable" class="table" >
                                                    <tr >
                                                        <th>#</th>
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
                                                            <td >{{$key+1}}</td>
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
                                                            <td >{{round($itemdata['gst_rate'],2);}}</td>
                                                            <td>{{round($itemdata['qty']*$itemdata['without_gst_rate'],2);}}</td>
                                                        </tr>
                                                         @php
                                                        $weight+=$itemdata['weight'];
                                                        $total_amount+=round($itemdata['qty']*$itemdata['without_gst_rate'],2);
                                                        $total_dis+=$itemdata['discount'];
                                                        $total_ship+=$itemdata['item_ship_chr'];
                                                        $gstamount+=$itemdata['gst_rate'];
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
                                                             <td  style="border:1px solid #000;"></td>
                                                            <td  style="border:1px solid #000;">Shipping Charges/Set customization charges</td>
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
                                                
                                                
                                                   <div style="padding-bottom:8px;text-align: right;border-bottom: 1px solid rgb(189, 180, 180);font-size: small;line-height: 0.6;">
                                                <p><span style="font-weight: bold">T/A (Before tax):</span> {{$total_amount}}</p>
                                                
                                                <!--<p><span style="font-weight: bold">Discount:</span> {{$total_dis}}</p>-->
                                                 <!--{{$total_ship}}-->
                                                 <!--$finalamount-->
                                                
                                                <p><span style="font-weight: bold">CGST:</span> {{round($igstcsgt,2)}}</p>
                                                <p><span style="font-weight: bold">SGST:</span> {{round($igstcsgt,2)}}</p>
                                                <p><span style="font-weight: bold">Shipping Charges:</span> {{$order->total_shipping}}</p>
                                                <p><span style="font-weight: bold">Final Price:</span> {{$order->grand_total}}</p>
                                    
                                                <p style="font-weight: bold; padding-right: 130px; margin: 3px">For:</p>
                                                <br />
                                                <br />
                                                <span style="font-weight: bold; margin: 10px">BHAGAT ENTERPRISES</span>
                                                <br />
                                            </div>
                                            
                                            
                                            
                                            
                                                </div>
                                            </div>
                                            
                                             
                                       
                                   
                                   <hr>
                                    </div>
                                    
                                        @if($order->print_status==0)<button type="button" class="btn btn-danger ">Unprint </button>@else <button type="button" class="btn btn-info ">Printed </button> @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button  class="btn btn-success" type="button" onclick="print_bill()">Print Bill</button>
                              
                                <div id="order_bill" style="color:#000 !important">
                                    
                                        <div style="width: 200mm;height: 261mm;margin: 0 auto;padding: 20px;box-sizing: border-box;">
                                            <div style="border-bottom: 1px solid black; display: flex">
                                                <div style="flex: 1">
                                                    <h5 style="font-size: small; padding: 0%; margin: 0%">
                                                        Purchase made on
                                                        <span style="text-decoration: dashed">evyapari.com</span>
                                                    </h5>
                                                    <div style="position: absolute">
                                                        <img src="{{Storage::disk('s3')->url('site_img/barcode.png')}}" alt="Barcode" style="height: 40px" />
                                                      
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
                                                    <span style="font-weight: bold"> SHIPPING ADDRESS:</span><br />
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
                                                            <td style="border:1px solid #000;">{{round($itemdata['gst_rate'],2);}}</td>
                                                            <td style="border:1px solid #000;">{{round($itemdata['qty']*$itemdata['without_gst_rate'],2);}}</td>
                                                        </tr>
                                                        @php
                                                        $weight+=$itemdata['weight']*$itemdata['qty'];
                                                        $total_amount+=round($itemdata['qty']*$itemdata['without_gst_rate'],2);
                                                        $total_dis+=$itemdata['discount'];
                                                        $total_ship+=$itemdata['item_ship_chr'];
                                                        $gstamount+=$itemdata['gst_rate'];
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
                                                            <td  style="border:1px solid #000;">Shipping Charges/Set customization charges</td>
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
                                                <p><span style="font-weight: bold">T/A (Before tax):</span> {{$total_amount}}</p>
                                                
                                                <!--<p><span style="font-weight: bold">Discount:</span> {{$total_dis}}</p>-->
                                                 <!--{{$total_ship}}-->
                                                 <!--$finalamount-->
                                                
                                                <p><span style="font-weight: bold">CGST:</span> {{round($igstcsgt,2)}}</p>
                                                <p><span style="font-weight: bold">SGST:</span> {{round($igstcsgt,2)}}</p>
                                                <p><span style="font-weight: bold">Shipping Charges:</span> {{$order->total_shipping}}</p>
                                                <p><span style="font-weight: bold">Final Price:</span> {{$order->grand_total}}</p>
                                    
                                                <p style="font-weight: bold; padding-right: 130px; margin: 3px">For:</p>
                                                <br />
                                                <br />
                                                <span style="font-weight: bold; margin: 10px">BHAGAT ENTERPRISES</span>
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
    
    
    
    

<!-- Modal -->
<div id="shipModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Shipping Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="myform" class="mb-3" action="{{url('/') }}/update_order_ship_address" method="POST"  enctype="multipart/form-data">
         @csrf

      <div class="modal-body">
    
            <input type="hidden" value="{{$order->invoice_number}}" name="invoice_number">
            <input type="hidden" value="{{$order->user_id}}" name="user_id">

    <div class="row">
            <div class="col-md-12">
              <div class="form-group m-2">
                <label for="shipName">Ship Name</label>
                <input type="text" class="form-control" name="name" id="shipName" value="{{$order->ship_name}}">
              </div>
            </div>
         
          </div>
          
          <!-- Second Row with Two Columns -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group m-2">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" value="{{$order->ship_city}}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group m-2">
                <label for="shipState">State</label>
                <input type="text" class="form-control" name="state" id="shipState" value="{{$order->ship_state}}">
              </div>
            </div>
          </div>

          <!-- Third Row with Two Columns -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group m-2">
                <label for="shipDistrict">District</label>
                <input type="text" class="form-control" name="district" id="shipDistrict" value="{{$order->ship_district}}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group m-2">
                <label for="shipVillage">Village/Appartment/Ward No.</label>
                <input type="text" name="village" class="form-control" id="shipVillage" value="{{$order->ship_village}}">
              </div>
            </div>
          </div>

          <!-- Fourth Row with Two Columns -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group m-2">
                <label for="shipAddress">Address</label>
                <input type="text" class="form-control" name="address" id="shipAddress" value="{{$order->ship_address}}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group m-2">
                <label for="shipPostOffice">Post Office</label>
                <input type="text" class="form-control" name="post_office" id="shipPostOffice" value="{{$order->ship_post_office}}">
              </div>
            </div>
          </div>

          <!-- Fifth Row with One Column (PinCode and Phone) -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group m-2">
                <label for="shipPincode">Pin Code</label>
                <input type="text" class="form-control" name="pincode" id="shipPincode" value="{{$order->ship_pincode}}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group m-2">
                <label for="shipPhoneNo">Mobile No.</label>
                <input type="text" class="form-control" id="shipPhoneNo" name="phone_no" value="{{$order->ship_phone_no}}">
              </div>
            </div>
          </div>

       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      
       </form>
    </div>
  </div>
</div>

<!-- JavaScript to open modal -->
<script>
function editShipAdd() {
  $('#shipModal').modal('show');
}
</script>

    
    

    @include('includes.footer_script')

<script>




function print_bill()
{
     var printContents = document.getElementById('order_bill').innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
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
           setTimeout(function() {
                    window.location.reload();
                }, 2000);
        }
        
        
        }
        }); 

});

</script>

</body>
</html>

