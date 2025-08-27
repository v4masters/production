<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Sale Tax Register</title>
    <meta name="description" content="" />
    @include('includes.header_script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        p{margin: 0 !important;border-bottom: 1px solid #ddd;width:auto;}
        .amountdiv{width: fit-content;}
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
                      <h5 class="card-header">Sale Tax Register</h5>

                            </div>

                        </div>

                        <div class="container">

                            <div class="card">



                                    
                                     <div class="card">
                                           <div class="card-header d-flex justify-content-between align-items-center">
                                                <div class="container">
                                                    Get Date Wise Report
                                                </div>
                                            </div>

                                     <div class="card-body">
                                     <form method="post"  action="{{url('/') }}/sale_tax_register" id="myform" enctype="multipart/form-data" novalidate>
                                        
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
                                    
                                        <div class="row gx-5">
                                            <div class="col-sm-5">
                                                <div class="mb-3">
                                                    <label class="form-label">From :</label>
                                                    <input type="date" class="form-control" name="from_date" required />
                                                     <div class="invalid-feedback">Please select a valid Date.</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="mb-3">
                                                    <label class="form-label">To :</label>
                                                    <input type="date" class="form-control" name="to_date" required />
                                                     <div class="invalid-feedback">Please select a valid Date.</div>
                                                </div>
                                            </div>
                                              <div class="col-sm-2">
                                                <div class="mb-3">
                                                    <label class="form-label"> </label>
                                                    <input type="submit" class="form-control btn btn-primary" value="Get Data">
                                                     <div class="invalid-feedback"></div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                        </form>
                                         </div>
                                         </div>
                                    
                                    


                            
                                <div class="table-responsive text-nowrap">
                                    
                                   <h4 class="pt-5">From: {{ $fromdate ?? '-' }} - To: {{ $todate ?? '-' }}</h4>


                                    <table class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">

                                       <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-sortable="true">Bill No<br>Order Id</th>
                                                 <th data-sortable="true" data-visible="false">Order Id</th>
                                                <th data-sortable="true" >User Name</th>
                                                <th data-sortable="true">Invoice Date</th>
                                                <th data-sortable="true">GST  </br>0%</th>
                                                <th data-sortable="true">GST  </br>5%</th>
                                                <th data-sortable="true">GST  </br>12%</th>
                                                <th data-sortable="true">GST  </br>18%</th>
                                                <th data-sortable="true">GST  </br>28%</th>
                                                <th data-sortable="true">Total <br>Amount</th>
                                                <th data-sortable="true">Sale<br>Type</th>
                                                
                                                <th data-sortable="true"data-visible="false">Shipping<br>Charges</th>
                                                <th data-sortable="true">User<br>State Code</th
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                            $gst0=0;
                                            $gst5=0;
                                            $gst12=0;
                                            $gst18=0;
                                            $gst28=0;
                                            $total_amount=0;
                                            $total_amount_ws=0;
                                            $curn_date="";
                                            $order_date="";
                                            $shipping_charge=0;
                                            @endphp
                                            
                                            
                                            @foreach($saletax as $key => $data)
                                            @php
                                            $key++;
                                            $strorder_time=explode(' ',$data->acc_created_at);
                                            $curn_date="";
                                            $curn_date=$strorder_time[0];
										    if($key==1){$order_date=$strorder_time[0];}
										   
										      $ordertrandate= DB::table('order_payment')->select('transaction_date')->where('order_id',$data->order_id)->first();
                                            if($ordertrandate){$transaction_date=$ordertrandate->transaction_date;}else{$transaction_date=$data->order_time;}
                                         
                                            @endphp
                                            
                                            @if($curn_date!=$order_date)
                                              <tr style="    border: 2px solid #6e6a6a;">
                                                <td style="    border: 2px solid #6e6a6a;" colspan="2"><b>{{$order_date}}</b></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style="    border: 2px solid #6e6a6a;"><b>{{$gst0}}</b></td>
                                                <td style="    border: 2px solid #6e6a6a;"><b>{{$gst5}}</b></td>
                                                <td style="    border: 2px solid #6e6a6a;" ><b>{{$gst12}}</b></td>
                                                <td style="    border: 2px solid #6e6a6a;" ><b>{{$gst18}}</b></td>
                                                <td style="    border: 2px solid #6e6a6a;" ><b>{{$gst28}}</b></td>
                                                <td style="    border: 2px solid #6e6a6a;" ><b>{{$total_amount}}</b></td>
                                                 <td style="border: 2px solid #6e6a6a;"></td>
                                         <td style="    border: 2px solid #6e6a6a;" ><b>{{$shipping_charge}}</b></td>
                                                <!--<td style="    border: 2px solid #6e6a6a;" ><b>{{$total_amount_ws}}</b></td>-->
                                            </tr>
                                            
                                            
                                            @php
                                            $gst0=0;
                                            $gst5=0;
                                            $gst12=0;
                                            $gst18=0;
                                            $gst28=0;
                                            $total_amount=0;
                                            $total_amount_ws=0;
                                            $shipping_charge=0;
                                            
                                            @endphp
                                           @endif
                                            
                                            <tr>
                                                <td>{{$key}}</td>
                                                <td><b>{{$data->bill_id}}</b><br><b>{{$data->order_id}}</b></td>
                                                <td>{{$data->order_id}}</td>
                                                <td>{{$data->name}}</td>
                                                <td>{{$data->acc_created_at}}</td>
                                                <td>{{$data->gst_0}}</td>
                                                <td>{{$data->gst_5}}</td>
                                                <td>{{$data->gst_12}}</td>
                                                <td>{{$data->gst_18}}</td>
                                                <td>{{$data->gst_28}}</td>
                                                <td>{{$data->total_amount}}</td>
                                                <td>
                                                @if ($data->gst_type == 1)
                                                SGST,CGST
                                                @else ($data->gst_type == 2)
                                                IGST,UGST
                                                @endif
                                               </td>

                                                <td>{{$data->shipping_charge}}</td>
                                                <td>{{$data->user_state_code}}</td>
                                                <!--<td>{{$data->total_amount-$data->shipping_charge}}</td>-->
                                            </tr>
                                            
                                            
                                            
                                            
                                         
                                            @php
                                            $gst0+=$data->gst_0;
                                            $gst5+=$data->gst_5;
                                            $gst12+=$data->gst_12;
                                            $gst18+=$data->gst_18;
                                            $gst28+=$data->gst_28;
                                            $total_amount+=$data->total_amount;
                                            $total_amount_ws+=$data->total_amount-$data->shipping_charge;
                                            $order_date=$curn_date;
                                            $shipping_charge+=$data->shipping_charge;
                                            @endphp
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




        
                     
                     
                     <!---->
                      <div class="modal" id="order_detail">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        
                                        <div class="row">
                                            <div class="col-md-5">
                                                <h4>Shipping Address</h4>
                                                   <div id="user_info">
                                            
                                                   </div>
                                            </div>
                                             <div class="col-md-7">
                                                 <h4>Order Info</h4>
                                                 <div id="order_info">
                                            
                                                 </div>
                                            </div>
                                        </div>
                                        
                                        <div id="itemdiv">
                                            
                                        </div>
                                        
                                       
                                    </div>
                                    
                                       <div class="divfooter text-left p-3" id="amount_div">
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


</body>
</html>

