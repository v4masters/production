<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;


class ClearBillController extends Controller
{



public function getGstInfo(Request $request)
{
    $invoice_number = $request->invoice_number;

    // Fetch order and associated tax data
    $order = DB::table('orders')
        ->leftJoin('sale_tax_register', 'orders.invoice_number', '=', 'sale_tax_register.order_id')
        ->where('orders.invoice_number', $invoice_number)
        ->select(
            'orders.*',
            'sale_tax_register.gst_0',
            'sale_tax_register.gst_5',
            'sale_tax_register.gst_12',
            'sale_tax_register.gst_18',
            'sale_tax_register.gst_28',
            'sale_tax_register.vendor_state_code'
        )
        ->first();

    if (!$order) {
        return response()->json([
            'error' => "Order '$invoice_number' not found or not eligible."
        ], 404);
    }

    // Read and decode JSONP order data
    try {
        $file = Storage::disk('s3')->get('sales_report/' . $invoice_number . '.jsonp');
        $items = json_decode($file, true);
        if (!$items || !is_array($items)) {
            throw new \Exception('Invalid JSON content');
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'File not found or invalid JSON'], 500);
    }

    $gst_type = 'Unknown';
    $itemsData = [];
    $subcategory_summary = [];

   $set_id = null; // Initialize outside to ensure it's always defined

foreach ($items as $item) {
    $item_type = $item['item_type'] ?? 1;
    $qty = $item['item_qty'] ?? 1;

    // Determine price
    $price = $item['unit_price'] ?? $item['mrp'] ?? 0;
    if (isset($item['item_discount'])) {
        $price -= $item['item_discount'];
    } elseif (isset($item['discounted_price'])) {
        $price = $item['discounted_price'];
    }

    $item_id_lookup = null;
    $cat_id = $cat_one = $cat_two = null;
    $master_cat_name = 'Unknown';
    $master_market_fee = 0;
    $set_id = null; // Reset per iteration

    if (!empty($item['product_id'])) {
        $item_id_lookup = $item['product_id'];
        $cat_id = DB::table('inventory_new')->where('product_id', $item_id_lookup)->value('cat_id');

        $catInfo = DB::table('inventory_cat')->where('cat_four', $cat_id)->select('cat_one', 'cat_two')->first();
        $cat_one = $catInfo->cat_one ?? null;
        $cat_two = $catInfo->cat_two ?? null;

        $masterCatInfo = DB::table('master_category_sub')
            ->where('cat_id', $cat_one)
            ->where('id', $cat_two)
            ->select('name', 'market_fee')
            ->first();

        $master_cat_name = $masterCatInfo ? trim($masterCatInfo->name) : 'Unknown';
        $master_market_fee = $masterCatInfo->market_fee ?? 0;

    } elseif (!empty($item['itemcode'])) {
        $item_id_lookup = $item['itemcode'];
        $set_id = DB::table('order_tracking')->where('product_id', $item_id_lookup)->value('set_id');
        $cat_id = $set_id; // For consistency

        $catInfo = DB::table('school_set')->where('set_id', $set_id)->select('set_category', 'market_place_fee')->first();
        $cat_one = $catInfo->set_category ?? null;
        $master_market_fee = $catInfo->market_place_fee ?? 0;

        $master_cat_name = 'School Set';
    } else {
        continue;
    }

    $clean_name = $master_cat_name;
    $subcategory_key = $clean_name;

    if (isset($subcategory_summary[$subcategory_key])) {
        $subcategory_summary[$subcategory_key]['total_qty'] += $qty;
    } else {
        $subcategory_summary[$subcategory_key] = [
            'subcategory_name' => $clean_name,
            'marketplace_fee' => $master_market_fee,
            'total_qty' => $qty,
            'set_id' => $set_id, // Optional: include in summary if needed
        ];
    }

    $itemsData[] = [
        'item_type' => $item_type,
        'id' => $item['id'] ?? null,
        'item_id' => $item_id_lookup,
        'cat_id' => $cat_id,
        'cat_one' => $cat_one,
        'cat_two' => $cat_two,
        'price' => round($price, 2),
        'qty' => $qty,
        'master_cat_name' => $clean_name,
        'market_fee' => $master_market_fee,
        'set_id' => $set_id, // ✅ include set_id for blade usage
    ];
}

    

