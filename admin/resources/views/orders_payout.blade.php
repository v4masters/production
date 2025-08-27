
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Delivered Orders</title>

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


                        <form method="GET" action="{{ route('orders.payout') }}">
                            <label for="from_date">From Date:</label>
                            <input type="date" name="from_date" value="{{ request('from_date') }}">
                            
                            <label for="to_date">To Date:</label>
                            <input type="date" name="to_date" value="{{ request('to_date') }}">
                            
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                        
                        

                      

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
                                <h5 class="card-header">View Delivered Orders</h5>
                                <div class="table-responsive text-nowrap">
                                    
                                    <table id="orders-table" class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">
                                        <thead>
            <tr>
                <th data-sortable="true">#</th>
                <th data-sortable="true">Vendor<br>State Code</th>
                <th data-sortable="true">Action</th>
                <th data-sortable="true">Invoice Number<br>Transaction ID<br>Order Time</th>
                <th data-sortable="true">Grand Total</th>
                <th data-sortable="true">Vendor</th>
                <th data-visible="false">School Details</th>
                <th data-sortable="true" data-visible="false">Bill Address</th>
                <th data-sortable="true">Ship Address</th>
                
                <th data-sortable="true">Order Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{$order->vendor_state_code}}</td>
                   <td>
    <button class="btn btn-danger btn-sm clear-bill-btn" data-invoice="{{ $order->invoice_number }}" data-bs-toggle="modal" data-bs-target="#clearBillModal">Clear Bill</button>
