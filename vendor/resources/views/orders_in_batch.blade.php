<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title> Orders Under Process</title>
    <meta name="description" content="" />
    @include('includes.header_script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .otiddiv{margin: 0 !important;border-bottom: 1px solid #ddd;width:auto;}
        .add_td{
          white-space: normal !important; 
          word-wrap: break-word;  
        }
        #batch_order_bill
        {display:none;}
        
            .page-break {
            display: block;
            page-break-before: always;
            /*white-space: nowrap;*/
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

 
                        
                            <div class="card">
                                <h5 class="card-header d-flex">
                                    
                                       @if($print_status==0)
                                    
                                       <form id="formAuthentication"  action="{{url('/') }}/update_batch_print_status"  method="POST"> 
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
                                        
                                        <input type="hidden" value="{{$batch_id}}" name="id" required>
                                       <button type="submit" class="btn btn-danger">Update Print Status</button>
                                       </form>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                       @endif
                                       <button type="button" onclick="print_batch_pdf()" class="btn btn-primary">Print Batch PDF</button>   
                                       
                                         <a href="{{url('download_batch_xsl',$batch_id)}}" target="_blank" class="btn btn-primary"> Post Office Xsl</a>   
                                    
                                 </h5>
                                
                                
                                <div class="table-responsive text-nowrap">
                                    <table id="mytable" class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">
                                        <thead>
                                            <tr>
                                                <th># </th>
                                                <th data-sortable="true">Invoice Number<br>Transaction ID</br>Order Time<br>MOP</th>
                                                <th data-sortable="true">Amount</th>
                                                <th data-sortable="true">Grand <br> Total</th>
                                                <th data-sortable="true">Class</th>
                                                <th data-sortable="true" data-visible="false">Bill Address</th>
                                                <th data-sortable="true">Ship Address</th>
                                                <th data-sortable="true"> Status</th>
                                                <!--<th data-sortable="true"> Action</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $count=count($data);
                                            @endphp
                                            @for($i=0;$i<$count;$i++)
                                            @php
                                            $i+1;
                                            if($data[$i]['ordersinfo']->ship_address_type==1){{$ship_address_type="<b>Home</b><br>";}} elseif($data[$i]['ordersinfo']->ship_address_type==2) {{$ship_address_type='<b>School</b><br>';}}  else {{$ship_address_type='<b>Pickup Point</b><br>';}} 
                                            if($data[$i]['ordersinfo']->ship_name==NULL){{$ship_name="";}} else {{$ship_name='<b>'.$data[$i]['ordersinfo']->ship_name.'</b><br>';}}
                                            if($data[$i]['ordersinfo']->ship_phone_no==NULL){{$ship_phone_no="";}} else {{$ship_phone_no=$data[$i]['ordersinfo']->ship_phone_no.',';}} 
                                            if($data[$i]['ordersinfo']->ship_alternate_phone==NULL){{$ship_alternate_phone="";}} else {{$ship_alternate_phone=$data[$i]['ordersinfo']->ship_alternate_phone.'<br>';}} 
                                            if($data[$i]['ordersinfo']->ship_school_name==NULL){{$ship_school_name="";}} else {{$ship_school_name=$data[$i]['ordersinfo']->ship_school_name.',(';}} 
                                            if($data[$i]['ordersinfo']->ship_school_code==NULL){{$ship_school_code="";}} else {{$ship_school_code=$data[$i]['ordersinfo']->ship_school_code.')<br>';}} 
                                            if($data[$i]['ordersinfo']->ship_state==NULL){{$ship_state="";}} else {{$ship_state=$data[$i]['ordersinfo']->ship_state.'<br>';}}
                                            if($data[$i]['ordersinfo']->ship_district==NULL){{$ship_district="";}} else {{$ship_district=$data[$i]['ordersinfo']->ship_district.',';}} 
                                            if($data[$i]['ordersinfo']->ship_city==NULL){{$ship_city="";}} else {{$ship_city=$data[$i]['ordersinfo']->ship_city.'<br>';}} 
                                            if($data[$i]['ordersinfo']->ship_village==NULL){{$ship_village="";}} else {{$ship_village=$data[$i]['ordersinfo']->ship_village.'<br>';}} 
                                            if($data[$i]['ordersinfo']->ship_address==NULL){{$ship_address="";}} else {{$ship_address=$data[$i]['ordersinfo']->ship_address.'<br>';}} 
                                            if($data[$i]['ordersinfo']->ship_post_office==NULL){{$ship_post_office="";}} else {{$ship_post_office=$data[$i]['ordersinfo']->ship_post_office.'(';}} 
                                            if($data[$i]['ordersinfo']->ship_pincode==NULL){{$ship_pincode="";}} else {{$ship_pincode=$data[$i]['ordersinfo']->ship_pincode.')';}} 
                                            
                                            @endphp
                                            <tr>
                                                <td>{{$i+1}}</td>
                                                <td><p  class="otiddiv mb-1 py-1 px-1 border border-1"  ><b>OID - </b><span onclick="copy(this)">{{$data[$i]['ordersinfo']->invoice_number}}</span></p><p  class="py-1 px-1 border border-1"  ><b>TID - </b><span  onclick="copy(this)">{{$data[$i]['ordersinfo']->transaction_id}}</span> <p  class="otiddiv mb-1 py-1 px-1 border border-1"><b>Bill No - </b>{{$data[$i]['ordersinfo']->bill_id}}</p><b>Time - </b>{{$data[$i]['ordersinfo']->transaction_date}} </td>
                                                <td> <b>@if($data[$i]['ordersinfo']->mode_of_payment==1){{'Online'}}@else{{'COD'}}@endif</b><br><b>Total - {{$data[$i]['ordersinfo']->total_amount}}</b><br><b>Discount - {{$data[$i]['ordersinfo']->total_discount}}</b><br><b>Shipping - {{$data[$i]['ordersinfo']->shipping_charge}}</b></td>
                                                <td>{{$data[$i]['ordersinfo']->grand_total}}</td>
                                                <td>{{$data[$i]['ordersinfo']->setclass}}</td>
                                                <td class="add_td"><b>{{$data[$i]['ordersinfo']->name}}</b><br>{{$data[$i]['ordersinfo']->phone_no}}<br>{{$data[$i]['ordersinfo']->school_code}}<br>{{$data[$i]['ordersinfo']->district.','.$data[$i]['ordersinfo']->city}}<br>{{$data[$i]['ordersinfo']->address}}<br>{{$data[$i]['ordersinfo']->post_office.','.$data[$i]['ordersinfo']->pincode}}</td>
                                                <td class="add_td">{!! $ship_address_type.$ship_name.$ship_phone_no.$ship_alternate_phone.$ship_school_name.$ship_school_code.$ship_state.$ship_district.$ship_city.$ship_village.$ship_address.$ship_post_office.$ship_pincode !!}</td>
                                                <td> @if($data[$i]['ordersinfo']->tracking_status!=""){!!$data[$i]['ordersinfo']->tracking_status!!}@endif @if($data[$i]['ordersinfo']->print_status==1)<span class="bg-success text-white p-1">{{'Printed';}}</span> @else <span class="bg-danger text-white p-1">{{'Unprint';}}</span>@endif
                                                  <br>
                                                <a  href="{{url('order_process_status',$data[$i]['ordersinfo']->invoice_number)}}" class="btn-sm  mt-3 btn btn-primary">Update</a></td>
                                             </tr>

                                            @endfor
                                        </tbody>

                                    </table>
                                    
                                   
				                
                                </div>
                            </div>
                         </div>
                            </div>
                            
                          
                    
                             
                         </div>
                            
                            
                        </div>
                    </div>
                </div>
                
                
                      
                      
                      
                      
                      
                      <div id="batch_order_bill" style="color:#000 !important">
                                            @php
                                            $count=count($data);
                                            @endphp
                                            @for($j=0;$j<$count;$j++)
                                
                              <div  style="color:#000 !important;page-break-before: always !important;">
                                  
                                       <div style="border:1px solid #000;padding:15px 10px 0px 10px;box-sizing: border-box;">
                                            <div style="border-bottom: 1px solid black; display: flex">
                                                <div style="flex: 1">
                                           
                                                      <p class="">{{$j+1}}</p>
                                                      <h5 style="font-size: small; padding: 0%; margin: 0%">
                                                        Purchase made on
                                                        <span style="text-decoration: dashed">evyapari.com</span>
                                                    </h5>
                                                    <div style="position: absolute">
                                                        {{$bid}}
                                                        <!--<img src="{{Storage::disk('s3')->url('site_img/barcode.png')}}" alt="Barcode" style="height: 25px" />-->
                                                      
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
                                                <h5 style="margin: 0">Tax Invoice</h5>
                                            </div>
                                            <div style="display: flex;font-size: 15px;border-bottom: 1px solid slategray; ">
                                                <p style="margin-right: 2%; font-size: x-small">
                                                    <strong>Sold By(seller) :</strong> {{$data[$j]['ordersinfo']->vendor_username;}},{{$data[$j]['ordersinfo']->vendor_address;}} ,
                                                   ({{$data[$j]['ordersinfo']->vendor_pincode;}}),{{$data[$j]['ordersinfo']->vendor_phone_no;}} ,GSTIN:{{$data[$j]['ordersinfo']->vendor_gst_no;}}
                                                </p>
                                              
                                            </div>
                                            
                                            <main>
                                                <p style="font-size: 8px; line-height: 14px; margin: 0% ;padding-bottom: 1%;">
                                                    <span style="font-weight: bold">BILLING ADDRESS:</span>
                                                    Name: {{$data[$j]['ordersinfo']->name;}},:Father's Name {{$data[$j]['ordersinfo']->fathers_name;}},{{$data[$j]['ordersinfo']->state;}},
                                                    {{$data[$j]['ordersinfo']->district;}}, Village/Ward No. {{$data[$j]['ordersinfo']->village;}},{{$data[$j]['ordersinfo']->address;}} <span style="font-weight: bold">PinCode:-</span>{{$data[$j]['ordersinfo']->pincode;}}
                                                 <span style="font-weight: bold ;">Mobile No. {{$data[$j]['ordersinfo']->phone_no;}}</span>
                                                </p>
                                                
                                    
                                                <div style="margin: 0%; padding-top: 5px;padding-left: 5px; padding-bottom: 5px; font-size: small; line-height: 16px; border: 1px solid slategray;box-shadow:  1px 1px gray; ">
                                                    <p style="font-weight: bold; margin: 0%; padding-top: 0% ; padding-bottom: 10px;"> To,</p>
                                                   
                                                    @if($data[$j]['ordersinfo']->ship_address_type==3)
                                                    <span style="font-weight: bold"> PICKUP POINT ADDRESS:</span><br />
                                                    <b>{{$data[$j]['ordersinfo']->name;}}</b><br>
                                                    @else
                                                    <span style="font-weight: bold"> SHIPPING ADDRESS:</span><br />
                                                    @endif
                                                    
                                                   
                                                    {{$data[$j]['ordersinfo']->ship_name;}}, @if($data[$j]['ordersinfo']->ship_school_name!=NULL || $data[$j]['ordersinfo']->ship_school_code!=NULL){{$data[$j]['ordersinfo']->ship_school_name;}}({{$data[$j]['ordersinfo']->ship_school_code;}})@endif @if($data[$j]['ordersinfo']->fathers_name!=NULL){{',Fathers Name:'.$data[$j]['ordersinfo']->fathers_name.',';}}@endif
                                                    {{$data[$j]['ordersinfo']->ship_state;}},{{$data[$j]['ordersinfo']->ship_district;}},
                                                    <span style="font-weight: bold">VILLAGE/Appartment/WARD NO.</span> {{$data[$j]['ordersinfo']->ship_village;}}, LANDMARK- {{$data[$j]['ordersinfo']->ship_address;}},
                                                    <span style="font-weight: bold">Post Office:-</span>{{$data[$j]['ordersinfo']->ship_post_office;}}<span style="font-weight: bold">
                                                        PinCode:-</span>{{$data[$j]['ordersinfo']->ship_pincode;}},<br />
                                                    <span style="font-weight: bold;padding-top: 5px;">Mobile No.{{$data[$j]['ordersinfo']->ship_phone_no;}}</span>
                                                </div>
                                    
                                                <p style="font-size: x-small;padding-bottom: 5px;padding-top: 10px;margin: 0%;border-bottom: 1px solid rgb(154, 147, 147); ">
                                                  @if($data[$j]['ordersinfo']->ship_school_name!=NULL){{'SCHOOL : '.$data[$j]['ordersinfo']->ship_school_name;}}@endif   @if($data[$j]['ordersinfo']->classno!==NULL) ,CLASS :{{$data[$j]['ordersinfo']->classno}}@endif
                                                </p>
                                                  
                                                <div style="display: flex;justify-content: space-between;font-size: x-small;">
                                                    <div style="text-align: left">
                                                        <p style="padding-left: 0px; margin: 0%;font-weight: bold;font-size:12px;">
                                                            <span style="font-weight: bold">Bill Number: </span>
                                                            {{$data[$j]['ordersinfo']->bill_id;}}
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Invoice Date: </span>{{$data[$j]['ordersinfo']->inv_created_at;}}
                                                            14:10:51
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Payment Mode: </span> 
                                                            @if($data[$j]['ordersinfo']->mode_of_payment==1){{'Online';}}@else{{'COD';}}@endif
                                                        </p>
                                                         <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold"> Order Type : </span>
                                                             @if($data[$j]['ordersinfo']->custom_set_status==1) {{'Custom School Set'}} @else {{'School Set'}} @endif
                                                        </p>
                                                    </div>
                                    
                                                    <div style="text-align: right">
                                                        <p style="padding: 0%; margin: 0%; font-weight: bold;font-size:14px;">
                                                            <span style="font-weight: bold">Order No: </span>
                                                            {{$data[$j]['ordersinfo']->invoice_number;}}
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Order Date: </span> {{$data[$j]['ordersinfo']->transaction_date;}}
                                                        </p>
                                                        <p style="padding: 0%; margin: 0%">
                                                            <span style="font-weight: bold">Transaction Id : </span>
                                                            {{$data[$j]['ordersinfo']->transaction_id;}}
                                                        </p>
                                                       
                                                    </div>
                                                </div>
                                            </main>
                                    
                                    
                                            <div>
                                                <h4 style="text-align: left; margin: 0;padding-top: 5px; padding-bottom:5px;">
                                                    Order Type : @if($data[$j]['ordersinfo']->custom_set_status==1) {{'Custom School Set'}} @else {{'School Set'}} @endif
                                                </h4>
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
                                                     $shipcharwithougst=0;
                                                        $shipgstamt=0;
                                                        $shipgstincamt=0;
                                                        $newvar=0;
                                                     @endphp
                                               
                                                        @foreach($data[$j]['item_info'] as  $key2 => $itemdata)
                                                        <tr>
                                                            <td style="border:1px solid #000;">{{$key2+1}}</td>
                                                            <td style="border:1px solid #000;">{{$itemdata['item_id'];}}</td>
                                                            <td style="border:1px solid #000;">{{$itemdata['itemname'];}}
                                                              <span style="font-size: 10px;">
                                                            @if($itemdata['class']!='')<br><b>Class: </b>{{$itemdata['class']}}@endif
                                                            @if($itemdata['size_medium']!='')<b> , Size/Medium: </b>{{$itemdata['size_medium']}}@endif</span>
                                                            </td>
                                                            <td style="border:1px solid #000;">{{$itemdata['cat'];}}</td>
                                                            <td style="border:1px solid #000;"><span class="text-decoration-line-through">{{$itemdata['rate'];}} </span> &nbsp;&nbsp;{{$itemdata['discount_rate'];}}</td>
                                                            <td style="border:1px solid #000;"><b style="font-size:12px">{{$itemdata['qty'];}}</b></td>
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
                                                        $finalamount+=$itemdata['rate']*$itemdata['qty'];
                                                        
                                                        $newvar+=$itemdata['discount_rate']*$itemdata['qty'];
                                                        
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
                                                <p><span style="font-weight: bold">T/A (Before tax):</span> {{round($total_amount+$base_value_ship,2)}}</p>
                                                
                                                  <!--<p><span style="font-weight: bold">Discount:</span> {{$total_dis}}</p>-->
                                                 <!--{{$total_ship}}-->
                                                 <!--$finalamount-->
                                                 
                                                <!--<p><span style="font-weight: bold">Discount:</span> {{$total_dis}}</p>-->
                                                <p><span style="font-weight: bold">CGST:</span> {{round($igstcsgt,2)}}</p>
                                                <p><span style="font-weight: bold">SGST:</span> {{round($igstcsgt,2)}}</p>
                                                <!--<p><span style="font-weight: bold">Shipping Charges:</span> {{$data[$j]['ordersinfo']->total_shipping}}</p>-->
                                                <p><span style="font-weight: bold">Final Price:</span> {{round(($total_amount+$base_value_ship)+($igstcsgt+$igstcsgt),2)}}</p>
                                    
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
                                  <br><br>
                                 @endfor
                                </div>
                                
                                
                <footer class="default-footer"
                    @include('includes.footer')</footer>
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
    @include('includes.footer_script')
</body>
</html>
<script>
    
    
    
function print_batch_pdf()
{
     var printContents = document.getElementById('batch_order_bill').innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}
</script>