    // Determine GST type based on state
    $vendor_state = $order->vendor_state_code ?? null;
    $admin_state = 2; // Replace with dynamic config if needed
    $gst_type = ($vendor_state && $admin_state && $vendor_state == $admin_state) ? 'CGST , SGST' : 'IGST';

    // GST values
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

$taxable_total = $taxable_5 + $taxable_12 + $taxable_18 + $taxable_28;

return response()->json([
    'gst_type' => $gst_type,
    'taxable_amount' => number_format($taxable_total, 2),
     'tax_amount' => number_format($gst_0, 2),
    'gst_0'  => number_format($gst_0, 2),
    'gst_18'  => number_format($gst_18, 2),
     'taxable_5'  => number_format($taxable_5, 2),
    'taxable_12' => number_format($taxable_12, 2),
    'taxable_18' => number_format($taxable_18, 2),
    'taxable_28' => number_format($taxable_28, 2),
    'items' => $items,
    'itemsdata' => $itemsData,
    'subcategory_summary' => array_values($subcategory_summary),
]);
}








/*public function getGstInfo(Request $request)
{
    $invoice = $request->input('invoice_number');
    $vendor_id = $request->input('vendor_id'); // You need vendor_id to filter items
    $adminCode = '2'; // Your admin state code

    // Get orders related to this invoice (modify as per your actual orders query)
    $orders = DB::table('orders')
        ->where('order_id', $invoice)
        ->get();

    if ($orders->isEmpty()) {
        return response()->json([
            'error' => 'No orders found for invoice: ' . $invoice
        ], 404);
    }

    $groupedOrders = [];

    foreach ($orders as $order) {
        $iteminfo = [];

        // Try to get JSONP file from S3 (order items info)
        try {
            $file = Storage::disk('s3')->get('sales_report/' . $order->order_id . '.jsonp');
            $getfile = json_decode($file, true);
        } catch (\Exception $e) {
            Log::error("Failed to get file for Order ID: {$order->order_id}, Vendor ID: $vendor_id, Error: " . $e->getMessage());
            $order->iteminfo = [];
            continue;
        }

        foreach ($getfile as $data) {
            if ($vendor_id == $data['vendor_id']) {
                $itemdata = [];

                if ($data['item_type'] == 1) {
                    // item_type == 1 special handling
                    $itemdata['item_type'] = 1;
                    $itemdata['id'] = $data['id'];
                    $itemdata['item_id'] = $data['itemcode'];
                    $itemdata['itemname'] = $data['itemname'];
                    $itemdata['weight'] = $data['item_weight'];
                    $itemdata['category'] = $data['set_cat'];
                    $itemdata['rate'] = $data['unit_price'];

                    $discount_rate = $data['unit_price'] - $data['item_discount'];
                    $itemdata['discount_rate'] = $discount_rate;
                    $itemdata['discount'] = $data['item_discount'];
                    $itemdata['total_without_gst'] = $discount_rate - ($discount_rate * $data['gst_title'] / 100);
                    $itemdata['qty'] = $data['item_qty'];
                    $itemdata['gst'] = $data['gst_title'];

                    $gstval = 100 + $data['gst_title'];
                    $itemdata['without_gst_rate'] = ($discount_rate / $gstval) * 100;
                    $itemdata['gst_rate'] = $discount_rate - ($discount_rate / $gstval) * 100;

                    $itemdata['item_ship_chr'] = $data['item_ship_chr'];
                    $itemdata['class'] = "";
                    $itemdata['size_medium'] = "";
                } else {
                    // item_type == 0 normal handling
                    $size_medium = "";
                    $sizemodel = managemastersizelistModel::find($data['size']);
                    if ($sizemodel) {
                        $size_medium = $sizemodel->title;
                    }

                    $itemdata['item_type'] = 0;
                    $itemdata['id'] = $data['id'];
                    $itemdata['item_id'] = $data['product_id'];
                    $itemdata['itemname'] = $data['product_name'];
                    $itemdata['weight'] = $data['net_weight'];
                    $itemdata['category'] = $data['catone'];
                    $itemdata['rate'] = $data['mrp'];
                    $itemdata['discount_rate'] = $data['mrp'] - ($data['mrp'] * $data['discount']) / 100;

                    $discount_rate = $data['mrp'] - $data['discounted_price'];
                    $itemdata['discount'] = ($data['mrp'] * $data['discount']) / 100;
                    $itemdata['total_without_gst'] = $discount_rate - ($discount_rate * $data['gst_title'] / 100);
                    $itemdata['qty'] = $data['item_qty'];
                    $itemdata['gst'] = $data['gst_title'];

                    $gstval = 100 + $data['gst_title'];
                    $itemdata['without_gst_rate'] = ($data['discounted_price'] / $gstval) * 100;
                    $itemdata['gst_rate'] = $discount_rate - ($discount_rate / $gstval) * 100;

                    $itemdata['item_ship_chr'] = $data['shipping_charges'];
                    $itemdata['class'] = $data['class_title'];
                    $itemdata['size_medium'] = $size_medium;
                }

                // Lookup item_type label from inventory table
                $inventoryItem = DB::table('inventory')
                    ->where('itemname', $itemdata['itemname']) 
                    ->first();

                $itemdata['item_type_label'] = $inventoryItem ? 
                    ($inventoryItem->item_type == 1 ? 'School Set Item' : 'Inventory Item') : 'Unknown';

                // Lookup category and marketplace fee
                $catId = null;
                $subCatId = null;
                $marketplaceFee = 0;

                if (!empty($itemdata['category'])) {
                    $category = DB::table('master_category_sub_two')
                        ->where('title', $itemdata['category'])
                        ->first();

                    if ($category) {
                        $catId = $category->cat_id;
                        $subCatId = $category->sub_cat_id;

                        $master = DB::table('master_category_sub')
                            ->where('cat_id', $catId)
                            ->first();

                        $marketplaceFee = $master ? $master->market_fee : 0;
                    }
                }

                $itemdata['cat_id'] = $catId;
                $itemdata['sub_cat_id'] = $subCatId;
                $itemdata['market_fee'] = $marketplaceFee;

                // Fetch tracking info for this item
                $tracking = OrderTrackingModel::select('courier_number', 'tracking_status', 'status')
                    ->where([
                        'invoice_number' => $order->order_id,
                        'vendor_id' => $data['vendor_id'],
                        'item_id' => $data['id'],
                        'item_type' => $data['item_type']
                    ])
                    ->first();

                if ($tracking) {
                    $itemdata['tracking_status'] = $tracking->tracking_status;
                    $itemdata['courier_number'] = $tracking->courier_number;
                    $itemdata['item_trk_status'] = $tracking->status;
                }

                $iteminfo[] = $itemdata;
            }
        }

        // Group items by order + category + subcategory
        foreach ($iteminfo as $item) {
            $key = $order->order_id . '-' . ($item['cat_id'] ?? 'null') . '-' . ($item['sub_cat_id'] ?? 'null');

            if (!isset($groupedOrders[$key])) {
                $groupedOrders[$key] = clone $order;
                $groupedOrders[$key]->iteminfo = [];
            }

            $groupedOrders[$key]->iteminfo[] = $item;
        }
    }

    // Add category name to each grouped order
    foreach ($groupedOrders as $key => $groupedOrder) {
        $firstItem = $groupedOrder->iteminfo[0] ?? null;
        $itemcategory = null;

        if ($firstItem && !empty($firstItem['cat_id'])) {
            $masterCategory = DB::table('master_category')->where('id', $firstItem['cat_id'])->first();
            if ($masterCategory) {
                $itemcategory = $masterCategory->name;
            }
        }

        $groupedOrders[$key]->itemcategory = $itemcategory;
    }

    // Get vendor data from sale_tax_register for GST info
    $vendorData = DB::table('sale_tax_register')
        ->where('order_id', $invoice)
        ->where('vendor_id', $vendor_id)
        ->first();

    if (!$vendorData) {
        return response()->json([
            'error' => 'Vendor data not found for invoice: ' . $invoice
        ], 404);
    }

    if (!isset($vendorData->vendor_state_code)) {
        return response()->json([
            'error' => 'Invalid vendor data.'
        ], 422);
    }

    $isSameState = ((string)$adminCode === (string)$vendorData->vendor_state_code);
    $gstType = $isSameState ? 'CGST/SGST' : 'IGST';

    $gstSums = DB::table('sale_tax_register')
        ->where('order_id', $invoice)
        ->where('vendor_id', $vendor_id)
        ->selectRaw('
            COALESCE(SUM(gst_0), 0) AS gst_0,
            COALESCE(SUM(gst_5), 0) AS gst_5,
            COALESCE(SUM(gst_12), 0) AS gst_12,
            COALESCE(SUM(gst_18), 0) AS gst_18,
            COALESCE(SUM(gst_28), 0) AS gst_28
        ')
        ->first();

    $totalTaxableAmount = $gstSums->gst_5 + $gstSums->gst_12 + $gstSums->gst_18 + $gstSums->gst_28;

    $allSubcategories = DB::table('master_category_sub')
        ->select('name', 'market_fee')
        ->where('del_status', 0)
        ->get();

    return response()->json([
        'gst_type' => $gstType,
        'gst_0' => number_format($gstSums->gst_0, 2),
        'gst_5' => number_format($gstSums->gst_5, 2),
        'gst_12' => number_format($gstSums->gst_12, 2),
        'gst_18' => number_format($gstSums->gst_18, 2),
        'gst_28' => number_format($gstSums->gst_28, 2),
        'taxable_amount' => number_format($totalTaxableAmount, 2),
        'subcategories' => $allSubcategories,
        'grouped_orders' => $groupedOrders // Added detailed grouped order data with items & categories
    ]);
}*/
   /* public function getGstInfo(Request $request)
{
    // Fetch all relevant orders for the vendor with necessary joins
    $orders = DB::table('sale_tax_register')
        ->join('users', 'sale_tax_register.user_id', '=', 'users.unique_id')
        ->leftJoin('order_payment', 'sale_tax_register.order_id', '=', 'order_payment.order_id')
        ->leftJoin('order_tracking', 'sale_tax_register.order_id', '=', 'order_tracking.invoice_number')
        ->where('sale_tax_register.order_status', 6)
        ->select(
            'sale_tax_register.*',
            'users.name',
            'users.phone_no',
            'users.city',
            'users.district',
            'users.state',
            'users.village',
            'users.pincode',
            'order_payment.transaction_id',
            'order_tracking.courier_number',
            'order_tracking.updated_at as tracking_updated'
        )
        ->get();

    $groupedOrders = [];

    foreach ($orders as $order) {
        $iteminfo = [];

        // Attempt to get the JSONP file from S3 storage
        try {
            $file = Storage::disk('s3')->get('sales_report/' . $order->order_id . '.jsonp');
            $getfile = json_decode($file, true);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve file for Order ID: {$order->order_id}, Vendor ID: $vendor_id, Error: " . $e->getMessage());
            // If file missing or error, assign empty iteminfo and continue to next order
            $order->iteminfo = [];
            continue;
        }

        // Loop through all items in the JSON data file for this order
        foreach ($getfile as $data) {
            if ($vendor_id == $data['vendor_id']) {
                $itemdata = [];

                if ($data['item_type'] == 1) {
                    // Special case for item_type == 1
                    $itemdata['item_type'] = 1;
                    $itemdata['id'] = $data['id'];
                    $itemdata['item_id'] = $data['itemcode'];
                    $itemdata['itemname'] = $data['itemname'];
                    $itemdata['weight'] = $data['item_weight'];
                    $itemdata['category'] = $data['set_cat'];
                    $itemdata['rate'] = $data['unit_price'];
                    $discount_rate = $data['unit_price'] - $data['item_discount'];
                    $itemdata['discount_rate'] = $discount_rate;
                    $itemdata['discount'] = $data['item_discount'];
                    $itemdata['total_without_gst'] = $discount_rate - ($discount_rate * $data['gst_title'] / 100);
                    $itemdata['qty'] = $data['item_qty'];
                    $itemdata['gst'] = $data['gst_title'];

                    $gstval = 100 + $data['gst_title'];
                    $itemdata['without_gst_rate'] = ($discount_rate / $gstval) * 100;
                    $itemdata['gst_rate'] = $discount_rate - ($discount_rate / $gstval) * 100;

                    $itemdata['item_ship_chr'] = $data['item_ship_chr'];
                    $itemdata['class'] = "";
                    $itemdata['size_medium'] = "";
                } else {
                    // Normal item_type == 0
                    $size_medium = "";
                    $sizemodel = managemastersizelistModel::find($data['size']);
                    if ($sizemodel) {
                        $size_medium = $sizemodel->title;
                    }

                    $itemdata['item_type'] = 0;
                    $itemdata['id'] = $data['id'];
                    $itemdata['item_id'] = $data['product_id'];
                    $itemdata['itemname'] = $data['product_name'];
                    $itemdata['weight'] = $data['net_weight'];
                    $itemdata['category'] = $data['catone'];
                    $itemdata['rate'] = $data['mrp'];
                    $itemdata['discount_rate'] = $data['mrp'] - ($data['mrp'] * $data['discount']) / 100;
                    $discount_rate = $data['mrp'] - $data['discounted_price'];
                    $itemdata['discount'] = ($data['mrp'] * $data['discount']) / 100;
                    $itemdata['total_without_gst'] = $discount_rate - ($discount_rate * $data['gst_title'] / 100);
                    $itemdata['qty'] = $data['item_qty'];
                    $itemdata['gst'] = $data['gst_title'];

                    $gstval = 100 + $data['gst_title'];
                    $itemdata['without_gst_rate'] = ($data['discounted_price'] / $gstval) * 100;
                    $itemdata['gst_rate'] = $discount_rate - ($discount_rate / $gstval) * 100;

                    $itemdata['item_ship_chr'] = $data['shipping_charges'];
                    $itemdata['class'] = $data['class_title'];
                    $itemdata['size_medium'] = $size_medium;
                }
  $inventoryItem = DB::table('inventory')
            ->where('itemname', $itemdata['itemname']) // or ->where('itemcode', $itemdata['item_id']) if more accurate
            ->first();

        if ($inventoryItem) {
            $itemdata['item_type_label'] = $inventoryItem->item_type == 1 ? 'School Set Item' : 'Inventory Item';
        } else {
            $itemdata['item_type_label'] = 'Unknown';
        }
                // Lookup category and marketplace fee
                $catId = null;
                $subCatId = null;
                $marketplaceFee = 0;

                if (!empty($itemdata['category'])) {
                    $category = DB::table('master_category_sub_two')
                        ->where('title', $itemdata['category'])
                        ->first();

                    if ($category) {
                        $catId = $category->cat_id;
                        $subCatId = $category->sub_cat_id;

                        $master = DB::table('master_category_sub')
                            ->where('cat_id', $catId)
                            ->first();

                        $marketplaceFee = $master ? $master->market_fee : 0;
                    }
                }

                $itemdata['cat_id'] = $catId;
                $itemdata['sub_cat_id'] = $subCatId;
                $itemdata['market_fee'] = $marketplaceFee;

                $itemcategory = null;

                $itemcategory = null;
foreach ($groupedOrders as $key => $groupedOrder) {
    // Get first item in the group to fetch cat_id
    $firstItem = $groupedOrder->iteminfo[0] ?? null;

    $itemcategory = null;
    if ($firstItem && !empty($firstItem['cat_id'])) {
        $masterCategory = DB::table('master_category')->where('id', $firstItem['cat_id'])->first();
        if ($masterCategory) {
            $itemcategory = $masterCategory->name; // or your actual category name field
        }
    }

    // Set this category name property for the grouped order
    $groupedOrders[$key]->itemcategory = $itemcategory;
}



                // Fetch tracking info for this item
                $tracking = OrderTrackingModel::select('courier_number', 'tracking_status', 'status')
                    ->where([
                        'invoice_number' => $order->order_id,
                        'vendor_id' => $data['vendor_id'],
                        'item_id' => $data['id'],
                        'item_type' => $data['item_type']
                    ])
                    ->first();

                if ($tracking) {
                    $itemdata['tracking_status'] = $tracking->tracking_status;
                    $itemdata['courier_number'] = $tracking->courier_number;
                    $itemdata['item_trk_status'] = $tracking->status;
                }

                $iteminfo[] = $itemdata;
            }
        }

        // Now group items by category and subcategory inside the order
        foreach ($iteminfo as $item) {
            $key = $order->order_id . '-' . ($item['cat_id'] ?? 'null') . '-' . ($item['sub_cat_id'] ?? 'null');

            if (!isset($groupedOrders[$key])) {
                // Clone order object and initialize iteminfo array
                $groupedOrders[$key] = clone $order;
                $groupedOrders[$key]->iteminfo = [];
            }

            $groupedOrders[$key]->iteminfo[] = $item;
        }
    }

    // Re-index the grouped orders for clean numeric keys
    $groupedOrders = array_values($groupedOrders);

    return view('viewall', [
        'orders' => $groupedOrders,
        
    ]);
}*/





   public function clearBill(Request $request)
{
    $invoice = $request->invoice_number;

    // Begin transaction to ensure data consistency
    DB::beginTransaction();

    try {
        // Update order_status to 6 in sale_tax_register
        DB::table('sale_tax_register')
            ->where('order_id', $invoice)
            ->update(['order_status' => 6]);

        // Update order_status to 6 in orders
        DB::table('orders')
            ->where('invoice_number', $invoice)
            ->update(['order_status' => 6]);

        DB::commit();

        return redirect()->back()->with('success', 'Bill cleared and order status updated successfully.');
    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->back()->with('error', 'Failed to clear bill: ' . $e->getMessage());
    }
}
/*public function addFee(Request $request)
{
    $request->validate([
        'subcategory_id' => 'required|exists:master_category_sub,id',
        'fee' => 'required|numeric|min:0',
    ]);

    DB::table('master_category_sub')
        ->where('id', $request->subcategory_id)
        ->update(['market_fee' => $request->fee]);

    return response()->json(['success' => true]);
}*/

 // your model for master_category_sub table

