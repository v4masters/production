
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Payout Bill</title>

    @include('includes.header_script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<!-- Optional: You can include the DataTables buttons if you're using them -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <style>
        #mytable.dataTable tbody td, #mytable.dataTable thead th {
            border-right: 1px solid #dee2e6;
        }
        #mytable.dataTable { border-collapse: separate; border-spacing: 0; }
        #mytable.dataTable tbody td:last-child, #mytable.dataTable thead th:last-child { border-right: none; }
        #mytable.dataTable tbody tr:nth-child(odd) { background-color: #f9f9f9; }
        #mytable.dataTable tbody tr:hover { background-color: #e3f2fd; }
        #mytable.dataTable thead th {
            background-color: #696cff;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        #mytable.dataTable tbody td { vertical-align: top; padding: 10px; }
        .btn-primary { background-color: #696cff; border-color: #0062cc; font-weight: 500; }
        .btn-primary:hover { background-color: #696cff; border-color: #004085; }
        #statusform { border: 1px solid #ccc; border-radius: 10px; }
        .otiddiv { margin: 0 !important; border-bottom: 1px solid #ddd; width: auto; }
        .add_td { white-space: normal !important; word-wrap: break-word; }
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
                    <div class="card-header d-flex justify-content-between align-items-center"></div>
                    <div class="container">


                        

                      

                        <form method="post" id="myform" action="{{ url('/create_batch') }}" enctype="multipart/form-data" novalidate>
                            @csrf

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-primary">{{ session('success') }}</div>
                            @endif
                           

                            <div class="card">
                                <h5 class="card-header">Payout Bill</h5>
                                <div class="table-responsive text-nowrap">
                                    
                                    <table id="orders-table" class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">
                                        <thead>
            <tr>
                <th data-sortable="true">#</th>
                <th data-sortable="true">Invoice Number<br>Transaction ID<br>Order Time</th>
                <th data-sortable="true">Amount</th>
                <th data-sortable="true">0.5% on<br>Taxable<br>Amount</th>
                <th data-sortable="true">Items<br>Category</th>
                <th data-sortable="true">Marketplace<br>Fee</th>
                <th data-sortable="true">Admin<br>Sale Type</th>
                <th data-sortable="true">Ship<br>Address</th>
                <th data-sortable="true">Shipping<br>State Code</th>
                <th data-sortable="true">Vendor<br>Sale Type</th>
                <th data-sortable=true>Order<br>Status</th>
                
                <th data-sortable="true">Fee<br>Amount</th>
                <th data-sortable="true">GST on<br>Fee(18%)</th>
                <th data-sortable="true">Amount<br>Deducted</th>
                <th data-sortable="true">Paid<br>Amount</th>

                
               
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $index => $order)
            @php
            $gst_0  = floatval($order->gst_0);
$gst_5  = floatval($order->gst_5);
$gst_12 = floatval($order->gst_12);
$gst_18 = floatval($order->gst_18);
$gst_28 = floatval($order->gst_28);

// Taxable value calculations using: gst / ((gst + rate) / 100)
$taxable_5  = ($gst_5  > 0) ? $gst_5  / (($gst_5  + 5)  / 100) : 0;
$taxable_12 = ($gst_12 > 0) ? $gst_12 / (($gst_12 + 12) / 100) : 0;
$taxable_18 = ($gst_18 > 0) ? $gst_18 / (($gst_18 + 18) / 100) : 0;
$taxable_28 = ($gst_28 > 0) ? $gst_28 / (($gst_28 + 28) / 100) : 0;
@endphp
            <tr>
                 <td>{{ $index + 1 }}</td>
                <td>
                    <strong>OID:</strong>{{$order->order_id}}<br>
                <strong>TID:</strong>{{$order->transaction_id}}<br>
                <strong>Bill No:</strong>{{$order->bill_id}}<br>
                <strong>Time:</strong>{{$order->created_at}}
                </td>
                <td>
                     @if($order->transaction_id)
       <strong>Online</strong>
    @else
        <strong>COD</strong>
    @endif <br><strong>Total:</strong>{{$order->total_amount}}<br>
                 <strong>Status:</strong>Delivered<br>
    <strong>Taxable Amount:</strong> 
    {{ number_format($taxable_5 + $taxable_12 + $taxable_18 + $taxable_28, 2) }}
</td>
<td>
    {{ number_format(($taxable_5 + $taxable_12 + $taxable_18 + $taxable_28) * 0.005, 2) }}
</td>

   <td>
    @if(!empty($order->iteminfo) && count($order->iteminfo) > 0)
        @php
            $firstItemType = $order->iteminfo[0]['item_type'];
        @endphp
        {{ $firstItemType == 1 ? 'School Set Item' : 'Inventory Item' }}
    @else
        Unknown
    @endif
</td>



          <td>
    @php
        $items = is_string($order->iteminfo) ? json_decode($order->iteminfo, true) : $order->iteminfo;
        $totalMarketFee = 0;
        if (!empty($items) && is_array($items)) {
            foreach ($items as $item) {
                $item = (array)$item;
                $totalMarketFee = isset($item['market_fee']) ? floatval($item['market_fee']) : 0;
            }
        }
    @endphp

    @if($totalMarketFee > 0)
        <div>
            <strong>MarketPlace Fee:</strong> {{ number_format($totalMarketFee, 2) }}
        </div>
    @else
        N/A
    @endif
</td>





       @php
    $admincode = 2;
@endphp

<td>
    @if($admincode == $order->vendor_state_code)
        CGST & SGST
    @else
        IGST
    @endif
</td>

                <td>{{$order->name}}<br>{{$order->phone_no}}<br>{{$order->village}}{{$order->city}}<br>{{$order->district}}<br>
                {{$order->state}}<br>{{$order->pincode}}</td>
                <td>{{$order->user_state_code}},{{$order->state}}</td>
                <td>
    {{ $order->gst_type == 1 ? 'CGST/SGST' : 'IGST' }}
</td>
<td>{{$order->courier_number}}<br>Delivered<br>{{$order->updated_at}}</td>

<td>
    ₹{{ number_format(($totalMarketFee * $order->total_amount)/100, 2) }}
</td>
<td> ₹{{ number_format(((($totalMarketFee * $order->total_amount)/100)*18)/100, 2) }}</td>
@php
    $totalMarketFee = floatval($totalMarketFee);
    $totalAmount = floatval($order->total_amount);
    $gst5 = floatval($order->gst_5);
    $gst12 = floatval($order->gst_12);
    $gst18 = floatval($order->gst_18);
    $gst28 = floatval($order->gst_28);

    $part1 = (($totalMarketFee * $totalAmount) / 100) * 18 / 100;
    $part2 = ($totalMarketFee * $totalAmount) / 100;
    $part3 = ($taxable_5 + $taxable_12 + $taxable_18 + $taxable_28) * 0.005;

    $total = $part1 + $part2 + $part3;
@endphp

<td>₹{{ number_format($total, 2) }}</td>


@php
    $totalAmount = floatval($order->total_amount);
    $totalMarketFee = floatval($totalMarketFee);
    $gstSum = $taxable_5 + $taxable_12 + $taxable_18 + $taxable_28;

    $part1 = ((($totalMarketFee * $totalAmount) / 100) * 18) / 100;
    $part2 = ($totalMarketFee * $totalAmount) / 100;
    $part3 = $gstSum * 0.005;

    $deduction = $part1 + $part2 + $part3;

    $finalAmount = $totalAmount - $deduction;
@endphp

<td>₹{{ number_format($finalAmount, 2) }}</td>

  </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No orders found for payout.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
  

                                </div>
                            </div>
                            <div class="card" style="display:none;" id="statusform" >
                                <h5 class="card-header">Create Batch of all selected orders</h5>
                                <div class="card-body">
                                             <div class="form-group p-3">
                                                  <label>Comment: <span class="text-danger">*</span></label>
                                                  <input type="text" name="comment" class="form-control" required>
                                              </div>
                                           
                                           
				                           <div class="form-group p-3">
                                           <input type="submit"  value="Create Batch " class="btn btn-primary">
                                           </div>
                                </div>
                            </div>
    
                        </form>

                    </div>
                </div>
            </div>

            <footer class="default-footer">@include('includes.footer')</footer>
            <div class="content-backdrop fade"></div>
        </div>
    </div>
</div>


<!-- Scripts -->
@include('includes.footer_script')
<!-- Clear Bill Modal -->


</body>
</html>