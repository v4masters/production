
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
                <th data-sortable="true">Vendor<br>State Code</th>
                <th data-sortable="true">Vendor ID</th>
                <th data-sortable="true">Vendor</th>
                <th>Action</th>
            </tr>
        </thead>
            <tbody>
            @forelse ($vendors as $index => $vendor)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{$vendor->state_code}}</td>
                    <td>{{$vendor->unique_id}}</td>
                    <td>{{$vendor->username}}<br>{{$vendor->phone_no}}<br>{{$vendor->state}}</td>
                    <td>
    <a href="{{ route('vendor.orders', $vendor->unique_id) }}" class="btn btn-primary">View All</a>
</td>

                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No orders found for payout bill.</td>
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
  


<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
