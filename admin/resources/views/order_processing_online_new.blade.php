<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Order Processing Online</title>
    @include('includes.header_script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">


    <style>
    /* Improve table border lines */
    #mytable.dataTable tbody td,
    #mytable.dataTable thead th {
        border-right: 1px solid #dee2e6;
    }

    #mytable.dataTable {
        border-collapse: separate;
        border-spacing: 0;
    }

    /* Optional: Remove right border on last column */
    #mytable.dataTable tbody td:last-child,
    #mytable.dataTable thead th:last-child {
        border-right: none;
    }

    /* Alternate row color and hover effect */
    #mytable.dataTable tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    #mytable.dataTable tbody tr:hover {
        background-color: #e3f2fd;
    }

    /* Header style */
    #mytable.dataTable thead th {
    background-color: #696cff; /* Same as DataTables default button color */
    color: white;
    font-weight: bold;
    text-align: center;
    border-right: 1px solid #dee2e6;
}


    /* Table body cells */
    #mytable.dataTable tbody td {
        vertical-align: top;
        padding: 10px;
    }

    /* Button styling */
    .btn-primary {
        background-color: #696cff;
        border-color: #0062cc;
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: #696cff;
        border-color: #004085;
    }

    /* Improve form card styling */
    #statusform {
        border: 1px solid #ccc;
        border-radius: 10px;
    

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
                                <h5 class="card-header">View Online Orders Under Process</h5>
                                <div class="table-responsive text-nowrap">
                                    <table id="mytable" class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">
                                        <thead>
                                            <tr>
                                               <th>Sr. No.</th>
                                               <th data-sortable="true">Invoice Number<br>Transaction ID</br>Order Time</th>
                                               <th>Amount</th>
                                                 <th>Vendor</th>
                                                <th>Action</th>
                                                <th data-visible="false">Bill Address</th>
                                                <th>Ship Address</th>
                                             
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $index => $row)
                                            @php
                                                $order_status = match($row->order_status) {
                                                    1 => 'Pending',
                                                    2 => 'Placed',
                                                    3 => 'InProcess',
                                                    4 => 'Delivered',
                                                    5 => 'Cancelled',
                                                    default => 'Unknown'
                                                };
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <strong>OID:</strong> {{ $row->invoice_number }}<br>
                                                    <strong>TID:</strong> {{ $row->transaction_id ?? 'COD' }}<br>
                                                    <strong>Bill No - </strong>{{$row->bill_id}}<br>
                                                    <strong>Time:</strong> {{ $row->created_at }}<br>
                                                </td>
                                                <td>
                                                   <strong>Total:</strong> {{ $row->total_amount }}<br>
                                                    <strong>Discount:</strong> {{ $row->total_discount }}<br>
                                                    <strong>Shipping:</strong> {{ $row->shipping_charge }}<br>
                                                    <strong>Final Price -</strong> {{($row->total_amount-$row->total_discount)+$row->shipping_charge}}<br>
                                                    <strong>Status -</strong> {{$order_status}}
                                                </td>
                                                <td> {!! nl2br(e($row->vendor_info)) !!}</td>
                                                <td>
                                                    <a href="{{ url('order_process_status', [$row->invoice_number, $row->vendor_id]) }}" class="btn btn-primary">Update<br>Status</a>
                                                </td>
                                                <td>
                                                    {{ $row->bill_name }}<br>
                                                    {{ $row->bill_phone }}<br>
                                                    {{ $row->bill_address }}<br>
                                                    {{ $row->ship_city }}<br>
                                                    - {{ $row->ship_pincode }}
                                                </td>
                                                
                                                <td>
                                                    {{ $row->bill_name }}<br>
                                                    {{ $row->bill_phone }}<br>
                                                    {{ $row->ship_address }}<br>
                                                    {{ $row->ship_city }}<br>
                                                     {{ $row->ship_state }} <br>
                                                     - {{ $row->ship_pincode }}
                                                </td>
                                               
                                                
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>

                            <div class="card mt-4" style="display: none;" id="statusform">
                                <h5 class="card-header">Create Batch of all selected orders</h5>
                                <div class="card-body">
                                    <div class="form-group p-3">
                                        <label>Comment: <span class="text-danger">*</span></label>
                                        <input type="text" name="comment" class="form-control" required>
                                    </div>
                                    <div class="form-group p-3">
                                        <input type="submit" value="Create Batch" class="btn btn-primary">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables & Export Buttons -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<!-- Dependencies for Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<!-- Bootstrap Icons (for the download icon) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


<script>
$(document).ready(function () {
    var t = $('#mytable').DataTable({
        paging: false,       // or true if you want pagination
        searching: false,
        info: false,
        ordering: true,
        order: [[1, 'asc']] // Default sort on 2nd column (Invoice Number)
    });

    t.on('order.dt draw.dt', function () {
        t.column(0, { order: 'applied', search: 'applied' })
         .nodes()
         .each(function (cell, i) {
             cell.innerHTML = i + 1;
         });
    }).draw();
});

</script>





</body>
</html>
