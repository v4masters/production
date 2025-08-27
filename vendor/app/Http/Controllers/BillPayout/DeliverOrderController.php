<?php
namespace App\Http\Controllers\BillPayout;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\BillPayout;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\OrdersModel;
use App\Models\OrderTrackingModel;
use App\Models\OrderShippingAddressModel;
use App\Models\ManageuserStudentModel;
use App\Models\Paytm;
use App\Models\SchoolSetVendorModel;
use App\Models\SaleTaxRegister;
use App\Models\managemastersizelistModel;
use App\Models\Courier_partner;
use App\Mail\OrderShipMail;
use App\Mail\OrderProcessMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class DeliverOrderController extends Controller
{
    
    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }
    
    //delivered_orders
    /*public function delivered_orders($from,$to)
     {
        $result=array();
        $where=array('sale_tax_register.vendor_id'=>session('id'),'orders.payment_status'=>2,'orders.status'=>1);
        $data= DB::table('orders')
            // ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->select('orders.shipping_charge','orders.grand_total','orders.order_status','orders.print_status','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
            ->whereIn('orders.mode_of_payment',[1,2])
            ->where('sale_tax_register.order_status',4)
            ->orderBy('orders.id','desc')
            ->get();
            
        for($i=0;$i<count($data);$i++)
        {  
           if(in_array(session('id'),explode(',',$data[$i]->vendor_id)))
           {
              
            $paymentdata= DB::table('order_payment')->select('transaction_id','transaction_date')->where('order_id',$data[$i]->invoice_number)->first();
            if($paymentdata)
            {
               
                 $data[$i]->transaction_id=$paymentdata->transaction_id;
                 $data[$i]->transaction_date=$paymentdata->transaction_date;
            }
            else
            {
                $data[$i]->transaction_id="";
                $data[$i]->transaction_date="";
                
            }
            
              
              $tracking_status=''; 
            //   $tracking_update_status=OrderTrackingModel::distinct('courier_number','tracking_status')->where(['invoice_number'=>$data[$i]->invoice_number,'vendor_id'=>$data[$i]->vendor_id,'status'=>1])->get();
              $tracking_update_status=DB::table('order_tracking')->select('courier_number','tracking_status','updated_at')->where('tracking_status',">=",1)->where(['invoice_number'=>$data[$i]->invoice_number,'vendor_id'=>session('id')])->distinct('courier_number','tracking_status','updated_at')->get();
              if(count($tracking_update_status)>0)
              {
              foreach($tracking_update_status as $trkingstatus)
              {
                  
                  if($trkingstatus->tracking_status==0){$statustrk="Pending";}
                  elseif($trkingstatus->tracking_status==1){$statustrk="In-process";}
                  elseif($trkingstatus->tracking_status==2){$statustrk="In-production";}
                  elseif($trkingstatus->tracking_status==3){$statustrk="Shipped";}
                  elseif($trkingstatus->tracking_status==4){$statustrk="Out for delivery";}
                  elseif($trkingstatus->tracking_status==5){$statustrk="Deliverd";}
                  $tracking_status.='<p  class="otiddiv mb-1 py-1 px-1 border border-1"  >'.$statustrk.'<br>'.$trkingstatus->courier_number.'<br>'.$trkingstatus->updated_at.'</p><br>';
               }
               
               
               
                 $data[$i]->tracking_status=$tracking_status;
              
              
              //sale_tax_register
              $sale_tax_register=DB::table('sale_tax_register')
                                 ->select('bill_id','total_amount','total_discount','shipping_charge')
                                 ->where(['order_id'=>$data[$i]->invoice_number,'vendor_id'=>session('id')])
                                 ->first();
                              
                                 
               $data[$i]->bill_id=$sale_tax_register->bill_id;
              $data[$i]->total_amount=$sale_tax_register->total_amount;
              $data[$i]->total_discount=$sale_tax_register->total_discount;
              $data[$i]->ven_shipping_charge=$sale_tax_register->shipping_charge;
             
          
             
              array_push($result,$data[$i]); 
              }
              
             
              
           }
        }  
        return view('BillPayouts.deliverd_orders', ['orders' => $result]);
    }*/
  public function delivered_orders(Request $request)
{
    $result = [];

    // Get the logged-in vendor's ID (use 'id' or 'unique_id' as per your setup)
    $vendor_id = Auth::user()->unique_id;

    // Determine mode of payment: 1 = online, 2 = COD
    $mode = $request->input('payment_mode');
    $allowedModes = [1, 2];

    $where = [
        'orders.order_status' => 4,  // Delivered
        'orders.batch_id' => 0,
        'orders.payment_status' => 2,
        'order_payment.status' => 1,
        'orders.status' => 1
    ];

    if (in_array($mode, $allowedModes)) {
        $where['orders.mode_of_payment'] = $mode;
    }

    $query = DB::table('orders')
        ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->leftJoin('sale_tax_register', 'sale_tax_register.order_id', '=', 'orders.invoice_number')
        ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
        ->select(
            'order_shipping_address.school_code',
            'sale_tax_register.shipping_charge',
            'orders.order_status',
            'sale_tax_register.bill_id',
            'order_shipping_address.address_type as ship_address_type',
            'order_shipping_address.name as ship_name',
            'order_shipping_address.phone_no as ship_phone_no',
            'order_shipping_address.school_code as ship_school_code',
            'order_shipping_address.school_name as ship_school_name',
            'order_shipping_address.alternate_phone as ship_alternate_phone',
            'order_shipping_address.village as ship_village',
            'order_shipping_address.address as ship_address',
            'order_shipping_address.post_office as ship_post_office',
            'order_shipping_address.pincode as ship_pincode',
            'order_shipping_address.city as ship_city',
            'order_shipping_address.state as ship_state',
            'order_shipping_address.state_code as ship_state_code',
            'order_shipping_address.district as ship_district',
            'sale_tax_register.total_amount',
            'sale_tax_register.total_discount',
            'sale_tax_register.vendor_id',
            'users.landmark',
            'order_payment.transaction_id',
            'order_payment.transaction_date',
            'orders.invoice_number',
            'orders.mode_of_payment'
        )
        ->where($where)
        ->where('sale_tax_register.vendor_id', $vendor_id) // ✅ Filter by current vendor
        ->orderBy('sale_tax_register.id', 'desc');

    // Optional date filtering
    if ($request->filled(['from_date', 'to_date'])) {
        $query->whereBetween('order_payment.transaction_date', [$request->from_date, $request->to_date]);
    } else {
        $query->limit(100);
    }

    $orders = $query->get();

    foreach ($orders as $order) {
        // Tracking info
        $tracking_update_status = DB::table('order_tracking')
            ->select('courier_number', 'tracking_status', 'updated_at')
            ->where('invoice_number', $order->invoice_number)
            ->where('tracking_status', '>=', 1)
            ->distinct()
            ->get();

        $order->tracking_status = 'No Tracking Info Available';
        if ($tracking_update_status->count() > 0) {
            $tracking_status = '';
            foreach ($tracking_update_status as $trk) {
                $statusText = match ((int)$trk->tracking_status) {
                    0 => 'Pending',
                    1 => 'In-process',
                    2 => 'In-production',
                    3 => 'Shipped',
                    4 => 'Out for delivery',
                    5 => 'Delivered',
                    default => 'Unknown',
                };
                $tracking_status .= '<p class="otiddiv mb-1 py-1 px-1 border border-1">'
                    . $statusText . '<br>' . $trk->courier_number . '<br>' . $trk->updated_at . '</p><br>';
            }
            $order->tracking_status = $tracking_status;
        }

        // Fallback for bill_id and charges
        if (empty($order->bill_id)) {
            $sale_tax = DB::table('sale_tax_register')
                ->select('bill_id', 'total_amount', 'total_discount', 'shipping_charge')
                ->where('order_id', $order->invoice_number)
                ->first();

            if ($sale_tax) {
                $order->bill_id = $sale_tax->bill_id;
                $order->total_amount = $sale_tax->total_amount;
                $order->total_discount = $sale_tax->total_discount;
                $order->ven_shipping_charge = $sale_tax->shipping_charge;
            }
        }

        $result[] = $order;
    }

    return view('BillPayouts.deliverd_orders', ['orders' => $result]);
}

    
    
    //bill_to_pay
    public function bill_to_pay()
    {
          $vendor_id = Auth::user()->unique_id;


    // Optional: handle missing session gracefully
    if (!$vendor_id) {
        return redirect()->back()->with('error', 'Vendor session expired. Please login again.');
    }
        $orders = DB::table('sale_tax_register')
        ->join('users', 'sale_tax_register.user_id', '=', 'users.unique_id')
        ->leftJoin('order_payment', 'sale_tax_register.order_id', '=', 'order_payment.order_id')
        ->leftJoin('order_tracking', 'sale_tax_register.order_id', '=', 'order_tracking.invoice_number')
        ->where('sale_tax_register.vendor_id', $vendor_id)
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
                    $itemdata['item_id1'] = $data['itemcode'];
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
               // Initialize defaults
$catId = null;
$subCatId = null;
$marketplaceFee = 0;

// Check for product_id in item_id for inventory items
if (!empty($itemdata['item_id'])) 
{
    
    $category = DB::table('inventory_new')
        ->where('product_id', $itemdata['item_id'])
        ->first();

    if ($category) {
        $catId = $category->cat_id;

        $master = DB::table('inventory_cat')
            ->where('cat_four', $catId)
            ->first();

        if ($master) {
            $cat_one = $master->cat_one ?? null;
            $cat_two = $master->cat_two ?? null;

            $masterCatInfo = DB::table('master_category_sub')
                ->where('cat_id', $cat_one)
                ->where('id', $cat_two)
                ->first();

            $marketplaceFee = $masterCatInfo ? $masterCatInfo->market_fee : 0;
            $subCatId = $cat_two;
        }
    }
}
// Fallback: if itemcode exists (likely a set), get set_id from order_tracking
elseif (!empty($itemdata['item_id1'])) {

    $category = DB::table('order_tracking')
        ->where('product_id', $itemdata['item_id1']) // Note: item_id is used here intentionally
        ->first();


    if ($category) {
        $catId = $category->set_id;
        
      

        $master = DB::table('school_set')
            ->where('set_id', $catId)
            ->first();
            
    

        $marketplaceFee = $master ? $master->market_place_fee : 0;
    }
}

$itemdata['market_fee'] = $marketplaceFee;


            

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

    return view('pay_to_bill', [
        'orders' => $groupedOrders,
        'vendor_id' => $vendor_id,
     
    ]);
        
   }
    
   //paid_bill
   public function paid_bill()
    {
        $result=array();
        $where=array('orders.pp_id'=>NULL,'sale_tax_register.vendor_id'=>session('id'),'orders.mode_of_payment'=>1,'sale_tax_register.batch_id'=>0,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->select('orders.shipping_charge','orders.grand_total','orders.order_status','orders.print_status','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
            ->where('sale_tax_register.order_status',3)
            ->orderBy('orders.id','desc')
            ->get();
            
        for($i=0;$i<count($data);$i++)
        {  
           if(in_array(session('id'),explode(',',$data[$i]->vendor_id)))
           {
              
              $tracking_status=''; 
            //   $tracking_update_status=OrderTrackingModel::distinct('courier_number','tracking_status')->where(['invoice_number'=>$data[$i]->invoice_number,'vendor_id'=>$data[$i]->vendor_id,'status'=>1])->get();
              $tracking_update_status=DB::table('order_tracking')->select('courier_number','tracking_status','updated_at')->where('tracking_status',">=",1)->where(['invoice_number'=>$data[$i]->invoice_number,'vendor_id'=>session('id')])->distinct('courier_number','tracking_status','updated_at')->get();
              if(count($tracking_update_status)>0)
              {
              foreach($tracking_update_status as $trkingstatus)
              {
                  
                  if($trkingstatus->tracking_status==0){$statustrk="Pending";}
                  elseif($trkingstatus->tracking_status==1){$statustrk="In-process";}
                  elseif($trkingstatus->tracking_status==2){$statustrk="In-production";}
                  elseif($trkingstatus->tracking_status==3){$statustrk="Shipped";}
                  elseif($trkingstatus->tracking_status==4){$statustrk="Out for delivery";}
                  elseif($trkingstatus->tracking_status==5){$statustrk="Deliverd";}
                  $tracking_status.='<p  class="otiddiv mb-1 py-1 px-1 border border-1"  >'.$statustrk.'<br>'.$trkingstatus->courier_number.'<br>'.$trkingstatus->updated_at.'</p><br>';
               }
               
               
               
                 $data[$i]->tracking_status=$tracking_status;
              
              
              //sale_tax_register
              $sale_tax_register=DB::table('sale_tax_register')
                                 ->select('bill_id','total_amount','total_discount','shipping_charge')
                                 ->where(['order_id'=>$data[$i]->invoice_number,'vendor_id'=>session('id')])
                                 ->first();
                              
                                 
               $data[$i]->bill_id=$sale_tax_register->bill_id;
              $data[$i]->total_amount=$sale_tax_register->total_amount;
              $data[$i]->total_discount=$sale_tax_register->total_discount;
              $data[$i]->ven_shipping_charge=$sale_tax_register->shipping_charge;
             
          
             
              array_push($result,$data[$i]); 
              }
              
             
              
           }
        }  
        return view('orders_under_process', ['orders' => $result]);
    }
   
	
}