</td>
                    <td>
                        <strong>OID:</strong> {{ $order->invoice_number }}<br>
                        <strong>TID:</strong> {{ $order->transaction_id ?? 'COD' }}<br>
                        <strong>Bill No:</strong> {{ $order->bill_id }}<br>
                        <strong>Time:</strong>{{$order->transaction_date}}
                    </td>
                    <td>
                        {{ $order->mode_of_payment == 1 ? 'Online' : 'COD' }}<br>
                        <strong>Total:</strong> {{ $order->total_amount }}<br>
                        <strong>Discount:</strong> {{ $order->total_discount}}<br>
                        <strong>Shipping:</strong> {{ $order->shipping_charge }}<br>
                        <strong>Status:</strong>Delivered
                    </td>
                   <td>{!! nl2br(e($order->vendor_info)) !!}</td>

                 <td>{{$order->user_school_code}}<br>
                     {{$order->school_name}}
                  </td>
                   
                    <td>
                        {{ $order->ship_name }}<br>
                        {{ $order->ship_phone_no }}<br>
                        {{ $order->ship_address }}<br>
                        {{ $order->ship_city }}<br>
                        - {{ $order->ship_state_code }}
                    </td>
                    <td>
                        {{ $order->ship_name }}<br>
                        {{ $order->ship_phone_no }}<br>
                        {{ $order->ship_address }}<br>
                        {{ $order->ship_city }}<br>
                        {{ $order->ship_state }}<br>
                        - {{ $order->ship_pincode }}
                    </td>
                    <td>{!! $order->tracking_status !!}</td>
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
<div class="modal fade" id="clearBillModal" tabindex="-1" aria-labelledby="clearBillModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="clearBillForm" method="POST" action="{{ route('clear.bill') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="clearBillModalLabel">Clear Bill</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="invoice_number" id="modal_invoice_number">
          <p><strong>Vendor GST Type:</strong> <span id="gst_type_text"></span></p>
         

          <p><strong>GST 0%:</strong> ₹<span id="gst_0">0.00</span></p>
          <p><strong>GST 5%:</strong> ₹<span id="gst_5">0.00</span></p>
          <p><strong>GST 12%:</strong> ₹<span id="gst_12">0.00</span></p>
          <p><strong>GST 18%:</strong> ₹<span id="gst_18">0.00</span></p>
          <p><strong>GST 28%:</strong> ₹<span id="gst_28">0.00</span></p>

           <p><strong>Taxable Amount(Exclude gst_0):</strong> ₹<span id="taxable_amount"></span></p>
           <p><strong>Exempted Sale:</strong> ₹<span id="tax_amount"></span></p>
           <hr>

<p><strong>Item Category:</strong></p>
<div id="subcategory_summary"></div>


        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Confirm Clear</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Add Marketplace Fee Modal -->
<!-- Add Marketplace Fee Modal -->
<div class="modal fade" id="addFeeModal" tabindex="-1" aria-labelledby="addFeeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addFeeForm">
        <div class="modal-header">
          <h5 class="modal-title" id="addFeeModalLabel">Add Marketplace Fee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="modal_subcat_name" name="subcategory_name">
          <div class="mb-3">
            <label for="market_fee" class="form-label">Marketplace Fee (₹)</label>
            <input type="number" step="0.01" class="form-control" id="market_fee" name="market_fee" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Fee</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
$(document).ready(function() {
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Event delegation to handle dynamically rendered buttons
    $(document).on('click', '.clear-bill-btn', function() {
        const invoice = $(this).data('invoice');
        $('#modal_invoice_number').val(invoice);

        // Reset fields before AJAX call
        $('#gst_type_text').text('Loading...');
        $('#taxable_amount').text('Loading...');
         $('#tax_amount').text('Loading...');
        $('#gst_0').text('Loading...');
        $('#gst_5').text('Loading...');
        $('#gst_12').text('Loading...');
        $('#gst_18').text('Loading...');
        $('#gst_28').text('Loading...');

        // AJAX call to fetch GST info
        $.ajax({
            url: "{{ route('get.gst.info') }}",
            method: 'POST',
            data: {
                invoice_number: invoice
            },
            success: function(data) {
                $('#gst_type_text').text(data.gst_type ?? 'N/A');
                
                function safeParse(value) {
                    return parseFloat((value ?? '0').toString().replace(/[^0-9.]/g, '')).toFixed(2);
                }

                $('#gst_0').text(safeParse(data.gst_0));
                $('#gst_5').text(safeParse(data.taxable_5));
                $('#gst_12').text(safeParse(data.taxable_12));
                $('#gst_18').text(safeParse(data.taxable_18));
                $('#gst_28').text(safeParse(data.taxable_28));
                $('#taxable_amount').text(safeParse(data.taxable_amount));
                $('#tax_amount').text(safeParse(data.tax_amount));

// Display subcategory summary with total quantities
if (data.subcategory_summary && data.subcategory_summary.length > 0) {
    let summaryHtml = '<ul class="list-group">';
    data.subcategory_summary.forEach(subcat => {
        let fee = parseFloat(subcat.marketplace_fee ?? 0).toFixed(2);
        summaryHtml += `
        <li class="list-group-item">
            <strong>Category:</strong> ${subcat.subcategory_name ?? 'N/A'}<br>
            <strong>Total Quantity:</strong> ${subcat.total_qty}<br>
            <strong>Marketplace Fee:</strong> ₹${fee}`;
            

        // Show "Add Fee" button if fee is 0.00
        if (fee === '0.00') {
           summaryHtml += ` 
<button type="button" class="btn btn-sm btn-primary mt-2 add-fee-btn" 
        data-subid="${subcat.set_id}">
    Add Fee
</button>`;

        }

        summaryHtml += `</li>`;
    });
    summaryHtml += '</ul>';
    $('#subcategory_summary').html(summaryHtml);
} else {
    $('#subcategory_summary').html('No subcategory summary found.');
}





},
            error: function(xhr) {
                $('#gst_type_text').text('Error fetching data');
                $('#taxable_amount').text('N/A');
                 $('#tax_amount').text('N/A');
                $('#gst_0').text('N/A');
                $('#gst_5').text('N/A');
                $('#gst_12').text('N/A');
                $('#gst_18').text('N/A');
                $('#gst_28').text('N/A');
                console.error('AJAX Error:', xhr.responseText);
            }
        });
    });
});
</script>
<script>
  $(document).on('click', '.add-fee-btn', function () {

    const setId = $(this).data('subid');
    // read set_id

    // Store set_id in modal's data attributes
    $('#addFeeModal').data('subid', setId);

    $('#market_fee').val('');
    $('#addFeeModal').modal('show');

    console.log('Clicked Set ID:', setId); // Just print it if you want
});



$('#addFeeForm').on('submit', function (e) {
    e.preventDefault();

   
    const marketFee = $('#market_fee').val();
    const setId = $('#addFeeModal').data('subid'); 
    console.log('Clicked Set ID:', setId); // Retrieve stored set_id

    $.ajax({
        url: '{{ route("marketplace_fee.update") }}',
        type: 'POST',
        data: {
         
            market_fee: marketFee,
            set_id: setId, // passed only here
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            alert(response.message);
            location.reload();
        },
        error: function (xhr) {
            alert(xhr.responseJSON.message || 'Update failed.');
        }
    });
});



</script>

</body>
</html>