/*public function updateMarketplaceFee(Request $request)
{
    $request->validate([
        'subcategory_name' => 'required|string',
        'market_fee' => 'required|numeric|min:0',
    ]);


DB::table('master_category_sub')
    ->where('name', $request->subcategory_name)
    ->update(['market_fee' => $request->market_fee]);


    return response()->json(['success' => true, 'message' => 'Marketplace fee updated successfully']);
}*/

/*public function updateMarketplaceFee(Request $request)
{
    $request->validate([
        'set_id' => 'required',
        'market_fee' => 'required|numeric|min:0',
    ]);

    // Attempt to update the school_set table using set_id
    $updatedRows = DB::table('school_set')
        ->where('set_id', $request->set_id)
        ->update(['market_place_fee' => $request->market_fee]);

    if ($updatedRows > 0) {
        return response()->json([
            'success' => true,
            'message' => 'Marketplace fee updated successfully.'
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'No records were updated. Invalid set ID or fee already set.'
        ], 400);
    }
}*/
public function updateMarketplaceFee(Request $request)
{
    $request->validate([
        'set_id' => 'required',
        'market_fee' => 'required|numeric|min:0',
    ]);

    $existing = DB::table('school_set')
        ->where('set_id', $request->set_id)
        ->first();

    if (!$existing) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid set ID. No such record found.'
        ], 404);
    }

    if ($existing->market_place_fee == $request->market_fee) {
        return response()->json([
            'success' => false,
            'message' => 'Marketplace fee is already set to the same value.'
        ], 200); // Or 400 if you treat it as a non-action
    }

    // Proceed with the update
    DB::table('school_set')
        ->where('set_id', $request->set_id)
        ->update(['market_place_fee' => $request->market_fee]);

    return response()->json([
        'success' => true,
        'message' => 'Marketplace fee updated successfully.'
    ]);
}





}
