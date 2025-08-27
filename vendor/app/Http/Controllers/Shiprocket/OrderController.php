

<?php
// add order using api in laravel shiprocket
// app/Services/ShiprocketService.php

namespace App\Services;
use GuzzleHttp\Client;

class ShiprocketService
{
    protected $client;
    protected $apiUrl;
    protected $accessToken;

    public function __construct()
    {
        // Set your Shiprocket API URL and access token
        $this->apiUrl = 'https://apiv2.shiprocket.in/v1/external';
        $this->accessToken = env('SHIPROCKET_API_ACCESS_TOKEN'); // Access token from your .env file
        $this->client = new Client();
    }

    // Function to create an order on Shiprocket
    public function createOrder($orderData)
    {
        // Define the order data you need to pass to the API
        $data = [
            'order_id' => $orderData['order_id'],  // Your unique order ID
            'order_date' => $orderData['order_date'],  // Order date
            'pickup_location' => $orderData['pickup_location'],  // Pickup location (address)
            'billing_address' => $orderData['billing_address'],  // Billing address
            'shipping_address' => $orderData['shipping_address'],  // Shipping address
            'items' => $orderData['items'],  // Order items
            'payment_method' => $orderData['payment_method'],  // Payment method
            'shipping_method' => $orderData['shipping_method'],  // Shipping method
        ];

        // Make the API request to Shiprocket to create the order
        $response = $this->client->post("{$this->apiUrl}/order/create", [
            'headers' => [
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        // Decode the response from the Shiprocket API
        return json_decode($response->getBody()->getContents(), true);
    }
}





SHIPROCKET_API_ACCESS_TOKEN=your_access_token_here

// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Services\ShiprocketService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $shiprocketService;

    public function __construct(ShiprocketService $shiprocketService)
    {
        $this->shiprocketService = $shiprocketService;
    }

    // Method to add order using Shiprocket API
    public function createOrder(Request $request)
    {
        // Order data (this would typically come from your order system)
        $orderData = [
            'order_id' => $request->order_id,  // Order ID
            'order_date' => now(),  // Current date and time
            'pickup_location' => $request->pickup_location,  // Pickup location
            'billing_address' => [
                'name' => $request->billing_name,
                'address' => $request->billing_address,
                'city' => $request->billing_city,
                'pincode' => $request->billing_pincode,
                'phone' => $request->billing_phone,
                'state' => $request->billing_state,
                'country' => 'India',
            ],
            'shipping_address' => [
                'name' => $request->shipping_name,
                'address' => $request->shipping_address,
                'city' => $request->shipping_city,
                'pincode' => $request->shipping_pincode,
                'phone' => $request->shipping_phone,
                'state' => $request->shipping_state,
                'country' => 'India',
            ],
            'items' => [
                // Item details for order (can be an array of items)
                [
                    'name' => $request->item_name,
                    'sku' => $request->item_sku,
                    'quantity' => $request->item_quantity,
                    'price' => $request->item_price,
                    'weight' => $request->item_weight,
                ],
            ],
            'payment_method' => $request->payment_method,  // Payment method
            'shipping_method' => 'shiprocket_standard',  // Shipping method
        ];

        // Call the ShiprocketService to create the order
        $response = $this->shiprocketService->createOrder($orderData);

        // Check the response from Shiprocket
        if ($response['status'] == 'success') {
            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully on Shiprocket',
                'data' => $response['data'],
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create order on Shiprocket',
                'error' => $response['message'] ?? 'Unknown error',
            ]);
        }
    }
}
  
  
  // routes/web.php or routes/api.php

use App\Http\Controllers\OrderController;

Route::post('/create-shiprocket-order', [OrderController::class, 'createOrder']);


{
  "order_id": "12345",
  "pickup_location": "Warehouse 1",
  "billing_name": "John Doe",
  "billing_address": "123 Main St",
  "billing_city": "Delhi",
  "billing_pincode": "110001",
  "billing_phone": "9876543210",
  "billing_state": "Delhi",
  "shipping_name": "John Doe",
  "shipping_address": "123 Main St",
  "shipping_city": "Delhi",
  "shipping_pincode": "110001",
  "shipping_phone": "9876543210",
  "shipping_state": "Delhi",
  "item_name": "Product Name",
  "item_sku": "sku123",
  "item_quantity": 1,
  "item_price": 500,
  "item_weight": 0.5,
  "payment_method": "COD",
  "shipping_method": "shiprocket_standard"
}
