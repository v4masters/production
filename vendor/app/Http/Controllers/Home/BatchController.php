<?php
   
namespace App\Http\Controllers\Home;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Home;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;


use App\Models\OrdersModel;
use App\Models\OrderBatch;
use App\Models\managemastersizelistModel;
use App\Models\SaleTaxRegister;
   
class BatchController extends Controller
{
    
    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }
    
    
	//create_batch
   public function create_batch(Request $request)
    { 
            $order_id=$request->invoice_number;
            $count=count($order_id);
            $lastid=OrderBatch::select('batch_no')->orderBy('batch_no','desc')->where('vendor_id',session('id'))->first();  
            if($lastid)
            {
                $batchid='BATCH-'.$lastid->batch_no+1;
                $bid=$lastid->batch_no+1;
            }
            else
            {
                $batchid='BATCH-01';
                $bid=1;
            }

            $data=[
                'batch_no'=>$bid,
                'batch_id'=>$batchid,
                'vendor_id'=>session('id'),
                'total_order'=>$count,
                'comment'=>$request->comment,
                'pp_status'=>$request->pp_status,
                'batch_status'=>1
                ];
            
            $OrderBatch=OrderBatch::create($data);
            if($OrderBatch)
            {
                    $row=0;
                    foreach($order_id as $inv_no)
                    {
                      $orderupdate=SaleTaxRegister::where(['order_id'=>$inv_no,'vendor_id'=>session('id')])->first();
                      $orderupdate->update(['batch_id'=>$OrderBatch->id,'batch_status'=>1]);
                      $row++;  
                    }
                    
                       if($row==$count)
                      {
                             if($request->pp_status==0){
                                return redirect('bacth_order')->with('success', 'Batch Created successfully.');
                             }
                             else
                             {
                                  return redirect('pp_bacth_order')->with('success', 'Batch Created successfully.');
                             }
                      }
                      else
                      {
                             return redirect('order_under_process')->withErrors(['' => 'Somthing went wrong!']);
                      }
            }
            else
            {
                 return redirect('order_under_process')->withErrors(['' => 'Somthing went wrong!']);
            }
            
    }
   /* public function create_batch(Request $request)
{
    $order_ids = $request->invoice_number;

    if (!is_array($order_ids)) {
        $order_ids = $order_ids ? [$order_ids] : [];
    }

    if (empty($order_ids)) {
        return back()->with('error', 'No orders selected.');
    }

    $count = count($order_ids);

    $lastBatch = OrderBatch::where('vendor_id', session('id'))
        ->orderByDesc('batch_no')
        ->first();

    $nextBatchNo = $lastBatch ? $lastBatch->batch_no + 1 : 1;

    foreach ($order_ids as $invoice_number) {
        OrderBatch::create([
            'invoice_number' => $invoice_number,
            'vendor_id' => session('id'),
            'batch_no' => $nextBatchNo,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    return back()->with('success', "Batch #{$nextBatchNo} created for {$count} orders.");
}*/

    
    //bacth_order
    public function bacth_order()
    { 
        // $data=OrderBatch::where(['status'=>0,'vendor_id'=>session('id')])->orderBy('id','desc')->get();
       
        $where=array('order_under_batch.pp_status'=>0,'sale_tax_register.order_status'=>3,'order_under_batch.status'=>0,'order_under_batch.vendor_id'=>session('id'));
        $data= DB::table('order_under_batch')
            ->leftJoin('sale_tax_register', 'sale_tax_register.batch_id', '=', 'order_under_batch.id')
            ->leftJoin('orders', 'orders.invoice_number', '=', 'sale_tax_register.order_id')
            ->select('order_under_batch.*')
            ->where($where)
            ->groupBy('sale_tax_register.batch_id')
            ->orderBy('order_under_batch.id','desc')
            ->get();
            
          
            
   
        return view('order_batch_in_proccess', ['batch' => $data]);
    }
    
    //bacth_all_order
    
