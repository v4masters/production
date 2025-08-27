<?php

namespace App\Http\Controllers;

use App\Services\ShiprocketService;
use Illuminate\Http\Request;

class ShiprocketController extends Controller
{
    protected $shiprocketService;

    public function __construct(ShiprocketService $shiprocketService)
    {
        $this->shiprocketService = $shiprocketService;
    }

    public function createOrder(Request $request)
    {
        $orderData = $request->all();
        $response = $this->shiprocketService->createOrder($orderData);

        return response()->json($response);
    }

    public function getOrderStatus($orderId)
    {
        $response = $this->shiprocketService->getOrderStatus($orderId);

        return response()->json($response);
    }
}
