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

use App\Models\ManageuserStudentModel;
use App\Models\OrdersModel;
use App\Models\VendorModel;
use App\Models\OrderBatchModel;
use App\Models\OrderShippingAddressModel;
use App\Models\SaleTaxRegisterModel;
use App\Models\managemastersizelistModel;
use App\Models\OrderTrackingModel;
use App\Models\Paytm;
use App\Models\Order;



class OrderController extends Controller
{
    
     public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }
    
    //new_orders
    public function new_orders()
    { 
        $result=array();
        $where=array('orders.order_status'=>2,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->select('orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_amount','order_payment.transaction_date','orders.invoice_number','orders.grand_total','orders.mode_of_payment')
            ->where($where)
            ->orderBy('orders.id','desc')
            ->get();
            
            
      
        foreach($data as $orderdata)
        {
          
          $vendors=explode(',',$orderdata->vendor_id);
           for($j=0;$j<count($vendors);$j++)
             {
                $vendor_total_amount=0; 
                $vendordata="";
                $vendor=VendorModel::where('unique_id',$vendors[$j])->first();
                if($vendor)
                {
                $vendordata="<span style='white-space:normal;'>".$vendor->username."<br>".$vendor->phone_no."<br>".$vendor->address.'</span>';
                }
                else
                {
                    $vendordata="";
                }
               
                $file=Storage::disk('s3')->get('sales_report/'.$orderdata->invoice_number.'.jsonp');
            	$getfile=json_decode ($file,true);
                foreach($getfile as $itemdata)
                {
                    if($vendors[$j]==$itemdata['vendor_id'])
                    {
                        $itemrate_withship=0;
                        if($itemdata['item_type']==1)
                        { 
                          $itemrate_withship=($itemdata['unit_price']-$itemdata['item_discount'])*$itemdata['item_qty']+$itemdata['item_ship_chr'];
                        }
                        else
                        {
                          $itemrate_withship=($itemdata['discounted_price']*$itemdata['item_qty'])+$itemdata['shipping_charges'];
                        }
                        $vendor_total_amount+=$itemrate_withship;
                    }
                }
                
                   
                   array_push($result,[$orderdata,[$vendordata,$vendor_total_amount,$vendors[$j]]]);  
               }
               
        }  
            
            
            
 
        // print_r($data);
        // dd($data);
        return view('new_orders', ['neworders' => $result]);
    }
    
    //order_processing_online
    // public function order_processing_online()
    // { 
    //     $result=array();
    //     $where=array('orders.order_status'=>3,'orders.mode_of_payment'=>1,'orders.batch_id'=>0,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
    //     $data= DB::table('orders')
    //         ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
    //         ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
    //         ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
    //         ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
    //         ->select('sale_tax_register.shipping_charge','orders.order_status','orders.print_status','sale_tax_register.bill_id','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','sale_tax_register.total_amount','sale_tax_register.total_discount','sale_tax_register.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment')
    //         ->where($where)
    //         ->orderBy('sale_tax_register.id','desc')
    //         ->get();
            
    //     for($i=0;$i<count($data);$i++)
    //     {
    //           $tracking_status=''; 
    //           $tracking_update_status=DB::table('order_tracking')->select('courier_number','tracking_status','updated_at')->where(['invoice_number'=>$data[$i]->invoice_number,'vendor_id'=>$data[$i]->vendor_id])->distinct('courier_number','tracking_status','updated_at')->get();
    //           if($tracking_update_status)
    //           {
    //             foreach($tracking_update_status as $trkingstatus)
    //             {
    //               if($trkingstatus->tracking_status==0){$statustrk="Pending";}
    //               elseif($trkingstatus->tracking_status==1){$statustrk="In-process";}
    //               elseif($trkingstatus->tracking_status==2){$statustrk="In-production";}
    //               elseif($trkingstatus->tracking_status==3){$statustrk="Shipped";}
    //               elseif($trkingstatus->tracking_status==4){$statustrk="Out for delivery";}
    //               elseif($trkingstatus->tracking_status==5){$statustrk="Deliverd";}
    //               $tracking_status.='<p  class="otiddiv mb-1 py-1 px-1 border border-1"  >'.$statustrk.'<br>'.$trkingstatus->courier_number.'<br>'.$trkingstatus->updated_at.'</p><br>';
    //             }
    //           }
              
    //             $vendor_id=$data[$i]->vendor_id;
    //             $vendordata="";
    //             // for($j=0;$j<count($vendor_id);$j++)
    //             // {
    //                 $vendor=VendorModel::where('unique_id', $vendor_id)->first();
    //                 $vendordata="<p class='mb-1 py-1 px-1 border border-1'>".$vendor->username."<br>".$vendor->phone_no."<br>".$vendor->address.'</p>';
    //             // }
          
    //             $data[$i]->vendor_info=$vendordata;
    //           $data[$i]->vendor_id=$vendor->unique_id;
    //             $data[$i]->tracking_status=$tracking_status;
              
    //             array_push($result,$data[$i]);  
    //     }  
    //     return view('order_processing_online', ['orders' => $result]);
    // }
    
  /* public function order_processing_online()
{
    $orders = DB::table('orders')
        ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->leftJoin('sale_tax_register', 'sale_tax_register.order_id', '=', 'orders.invoice_number')
        ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
        ->where([
            ['orders.order_status', '=', 3],
            ['orders.mode_of_payment', '=', 1],
            ['orders.batch_id', '=', 0],
            ['orders.payment_status', '=', 2],
            ['order_payment.status', '=', 1],
            ['orders.status', '=', 1],
        ])
        ->limit(500)
        ->select('orders.invoice_number', 'orders.mode_of_payment', 'sale_tax_register.total_amount',
                 'sale_tax_register.total_discount', 'sale_tax_register.shipping_charge', 'order_payment.transaction_id',
                 'orders.created_at', 'users.name as bill_name', 'users.phone_no as bill_phone', 'users.address as bill_address',
                 'order_shipping_address.address as ship_address', 'order_shipping_address.city as ship_city',
                 'order_shipping_address.state as ship_state', 'order_shipping_address.pincode as ship_pincode',
                 'orders.order_status', 'sale_tax_register.vendor_id')
        ->get();
        
        for($i=0;$i<count($orders);$i++)
        {
         $vendor_id=$orders[$i]->vendor_id;
         $vendordata="";
         $vendor=VendorModel::where('unique_id', $vendor_id)->first();
         $vendordata="<p class='mb-1 py-1 px-1 border border-1'>".$vendor->username."<br>".$vendor->phone_no."<br>".$vendor->address.'</p>';
         
         $orders[$i]->vendor_info=$vendordata;
         $orders[$i]->vendor_id=$vendor_id;
}
    return view('order_processing_online_new', compact('orders'));
}*/
/*public function order_processing_online()
{
    $orders = DB::table('orders')
        ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->leftJoin('sale_tax_register', 'sale_tax_register.order_id', '=', 'orders.invoice_number')
        ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
        ->where([
            ['orders.order_status', '=', 3],
            ['orders.mode_of_payment', '=', 1],
            ['orders.batch_id', '=', 0],
            ['orders.payment_status', '=', 2],
            ['order_payment.status', '=', 1],
            ['orders.status', '=', 1],
        ])
        
        ->select(
            'orders.invoice_number', 'orders.mode_of_payment', 'sale_tax_register.total_amount',
            'sale_tax_register.total_discount', 'sale_tax_register.shipping_charge', 'order_payment.transaction_id',
            'orders.created_at', 'users.name as bill_name', 'users.phone_no as bill_phone', 'users.address as bill_address',
            'order_shipping_address.address as ship_address', 'order_shipping_address.city as ship_city',
            'order_shipping_address.state as ship_state', 'order_shipping_address.pincode as ship_pincode',
            'orders.order_status', 'sale_tax_register.vendor_id', 'sale_tax_register.bill_id'
        )
        ->get();

    // Step 1: Get all unique vendor IDs
    $vendorIds = $orders->pluck('vendor_id')->unique()->filter()->toArray();

    // Step 2: Fetch all vendors in one query
    $vendors = VendorModel::whereIn('unique_id', $vendorIds)->get()->keyBy('unique_id');

    // Step 3: Assign vendor info to orders
    foreach ($orders as $order) {
        $vendor = $vendors[$order->vendor_id] ?? null;
        $order->vendor_info = $vendor
            ? "{$vendor->username}\n{$vendor->phone_no}\n{$vendor->address}"
            : "Vendor not found";
    }

    return view('order_processing_online_new', compact('orders'));
} */

/*public function order_processing_online(Request $request)
{
    // Step 1: Query from optimized view
    $query = DB::table('view_order_processing_online');

    // Step 2: Apply date filter
    if ($request->has('from_date') && $request->has('to_date')) {
        $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
    } else {
        $query->orderBy('created_at', 'desc')->limit(100);
    }

    // Step 3: Fetch orders
    $orders = $query->get();

    // Step 4: Fetch vendors in bulk
    $vendorIds = $orders->pluck('vendor_id')->unique()->filter()->toArray();
    $vendors = VendorModel::whereIn('unique_id', $vendorIds)->get()->keyBy('unique_id');

    // Step 5: Iterate over orders
    foreach ($orders as $order) {
        // Add vendor info
        $vendor = $vendors[$order->vendor_id] ?? null;
        $order->vendor_info = $vendor
            ? "{$vendor->username}\n{$vendor->phone_no}\n{$vendor->address}"
            : "Vendor not found";

        // Step 6: Fetch tracking details
        $tracking_status_html = '';
        $tracking_update_status = DB::table('order_tracking')
            ->select('courier_number', 'tracking_status', 'updated_at')
            ->where([
                'invoice_number' => $order->invoice_number,
                'vendor_id' => $order->vendor_id,
            ])
            ->distinct()
            ->get();

        // Step 7: Format tracking statuses
        foreach ($tracking_update_status as $trkingstatus) {
            switch ($trkingstatus->tracking_status) {
                case 0:
                    $statusText = "Pending";
                    break;
                case 1:
                    $statusText = "In-process";
                    break;
                case 2:
                    $statusText = "In-production";
                    break;
                case 3:
                    $statusText = "Shipped";
                    break;
                case 4:
                    $statusText = "Out for delivery";
                    break;
                case 5:
                    $statusText = "Delivered";
                    break;
                default:
                    $statusText = "Unknown";
            }

            // Append formatted status
            $tracking_status_html .= '<p class="otiddiv mb-1 py-1 px-1 border border-1">' .
                                     $statusText . '<br>' .
                                     $trkingstatus->courier_number . '<br>' .
                                     $trkingstatus->updated_at .
                                     '</p><br>';
        }

        // Step 8: Add to order object
        $order->tracking_status_html = $tracking_status_html;
    }

    // Step 9: Return view with processed orders
    return view('order_processing_online1', compact('orders'));
}*/

    public function order_processing_online(Request $request)
{
    // Initial query from the view
    $query = DB::table('new_order_processing_data2')
        ->where('order_status', 3) // Apply order_status in controller
        ->where('status', 1);      // Apply status in controller

    // Apply date range if available
    if ($request->has('from_date') && $request->has('to_date')) {
        $query->whereBetween('transaction_date', [$request->from_date, $request->to_date]);
    } else {
        $query->limit(100);
    }

    // Execute query
    $orders = $query->get();

    // Fetch vendor details
    $vendorIds = $orders->pluck('vendor_id')->unique()->filter()->toArray();
    $vendors = VendorModel::whereIn('unique_id', $vendorIds)->get()->keyBy('unique_id');

    foreach ($orders as $order) {
        // Vendor info
        $vendor = $vendors[$order->vendor_id] ?? null;
        $order->vendor_info = $vendor
            ? "{$vendor->username}\n{$vendor->phone_no}\n{$vendor->address}"
            : "Vendor not found";

        // Tracking status
        $tracking_status = '';
        $tracking_update_status = DB::table('order_tracking')
            ->select('courier_number', 'tracking_status', 'updated_at')
            ->where([
                'invoice_number' => $order->invoice_number,
                'vendor_id' => $order->vendor_id
            ])
            ->distinct()
            ->get();

        foreach ($tracking_update_status as $trkingstatus) {
            $statustrk = match ($trkingstatus->tracking_status) {
                0 => "Pending",
                1 => "In-process",
                2 => "In-production",
                3 => "Shipped",
                4 => "Out for delivery",
                5 => "Delivered",
                default => "Unknown"
            };

            $tracking_status .= '<p class="otiddiv mb-1 py-1 px-1 border border-1">' .
                $statustrk . '<br>' .
                $trkingstatus->courier_number . '<br>' .
                $trkingstatus->updated_at .
                '</p><br>';
        }

        $order->tracking_status_html = $tracking_status;
    }

    return view('order_processing_online1', compact('orders'));
}


/*public function order_processing_online(Request $request)
{
    // Build the query using Eloquent
    $query = Order::with(['payment', 'user', 'taxRegister', 'shippingAddress'])
        ->where('order_status', 3)
        ->where('status', 1)
        ->where('mode_of_payment', 1); // Online orders only

    // Apply date filter based on transaction_date from order_payment
    if ($request->filled(['from_date', 'to_date'])) {
        $query->whereHas('payment', function ($q) use ($request) {
            $q->whereBetween('transaction_date', [$request->from_date, $request->to_date]);
        });
    } else {
        $query->limit(100);
    }

    // Fetch orders
    $orders = $query->get();

    // Preload vendor data
    $vendorIds = $orders->pluck('taxRegister.vendor_id')->unique()->filter()->toArray();
    $vendors = VendorModel::whereIn('unique_id', $vendorIds)->get()->keyBy('unique_id');

    // Append vendor info and tracking status
    foreach ($orders as $order) {
        $vendorId = optional($order->taxRegister)->vendor_id;
        $vendor = $vendorId ? ($vendors[$vendorId] ?? null) : null;

        $order->vendor_info = $vendor
            ? "{$vendor->username}\n{$vendor->phone_no}\n{$vendor->address}"
            : "Vendor not found";

        // Tracking info
        $tracking_status = '';
        $tracking_update_status = DB::table('order_tracking')
            ->select('courier_number', 'tracking_status', 'updated_at')
            ->where([
                'invoice_number' => $order->invoice_number,
                'vendor_id' => $vendorId
            ])
            ->distinct()
            ->get();

        foreach ($tracking_update_status as $track) {
            $statusText = match ($track->tracking_status) {
                0 => "Pending",
                1 => "In-process",
                2 => "In-production",
                3 => "Shipped",
                4 => "Out for delivery",
                5 => "Delivered",
                default => "Unknown"
            };

            $tracking_status .= '<p class="otiddiv mb-1 py-1 px-1 border border-1">' .
                $statusText . '<br>' .
                $track->courier_number . '<br>' .
                $track->updated_at .
                '</p><br>';
        }

        $order->tracking_status_html = $tracking_status;
    }

    return view('order_processing_online1', compact('orders'));
}*/



    //order_under_process_cod
    /*public function order_processing_cod(Request $request)
    { 
        $result=array();
        $where=array('orders.order_status'=>3,'orders.mode_of_payment'=>2,'orders.batch_id'=>0,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->select('order_shipping_address.school_code','sale_tax_register.shipping_charge','orders.order_status','orders.print_status','sale_tax_register.bill_id','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','sale_tax_register.total_amount','sale_tax_register.total_discount','sale_tax_register.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
            ->orderBy('sale_tax_register.id','desc')
            ->get();
            
              if ($request->has('from_date') && $request->has('to_date')) {
        $data->whereBetween('transaction_date', [$request->from_date, $request->to_date]);
    } else {
           $data->limit(100);
    }
    
        for($i=0;$i<count($data);$i++)
        {
              $tracking_status=''; 
            //$tracking_update_status=OrderTrackingModel::distinct('courier_number','tracking_status')->where(['invoice_number'=>$data[$i]->invoice_number,'vendor_id'=>$data[$i]->vendor_id,'status'=>1])->get();
              $tracking_update_status=DB::table('order_tracking')->select('courier_number','tracking_status','updated_at')->where(['invoice_number'=>$data[$i]->invoice_number,'vendor_id'=>$data[$i]->vendor_id])->distinct('courier_number','tracking_status','updated_at')->get();
              if($tracking_update_status)
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
              }
              
                $vendor_id=$data[$i]->vendor_id;
                $vendordata="";
                // for($j=0;$j<count($vendor_id);$j++)
                // {
                    $vendor=VendorModel::where('unique_id', $vendor_id)->first();
                    $vendordata="<p class='mb-1 py-1 px-1 border border-1'>".$vendor->username."<br>".$vendor->phone_no."<br>".$vendor->address.'</p>';
                // }
          
                 $data[$i]->vendor_info=$vendordata;
                 $data[$i]->vendor_id=$vendor_id;
                $data[$i]->tracking_status=$tracking_status;
              
                array_push($result,$data[$i]);  
        }  
        return view('order_processing_cod1', ['orders' => $result]);
    }*/
    
  /*  public function order_processing_cod(Request $request)
{
    $result = [];

    $where = [
        'orders.order_status' => 3,
        'orders.mode_of_payment' => 2,
        'orders.batch_id' => 0,
        'orders.payment_status' => 2,
        'order_payment.status' => 1,
        'orders.status' => 1
    ];

    $query = DB::table('orders')
        ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->leftJoin('sale_tax_register', 'sale_tax_register.order_id', '=', 'orders.invoice_number')
        ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
        ->select(
            'order_shipping_address.school_code',
            'sale_tax_register.shipping_charge',
            'orders.order_status',
            'orders.print_status',
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
            'users.user_type',
            'users.name',
            'users.fathers_name',
            'users.phone_no',
            'users.school_code',
            'users.state',
            'users.district',
            'users.city',
            'users.post_office',
            'users.village',
            'users.address',
            'users.landmark',
            'users.pincode',
            'order_payment.transaction_id',
            'order_payment.transaction_date',
            'orders.invoice_number',
            'orders.mode_of_payment'
        )
        ->where($where)
        ->orderBy('sale_tax_register.id', 'desc');

    // Apply date filter or limit
    if ($request->has('from_date') && $request->has('to_date')) {
        $query->whereBetween('order_payment.transaction_date', [$request->from_date, $request->to_date]);
    } else {
        $query->limit(100);
    }

    $data = $query->get();
    
    


    foreach ($data as $order) {
        // Get tracking status
      
       

        $tracking_status = '';
        $tracking_updates = DB::table('order_tracking')
            ->select('courier_number', 'tracking_status', 'updated_at')
            ->where([
                'invoice_number' => $order->invoice_number,
                'vendor_id' => $order->vendor_id
            ])
            ->distinct()
            ->get();

        foreach ($tracking_updates as $track) {
            $statusText = match ((int)$track->tracking_status) {
                0 => 'Pending',
                1 => 'In-process',
                2 => 'In-production',
                3 => 'Shipped',
                4 => 'Out for delivery',
                5 => 'Delivered',
                default => 'Unknown',
            };

            $tracking_status .= "<p class='otiddiv mb-1 py-1 px-1 border border-1'>{$statusText}<br>{$track->courier_number}<br>{$track->updated_at}</p><br>";
        }

        // Get vendor info
   
        

        $order->tracking_status = $tracking_status;
      

        $result[] = $order;
    }

    return view('order_processing_cod1', ['orders' => $result]);
}*/

public function order_processing_cod(Request $request)
{
    $result = [];

    $where = [
        'orders.order_status' => 3,
        'orders.mode_of_payment' => 2,
        'orders.batch_id' => 0,
        'orders.payment_status' => 2,
        'order_payment.status' => 1,
        'orders.status' => 1
    ];

    $query = DB::table('orders')
        ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->leftJoin('sale_tax_register', 'sale_tax_register.order_id', '=', 'orders.invoice_number')
        ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
        ->leftJoin('vendor', 'vendor.unique_id', '=', 'sale_tax_register.vendor_id')
        ->leftjoin('school', 'users.school_code', '=', 'school.school_code')// Add vendor join
        ->select(
            'order_shipping_address.school_code',
            'sale_tax_register.shipping_charge',
            'orders.order_status',
            'orders.print_status',
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
            'users.user_type',
            'users.name',
            'users.fathers_name',
            'users.phone_no',
            'users.school_code as school_code',
            'users.state',
            'users.district',
            'users.city',
            'users.post_office',
            'users.village',
            'users.address',
            'users.landmark',
            'users.pincode',
            'order_payment.transaction_id',
            'order_payment.transaction_date',
            'orders.invoice_number',
            'orders.mode_of_payment',
            'users.school_code as user_school_code',  
            'school.school_name as school_name',

            // Vendor Info
            'vendor.username as vendor_name',
            'vendor.email as vendor_email',
            'vendor.phone_no as vendor_phone'
        )
        ->where($where)
        ->orderBy('sale_tax_register.id', 'desc');

    // Apply date filter or limit
    if ($request->has('from_date') && $request->has('to_date')) {
        $query->whereBetween('order_payment.transaction_date', [$request->from_date, $request->to_date]);
    } else {
        $query->limit(100);
    }

    $data = $query->get();

    foreach ($data as $order) {
        // Get tracking status
        $tracking_status = '';
        $tracking_updates = DB::table('order_tracking')
            ->select('courier_number', 'tracking_status', 'updated_at')
            ->where([
                'invoice_number' => $order->invoice_number,
                'vendor_id' => $order->vendor_id
            ])
            ->distinct()
            ->get();

        foreach ($tracking_updates as $track) {
            $statusText = match ((int)$track->tracking_status) {
                0 => 'Pending',
                1 => 'In-process',
                2 => 'In-production',
                3 => 'Shipped',
                4 => 'Out for delivery',
                5 => 'Delivered',
                default => 'Unknown',
            };

            $tracking_status .= "<p class='otiddiv mb-1 py-1 px-1 border border-1'>{$statusText}<br>{$track->courier_number}<br>{$track->updated_at}</p><br>";
        }

        $order->tracking_status = $tracking_status;

        $result[] = $order;
    }

    return view('order_processing_cod1', ['orders' => $result]);
}


    
    public function orderProcessingForPayout(Request $request)
    {
        $result = [];
    
        // Determine mode of payment: 1 = online, 2 = COD
        $mode = $request->input('payment_mode');
        $allowedModes = [1, 2];
    
        $where = [
            'orders.order_status' => 4,
            'orders.batch_id' => 0,
            'orders.payment_status' => 2,
            'order_payment.status' => 1,
            'orders.status' => 1
        ];
    
        if (in_array($mode, $allowedModes)) {
            $where['orders.mode_of_payment'] = $mode;
        }
    
        // Build base query
        $query = DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register', 'sale_tax_register.order_id', '=', 'orders.invoice_number')
            ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
            ->leftjoin('school', 'users.school_code', '=', 'school.school_code')
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
                'orders.mode_of_payment',
                'users.school_code as user_school_code',  
            'school.school_name as school_name',
            'sale_tax_register.vendor_state_code'
            )
            ->where($where)
            ->orderBy('sale_tax_register.id', 'desc');
            
        // Optional date filtering
        if ($request->filled(['from_date', 'to_date'])) {
            $query->whereBetween('order_payment.transaction_date', [$request->from_date, $request->to_date]);
        } else {
            $query->limit(100);
        }
    
        // Get data
        $orders = $query->get();
    
        // Fetch vendor info in bulk
        $vendorIds = $orders->pluck('vendor_id')->unique()->filter()->toArray();
        $vendors = VendorModel::whereIn('unique_id', $vendorIds)->get()->keyBy('unique_id');
    
        foreach ($orders as $order) {
            // Add vendor info
            $vendor = $vendors[$order->vendor_id] ?? null;
            $order->vendor_info = $vendor
                ? "{$vendor->username}\n{$vendor->phone_no}\n{$vendor->address}"
                : "Vendor not found";
    
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
            $sale_tax = DB::table('sale_tax_register')
                ->select('bill_id', 'total_amount', 'total_discount', 'shipping_charge')
                ->where([
                    'order_id' => $order->invoice_number,
                ])
                ->first();
    
            if ($sale_tax) {
                $order->bill_id = $sale_tax->bill_id;
                $order->total_amount = $sale_tax->total_amount;
                $order->total_discount = $sale_tax->total_discount;
                $order->ven_shipping_charge = $sale_tax->shipping_charge;
            }
            $sale_tax = DB::table('sale_tax_register')
            ->select('bill_id', 'total_amount', 'total_discount', 'shipping_charge')
            ->where([
                'order_id' => $order->invoice_number,
            ])
            ->first();

        if ($sale_tax) {
            $order->bill_id = $sale_tax->bill_id;
            $order->total_amount = $sale_tax->total_amount;
            $order->total_discount = $sale_tax->total_discount;
            $order->ven_shipping_charge = $sale_tax->shipping_charge;
        }
            $result[] = $order;
        }
    
        return view('orders_payout', ['orders' => $result]);
    }
    
    
    //order_process_status
     public function order_process_status(Request $request,String $id,String $vid)
    { 
        $result=array();
        $where=array('sale_tax_register.vendor_id'=>$vid,'orders.invoice_number'=>$id,'orders.order_status'=>3,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $order_data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->leftJoin('vendor','vendor.unique_id','=','sale_tax_register.vendor_id')
            ->select('orders.custom_set_status','orders.grand_total','orders.shipping_charge as total_shipping','orders.print_status','sale_tax_register.created_at as inv_created_at','vendor.unique_id','sale_tax_register.bill_id','vendor.unique_id as vendor_unique_id',	'vendor.username as vendor_username',	'vendor.email as vendor_email',	'vendor.phone_no as vendor_phone_no',	'vendor.gst_no as vendor_gst_no',	'vendor.country as vendor_country',	'vendor.state as vendor_state',	'vendor.distt as vendor_distt',	'vendor.city as vendor_city',	'vendor.landmark as vendor_landmark',	'vendor.pincode as vendor_pincode',	'vendor.address as vendor_address',	'order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','sale_tax_register.total_amount','sale_tax_register.total_discount','sale_tax_register.shipping_charge','sale_tax_register.vendor_id','users.unique_id as user_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.classno','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.order_status','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
            ->first();
            
            
            $file=Storage::disk('s3')->get('sales_report/'.$id.'.jsonp');
        	$getfile=json_decode ($file,true);
        	$iteminfo=array();   
        	$total_item=0;
            foreach($getfile as $data)
            {
              
                if($vid==$data['vendor_id'])
                {
                     // set item
                    if($data['item_type']==1)
                    { 
                        $itemdata['item_type']=1;
                        $itemdata['id']=$data['id'];
                        $itemdata['item_id']=$data['itemcode'];
                        $itemdata['itemname']=$data['itemname'];
                        $itemdata['weight']=$data['item_weight'];
                        $itemdata['cat']=$data['set_cat'];
                        $itemdata['rate']=$data['unit_price'];
                        $itemdata['discount_rate']=$data['unit_price']-$data['item_discount'];
                        $itemdata['discount']=$data['item_discount'];
                        $discount_rate=$data['unit_price']-$data['item_discount'];
                        $itemdata['total_without_gst']=$discount_rate-($discount_rate*$data['gst_title']/100);
                        $itemdata['qty']=$data['item_qty'];
                        $itemdata['gst']=$data['gst_title'];
                       
                        $gstval=100+$data['gst_title'];
                        $itemdata['without_gst_rate']=($discount_rate/$gstval)*100;
                        $itemdata['gst_rate']=$discount_rate-($discount_rate/$gstval)*100;
                        
                        $itemdata['item_ship_chr']=$data['item_ship_chr'];
                       
                        $itemdata['class']="";
                        $itemdata['size_medium']="";
                    }
                    else
                    {
                        $size_medium=""; 
                        $managemastersizelistModel=managemastersizelistModel::where(['id'=>$data['size']])->first();  
                    if($managemastersizelistModel)
                    {
                        $size_medium=$managemastersizelistModel->title; 
                    }
                     //inventory item  
                    $itemdata['item_type']=0;
                    $itemdata['item_type']=0;
                    $itemdata['id']=$data['id'];
                    $itemdata['item_id']=$data['product_id'];
                    $itemdata['itemname']=$data['product_name'];
                    $itemdata['weight']=$data['net_weight'];
                    $itemdata['cat']=$data['catone'];
                    $itemdata['rate']=$data['mrp'];
                    $itemdata['discount_rate']=$data['mrp']-($data['mrp']*$data['discount'])/100;
                    $discount_rate=$data['mrp']-$data['discounted_price'];
                    $itemdata['discount']=($data['mrp']*$data['discount'])/100;
                    $itemdata['total_without_gst']=$discount_rate-($discount_rate*$data['gst_title']/100);
                    $itemdata['qty']=$data['item_qty'];
                    $itemdata['gst']=$data['gst_title'];
                    
                    $gstval=100+$data['gst_title'];
                    $itemdata['without_gst_rate']=($data['discounted_price']/$gstval)*100;
                    $itemdata['gst_rate']=$discount_rate-($discount_rate/$gstval)*100;
                    $itemdata['item_ship_chr']=$data['shipping_charges'];
                    
                    
                    
                    $itemdata['class']=$data['class_title'];
                    $itemdata['size_medium']=$size_medium;
                        
                    }  
                    
                    $item_traking_status=OrderTrackingModel::select('courier_number','tracking_status','status')->where(['invoice_number'=>$id,'vendor_id'=>$data['vendor_id'],'item_id'=>$data['id'],'item_type'=>$data['item_type']])->first();
                    $itemdata['tracking_status']=$item_traking_status->tracking_status;
                    $itemdata['courier_number']=$item_traking_status->courier_number;
                    $itemdata['item_trk_status']=$item_traking_status->status;
                    
                    array_push($iteminfo,$itemdata);
                    $total_item++;
                }
            
             }    
            
        $order_data->total_item=$total_item; 
        $order_data->order_vendor_id=$vid;
        $tracking=array();
        return view('orders_update_status', ['order' => $order_data,'item_info'=>$iteminfo,'tracking'=>$tracking]);
    }
    
    //update_order_item_status
  /*  public function update_order_item_status(Request $request)
    {
        $itemid_type=$request->id_type;
        $invoice_number=$request->invoice_number;
        $vendor_id=$request->vendor_id;
        $user_id=$request->user_id;
        $order_item_status=$request->order_item_status;
        // $courier_no=$request->courier_no;
        $shipper_name=$request->shipper_name;
        $shipper_address=$request->shipper_address;
        $total_item=$request->total_item;
        $row=0;
        
        $count=count($itemid_type);
        if($count>0)
        {
        foreach($itemid_type as $item)
        {
          
            $item_array=explode(',',$item);
            $update_status=OrderTrackingModel::where(['invoice_number'=>$invoice_number,'vendor_id'=>$vendor_id,'item_id'=>$item_array[0],'item_type'=>$item_array[1]]);
            $get_status=OrderTrackingModel::select('out_for_delivery')->where(['invoice_number'=>$invoice_number,'vendor_id'=>$vendor_id,'item_id'=>$item_array[0],'item_type'=>$item_array[1]])->first();
            
            // if($order_item_status==2){$update_status->update(['in_production_on'=>date('Y-m-d'),'status'=>1,'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'courier_number'=>$courier_no,'shipper_address'=>$shipper_address,'courier_no_status'=>1]);}
            // elseif($order_item_status==3){$update_status->update(['shipped_on'=>date('Y-m-d'),'status'=>1,'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'courier_number'=>$courier_no,'shipper_address'=>$shipper_address,'courier_no_status'=>1]);}
            // elseif($order_item_status==4){$update_status->update(['out_for_delivery'=>date('Y-m-d'),'status'=>1,'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'courier_number'=>$courier_no,'shipper_address'=>$shipper_address,'courier_no_status'=>1]);}
            if($order_item_status==4)
            {
                $update_status->update(['out_for_delivery'=>date('Y-m-d'),'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'shipper_address'=>$shipper_address]);
            }
            else
            {
                if($get_status->out_for_delivery==NULL)
                {
                     $update_status->update(['out_for_delivery'=>date('Y-m-d'),'delivered_on'=>date('Y-m-d'),'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'shipper_address'=>$shipper_address]);
                }
                else
                {
                    $update_status->update(['delivered_on'=>date('Y-m-d'),'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'shipper_address'=>$shipper_address]);
                }
           
           
            }
            
            
            $row++;
        }
        
        if($row==$count)
        {
            
            
         $totalRowCounts = DB::table('order_tracking')->selectRaw('COUNT(invoice_number) 
                                           AS total_rows,SUM(CASE WHEN tracking_status = 5 THEN 1 ELSE 0 END) AS total_updated')
                                           ->where('invoice_number', '=', $invoice_number)
                                           ->first();
                         
        if($totalRowCounts->total_rows==$totalRowCounts->total_updated)
        {
        
        $Order=OrdersModel::where(['invoice_number'=>$invoice_number,'user_id'=>$user_id,'order_status'=>3]);
        if($Order)
        {
               $Order->update(['order_status'=>4]);
               $orderupdate=SaleTaxRegisterModel::where(['order_id'=>$invoice_number,'vendor_id'=>$vendor_id]);
               $orderupdate->update(['batch_status'=>3,'order_status'=>4,'delivery_status'=>1,'deliver_on'=>date('Y-m-d')]);
               
              
               $response['success']=1;
               $response['msg']='Order Status Updated successfully!';
               $this->output($response); 
               
            }
            else
            {
               $response['success']=0;
               $response['msg']='Order Already Deliverd!';
               $this->output($response);  
           }
        
        }
         else
         {
           $response['success']=1;
           $response['msg']='Order Item Deliverd Successfully';
           $this->output($response);
         }
        }
        else
        {
           
              $response['success']=0;
               $response['msg']='Something Went Wrong!';
               $this->output($response); 
          
        }
        
        }
        else
        {
                $response['success']=0;
               $response['msg']='Select item to update status!';
               $this->output($response); 
        }
 
        
    }*/
    
      public function update_order_item_status(Request $request)
    {
        // 1. Validate incoming payload
        $request->validate([
            'id_type'           => ['required', 'array', 'min:1'],
            'id_type.*'         => ['required', 'regex:/^\d+,[^,]+$/'],
            'invoice_number'    => ['required', 'string'],
            'vendor_id'         => ['required', 'string'],
            'user_id'           => ['required', 'string'],
            'order_item_status' => ['required', 'integer', 'between:2,5'],
            'shipper_name'      => ['required', 'string'],
            'shipper_address'   => ['required', 'string'],
        ]);
    
        $itemPairs      = $request->input('id_type');
        $invoiceNumber  = $request->input('invoice_number');
        $vendorId       = $request->input('vendor_id');
        $userId         = $request->input('user_id');
        $newStatus      = (int) $request->input('order_item_status');
        $shipperName    = $request->input('shipper_name');
        $shipperAddress = $request->input('shipper_address');
    
        $updatedCount = 0;
        foreach ($itemPairs as $pair) {
            [$itemId, $itemType] = explode(',', $pair, 2);
    
            // 2. Fetch the specific tracking record
            $tracking = OrderTrackingModel::where([
                'invoice_number' => $invoiceNumber,
                'vendor_id'      => $vendorId,
                'item_id'        => $itemId,
                'item_type'      => $itemType,
            ])->first();
    
            if (! $tracking) {
                continue; // skip missing rows
            }
    
            // 3. Build update payload (now including 'status' => 1)
            $payload = [
                'tracking_status' => $newStatus,
                'status'          => 1,                  // activate this tracking row
                'shipper_name'    => $shipperName,
                'shipper_address' => $shipperAddress,
            ];
    
            switch ($newStatus) {
                case 2: // In-production
                    $payload['in_production_on'] = now()->toDateString();
                    break;
    
                case 3: // Shipped
                    $payload['shipped_on'] = now()->toDateString();
                    break;
    
                case 4: // Out for delivery
                    $payload['out_for_delivery'] = now()->toDateString();
                    break;
    
                case 5: // Delivered
                    if (is_null($tracking->out_for_delivery)) {
                        $payload['out_for_delivery'] = now()->toDateString();
                    }
                    $payload['delivered_on'] = now()->toDateString();
                    break;
            }
    
            $tracking->update($payload);
            $updatedCount++;
        }
    
        // 4. If none updated, return error
        if ($updatedCount === 0) {
            return $this->output([
                'success' => 0,
                'msg'     => 'No order items were updated.'
            ]);
        }
    
        // 5. Check if all items are now delivered
        $totals = DB::table('order_tracking')
            ->selectRaw('COUNT(*) AS total_rows,
                         SUM(CASE WHEN tracking_status = 5 THEN 1 ELSE 0 END) AS delivered_count')
            ->where('invoice_number', $invoiceNumber)
            ->first();
    
        // 6. If every item is delivered, update parent order + sale_tax_register
        if ($totals->total_rows === $totals->delivered_count) {
            $order = OrdersModel::where([
                'invoice_number' => $invoiceNumber,
                'user_id'        => $userId,
                'order_status'   => 3,
            ])->first();
    
            if ($order) {
                $order->update(['order_status' => 4]); // delivered
    
                SaleTaxRegisterModel::where([
                    'order_id'  => $invoiceNumber,
                    'vendor_id' => $vendorId,
                ])->update([
                    'batch_status'    => 3,
                    'order_status'    => 4,
                    'delivery_status' => 1,
                    'deliver_on'      => now()->toDateString(),
                ]);
    
                return $this->output([
                    'success' => 1,
                    'msg'     => 'Order Status Updated successfully!'
                ]);
            }
    
            return $this->output([
                'success' => 0,
                'msg'     => 'Parent order not found or already delivered.'
            ]);
        }
    
        // 7. Some items updated but not all yet
        return $this->output([
            'success' => 1,
            'msg'     => 'Order item status updated successfully.'
        ]);
    }
    
     /*public function markAsDelivered(Request $request)
    {
        try {
            $invoiceNumber = $request->input('invoice');
            
            // Debugging log for the invoice number
            Log::info("Attempting to mark order as delivered for invoice: $invoiceNumber");
    
            // Update order_tracking table
            $trackingUpdate = DB::table('order_tracking')
                ->where('invoice_number', $invoiceNumber)
                ->update([
                    'tracking_status' => 4,
                    'delivered_on' => now(),
                    'out_for_delivery' => DB::raw("IFNULL(out_for_delivery, '" . now() . "')"),
                    'updated_at' => now(),
                ]);
            
            Log::info("Order tracking updated: " . ($trackingUpdate ? 'Success' : 'Failed'));
    
            // Update orders table
            $orderUpdate = DB::table('orders')
                ->where('invoice_number', $invoiceNumber)
                ->update([
                    'order_status' => 4,
                    'updated_at' => now(),
                ]);
            
            Log::info("Order updated: " . ($orderUpdate ? 'Success' : 'Failed'));
    
            // Update new_order_processing_data table
            $updated = DB::table('new_order_processing_data1')
                ->where('invoice_number', $invoiceNumber)
                ->update([
                    'order_status' => 4,
                  
                ]);
    
            Log::info("New order processing data updated: " . ($updated ? 'Success' : 'Failed'));
    
            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order marked as delivered successfully.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update new_order_processing_data.',
                ]);
            }
    
        } catch (\Exception $e) {
            // Log the detailed error message
            Log::error('Error in markAsDelivered: ' . $e->getMessage());
    
            // Return a more specific message with the exception details
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while marking the order as delivered. ' . $e->getMessage(),
            ]);
        }
    }*/
public function markAsDelivered(Request $request)
{
    try {
        $invoiceNumber = $request->input('invoice');
        Log::info("Attempting to mark order as delivered for invoice: $invoiceNumber");

        // Update order_tracking table
        $trackingUpdate = DB::table('order_tracking')
            ->where('invoice_number', $invoiceNumber)
            ->update([
                'tracking_status' => 5,
                'delivered_on' => now(),
                'out_for_delivery' => DB::raw("IFNULL(out_for_delivery, '" . now() . "')"),
                'updated_at' => now(),
            ]);
        
        Log::info("Order tracking updated: " . ($trackingUpdate ? 'Success' : 'Failed'));

        // Fetch the order to get the mode_of_payment
        $order = DB::table('orders')
            ->where('invoice_number', $invoiceNumber)
            ->first();
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ]);
        }

        // Update based on mode_of_payment
        if ($order->mode_of_payment == 1) {
            $updated = DB::table('new_order_processing_data2')
                ->where('invoice_number', $invoiceNumber)
                ->update([
                    'order_status' => 4,
                ]);
            $orderUpdate = DB::table('orders')
                ->where('invoice_number', $invoiceNumber)
                ->update([
                    'order_status' => 4,
                    'updated_at' => now(),
                ]);

            Log::info("New order processing data updated: " . ($updated ? 'Success' : 'Failed'));

            if (!$updated) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update new_order_processing_data1.',
                ]);
            }
        } else {
            $orderUpdate = DB::table('orders')
                ->where('invoice_number', $invoiceNumber)
                ->update([
                    'order_status' => 4,
                    'updated_at' => now(),
                ]);
            
            Log::info("Order updated: " . ($orderUpdate ? 'Success' : 'Failed'));

            if (!$orderUpdate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update orders table.',
                ]);
            }
        }

        // ✅ Return success message here
        return response()->json([
            'success' => true,
            'message' => 'Order marked as delivered successfully.',
        ]);

    } catch (\Exception $e) {
        Log::error('Error in markAsDelivered: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'An error occurred while marking the order as delivered. ' . $e->getMessage(),
        ]);
    }
}

    //deliver_order
     public function deliver_order(Request $request)
    {
        $invoice_number=$request->invoice_number;
        $vendor_id=$request->vendor_id;
        $update_status=OrderTrackingModel::where(['invoice_number'=>$invoice_number,'vendor_id'=>$vendor_id])->whereIn('tracking_status',[3,4]);
        $update_status->update(['delivered_on'=>date('Y-m-d'),'status'=>1,'tracking_status'=>5]);
           
        $totalRowCounts = DB::table('order_tracking')->selectRaw('COUNT(invoice_number) 
                                           AS total_rows,SUM(CASE WHEN tracking_status = 5 THEN 1 ELSE 0 END) AS total_updated')
                                           ->where('invoice_number', '=', $invoice_number)
                                           ->first();
                         
        if($totalRowCounts->total_rows==$totalRowCounts->total_updated)
        {
        
            $Order=OrdersModel::where(['invoice_number'=>$invoice_number,'order_status'=>3]);
            if($Order)
            {
            
               $Order->update(['order_status'=>4]);
               $orderupdate=SaleTaxRegisterModel::where(['order_id'=>$invoice_number]);
               $orderupdate->update(['batch_status'=>3,'order_status'=>4,'delivery_status'=>1,'deliver_on'=>date('Y-m-d')]);
              
               $response['success']=1;
               $response['msg']='Order Status Updated successfully!';
               $this->output($response); 
               
            }
            else
            {
               $response['success']=0;
               $response['msg']='Order Already Deliverd!';
               $this->output($response);  
            }
        
        }
         else
         {
           $response['success']=1;
           $response['msg']='Order Item Deliverd Successfully';
           $this->output($response);
         }
        
    }
    
    //deliver_order_vendor_wise
    public function deliver_order_vendor_wise(Request $request)
    {
        $invoice_number=$request->invoice_number;
        $vendor_id=$request->vendor_id;
        $user_id=$request->user_id;
        $order_item_status=$request->order_item_status;
        $courier_no=$request->courier_no;
        $shipper_name=$request->shipper_name;
        $shipper_address=$request->shipper_address;
        $total_item=$request->total_item;
        $row=0;
        
        foreach($itemid_type as $item)
        {
          
            $item_array=explode(',',$item);
            $update_status=OrderTrackingModel::where(['invoice_number'=>$invoice_number,'vendor_id'=>$vendor_id,'item_id'=>$item_array[0],'item_type'=>$item_array[1],'status'=>0]);
            
            // if($order_item_status==2){$update_status->update(['in_production_on'=>date('Y-m-d'),'status'=>1,'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'courier_number'=>$courier_no,'shipper_address'=>$shipper_address,'courier_no_status'=>1]);}
            // elseif($order_item_status==3){$update_status->update(['shipped_on'=>date('Y-m-d'),'status'=>1,'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'courier_number'=>$courier_no,'shipper_address'=>$shipper_address,'courier_no_status'=>1]);}
            // elseif($order_item_status==4){$update_status->update(['out_for_delivery'=>date('Y-m-d'),'status'=>1,'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'courier_number'=>$courier_no,'shipper_address'=>$shipper_address,'courier_no_status'=>1]);}
            if($order_item_status==5){$update_status->update(['delivered_on'=>date('Y-m-d'),'status'=>1,'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'courier_number'=>$courier_no,'shipper_address'=>$shipper_address,'courier_no_status'=>1]);}
            
            
            
            $row++;
        }
        
        if($row==$total_item)
        {
            
            
         $totalRowCounts = DB::table('order_tracking')->selectRaw('COUNT(invoice_number) 
                                           AS total_rows,SUM(CASE WHEN tracking_status = 5 THEN 1 ELSE 0 END) AS total_updated')
                                           ->where('invoice_number', '=', $invoice_number)
                                           ->first();
                         
        if($totalRowCounts->total_rows==$totalRowCounts->total_updated)
        {
        
        $Order=OrdersModel::where(['invoice_number'=>$invoice_number,'user_id'=>$user_id,'order_status'=>3]);
        if($Order)
        {
            
               $Order->update(['order_status'=>4]);
               $orderupdate=SaleTaxRegisterModel::where(['order_id'=>$invoice_number,'vendor_id'=>$vendor_id]);
               $orderupdate->update(['batch_status'=>3,'order_status'=>4,'delivery_status'=>1,'deliver_on'=>date('Y-m-d')]);
               
              
               $response['success']=1;
               $response['msg']='Order Status Updated successfully!';
               $this->output($response); 
               
            }
            else
            {
               $response['success']=0;
               $response['msg']='Order Already Deliverd!';
               $this->output($response);  
           }
        
        }
         else
         {
           $response['success']=1;
           $response['msg']='Order Item Deliverd Successfully';
           $this->output($response);
         }
        }
        else
        {
           
              $response['success']=0;
               $response['msg']='Something Went Wrong!';
               $this->output($response); 
          
        }
 
        
    }
    
    
    
    //get_order_item_details
    public function get_order_item_details(Request $request)
    {
            $orderdata=[];
            $orderitem=[];   
            $itemdata=[];
            $totalamount=0;
            $total_dis=0;
            $total_ship=0;
            $total_wo_gst_amount=0;

         $where=array('orders.invoice_number'=>$request->order_id);
         $order_data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
            ->select('order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment','order_shipping_address.address_type','order_shipping_address.name','order_shipping_address.phone_no','order_shipping_address.school_code','order_shipping_address.school_name','order_shipping_address.alternate_phone','order_shipping_address.village','order_shipping_address.address','order_shipping_address.post_office','order_shipping_address.pincode','order_shipping_address.city','order_shipping_address.state','order_shipping_address.district')
            ->where($where)
            ->first();
            
            $file=Storage::disk('s3')->get('sales_report/'.$request->order_id.'.jsonp');
        	$getfile=json_decode ($file,true);
            foreach($getfile as $data)
            {
                $item_mrp=0;
                $item_dis=0;
                $item_ship=0;
                $item_basic_price=0;
                $item_qty=0;
                if($request->vendor_id==$data['vendor_id'])
                {
                     // set item
                    if($data['item_type']==1)
                    {
                    // if(array_key_exists("set_cat",$data)){$set_cat=$data['set_cat'];}else{$set_cat="";}    
                    $itemdata['item_id']=$data['itemcode'];
                    $itemdata['itemname']=$data['itemname'];
                    $itemdata['weight']=$data['item_weight'];
                    $itemdata['cat']=$data['set_cat'];
                    $itemdata['rate']=$data['unit_price'];
                    $itemdata['total_without_gst']=$data['unit_price']-($data['unit_price']*$data['gst_title']/100);
                    
                    // if(array_key_exists("item_discount",$data)){$item_discount=$data['item_discount'];}else{$item_discount=0;}
                    
                        $item_qty=$data['item_qty'];
                        $item_mrp=$data['unit_price']*$item_qty;
                        $item_basic_price=$item_mrp-($item_mrp*$data['gst_title']/100);
                        $item_dis=$data['item_discount'];
                        $itemdata['qty']=$item_qty;
                          $itemdata['item_ship_chr']=$data['item_ship_chr'];
                          $item_ship=$itemdata['item_ship_chr'];
                    }
                    else
                    {
                     //inventory item  
                    $itemdata['item_id']=$data['product_id'];
                    $itemdata['itemname']=$data['product_name'];
                    $itemdata['weight']=$data['net_weight'];
                    $itemdata['cat']=$data['catone'];
                    $itemdata['rate']=$data['mrp'];
                    $itemdata['total_without_gst']=$data['mrp']-($data['mrp']*$data['gst_title']/100);
                   
                        $item_qty=$data['item_qty'];
                        $item_mrp=$data['mrp']*$item_qty;
                        $item_basic_price=$item_mrp-($item_mrp*$data['gst_title']/100);
                        $item_dis=($item_mrp*$data['discount'])/100;
                        
                   
                        $itemdata['qty']=$item_qty;
                        $itemdata['item_ship_chr']=$data['shipping_charges'];
                        $item_ship=$data['shipping_charges'];
                     
                    }
                    
                    $itemdata['gst']=$data['gst_title'];
                   
                    array_push($orderitem,$itemdata);
                    $totalamount+=$item_mrp;
                    $total_wo_gst_amount+=$item_basic_price;
                    $total_dis+=$item_dis;
                    $total_ship+=$item_ship;
                }
            
             }
        	
        	if($order_data->mode_of_payment==1){$mop="Online";}else{$mop="COD";}
        	$order_data->total_amount=$totalamount;
        	$order_data->total_wo_gst_amount=$total_wo_gst_amount;
        	$order_data->total_discount=$total_dis;
        	$order_data->total_shipping=$total_ship;
        	$order_data->mop=$mop;
        	
        	
            $this->output(array('item_info'=>$orderitem,'order_info'=>$order_data));
        }

    //accept_order
    public function accept_order(Request $request)
    {
          //sale tax register
            $filedata=array();
            $jsonfile=Storage::disk('s3')->get('sales_report/'.$request->order_id.'.jsonp');
        	$getfiledata=json_decode ($jsonfile,true);
            $totalamount=0;$total_discount=0;$shippcharges=0;$gst0=0;$gst5=0;$gst12=0;$gst18=0;$gst28=0;
            foreach($getfiledata as $filedata)
            {
                //if($filedata['vendor_id']==session('id'))    
                  
                //inv
                if($filedata['item_type']==0)
                {
                    $mrp=$filedata['mrp'];
                    $discount=($mrp*$filedata['discount'])/100;
                       $shippcharges+=$filedata['shipping_charges'];
                }
                //set inv
                else
                {
                    $mrp=$filedata['unit_price'];
                    $discount=$filedata['item_discount'];
                       $shippcharges+=$filedata['item_ship_chr'];
                }
               
                $totalamount+=$mrp;
                $total_discount+=$discount;
             
                $gst=$filedata['gst_title'];
                if($gst==0){$gst0+=$mrp;}elseif($gst==5){$gst5+=$mrp;}elseif($gst==12){$gst12+=$mrp;}elseif($gst==18){$gst18+=$mrp;}elseif($gst==28){$gst28+=$mrp;}
            }

            $Orders = OrdersModel::where(['invoice_number'=>$request->order_id])->first();
            $vendor_id=$Orders->vendor_id;
            $userstatecode= OrderShippingAddressModel::select('state_code')->where(['user_id'=>$Orders->user_id,'invoice_number'=>$request->order_id])->first();
            $vendorstatecode=  DB::table('vendor')->select('state_code')->where('unique_id',$vendor_id)->first();
            $lastbill=SaleTaxRegisterModel::select('bill_no')->where('vendor_id',$vendor_id)->orderBy('id','desc')->first();
            if($vendorstatecode->state_code==$userstatecode->state_code){$gsttype=1;}else{$gsttype=2;}
            
            
            if($lastbill){$billno=$lastbill->bill_no+1;}else{$billno=1;}
            $SaleTaxRegister=[
                'vendor_id'=>$vendor_id,
                'order_id'=>$request->order_id,
                'user_id'=>$Orders->user_id,
                'bill_no'=>$billno,
                'bill_id'=>$vendor_id.'-'.$billno,
                'total_amount'=>$totalamount,
                'total_discount'=>$total_discount,
                'shipping_charge'=>$shippcharges,
                'gst_type'=>$gsttype,
                'gst_0'=>$gst0,
                'gst_5'=>$gst5,
                'gst_12'=>$gst12,
                'gst_18'=>$gst18,
                'gst_28'=>$gst28,
                'vendor_state_code'=>$vendorstatecode->state_code,
                'user_state_code'=>$userstatecode->state_code,
                
                ];
                
                
            $checkisexist=SaleTaxRegisterModel::where(['order_id'=>$request->order_id,'vendor_id'=>$vendor_id,])->count();  
            if($checkisexist==0)
            {
              $salrreg=SaleTaxRegisterModel::create($SaleTaxRegister);
            }

             if($Orders)
             {
                    $OrdersTrackingModel =OrderTrackingModel::where(['invoice_number'=>$request->order_id,'vendor_id'=>$vendor_id])->get();
                    $OrdersTrackingModelupdate =OrderTrackingModel::where(['invoice_number'=>$request->order_id,'vendor_id'=>$vendor_id]);
                    $count=count($OrdersTrackingModel);
                    $row=0;
                    for($i=0;$i<$count;$i++)
                    {
                       if($OrdersTrackingModel[$i]->item_type==0)
                       {
                           $inv=DB::table('inventory_new')->select('qty_available')->where(['vendor_id'=>$vendor_id,'id'=>$OrdersTrackingModel[$i]->item_id])->first();
                           DB::table('inventory_new')->where('id', $OrdersTrackingModel[$i]->item_id)->update(['qty_available' =>$inv->qty_available-1]);
                       }
                       else
                       {
                           if($i==0)
                           {
                               
                           $set_inv=DB::table('school_set_vendor')->distinct('set_id')->where(['vendor_id'=>$vendor_id,'set_id'=>$OrdersTrackingModel[$i]->set_id])->get();
                           foreach($set_inv as $totalset)
                           {
                             $upinv=DB::table('school_set_vendor')->select('set_qty')->where(['vendor_id'=>$vendor_id,'set_id'=>$totalset->set_id])->first();
                             DB::table('school_set_vendor')->where(['vendor_id'=>$vendor_id,'set_id'=>$totalset->set_id])->update(['set_qty' =>$upinv->set_qty-1]);
                           }
                               
                           }
                       }
                     $row++;
                    }
                    
                    if($row==$count)
                    {
                        
                     $updatetracking=$OrdersTrackingModelupdate->update(['tracking_status'=>1]);   
                     if($updatetracking)
                     {
                        $acceptorder=$Orders->update(['order_status'=>3]);
                        if($acceptorder)
                        {
                        
                        $response['success']=1;
                        $response['msg']='Order Accepted Successfully';
                        $this->output($response);
                        }
                        else
                        {
                        $response['success']=0;
                        $response['msg']='Something Went Wrong 2!';
                        $this->output($response);
                        }
                     }
                     else
                     {
                            $response['success']=0;
                            $response['msg']='Something Went Wrong 2!';
                            $this->output($response); 
                     }
                    
                }
                else
                {
                    $response['success']=0;
                    $response['msg']='Something Went Wrong 1!';
                    $this->output($response);
                }
             }
        }

    //cancle_order
    public function cancle_order(Request $request)
    {
        $Orders = OrdersModel::where(['invoice_number'=>$request->order_id])->first();
        $cancle_order=$Orders->update(['order_status'=>5,'status'=>0]);
        if($cancle_order)
        {
        
        $response['success']=1;
        $response['msg']='Order Cancelled Successfully';
        $this->output($response);
        }
        else
        {
            $response['success']=0;
            $response['msg']='Something Went Wrong 1!';
            $this->output($response); 
        }    
    }

    //orders_cancelled
    public function orders_cancelled()
    { 
        $result=array();
        $where=array('orders.order_status'=>5);
        $data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->select('orders.print_status','sale_tax_register.bill_id','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','sale_tax_register.total_amount','sale_tax_register.total_discount','sale_tax_register.shipping_charge','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
            ->orderBy('sale_tax_register.id','desc')
            ->get();
            
            
        for($i=0;$i<count($data);$i++)
        {  
           $vendor_id=explode(',',$data[$i]->vendor_id);
            $vendordata="";
            for($j=0;$j<count($vendor_id);$j++)
            {
                $vendor=VendorModel::where('unique_id', $vendor_id[$j])->first();
                $vendordata.="<p class='mb-1 py-1 px-1 border border-1'>".$vendor->username."<br>".$vendor->phone_no."<br>".$vendor->address.'</p>';
            }
              
            $data[$i]->vendor_info=$vendordata;
            array_push($result,$data[$i]);
        }  
        return view('orders_cancelled', ['orders' => $result]);
    }
    
    //search_order
    public function search_order()
    { 
        return view('orders_search');
    }

    //filter_search_order
    public function filter_search_order(Request $request)
    { 
        if($request->search_type==1)
        {
        $id=$request->search_key;    
        $result=array();
        $where=array('orders.invoice_number'=>$id);
        $order_data= DB::table('orders')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->leftJoin('vendor','vendor.unique_id','=','sale_tax_register.vendor_id')
            ->leftJoin('order_under_batch','order_under_batch.id','=','sale_tax_register.batch_id')
            ->leftJoin('school','school.school_code','=','users.school_code')
            ->select('school.school_name','users.school_code','order_under_batch.batch_id','orders.grand_total','orders.shipping_charge as total_shipping','orders.print_status','sale_tax_register.created_at as inv_created_at','vendor.unique_id','sale_tax_register.bill_id','vendor.unique_id as vendor_unique_id',	'vendor.username as vendor_username',	'vendor.email as vendor_email',	'vendor.phone_no as vendor_phone_no',	'vendor.gst_no as vendor_gst_no',	'vendor.country as vendor_country',	'vendor.state as vendor_state',	'vendor.distt as vendor_distt',	'vendor.city as vendor_city',	'vendor.landmark as vendor_landmark',	'vendor.pincode as vendor_pincode',	'vendor.address as vendor_address',	'order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','sale_tax_register.total_amount','sale_tax_register.total_discount','sale_tax_register.shipping_charge','orders.vendor_id','users.unique_id as user_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.classno','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode',
             'orders.order_status','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
            ->first();
            
            
          if($order_data)
          {
                $paymentdata= DB::table('order_payment')->select('transaction_id','transaction_date')->where(['order_id'=>$id])->first();
                if($paymentdata)
                {
                   
                     $transaction_id=$paymentdata->transaction_id;
                     $transaction_date=$paymentdata->transaction_date;
                     
                }
                else
                {
                    $transaction_id="";
                    $transaction_date="";
                    
                }

            
            $file=Storage::disk('s3')->get('sales_report/'.$id.'.jsonp');
        	$getfile=json_decode ($file,true);
        	$iteminfo=array();   
        	$total_item=0;
            foreach($getfile as $data)
            {
              
                
                     // set item
                    if($data['item_type']==1)
                    { 
                    $itemdata['item_type']=1;
                    $itemdata['id']=$data['id'];
                    $itemdata['item_id']=$data['itemcode'];
                    $itemdata['itemname']=$data['itemname'];
                    $itemdata['weight']=$data['item_weight'];
                    $itemdata['cat']=$data['set_cat'];
                    $itemdata['rate']=$data['unit_price'];
                    $itemdata['discount_rate']=$data['unit_price']-$data['item_discount'];
                    $itemdata['discount']=$data['item_discount'];
                    $discount_rate=$data['unit_price']-$data['item_discount'];
                    $itemdata['total_without_gst']=$discount_rate-($discount_rate*$data['gst_title']/100);
                    $itemdata['qty']=$data['item_qty'];
                    $itemdata['gst']=$data['gst_title'];
                   
                    $gstval=100+$data['gst_title'];
                    $itemdata['without_gst_rate']=($discount_rate/$gstval)*100;
                    $itemdata['gst_rate']=$discount_rate-($discount_rate/$gstval)*100;
                    
                    $itemdata['item_ship_chr']=$data['item_ship_chr'];
                   
                    $itemdata['class']="";
                    $itemdata['size_medium']="";
                    
                    }
                    else
                    {
                     $size_medium=""; 
                     $managemastersizelistModel=managemastersizelistModel::where(['id'=>$data['size']])->first();  
                     if($managemastersizelistModel)
                     {
                        $size_medium=$managemastersizelistModel->title; 
                     }
                     //inventory item  
                    $itemdata['item_type']=0;
                    $itemdata['item_type']=0;
                    $itemdata['id']=$data['id'];
                    $itemdata['item_id']=$data['product_id'];
                    $itemdata['itemname']=$data['product_name'];
                    $itemdata['weight']=$data['net_weight'];
                    $itemdata['cat']=$data['catone'];
                    $itemdata['rate']=$data['mrp'];
                    $itemdata['discount_rate']=$data['mrp']-($data['mrp']*$data['discount'])/100;
                    $discount_rate=$data['mrp']-$data['discounted_price'];
                    $itemdata['discount']=($data['mrp']*$data['discount'])/100;
                    $itemdata['total_without_gst']=$discount_rate-($discount_rate*$data['gst_title']/100);
                    $itemdata['qty']=$data['item_qty'];
                    $itemdata['gst']=$data['gst_title'];
                    
                    $gstval=100+$data['gst_title'];
                    $itemdata['without_gst_rate']=($data['discounted_price']/$gstval)*100;
                    $itemdata['gst_rate']=$discount_rate-($discount_rate/$gstval)*100;
                    $itemdata['item_ship_chr']=$data['shipping_charges'];
                    
                    
                    
                    $itemdata['class']=$data['class_title'];
                    $itemdata['size_medium']=$size_medium;
                        
                    }  
                    
                    $item_traking_status=OrderTrackingModel::select('courier_number','tracking_status','status')->where(['invoice_number'=>$id,'item_id'=>$data['id'],'item_type'=>$data['item_type']])->first();
                    $itemdata['tracking_status']=$item_traking_status->tracking_status;
                    $itemdata['courier_number']=$item_traking_status->courier_number;
                    $itemdata['item_trk_status']=$item_traking_status->status;
                    array_push($iteminfo,$itemdata);
                    $total_item++;
                
            
             }    
            
            $order_data->total_item=$total_item; 
              $order_data->transaction_id=$transaction_id; 
            $order_data->transaction_date=$transaction_date; 
           
           
            $tracking=array();
            return view('orders_details', ['order' => $order_data,'item_info'=>$iteminfo,'tracking'=>$tracking]);
          }
          else
          {
             return redirect('search_order')->withErrors(['' => 'Invalid Order id!']);   
          }
        }
        else
        {
        
        //user all order
        
        $result=array();
        $where=array('users.phone_no'=>$request->search_key);
        $data= DB::table('orders')
            // ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->select('orders.shipping_charge','orders.order_status','orders.print_status','sale_tax_register.bill_id','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','sale_tax_register.total_amount','sale_tax_register.total_discount','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode',
            // 'order_payment.transaction_id','order_payment.transaction_date',
            //  DB::raw('IFNULL(order_payment.transaction_id, NULL) as transaction_id'),
            //  DB::raw('IFNULL(order_payment.transaction_date, NULL) as transaction_date'),
            'orders.invoice_number','orders.mode_of_payment')
            ->where($where)
            ->orderBy('sale_tax_register.id','desc')
            ->get();
        if($data)
        {
        for($i=0;$i<count($data);$i++)
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
              $tracking_update_status=DB::table('order_tracking')->select('courier_number','tracking_status','updated_at')->where(['invoice_number'=>$data[$i]->invoice_number])->distinct('courier_number','tracking_status','updated_at')->get();
              if($tracking_update_status)
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
              }
              
              $data[$i]->tracking_status=$tracking_status;
              
              array_push($result,$data[$i]);  
              
           
        }  
           return view('orders_search_by_user', ['orders' => $result]);
        }
        else
        {
               return redirect('search_order')->withErrors(['' => 'User not found with this phone number!']);   
        }
      }
}
    
    
//batch_underprocessing
public function batch_underprocessing()
{ 
        $result=array();
        $data=OrderBatchModel::where(['status'=>0])->orderBy('id','desc')->get();  
        
        for($i=0;$i<count($data);$i++)
        {  
          $vendor_id=explode(',',$data[$i]->vendor_id);
          $vendordata="";
          for($j=0;$j<count($vendor_id);$j++)
          {
              $vendor=VendorModel::where('unique_id', $vendor_id[$j])->first();
              $vendordata.="<p class='mb-1 py-1 px-1 border border-1'>".$vendor->username."<br>".$vendor->phone_no."<br>".$vendor->address.'</p>';
          }
          
          $data[$i]->vendor_info=$vendordata;
          array_push($result,$data[$i]);
        }  
        
        return view('batch_underprocessing', ['batch' => $result]);
}
    
    //bacth_all_order
    public function bacth_all_order(Request $request,$id)
    { 
      
        $result=array();
        $array_push=array();
        $where=array('sale_tax_register.batch_id'=>$id,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $orderdata= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->leftJoin('vendor','vendor.unique_id','=','sale_tax_register.vendor_id')
            ->select('orders.order_status','orders.user_id','orders.custom_set_status','vendor.unique_id as vendor_unique_id','sale_tax_register.created_at as inv_created_at','vendor.username as vendor_username',	'vendor.email as vendor_email',	'vendor.phone_no as vendor_phone_no',	'vendor.gst_no as vendor_gst_no',	'vendor.country as vendor_country',	'vendor.state as vendor_state',	'vendor.distt as vendor_distt',	'vendor.city as vendor_city',	'vendor.landmark as vendor_landmark',	'vendor.pincode as vendor_pincode',	'vendor.address as vendor_address',	'orders.print_status','sale_tax_register.bill_id','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','sale_tax_register.total_amount','sale_tax_register.total_discount','sale_tax_register.shipping_charge','sale_tax_register.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.classno','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment','orders.grand_total','orders.shipping_charge as total_shipping')
            ->where($where)
            ->where('orders.order_status','>=',3)
            ->orderBy('sale_tax_register.id','desc')
            ->get();
            
            
        for($i=0;$i<count($orderdata);$i++)
        {  
        //   if(in_array(session('id'),explode(',',$orderdata[$i]->vendor_id)))
        //   {
               
            $file=Storage::disk('s3')->get('sales_report/'.$orderdata[$i]->invoice_number.'.jsonp');
        	$getfile=json_decode ($file,true);
        	$iteminfo=array();   
            foreach($getfile as $data)
            {
                // set item
                if($data['item_type']==1)
                {  
                    $itemdata['item_id']=$data['itemcode'];
                    $itemdata['itemname']=$data['itemname'];
                    $itemdata['weight']=$data['item_weight'];
                    $itemdata['cat']=$data['set_cat'];
                    $itemdata['rate']=$data['unit_price'];
                    $itemdata['discount_rate']=$data['unit_price']-$data['item_discount'];
                    $itemdata['discount']=$data['item_discount'];
                    $discount_rate=$data['unit_price']-$data['item_discount'];
                    $itemdata['total_without_gst']=$discount_rate-($discount_rate*$data['gst_title']/100);
                    $itemdata['qty']=$data['item_qty'];
                    $itemdata['gst']=$data['gst_title'];
                   
                    $gstval=100+$data['gst_title'];
                    $itemdata['without_gst_rate']=($discount_rate/$gstval)*100;
                    $itemdata['gst_rate']=$discount_rate-($discount_rate/$gstval)*100;
                    
                    $itemdata['item_ship_chr']=$data['item_ship_chr'];
                    $itemdata['class']="";
                    $itemdata['size_medium']="";
                }
                else
                {
                $size_medium=""; 
                 $managemastersizelistModel=managemastersizelistModel::where(['id'=>$data['size']])->first();  
                 if($managemastersizelistModel)
                 {
                    $size_medium=$managemastersizelistModel->title; 
                 }
                 
                 //inventory item  
                $itemdata['item_id']=$data['product_id'];
                $itemdata['itemname']=$data['product_name'];
                $itemdata['weight']=$data['net_weight'];
                $itemdata['cat']=$data['catone'];
                $itemdata['rate']=$data['mrp'];
                $itemdata['discount_rate']=$data['mrp']-($data['mrp']*$data['discount'])/100;
                $discount_rate=$data['mrp']-$data['discount'];
                $itemdata['discount']=($data['mrp']*$data['discount'])/100;
                $itemdata['total_without_gst']=$discount_rate-($discount_rate*$data['gst_title']/100);
                $itemdata['qty']=$data['item_qty'];
                $itemdata['gst']=$data['gst_title'];
                
                $gstval=100+$data['gst_title'];
                $itemdata['without_gst_rate']=($discount_rate/$gstval)*100;
                $itemdata['gst_rate']=$discount_rate-($discount_rate/$gstval)*100;
                
                $itemdata['item_ship_chr']=$data['shipping_charges'];
                    
                $itemdata['class']=$data['class_title'];
                $itemdata['size_medium']=$size_medium;
                }
                    
                    array_push($iteminfo,$itemdata);
             }   
             
             
              $tracking_status=''; 
              $shipped_status=[];
              $tracking_update_status=DB::table('order_tracking')->select('courier_number','tracking_status','updated_at')->where(['invoice_number'=>$orderdata[$i]->invoice_number,'vendor_id'=>$orderdata[$i]->vendor_id])->distinct('courier_number','tracking_status','updated_at')->get();
              if($tracking_update_status)
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
                    
                     array_push($shipped_status,$trkingstatus->tracking_status); 
                     
                }
              }
              
              $orderdata[$i]->tracking_status=$tracking_status;
              $orderdata[$i]->shipped_status=array_unique($shipped_status);
             
              $array_push=['ordersinfo'=>$orderdata[$i],'item_info'=>$iteminfo];
              array_push($result,$array_push);  
           }
        
        $batchModel=OrderBatchModel::where(['id'=>$request->id])->first();
        return view('orders_in_batch',['data'=>$result,'batch_id'=>$id,'print_status'=>$batchModel->print_status]);
    }
    
    //order_print_status
    public function order_print_status(Request $request)
    {
        $OrdersModel=OrdersModel::where(['invoice_number'=>$request->order_id]);
        $updatet=$OrdersModel->update(['print_status'=>1]);  
        if($updatet)
        {
               $response['success']=1;
               $response['msg']='Updated Successfully!';
               $this->output($response); 
        }
        else
        {
               $response['success']=0;
               $response['msg']='Something Went Wrong!';
               $this->output($response); 
        }
                
    }
    
    //download_batch_xsl
    public function download_batch_xsl(string $id)
    {
        // 
        
        $where = array('orders.batch_id'=>$id,'order_tracking.vendor_id'=>session('id'));
        $data= DB::table('orders')
            ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'order_shipping_address.user_id')
            ->leftJoin('order_tracking', 'order_tracking.invoice_number', '=', 'orders.invoice_number')
            ->leftJoin('vendor', 'vendor.unique_id', '=', 'order_tracking.vendor_id')
            ->select(DB::raw('COUNT(order_tracking.invoice_number) as order_no'),'order_tracking.invoice_number','order_tracking.courier_number','vendor.phone_no as vendor_phone','users.email','order_shipping_address.name','order_shipping_address.phone_no','order_shipping_address.village','order_shipping_address.address','order_shipping_address.post_office','order_shipping_address.pincode','order_shipping_address.city','order_shipping_address.state','order_shipping_address.district')
            ->where($where)
            ->where('order_tracking.courier_number','!=',NULL)
            ->groupBy('order_tracking.courier_number')
            ->orderBy('order_tracking.id','asc')
            ->get();
   
        return view('orders_in_batch_xsl', ['data'=>$data]);
        
        
    }
    
    
    
   
    //pending_order	
    public function pending_order() {
        return view('orders_pending');
	}

    //update_pending_order
    public function update_pending_order(Request $request){
      
            $order= OrdersModel::where(['invoice_number'=>$request->oid])->first();
            if($order->order_status==1 || $order->order_status==2)
            {
                  $update=$order->update(['order_status'=>2,'payment_status'=>2]);
                  if($update)
                  {
                      
                      
                      
                      
                     $user = ManageuserStudentModel::where('unique_id',$order->user_id)->first();
                     if($user->email==NULL){$email='evyapari@hotmail.com';}else{$email=$user->email;}
          
                        $userData = [
                        'user_id'=>$user->unique_id,
                        'name' => $user->name, 
                        'mobile' => $user->phone_no, 
                        'email' => $email, 
                        'amount' => $request->total_amount,
                        'transaction_amount'=>$request->total_amount,
                        'transaction_id'=>$request->tid,
                        'transaction_status'=>'TXN_SUCCESS',
                        'transaction_date'=>date('Y-m-d H:i:s'),
                        'order_id' => $order->invoice_number,
                        'status' => 1, 
                        'pay_mode'=>$request->paymode,
                        ];
                        
                         
                      $isexist=Paytm::where(['order_id'=>$request->oid,'user_id'=>$user->unique_id])->first(); 
                      if($isexist)
                      {
                        $isexist->update( ['transaction_amount'=>$request->total_amount,'transaction_id'=>$request->tid,'transaction_status'=>'TXN_SUCCESS','transaction_date'=>date('Y-m-d H:i:s'),'order_id' => $order->invoice_number,'status' => 1, 'pay_mode'=>$request->paymode,]); 
                      }
                      else
                      {
                        Paytm::create($userData);
                      }
                      
                      return redirect()->back()->with('success', 'Submitted successfully.');
                      
                  }
                  else
                  {
                      return redirect('pending_order')->withErrors(['' => 'Somthing went wrong!']); 
                  }
            }
            else
            {
                return redirect('pending_order')->withErrors(['' => 'Order already updated Check in new orders or in processing orders']); 
            }
          
	}

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  

// //update_pending_order	
// 	//get_payment_status
//     public function get_payment_status(Request $request) {
        
//         $payment_status= DB::table('order_payment')
//                 ->leftjoin('users','users.unique_id','=','order_payment.user_id')
//                 ->select('order_payment.order_id','order_payment.status','order_payment.transaction_id','order_payment.transaction_amount','users.name')
//                 ->where(['order_payment.order_id'=>$request->order_id,'order_payment.user_id'=>$request->user_id])
//                 ->first();  
                
//         if($payment_status->status==0)
//         {
//             $msg="Your payment is failed! reattempt the transaction.";
//         }
//         elseif($payment_status->status==1)
//         {
//             $msg="Your payment is successfull.";
//         }
//         elseif($payment_status->status==2)
//         {
//             $msg="Your payment is processing.";
//         }
//         else
//         {
//              $msg="Something went wrong!";
//         }
        
//         $response = ['success' => 1,'message'=>$msg,'data' => $payment_status,];
//         return response()->json($response, 200);
// 	}
		

	
// 	//get_payment_status
//     public function get_payment_status(Request $request) {
        
//         $payment_status= DB::table('order_payment')
//                 ->leftjoin('users','users.unique_id','=','order_payment.user_id')
//                 ->select('order_payment.order_id','order_payment.status','order_payment.transaction_id','order_payment.transaction_amount','users.name')
//                 ->where(['order_payment.order_id'=>$request->order_id,'order_payment.user_id'=>$request->user_id])
//                 ->first();  
                
//         if($payment_status->status==0)
//         {
//             $msg="Your payment is failed! reattempt the transaction.";
//         }
//         elseif($payment_status->status==1)
//         {
//             $msg="Your payment is successfull.";
//         }
//         elseif($payment_status->status==2)
//         {
//             $msg="Your payment is processing.";
//         }
//         else
//         {
//              $msg="Something went wrong!";
//         }
        
//         $response = ['success' => 1,'message'=>$msg,'data' => $payment_status,];
//         return response()->json($response, 200);
// 	}
	

	
//     //proceedToCheckout
//     public function proceedToCheckout(Request $request)
//     {
//         $user_id = $request->user_id;
//         $shipping_address_id = $request->shipping_address_id;
//         $invoice_number=date("YmdHis")."-".$user_id."-".$this->createRandomKey();
//         $order_date=date("d");
// 		$order_month=date("m");
// 		$order_year=date("Y");
// 		$order_time=date("Y-m-d H:i:s");
//         $order_total_without_shipping=0;
//         $shipping_charge=0;
//         $order_weight=0;
//         $totaldiscount=0;
//         $bill_no="";
//         $lastsetid="";
//         $lastvendorid="";
//         $orderarray=array();
        
      
		
//         $user = Users::where('unique_id',$user_id)->first();
//         $cart_items = CartModel::where('user_id', $user_id)->orderBy('id','asc')->get();
//         $allvendor_id=array();
//         $oldvendor_id='';
//         //Order Item
//         foreach($cart_items as $cartitem)
//         {
            
          
//             if($cartitem->item_type==0)
//             {
//                 $data= DB::table('inventory_new')
//                 ->leftjoin('inventory_cat','inventory_cat.cat_four', '=', 'inventory_new.cat_id')
//                 ->leftjoin('master_taxes','master_taxes.id', '=', 'inventory_new.gst')
//                 ->leftjoin('master_brand','master_brand.id', '=', 'inventory_new.brand')
//                 ->leftjoin('master_stream','master_stream.id', '=', 'inventory_new.stream')
//                 ->leftjoin('master_classes','master_classes.id', '=', 'inventory_new.class')
//                 ->leftjoin('master_qty_unit','master_qty_unit.id', '=', 'inventory_new.qty_unit')
//                 ->select('inventory_new.*','master_classes.title as class_title','master_stream.title as stream_title','master_brand.title as brand_title','inventory_cat.cat_one','inventory_cat.cat_two','inventory_cat.cat_three','inventory_cat.cat_four','master_taxes.title as gst_title')
//                 ->where(['inventory_new.id'=>$cartitem->product_id])
//                 ->first();  
                
//                 //item cat
//                 $cat_one = CatOne::select('name')->where('id', $data->cat_one)->first();
//                 if($cat_one){$data->catone=$cat_one->name;}else{$data->catone='';}
               
//                 $cat_two = CatTwo::select('name')->where('id', $data->cat_two)->first();
//                  if($cat_two){$data->cattwo=$cat_two->name;}else{$data->cattwo='';}
                
//                 $cat_three = CatThree::select('title')->where('id', $data->cat_three)->first();
//                  if($cat_three){$data->catthree=$cat_three->title;}else{$data->catthree='';}
               
//                 $cat_four = CatFour::select('title')->where('id', $data->cat_four)->first();
//                  if($cat_four){$data->catfour=$cat_four->title;}else{$data->catfour='';}
                 
                 
//                  //item images
//                  $allimages="";
//                  $inv_images = InventoryImgModel::where(['item_id'=>$data->id])->get();
//                  foreach($inv_images as $invimages)
//                   {
//                      $allimages.=$invimages->image.",";
 
//                   }
                  
//                  $data->item_order_status=1;
//                  $data->order_billno='BILL-'.$invoice_number."-".$data->vendor_id;
//                  $data->item_images=$allimages;
                 
//                  $order_total_without_shipping+=$data->mrp;
//                  $totaldiscount+=$data->mrp-$data->discounted_price;
//                  $shipping_charge+=$data->shipping_charges;
//                  $order_weight+=$data->net_weight;
	        
	
// 	                  //order tracking
// 	                    $inventory_new_item = InventoryNewModel::where('id', $cartitem->product_id)->first();
//                         $order_tracking_data = [
//                             'invoice_number'=>$invoice_number,
//                             'product_id'=>$inventory_new_item->product_id,
//                             'item_id'=>$inventory_new_item->id,
//                             'item_type'=>0,
//                             'qty'=>$cartitem->qty,
//                             'vendor_id'=>$inventory_new_item->vendor_id,
//                             'created_by'=>$inventory_new_item->created_by,
//                         ];
//                       OrderTrackingModel::create($order_tracking_data);
//                       if($oldvendor_id!=$inventory_new_item->vendor_id){array_push($allvendor_id,$inventory_new_item->vendor_id);}
//                       $oldvendor_id=$inventory_new_item->vendor_id;
//             }
//             else
//             {
//                 $data= DB::table('inventory')
//                 ->leftjoin('master_taxes','master_taxes.id', '=', 'inventory.gst')
//                 ->leftjoin('master_classes','master_classes.id', '=', 'inventory.class')
//                 ->select('master_classes.title as class_title','master_taxes.title as gst_title','inventory.*')
//                 ->where(['inventory.id'=>$cartitem->product_id])
//                 ->first(); 
            
//                 $iteminfo=SchoolSetVendorModel::where(array('vendor_id'=>$cartitem->vendor_id,'set_id'=>$cartitem->set_id))->first(); 
              
//                 $item_id=explode(",",$iteminfo->item_id);
//                 $item_qty=explode(",",$iteminfo->item_qty);
//                 $item_discount=explode(",",$iteminfo->item_discount);
                
                
//                 $setdiscount=0;
//                 $setitemmrp=0;
//                 $set_ship=0;
//                 for($j=0;$j<count($item_id);$j++)
//                 {
//                     if($item_id[$j]==$cartitem->product_id)
//                     {
//                         $setdiscount=(($data->unit_price*$item_qty[$j])*$item_discount[$j])/100;
//                         $setitemmrp=$data->unit_price*$item_qty[$j];
                        
//                         if($j==0 && $iteminfo->set_id!=$lastsetid )
//                         {
//                             $set_ship=$iteminfo->shipping_charges;
//                         }
                       
//                     }
//                 }
                
                
//                  $lastsetid=$iteminfo->set_id;
//                  $lastvendorid=$iteminfo->vendor_id;
//                  $data->item_order_status=1;
//                  $data->order_billno='BILL-'.$invoice_number."-".$cartitem->vendor_id;
//                  $data->set_type=$cartitem->set_type;
//                  $data->set_id=$cartitem->set_id;
//                  $data->vendor_id=$iteminfo->vendor_id;
//                  $data->size=$cartitem->size;
//                  $order_total_without_shipping+=$setitemmrp;
//                  $totaldiscount+=$setdiscount;
//                  $shipping_charge+=$set_ship;
//                  $order_weight+=$data->item_weight;
                 
                       
//                       //order tracking
//                         $inventory_item = InventoryModel::where('id', $cartitem->product_id)->first();
//                         $order_tracking_data = [
//                             'invoice_number'=>$invoice_number,
//                             'product_id'=>$inventory_item->itemcode,
//                             'item_id'=>$inventory_item->id,
//                             'item_type'=>1,
//                             'vendor_id'=>$cartitem->vendor_id,
//                             'set_id'=>$cartitem->set_id,
//                             'qty'=>$cartitem->qty,
//                             // 'created_by'=>$inventory_item->created_by,
//                         ];
//                         OrderTrackingModel::create($order_tracking_data);
                        
//                  if($oldvendor_id!=$cartitem->vendor_id){array_push($allvendor_id,$cartitem->vendor_id);}
//                  $oldvendor_id=$cartitem->vendor_id;
            
//             }
            
// 	      array_push($orderarray,$data);
            
//         }
        
        
        
        
//          Storage::disk('s3')->put('sales_report/'.$invoice_number.'.jsonp', json_encode($orderarray, JSON_PRETTY_PRINT));
//          $delitem=CartModel::where('user_id', $user_id)->delete();

//          //Order Shipping Address
//         if($shipping_address_id!=0){
//             $address = UserAddressesModel::where(['user_id'=>$user_id, 'id'=>$shipping_address_id])->first();
//             if($address->address_type=="1") 
//             {
//                 $order_address_data = [
//                     'user_id'=>$user_id,
//                     'invoice_number'=>$invoice_number,
//                     'address_type'=>$address->address_type,
//                     'name'=>$address->name,
//                     'phone_no'=>$address->phone_no,
//                     'school_code'=>$address->school_code,
//                     'alternate_phone'=>$address->alternate_phone,
//                     'village'=>$address->village,
//                     'address'=>$address->address,
//                     'post_office'=>$address->post_office,
//                     'pincode'=>$address->pincode,
//                     'city'=>$address->city,
//                     'state'=>$address->state,
//                     'district'=>$address->district,
//                 ];  
//             }
//             else
//             {
//                 $school = SchoolModel::where(['school_code'=>$address->school_code, 'del_status'=>0])->first();
                
//                 $order_address_data = [
//                     'user_id'=>$user_id,
//                     'invoice_number'=>$invoice_number,
//                     'address_type'=>2,
//                     'name'=>$address->name,
//                     'phone_no'=>$school->school_phone,
//                     'school_code'=>$address->school_code,
//                     'school_name'=>$school->school_name,
//                     'alternate_phone'=>$address->alternate_phone,
//                     'village'=>$school->village,
//                     'address'=>$school->landmark,
//                     'post_office'=>$school->post_office,
//                     'pincode'=>$school->zipcode,
//                     'city'=>$school->city,
//                     'state'=>$school->state,
//                     'district'=>$school->distt,
//                 ];  
//             }
            
//         }
//         else 
//         {
//             $order_address_data = [
//                 'user_id'=>$user_id,
//                 'invoice_number'=>$invoice_number,
//                 'address_type'=>1,
//                 'name'=>$user->name,
//                 'phone_no'=>$user->phone_no,
//                 'school_code'=>$user->school_code,
//                 // 'alternate_phone'=>$user->alternate_phone,
//                 'village'=>$user->village,
//                 'address'=>$user->address,
//                 'post_office'=>$user->post_office,
//                 'pincode'=>$user->pincode,
//                 'city'=>$user->city,
//                 'state'=>$user->state,
//                 'district'=>$user->district,
//             ];
            
            
//             $address = UserAddressesModel::where(['user_id'=>$user_id, 'default_address'=>1]);
//             if($address)
//             {
//                 $address->update(['default_address'=>0]);
//             }
          
//             $billing_address=[
//                 "user_id"=>$user_id,
//                 "address_type"=>1,
//                 "default_address"=>1,
//                 "name"=>$user->name,
//                 "phone_no"=>$user->phone_no,
//                 // "alternate_phone"=>$request->alternate_phone,
//                 "village"=>$user->village,
//                 "city"=>$user->city,
//                 "state"=>$user->state,
//                 "district"=>$user->district,
//                 "post_office"=>$user->post_office,
//                 "pincode"=>$user->pincode,
//                 "address"=>$user->address,
//             ];  
        
//             $add_to_shippingaddress= UserAddressesModel::create($billing_address);
        
//         }
//       $store_ship_add=OrderShippingAddressModel::create($order_address_data);
//       //Order Shipping Address end
       
       
       
        
//         //orders
//         $order_data = [
//             'invoice_number'=>$invoice_number,
//             'user_id'=>$user->unique_id,
//             'vendor_id'=>implode(',',$allvendor_id),
//             'user_type'=>$user->user_type,
//             'class'=>$user->classno,
//             'mode_of_payment'=>$request->mode_of_payment,
//             'order_total'=>$order_total_without_shipping,
//             'grand_total'=>($order_total_without_shipping-$totaldiscount)+$shipping_charge,
//             'shipping_charge'=>$shipping_charge,
//             'discount'=>$totaldiscount,
//             'order_date'=>$order_date,
//             'order_month'=>$order_month,
//             'order_year'=>$order_year,
//             'order_time'=>$order_time,
//             'order_weight'=>$order_weight,
            
//         ];
//         $order=OrdersModel::create($order_data);
   
     
//         $res = [
//             'user_id'=>$user_id, 
//             'shipping_address_id'=>$shipping_address_id,
//             'invoice_number'=>$invoice_number,
//             'order_time'=>$order_time,
//             // 'transaction_id'=>$transaction_id,
//         ];
//         $response = ['success' => 1,'message'=>'successfully','data' => $res,];
//         return response()->json($response, 200);
//     }
   
//   //orderPreview
//     public function orderPreview(Request $request)
//     {
//         $user_id = $request->user_id;
//         $invoice_number=$request->invoice_number;
//         $myorder= OrdersModel::where(['user_id'=>$user_id, 'invoice_number'=>$invoice_number])->first();
//         $myaddress = OrderShippingAddressModel::where(['user_id'=>$user_id, 'invoice_number'=>$invoice_number])->first();
        
//         $all_items = OrderTrackingModel::where(['invoice_number'=>$invoice_number])->get();
//         $count=count($all_items);
//         $ordered_items=[];
//         for($i=0;$i<$count;$i++)
//         {
//             if($all_items[$i]->item_type==0)
//             {
//                 $data= DB::table('order_tracking')
//                 ->leftjoin('inventory_new', 'order_tracking.item_id', '=', 'inventory_new.id') 
//                 ->leftjoin('inventory_images', 'inventory_images.item_id', '=', 'inventory_new.id')
//                 ->leftjoin('master_colour', 'master_colour.id', '=', 'inventory_new.color')
//                 ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
//                 ->leftjoin('vendor', 'inventory_new.vendor_id', '=', 'vendor.unique_id')
//                 ->leftjoin('size_list', 'size_list.id', '=', 'inventory_new.size')
//                 ->leftjoin('sizes', 'sizes.id', '=', 'size_list.size_id')
//                 ->select('vendor.username as vendor_name','order_tracking.item_type','order_tracking.qty','order_tracking.vendor_id','master_colour.title as product_color','size_list.title as product_size','master_classes.title as class_title','inventory_new.shipping_charges','inventory_new.product_name','inventory_new.discounted_price','inventory_new.mrp', 'inventory_new.description','inventory_new.id','inventory_images.image','inventory_images.folder','inventory_images.alt')
//                 ->where(['order_tracking.item_type'=>0,'inventory_new.id'=>$all_items[$i]->item_id,'inventory_images.dp_status'=>1])
//                 ->first();
//             }
//             else 
//             {
//                 $data= DB::table('order_tracking')
//                 ->leftjoin('inventory', 'order_tracking.item_id', '=', 'inventory.id') 
//                 ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory.class')
//                 ->leftjoin('vendor', 'order_tracking.vendor_id', '=', 'vendor.unique_id')
//                 ->select('vendor.username as vendor_name','order_tracking.item_type','order_tracking.vendor_id','order_tracking.qty','master_classes.title as class_title','inventory.cover_photo as image','inventory.itemname as product_name','inventory.discount','inventory.unit_price', 'inventory.description','inventory.id')
//                 ->where(['order_tracking.item_type'=>1,'inventory.id'=>$all_items[$i]->item_id])
//                 ->first(); 
                
//                 $iteminfo=SchoolSetVendorModel::where(array('vendor_id'=>$all_items[$i]->vendor_id,'set_id'=>$all_items[$i]->set_id,'del_status'=>0))->first();
              
//                 $item_id=explode(",",$iteminfo->item_id);
//                 $item_qty=explode(",",$iteminfo->item_qty);
//                 $item_discount=explode(",",$iteminfo->item_discount);
                
//                 for($j=0;$j<count($item_id);$j++)
//                 {
//                     if($item_id[$j]==$data->id)
//                     {
//                         $discount=(($data->unit_price*$item_qty[$j])*$item_discount[$j])/100;
                        
//                         $data->mrp=$data->unit_price*$item_qty[$j];
//                         $data->discounted_price=($data->unit_price*$item_qty[$j])-$discount;
//                     }
//                 }
//             }
//              array_push($ordered_items, $data);
//         }
        
//         $res = [
//             'order_address'=>$myaddress,
//             'ordered_items' => $ordered_items,
//             'invoice_number'=>$invoice_number,
//             'shipping_charge'=>$myorder->shipping_charge, 
//             'order_total_without_shipping'=>$myorder->order_total, 
//             'discount'=>$myorder->discount, 
//             'grand_total'=>$myorder->grand_total, 
//             'order_date'=>$myorder->order_time, 
//             'order_status'=>$myorder->order_status,
//         ];
//         $response = ['success' => 1,'message' => 'successfull','data' => $res,];
//         return response()->json($response, 200);
    
//     }
   
    
//     //updateOrderShippingAddress
//     public function updateOrderShippingAddress(Request $request)
//     {
//         $user_id = $request->user_id;
//         $invoice_number=$request->invoice_number;
//         $address_id = $request->address_id;
        
//         $new_address = UserAddressesModel::where(['id'=>$address_id,'user_id'=>$user_id,])->first();
//         $order_address = OrderShippingAddressModel::where(['user_id'=>$user_id, 'invoice_number'=>$invoice_number]);
        
//         if($new_address->address_type==1)
//         {
//             $updateData = [
//                 'user_id'=>$user_id,
//                 'invoice_number'=>$invoice_number,
//                 'address_type'=>$new_address->address_type,
//                 'name'=>$new_address->name,
//                 'phone_no'=>$new_address->phone_no,
//                 'school_code'=>$new_address->school_code,
//                 'alternate_phone'=>$new_address->alternate_phone,
//                 'village'=>$new_address->village,
//                 'address'=>$new_address->address,
//                 'post_office'=>$new_address->post_office,
//                 'pincode'=>$new_address->pincode,
//                 'city'=>$new_address->city,
//                 'state'=>$new_address->state,
//                 'district'=>$new_address->district,
//             ];
//         }
//         else 
//         {
//             $school = SchoolModel::where(['school_code'=>$new_address->school_code, 'del_status'=>0])->first();
//             $updateData = [
//                 'user_id'=>$user_id,
//                 'invoice_number'=>$invoice_number,
//                 'address_type'=>2,
//                 'name'=>$new_address->name,
//                 'phone_no'=>$school->school_phone,
//                 'school_code'=>$new_address->school_code,
//                 'school_name'=>$school->school_name,
//                 'alternate_phone'=>$new_address->alternate_phone,
//                 'village'=>$school->village,
//                 'address'=>$school->landmark,
//                 'post_office'=>$school->post_office,
//                 'pincode'=>$school->zipcode,
//                 'city'=>$school->city,
//                 'state'=>$school->state,
//                 'district'=>$school->distt,
//             ];  
//         }
        
//         $order_address->update($updateData);
        
//         $response = ['success' => 1,'message' => 'successfull','data' => null];
//         return response()->json($response, 200);
//     }
    
//     //getMyOrders
//     public function getMyOrders(Request $request)
//     {
//         $user_id = $request->user_id;
//         $orders = OrdersModel::where(['user_id'=>$user_id])->orderBy('id','desc')->get();
//         $response = ['success' => 1,'message' => 'successfull','data' => $orders,];
//         return response()->json($response, 200);
//     }
    
//     //getOrderDetails
//     public function getOrderDetails(Request $request)
//     {
//         $user_id = $request->user_id;
//         $invoice_number=$request->invoice_number;
        
//         $myorder= OrdersModel::where(['user_id'=>$user_id, 'invoice_number'=>$invoice_number])->first();
//         $myaddress = OrderShippingAddressModel::where(['user_id'=>$user_id, 'invoice_number'=>$invoice_number])->first();
//         $ordered_payment=Paytm::select('order_id','status','transaction_id','transaction_amount')->where(['order_id'=>$request->invoice_number,'user_id'=>$request->user_id])->first();
     
            
//         if($myorder->order_status!=1)
//         {
//             $all_items = OrderTrackingModel::where(['invoice_number'=>$invoice_number])->get();
//             $count=count($all_items);
//             $ordered_items=[];
//             for($i=0;$i<$count;$i++)
//             {
//                 if($all_items[$i]->item_type==0)
//                 {
//                     $data= DB::table('order_tracking')
//                     ->leftjoin('inventory_new', 'order_tracking.item_id', '=', 'inventory_new.id') 
//                     ->leftjoin('inventory_images', 'inventory_images.item_id', '=', 'inventory_new.id')
//                     ->leftjoin('master_colour', 'master_colour.id', '=', 'inventory_new.color')
//                     ->leftjoin('vendor', 'inventory_new.vendor_id', '=', 'vendor.unique_id')
//                     ->leftjoin('size_list', 'size_list.id', '=', 'inventory_new.size')
//                     ->leftjoin('sizes', 'sizes.id', '=', 'size_list.size_id')
//                     ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
//                     ->select('vendor.username as vendor_name','order_tracking.item_type','order_tracking.qty','order_tracking.vendor_id','master_colour.title as product_color','size_list.title as product_size','master_classes.title as class_title','inventory_new.shipping_charges','inventory_new.product_name','inventory_new.discounted_price','inventory_new.mrp', 'inventory_new.description','inventory_new.id','inventory_images.image','inventory_images.folder','inventory_images.alt')
//                     ->where(['order_tracking.item_type'=>0,'inventory_new.id'=>$all_items[$i]->item_id,'inventory_images.dp_status'=>1])
//                     ->first();
//                 }
//                 else 
//                 {
//                     $data= DB::table('order_tracking')
//                     ->leftjoin('inventory', 'order_tracking.item_id', '=', 'inventory.id') 
//                     ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory.class')
//                     ->leftjoin('vendor', 'order_tracking.vendor_id', '=', 'vendor.unique_id')
//                     ->select('vendor.username as vendor_name','order_tracking.item_type','order_tracking.vendor_id','order_tracking.qty','master_classes.title as class_title','inventory.cover_photo as image','inventory.itemname as product_name','inventory.discount','inventory.unit_price', 'inventory.description','inventory.id')
//                     ->where(['order_tracking.item_type'=>1,'inventory.id'=>$all_items[$i]->item_id])
//                     ->first(); 
                    
//                     $iteminfo=SchoolSetVendorModel::where(array('vendor_id'=>$all_items[$i]->vendor_id,'set_id'=>$all_items[$i]->set_id,'del_status'=>0))->first();
                  
//                     $item_id=explode(",",$iteminfo->item_id);
//                     $item_qty=explode(",",$iteminfo->item_qty);
//                     $item_discount=explode(",",$iteminfo->item_discount);
                    
//                     for($j=0;$j<count($item_id);$j++)
//                     {
//                         if($item_id[$j]==$data->id)
//                         {
//                             $discount=(($data->unit_price*$item_qty[$j])*$item_discount[$j])/100;
                            
//                             $data->mrp=$data->unit_price*$item_qty[$j];
//                             $data->discounted_price=($data->unit_price*$item_qty[$j])-$discount;
//                         }
//                     }
//                 }
//                  array_push($ordered_items, $data);
//         }
        
//             $res = [ 
//             'ordered_payment_info' => $ordered_payment,
//             'order_address'=>$myaddress,
//             'ordered_items' => $ordered_items,
//             'invoice_number'=>$invoice_number,
//             'shipping_charge'=>$myorder->shipping_charge, 
//             'order_total_without_shipping'=>$myorder->order_total, 
//             'discount'=>$myorder->discount, 
//             'grand_total'=>$myorder->grand_total, 
//             'order_date'=>$myorder->order_time, 
//             'order_status'=>$myorder->order_status,
//         ];
//             $response = ['success' => 1,'message' => 'successfull','data' => $res,];
//             return response()->json($response, 200);
//         }
//         else
//         {
//             // $res = ['address'=>$user_id];
//             $response = ['success' => 1,'message' => 'placed','data' => $myorder,];
//             return response()->json($response, 200);
//         }
//     }
   
  
//     //orderShippingAddress
//     public function orderShippingAddress(Request $request)
//     {
//         $user_id = $request->user_id;
//         $invoice_number=$request->invoice_number;
        
//         $address = OrderShippingAddressModel::where(['user_id'=>$user_id, 'invoice_number'=>$invoice_number])->first();
        
//         $response = ['success' => 1,'message' => 'successfull','data' => $address,];
//         return response()->json($response, 200);
//     }
    
//   //getOrderedItems
//     public function getOrderedItems(Request $request)
//     {
//         $invoice_number=$request->invoice_number;
        
//         $all_items = OrderTrackingModel::where(['invoice_number'=>$invoice_number])->get();
//         $count=count($all_items);
//         $res=[];
//         for($i=0;$i<$count;$i++)
//         {
//             if($all_items[$i]->item_type==0)
//             {
//                 $data= DB::table('order_tracking')
//                 ->leftjoin('inventory_new', 'order_tracking.item_id', '=', 'inventory_new.id') 
//                 ->leftjoin('inventory_images', 'inventory_images.item_id', '=', 'inventory_new.id')
//                 ->leftjoin('master_colour', 'master_colour.id', '=', 'inventory_new.color')
//                 ->leftjoin('size_list', 'size_list.id', '=', 'inventory_new.size')
//                 ->leftjoin('sizes', 'sizes.id', '=', 'size_list.size_id')
//                 ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
//                 ->select('order_tracking.item_type','order_tracking.qty','order_tracking.vendor_id','master_colour.title as product_color','size_list.title as product_size','master_classes.title as class_title','inventory_new.shipping_charges','inventory_new.product_name','inventory_new.discounted_price','inventory_new.mrp', 'inventory_new.description','inventory_new.id','inventory_images.image','inventory_images.folder','inventory_images.alt')
//                 ->where(['order_tracking.item_type'=>0,'inventory_new.id'=>$all_items[$i]->item_id,'inventory_images.dp_status'=>1])
//                 ->first();
//             }
//             else 
//             {
//                 $data= DB::table('order_tracking')
//                 ->leftjoin('inventory', 'order_tracking.item_id', '=', 'inventory.id') 
//                 ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory.class')
//                 ->select('order_tracking.item_type','order_tracking.vendor_id','order_tracking.qty','master_classes.title as class_title','inventory.cover_photo as image','inventory.itemname as product_name','inventory.discount','inventory.unit_price', 'inventory.description','inventory.id')
//                 ->where(['order_tracking.item_type'=>1,'inventory.id'=>$all_items[$i]->item_id])
//                 ->first(); 
                
//                 $iteminfo=SchoolSetVendorModel::where(array('vendor_id'=>$all_items[$i]->vendor_id,'set_id'=>$all_items[$i]->set_id,'del_status'=>0))->first();
              
//                 $item_id=explode(",",$iteminfo->item_id);
//                 $item_qty=explode(",",$iteminfo->item_qty);
//                 $item_discount=explode(",",$iteminfo->item_discount);
                
//                 for($j=0;$j<count($item_id);$j++)
//                 {
//                     if($item_id[$j]==$data->id)
//                     {
//                         $discount=(($data->unit_price*$item_qty[$j])*$item_discount[$j])/100;
                        
//                         $data->mrp=$data->unit_price*$item_qty[$j];
//                         $data->discounted_price=($data->unit_price*$item_qty[$j])-$discount;
//                     }
//                 }
//             }
//              array_push($res, $data);
//         }
        
//         $response = ['success' => 1,'message' => 'successfull','data' => $res,];
//         return response()->json($response, 200);
//     }

   public function payoutBill()
    {
        // Select only the fields you want to display
        
     $vendors = DB::table('vendor')->select('unique_id', 'state_code', 'username','state','phone_no')->where('del_status',0)->get();

    // Pass data to view
    return view('PayoutBill', compact('vendors'));
        // Return payoutbill view with vendors data
        
    }
    public function viewAllVendorOrders(Request $request, $vendor_id)
{
    // Fetch all relevant orders for the vendor with necessary joins
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

    return view('viewall', [
        'orders' => $groupedOrders,
        'vendor_id' => $vendor_id,
     
    ]);
}



}












