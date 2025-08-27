<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title> Searched Orders</title>
    <meta name="description" content="" />
    @include('includes.header_script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .otiddiv{margin: 0 !important;border-bottom: 1px solid #ddd;width:auto;}
        .add_td{
          white-space: normal !important; 
          word-wrap: break-word;  
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
                                <h5 class="card-header">View Search  Orders  </h5>
                                <div class="table-responsive text-nowrap">

                                    <table id="mytable" class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">

                                        <thead>
                                            <tr>
                                               <th># </th>
                                                <th data-sortable="true">Invoice Number<br>Transaction ID</br>Order Time<br>MOP</th>
                                                   <th data-sortable="true">Amount</th>
                                                    <th data-sortable="true" data-visible="false">Bill Address</th>
                                                    <th data-sortable="true">Ship Address</th>
                                                     <th data-sortable="true">Order Status</th>
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
   
                                            @foreach($orders as $key => $data)
                                            @php
                                            $key++;
                                            if($data->ship_address_type==1){{$ship_address_type="<b>Home</b><br>";}} else {{$ship_address_type='<b>School</b><br>';}} 
                                            if($data->ship_name==NULL){{$ship_name="";}} else {{$ship_name='<b>'.$data->ship_name.'</b><br>';}}
                                            if($data->ship_phone_no==NULL){{$ship_phone_no="";}} else {{$ship_phone_no=$data->ship_phone_no.',';}} 
                                            if($data->ship_alternate_phone==NULL){{$ship_alternate_phone="";}} else {{$ship_alternate_phone=$data->ship_alternate_phone.'<br>';}} 
                                            if($data->ship_school_name==NULL){{$ship_school_name="";}} else {{$ship_school_name=$data->ship_school_name.',(';}} 
                                            if($data->ship_school_code==NULL){{$ship_school_code="";}} else {{$ship_school_code=$data->ship_school_code.')<br>';}} 
                                            if($data->ship_state==NULL){{$ship_state="";}} else {{$ship_state=$data->ship_state.'<br>';}}
                                            if($data->ship_district==NULL){{$ship_district="";}} else {{$ship_district=$data->ship_district.',';}} 
                                            if($data->ship_city==NULL){{$ship_city="";}} else {{$ship_city=$data->ship_city.'<br>';}} 
                                            if($data->ship_village==NULL){{$ship_village="";}} else {{$ship_village=$data->ship_village.'<br>';}} 
                                            if($data->ship_address==NULL){{$ship_address="";}} else {{$ship_address=$data->ship_address.'<br>';}} 
                                            if($data->ship_post_office==NULL){{$ship_post_office="";}} else {{$ship_post_office=$data->ship_post_office.'(';}} 
                                            if($data->ship_pincode==NULL){{$ship_pincode="";}} else {{$ship_pincode=$data->ship_pincode.')';}} 
                                            
                                            if($data->order_status==1)
                                            {
                                            $order_status="Pending";
                                            }
                                            elseif($data->order_status==2)
                                            {
                                            $order_status="Placed";
                                            }
                                            elseif($data->order_status==3)
                                            {
                                            $order_status="InProcess";
                                            }
                                            elseif($data->order_status==4)
                                            {
                                            $order_status="Deliverd";
                                            }
                                            elseif($data->order_status==5)
                                            {
                                            $order_status="Cancled";
                                            }
                                            else
                                            {
                                            $order_status="";
                                            }
                                            
                                           
                                            
                                            @endphp
                                            <tr>
                                                <td>{{$key}} </td>
                                                <td><p  class="otiddiv mb-1 py-1 px-1 border border-1"  ><b>OID - </b><span onclick="copy(this)">{{$data->invoice_number}}</span></p><p  class="py-1 px-1 border border-1"  ><b>TID - </b><span  onclick="copy(this)">{{$data->transaction_id}}</span> <p  class="otiddiv mb-1 py-1 px-1 border border-1"><b>Bill No - </b>{{$data->bill_id}}</p><b>Time - </b>{{$data->transaction_date}} </td>
                                                  <td> <b>@if($data->mode_of_payment==1){{'Online'}}@else{{'COD'}}@endif</b><br><b>Total - {{$data->total_amount}}</b><br><b>Discount - {{$data->total_discount}}</b><br><b>Shipping - {{$data->shipping_charge}}</b><br><b>Status - {{$order_status}}</b></td>
                                                    <td class="add_td"><b>{{$data->name}}</b><br>{{$data->phone_no}}<br>{{$data->school_code}}<br>{{$data->district.','.$data->city}}<br>{{$data->address}}<br>{{$data->post_office.','.$data->pincode}}</td>
                                                    <td class="add_td">{!! $ship_address_type.$ship_name.$ship_phone_no.$ship_alternate_phone.$ship_school_name.$ship_school_code.$ship_state.$ship_district.$ship_city.$ship_village.$ship_address.$ship_post_office.$ship_pincode !!}</td>
                                                    <td> @if($data->tracking_status!=""){!!$data->tracking_status!!}@endif @if($data->print_status==1)<span class="bg-success text-white p-1">{{'Printed';}}</span> @else <span class="bg-danger text-white p-1">{{'Unprint';}}</span>@endif
                                                   
                                                         <form class="mt-1"  method="get" id="myform" action="{{url('/') }}/filter_search_order"  enctype="multipart/form-data" novalidate>
                                                               @csrf
                                                                 <input type="hidden" value="1" name="search_type" required>
                                                                 <input type="hidden" value="{{$data->invoice_number}}" name="search_key" required>
                                                                 <button type="submit" class="btn btn-primary">Details</button>
                                                          </form>
                                                   </td>
                                                   



                                            </tr>

                                            @endforeach
                                        </tbody>

                                    </table>
                                    
                                   
				                
                                </div>
                            </div>
                            
                     
                            
                            
                        </div>
                    </div>
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
