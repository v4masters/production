<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Batch Orders Under Proccess</title>
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
                          

                            <div class="card">
                                <h5 class="card-header">View  Order  Under Process</h5>
                                <div class="table-responsive text-nowrap">

                                    <table id="mytable" class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">

                                        <thead>
                                            <tr>
                                               <th>#</th>
                                                <th data-sortable="true">Batch Id <br></th>
                                                    <!--<th data-sortable="true">Tracking Id</th>-->
                                                    <th data-sortable="true"> Status<br>Created</th>
                                                     <th data-sortable="true">Comment</th>
                                                     <th data-sortable="true">Pending<br> Items</th>
                                                        <th data-sortable="true"> View</th>
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($batch as $key => $data)
                                            @php
                                            $key++;
                                            
                                            
                                            $penitemdata = DB::table('sale_tax_register')
                                            ->leftJoin('order_tracking', 'order_tracking.invoice_number', '=', 'sale_tax_register.order_id')
                                            ->select('sale_tax_register.batch_id', 
                                                DB::raw('COUNT(CASE WHEN  order_tracking.status = 0 THEN 1 END) AS pending_items')
                                            )
                                            
                                            ->where('order_tracking.vendor_id', session('id'))
                                            ->where('sale_tax_register.batch_id', $data->id)
                                            ->where('sale_tax_register.order_status', 3)
                                            ->groupBy('sale_tax_register.batch_id')  
                                            ->first();

                                                 
                                                                
                                            @endphp
                                            
                                            <tr>
                                                <td>{{$key}} </td>
                                                 <td><b>{{$data->batch_id}} </b><br><b>Orders - </b>{{$data->total_order}} </td>
                                                  <!--<td> </td>-->
                                                   <td> @if($data->print_status==1)<span class="bg-success text-white p-1">{{'Printed';}}</span> @else <span class="bg-danger text-white p-1">{{'Unprint';}}</span>@endif <br>{{$data->created_at}}</td>
                                                    <td>{{$data->comment}} </td>
                                                      <td>
                                                          @if($penitemdata->pending_items>0)
                                                          <p class="btn btn-sm btn-danger">{{$penitemdata->pending_items}} items</p>
                                                        @endif
                                                       </td>
                                                     <td><a  href="{{url('bacth_all_order',[$data->id, $data->batch_id])}}" class="btn btn-primary">View all</a></td>
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

<script>


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






</script>