public function bacth_all_order(Request $request, $id, $bid)
{
    $result = [];
    $where = [
        'sale_tax_register.order_status' => 3,
        'sale_tax_register.batch_id' => $id,
        'sale_tax_register.vendor_id' => session('id'),
        'orders.payment_status' => 2,
        'order_payment.status' => 1,
        'orders.status' => 1
    ];

    $orderdata = DB::table('orders')
        ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->leftJoin('sale_tax_register', 'sale_tax_register.order_id', '=', 'orders.invoice_number')
        ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
        ->leftJoin('vendor', 'vendor.unique_id', '=', 'sale_tax_register.vendor_id')
        ->select(
            'orders.custom_set_status', 'orders.grand_total', 'vendor.unique_id as vendor_unique_id',
            'sale_tax_register.created_at as inv_created_at', 'vendor.username as vendor_username',
            'vendor.email as vendor_email', 'vendor.phone_no as vendor_phone_no',
            'vendor.gst_no as vendor_gst_no', 'vendor.country as vendor_country',
            'vendor.state as vendor_state', 'vendor.distt as vendor_distt', 'vendor.city as vendor_city',
            'vendor.landmark as vendor_landmark', 'vendor.pincode as vendor_pincode',
            'vendor.address as vendor_address', 'sale_tax_register.print_status', 'sale_tax_register.bill_id',
            'order_shipping_address.address_type as ship_address_type',
            'order_shipping_address.name as ship_name', 'order_shipping_address.phone_no as ship_phone_no',
            'order_shipping_address.school_code as ship_school_code',
            'order_shipping_address.school_name as ship_school_name',
            'order_shipping_address.alternate_phone as ship_alternate_phone',
            'order_shipping_address.village as ship_village', 'order_shipping_address.address as ship_address',
            'order_shipping_address.post_office as ship_post_office',
            'order_shipping_address.pincode as ship_pincode', 'order_shipping_address.city as ship_city',
            'order_shipping_address.state as ship_state', 'order_shipping_address.state_code as ship_state_code',
            'order_shipping_address.district as ship_district',
            'sale_tax_register.total_amount', 'sale_tax_register.total_discount',
            'sale_tax_register.shipping_charge', 'orders.vendor_id',
            'users.user_type', 'users.name', 'users.fathers_name', 'users.phone_no',
            'users.school_code', 'users.state', 'users.district', 'users.city', 'users.post_office',
            'users.village', 'users.classno', 'users.address', 'users.landmark', 'users.pincode',
            'order_payment.transaction_id', 'order_payment.transaction_date',
            'orders.invoice_number', 'orders.mode_of_payment', 'orders.grand_total',
            'orders.shipping_charge as total_shipping'
        )
        ->where($where)
        ->orderBy('sale_tax_register.id', 'desc')
        ->get();

    for ($i = 0; $i < count($orderdata); $i++) {
        if (in_array(session('id'), explode(',', $orderdata[$i]->vendor_id))) {
            $iteminfo = [];
            $filePath = 'sales_report/' . $orderdata[$i]->invoice_number . '.jsonp';

            if (Storage::disk('s3')->exists($filePath)) {
                $file = Storage::disk('s3')->get($filePath);
                $getfile = json_decode($file, true);

                if (is_array($getfile)) {
                    foreach ($getfile as $data) {
                        if (session('id') == $data['vendor_id']) {
                            $itemdata = [];

                            if ($data['item_type'] == 1) {
                                $itemdata['item_id'] = $data['itemcode'];
                                $itemdata['itemname'] = $data['itemname'];
                                $itemdata['weight'] = $data['item_weight'];
                                $itemdata['cat'] = $data['set_cat'];
                                $itemdata['rate'] = $data['unit_price'];
                                $itemdata['discount_rate'] = $data['unit_price'] - $data['item_discount'];
                                $itemdata['discount'] = $data['item_discount'];
                                $discount_rate = $itemdata['discount_rate'];
                                $itemdata['total_without_gst'] = $discount_rate - ($discount_rate * $data['gst_title'] / 100);
                                $itemdata['qty'] = $data['item_qty'];
                                $itemdata['gst'] = $data['gst_title'];
                                $gstval = 100 + $data['gst_title'];
                                $itemdata['without_gst_rate'] = ($discount_rate / $gstval) * 100;
                                $itemdata['gst_rate'] = $discount_rate - $itemdata['without_gst_rate'];
                                $itemdata['item_ship_chr'] = $data['item_ship_chr'];
                                $itemdata['class'] = '';
                                $itemdata['size_medium'] = '';
                            } else {
                                $size_medium = '';
                                $managemastersizelistModel = managemastersizelistModel::find($data['size']);
                                if ($managemastersizelistModel) {
                                    $size_medium = $managemastersizelistModel->title;
                                }

                                $itemdata['item_id'] = $data['product_id'];
                                $itemdata['itemname'] = $data['product_name'];
                                $itemdata['weight'] = $data['net_weight'];
                                $itemdata['cat'] = $data['catone'];
                                $itemdata['rate'] = $data['mrp'];
                                $itemdata['discount_rate'] = $data['mrp'] - ($data['mrp'] * $data['discount']) / 100;
                                $itemdata['discount'] = ($data['mrp'] * $data['discount']) / 100;
                                $itemdata['total_without_gst'] = $data['discounted_price'] - ($data['discounted_price'] * $data['gst_title'] / 100);
                                $itemdata['qty'] = $data['item_qty'];
                                $itemdata['gst'] = $data['gst_title'];
                                $gstval = 100 + $data['gst_title'];
                                $itemdata['without_gst_rate'] = ($data['discounted_price'] / $gstval) * 100;
                                $itemdata['gst_rate'] = $data['discounted_price'] - $itemdata['without_gst_rate'];
                                $itemdata['item_ship_chr'] = $data['shipping_charges'];
                                $itemdata['class'] = $data['class_title'];
                                $itemdata['size_medium'] = $size_medium;
                            }

                            array_push($iteminfo, $itemdata);
                        }
                    }
                }
            }

            // Tracking Status
            $tracking_status = '';
            $tracking_update_status = DB::table('order_tracking')
                ->select('courier_number', 'tracking_status', 'updated_at')
                ->where(['invoice_number' => $orderdata[$i]->invoice_number, 'vendor_id' => $orderdata[$i]->vendor_id])
                ->distinct()
                ->get();

            foreach ($tracking_update_status as $trkingstatus) {
                $status_text = match ((int)$trkingstatus->tracking_status) {
                    0 => 'Pending',
                    1 => 'In-process',
                    2 => 'In-production',
                    3 => 'Shipped',
                    4 => 'Out for delivery',
                    5 => 'Delivered',
                    default => 'Unknown'
                };
                $tracking_status .= '<p class="otiddiv mb-1 py-1 px-1 border border-1">' .
                    $status_text . '<br>' . $trkingstatus->courier_number . '<br>' . $trkingstatus->updated_at .
                    '</p><br>';
            }

            // Set Class
            $getsetclass = DB::table('order_tracking')
                ->select('master_classes.title')
                ->leftJoin('school_set_vendor', 'school_set_vendor.set_id', '=', 'order_tracking.set_id')
                ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set_vendor.set_class')
                ->where('order_tracking.invoice_number', $orderdata[$i]->invoice_number)
                ->distinct()
                ->get();

            $setclass = '';
            foreach ($getsetclass as $class) {
                $setclass .= $class->title . ',';
            }

            $orderdata[$i]->tracking_status = $tracking_status;
            $orderdata[$i]->setclass = $setclass;

            $array_push = ['ordersinfo' => $orderdata[$i], 'item_info' => $iteminfo];
            array_push($result, $array_push);
        }
    }

    $batchModel = OrderBatch::where('id', $request->id)->first();
    return view('orders_in_batch', [
        'data' => $result,
        'batch_id' => $id,
        'bid' => $bid,
        'print_status' => $batchModel->print_status ?? 0
    ]);
}

    
   /* public function bacth_all_order(Request $request, $id, $bid)
{
    $vendorId = session('id');
    $result = [];

    $where = [
        'sale_tax_register.order_status' => 3,
        'sale_tax_register.batch_id' => $id,
        'sale_tax_register.vendor_id' => $vendorId,
        'orders.payment_status' => 2,
        'order_payment.status' => 1,
        'orders.status' => 1
    ];

    $orderdata = DB::table('orders')
        ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->leftJoin('sale_tax_register', 'sale_tax_register.order_id', '=', 'orders.invoice_number')
        ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
        ->leftJoin('vendor', 'vendor.unique_id', '=', 'sale_tax_register.vendor_id')
        ->select(
            'orders.custom_set_status', 'orders.grand_total', 'vendor.unique_id as vendor_unique_id',
            'sale_tax_register.created_at as inv_created_at', 'vendor.username as vendor_username',
            'vendor.email as vendor_email', 'vendor.phone_no as vendor_phone_no', 'vendor.gst_no as vendor_gst_no',
            'vendor.country as vendor_country', 'vendor.state as vendor_state', 'vendor.distt as vendor_distt',
            'vendor.city as vendor_city', 'vendor.landmark as vendor_landmark', 'vendor.pincode as vendor_pincode',
            'vendor.address as vendor_address', 'sale_tax_register.print_status', 'sale_tax_register.bill_id',
            'order_shipping_address.address_type as ship_address_type', 'order_shipping_address.name as ship_name',
            'order_shipping_address.phone_no as ship_phone_no', 'order_shipping_address.school_code as ship_school_code',
            'order_shipping_address.school_name as ship_school_name', 'order_shipping_address.alternate_phone as ship_alternate_phone',
            'order_shipping_address.village as ship_village', 'order_shipping_address.address as ship_address',
            'order_shipping_address.post_office as ship_post_office', 'order_shipping_address.pincode as ship_pincode',
            'order_shipping_address.city as ship_city', 'order_shipping_address.state as ship_state',
            'order_shipping_address.state_code as ship_state_code', 'order_shipping_address.district as ship_district',
            'sale_tax_register.total_amount', 'sale_tax_register.total_discount', 'sale_tax_register.shipping_charge',
            'orders.vendor_id', 'users.user_type', 'users.name', 'users.fathers_name', 'users.phone_no',
            'users.school_code', 'users.state', 'users.district', 'users.city', 'users.post_office', 'users.village',
            'users.classno', 'users.address', 'users.landmark', 'users.pincode', 'order_payment.transaction_id',
            'order_payment.transaction_date', 'orders.invoice_number', 'orders.mode_of_payment',
            'orders.grand_total', 'orders.shipping_charge as total_shipping'
        )
        ->where($where)
        ->orderBy('sale_tax_register.id', 'desc')
        ->get();

    foreach ($orderdata as $order) {
        if (!in_array($vendorId, explode(',', $order->vendor_id))) continue;

        $filePath = 'sales_report/' . $order->invoice_number . '.jsonp';
        $getfile = null;

        // Try loading file from S3
        for ($attempts = 0; $attempts < 3; $attempts++) {
            try {
                $file = Storage::disk('s3')->get($filePath);
                $file = trim(preg_replace('/\x{FEFF}/u', '', $file));
                $getfile = json_decode($file, true);

                if (is_array($getfile)) {
                    break; // valid
                }
            } catch (\Throwable $e) {
                \Log::warning("S3 file missing or unreadable: $filePath | " . $e->getMessage());
            }
        }

        $iteminfo = [];

        if (is_array($getfile)) {
            foreach ($getfile as $data) {
                if ($data['vendor_id'] != $vendorId) continue;

                $gstval = 100 + $data['gst_title'];

                if ($data['item_type'] == 1) {
                    $discount_rate = $data['unit_price'] - $data['item_discount'];
                    $iteminfo[] = [
                        'item_id' => $data['itemcode'],
                        'itemname' => $data['itemname'],
                        'weight' => $data['item_weight'],
                        'cat' => $data['set_cat'],
                        'rate' => $data['unit_price'],
                        'discount_rate' => $discount_rate,
                        'discount' => $data['item_discount'],
                        'total_without_gst' => $discount_rate - ($discount_rate * $data['gst_title'] / 100),
                        'qty' => $data['item_qty'],
                        'gst' => $data['gst_title'],
                        'without_gst_rate' => ($discount_rate / $gstval) * 100,
                        'gst_rate' => $discount_rate - ($discount_rate / $gstval) * 100,
                        'item_ship_chr' => $data['item_ship_chr'],
                        'class' => "",
                        'size_medium' => ""
                    ];
                } else {
                    $size_medium = '';
                    $sizeModel = managemastersizelistModel::find($data['size']);
                    if ($sizeModel) {
                        $size_medium = $sizeModel->title;
                    }

                    $discount = ($data['mrp'] * $data['discount']) / 100;
                    $discounted_price = $data['mrp'] - $discount;

                    $iteminfo[] = [
                        'item_id' => $data['product_id'],
                        'itemname' => $data['product_name'],
                        'weight' => $data['net_weight'],
                        'cat' => $data['catone'],
                        'rate' => $data['mrp'],
                        'discount_rate' => $discounted_price,
                        'discount' => $discount,
                        'total_without_gst' => $data['discounted_price'] - ($data['discounted_price'] * $data['gst_title'] / 100),
                        'qty' => $data['item_qty'],
                        'gst' => $data['gst_title'],
                        'without_gst_rate' => ($data['discounted_price'] / $gstval) * 100,
                        'gst_rate' => $data['discounted_price'] - ($data['discounted_price'] / $gstval) * 100,
                        'item_ship_chr' => $data['shipping_charges'],
                        'class' => $data['class_title'],
                        'size_medium' => $size_medium
                    ];
                }
            }
        }

        // Tracking Status
        $tracking_status = '';
        $tracking_update_status = DB::table('order_tracking')
            ->select('courier_number', 'tracking_status', 'updated_at')
            ->where([
                'invoice_number' => $order->invoice_number,
                'vendor_id' => $order->vendor_id
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

            $tracking_status .= '<p class="otiddiv mb-1 py-1 px-1 border border-1">'
                . $statusText . '<br>' . $track->courier_number . '<br>' . $track->updated_at . '</p><br>';
        }

        // Class info
        $getsetclass = DB::table('order_tracking')
            ->select('master_classes.title')
            ->leftJoin('school_set_vendor', 'school_set_vendor.set_id', '=', 'order_tracking.set_id')
            ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set_vendor.set_class')
            ->where('order_tracking.invoice_number', $order->invoice_number)
            ->distinct()
            ->get();

        $setclass = implode(',', $getsetclass->pluck('title')->toArray());

        $order->tracking_status = $tracking_status;
        $order->setclass = $setclass;

        $result[] = ['ordersinfo' => $order, 'item_info' => $iteminfo];
    }

    $batchModel = OrderBatch::find($id);

    return view('orders_in_batch', [
        'data' => $result,
        'batch_id' => $id,
        'bid' => $bid,
        'print_status' => $batchModel?->print_status ?? 0
    ]);
}*/

    
    //billing_cleared_view
    public function billing_cleared_view(Request $request)
    { 
    //     $fromdate=$from." 00:00:00";
    //     $todate=$to." 23:59:59";
      
        $result=array();
        $array_push=array();
        $where=array('orders.order_status'=>5,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $orderdata= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->leftJoin('vendor','vendor.unique_id','=','sale_tax_register.vendor_id')
            ->select('orders.custom_set_status','orders.grand_total','vendor.unique_id as vendor_unique_id','sale_tax_register.created_at as inv_created_at','vendor.username as vendor_username',	'vendor.email as vendor_email',	'vendor.phone_no as vendor_phone_no',	'vendor.gst_no as vendor_gst_no',	'vendor.country as vendor_country',	'vendor.state as vendor_state',	'vendor.distt as vendor_distt',	'vendor.city as vendor_city',	'vendor.landmark as vendor_landmark',	'vendor.pincode as vendor_pincode',	'vendor.address as vendor_address',	'orders.print_status','sale_tax_register.bill_id','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','sale_tax_register.total_amount','sale_tax_register.total_discount','sale_tax_register.shipping_charge','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.classno','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment','orders.grand_total','orders.shipping_charge as total_shipping')
            ->where($where)
            // ->whereBetween('orders.order_time', [$fromdate, $todate])
            ->orderBy('sale_tax_register.id','desc')
            ->get();
            
            
        for($i=0;$i<count($orderdata);$i++)
        {  
           if(in_array(session('id'),explode(',',$orderdata[$i]->vendor_id)))
           {
               
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
            //$tracking_update_status=OrderTrackingModel::distinct('courier_number','tracking_status')->where(['invoice_number'=>$data[$i]->invoice_number,'vendor_id'=>$data[$i]->vendor_id,'status'=>1])->get();
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
                }
            }
              
              
              $getsetclass=DB::table('order_tracking')->select('master_classes.title')
              ->leftJoin('school_set_vendor', 'school_set_vendor.set_id', '=', 'order_tracking.set_id')
              ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set_vendor.set_class')
              ->where(['order_tracking.invoice_number'=>$orderdata[$i]->invoice_number])
              ->distinct('order_tracking.set_id')->get();
              
              $setclass="";
              for($s=0;$s<count($getsetclass);$s++)
              {
                  $setclass.=$getsetclass[$s]->title.",";
              }
              
              $orderdata[$i]->tracking_status=$tracking_status;
              $orderdata[$i]->setclass=$setclass;
              
              
              $array_push=['ordersinfo'=>$orderdata[$i],'item_info'=>$iteminfo];
              array_push($result,$array_push);  
           }
        }  
        
        return view('billing_cleared_view',['data'=>$result]);
    }
    
    
    
    
    //update_batch_print_status
    public function update_batch_print_status(Request $request)
    {
        $OrdersModel=SaleTaxRegister::where(['batch_id'=>$request->id]);
        $updatet=$OrdersModel->update(['print_status'=>1]);  
        if($updatet)
        {
             $batchModel=OrderBatch::where(['id'=>$request->id]);
             $batchModel->update(['print_status'=>1]);  
        
             return redirect()->back()->with('success', 'All Order Print Status Updated Successfully!');
        }
        else
        {
              
               return redirect()->back()->withErrors('error', 'Somthing went wrong!');
        }
                
    }

    
       //undo_batch_orders
    public function undo_batch_orders_one(Request $request)
    {
        $OrdersModel=OrdersModel::where(['invoice_number'=>$request->order_id,'batch_id'=>$request->bid]);
        $updatet=$OrdersModel->update(['batch_id'=>0]);  
        if($updatet)
        {
             $batchModel=OrderBatch::where(['id'=>$request->bid])->first();
             $total_order=$batchModel->total_order-1;
             $batchModel->update(['total_order'=>$total_order]);  
        
             return redirect()->back()->with('success', ' Order Undo Successfully!');
        }
        else
        {
              
               return redirect()->back()->withErrors('error', 'Somthing went wrong!');
        }
                
    }

    
       //order_process_status
     public function order_process_status(String $id)
    { 
        $result=array();
        $where=array('orders.invoice_number'=>$id,'orders.order_status'=>3,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $order_data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
             ->leftJoin('vendor','vendor.unique_id','=','sale_tax_register.vendor_id')
            ->select('orders.print_status','sale_tax_register.created_at as inv_created_at','vendor.unique_id','sale_tax_register.bill_id','vendor.unique_id as vendor_unique_id',	'vendor.username as vendor_username',	'vendor.email as vendor_email',	'vendor.phone_no as vendor_phone_no',	'vendor.gst_no as vendor_gst_no',	'vendor.country as vendor_country',	'vendor.state as vendor_state',	'vendor.distt as vendor_distt',	'vendor.city as vendor_city',	'vendor.landmark as vendor_landmark',	'vendor.pincode as vendor_pincode',	'vendor.address as vendor_address',	'order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','sale_tax_register.total_amount','sale_tax_register.total_discount','sale_tax_register.shipping_charge','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.classno','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
            ->first();
            
                                            
            
            $file=Storage::disk('s3')->get('sales_report/'.$id.'.jsonp');
        	$getfile=json_decode ($file,true);
        	$iteminfo=array();   
            foreach($getfile as $data)
            {
              
                if(session('id')==$data['vendor_id'])
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
                   
                    
                    }
                    else
                    {
                     //inventory item  
                    $itemdata['item_id']=$data['product_id'];
                    $itemdata['itemname']=$data['product_name'];
                    $itemdata['weight']=$data['net_weight'];
                    $itemdata['cat']=$data['catone'];
                    $itemdata['rate']=$data['mrp'];
                    $itemdata['discount_rate']=$data['mrp']-($data['mrp']*$data['discount'])/100;
                    $discount_rate=$data['mrp']-$data['item_discount'];
                    $itemdata['discount']=($data['mrp']*$data['discount'])/100;
                    $itemdata['total_without_gst']=$discount_rate-($discount_rate*$data['gst_title']/100);
                    $itemdata['qty']=$data['item_qty'];
                    $itemdata['gst']=$data['gst_title'];
                    
                    $gstval=100+$data['gst_title'];
                    $itemdata['without_gst_rate']=($discount_rate/$gstval)*100;
                    $itemdata['gst_rate']=$discount_rate-($discount_rate/$gstval)*100;
                    
                    $itemdata['item_ship_chr']=$data['shipping_charges'];
                        
                    }
                    
                    
                    
                    array_push($iteminfo,$itemdata);
              
                }
            
             }    
            
        return array('order' => $order_data,'item_info'=>$iteminfo);
    }
    
    

}












