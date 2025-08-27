<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail</title>
    @include('includes.header_script')
    <style>
        .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table th {
            width: 30%;
            background-color: #f8f9fa;
        }
        table td, table th {
            padding: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('includes.sidebar')

            <div class="layout-page">
                @include('includes.header')

                <div class="container mt-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Order Detail</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Bill No</th>
                                    <td>{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td>{{ $order->first_name }}</td> <!-- Display the username -->
                                </tr>
                                <tr>
                                    <th>Order Number</th>
                                    <td>{{ $order->invoice_number }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Mode</th>
                                    <td>{{ $order->mode_of_payment == 1 ? 'Online' : 'COD' }}</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i:s') : '-' }}</td>
                                </tr>
                            </table>

                            <h5 class="mt-4">Item Details</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Brand</th>
                                        <th>Class</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr>
                                            <td>{{ $item['itemname'] ?? $item['product_name'] }}</td>
                                            <td>{{ $item['brand_title'] ?? $item['company_name'] }}</td>
                                            <td>{{ $item['class_title'] ?? '-' }}</td>
                                            <td>{{ $item['item_qty'] }}</td>
                                            <td>
                                                {{ $item['item_type'] == 1 
                                                    ? ($item['unit_price'] - $item['item_discount']) 
                                                    : $item['discounted_price'] 
                                                }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center">No item data found</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @include('includes.footer')
            </div>
        </div>
    </div>

    @include('includes.footer_script')
</body>
</html>
