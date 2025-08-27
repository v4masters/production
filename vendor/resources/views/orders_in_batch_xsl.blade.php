<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Batch XSL</title>
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
                              
                                <div class="table-responsive text-nowrap">

                                    <table id="mytable" class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">

                                        <thead>
                                            <tr>
                                               <th>SL</th>
                                               <!--<th data-sortable="true" > Order Id<br>Courier Number</th>-->
                                               
                                                <th data-sortable="true"> Barcode</th>
                                                <th data-sortable="true"> REF</th>
                                                <th data-sortable="true"> City</th>
                                                <th data-sortable="true"> Pincode</th>
                                                <th data-sortable="true"> Name</th>
                                                <th data-sortable="true"> ADD1</th>
                                                <th data-sortable="true"> ADD2</th>
                                                <th data-sortable="true"> ADD3</th>
                                                <th data-sortable="true"> ADDREMAIL</th>
                                                <th data-sortable="true"> ADDRMOBILE</th>
                                                <th data-sortable="true"> SENDERMOBILE</th>
                                                <th data-sortable="true"> Weight</th>
                                                <th data-sortable="true"> COD</th>
                                                <th data-sortable="true"> InsVal</th>
                                                <th data-sortable="true"> VPP</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                         
                                            @foreach($data as $key => $order)
                                            
                                             <tr>
                                                      <td>{{$key+1}}</td>
                                                      <!--<td><span class="border" onclick="copy(this)">{{$order->invoice_number}}</span><br>{{$order->courier_number}}</td>-->
                                                      <td>{{$order->courier_number}}</td>
                                                      <td></td>
                                                      <td>{{$order->city}}</td>
                                                      <td>{{$order->pincode}}</td>
                                                      <td>{{$order->name}}</td>
                                                      <td>{{$order->village}}</td>
                                                      <td>{{$order->address.',P.O-'.$order->post_office}}</td>
                                                      <td>{{$order->district.','.$order->state}}</td>
                                                      <td>{{$order->email}}</td>
                                                      <td>{{$order->phone_no}}</td>
                                                      <td>{{$order->vendor_phone}}</td>
                                                      <td>{{$order->order_weight}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                           
                                             </tr>
                                             @endforeach
                                         
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
    function copy(that){
var inp =document.createElement('input');
document.body.appendChild(inp)
inp.value =that.textContent
inp.select();
document.execCommand('copy',false);
inp.remove();
}
</script>
