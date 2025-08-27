<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $shipCounts = DB::table('orders')
            ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
            ->select(
                DB::raw("COUNT(*) as count"),
                'order_shipping_address.ship_address_type'
            )
            ->whereIn('orders.order_status', [3, 4])
            ->groupBy('order_shipping_address.ship_address_type')
            ->get();

        // Set default counts to 0
        $shipTypes = [
            1 => ['label' => 'Home', 'icon' => 'bx-home-alt', 'count' => 0],
            2 => ['label' => 'School', 'icon' => 'bx-book', 'count' => 0],
            3 => ['label' => 'Pickup Point', 'icon' => 'bx-store-alt', 'count' => 0],
        ];

        foreach ($shipCounts as $item) {
            $type = $item->ship_address_type;
            if (isset($shipTypes[$type])) {
                $shipTypes[$type]['count'] = $item->count;
            }
        }

        return view('index', compact('shipTypes'));
    }
}
