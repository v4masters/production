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

class OrderController extends Controller
{
    
    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }
    
    function get_token_shiprocket()
    {
        $userdata = Courier_partner::select('token','channel_id')->where(['courier_partner'=>3,'status'=>1,'del_status'=>0])->first();
         return $userdata;
    }
    
    // move_order_ship_to_inprocess_view
    public function move_order_ship_to_inprocess_view()
    { 
        return view('orders_ship_to_inprocess');
    }
 
    // move_order_ship_to_inprocess
    public function move_order_ship_to_inprocess(Request $request)
    {
        $response=[];
        
         $update_status=OrderTrackingModel::where(['invoice_number'=>$request->order_id,'vendor_id'=>session('id')]);
         $res=$update_status->update(['status'=>0,'shipped_status'=>0,'shipment_id'=>'','in_production_on'=>NULL,'ship_order_id'=>'',"in_process_on"=>'',"shipped_on"=>'','tracking_status'=>1,'shipper_name'=>'','courier_number'=>'','shipper_address'=>'','courier_no_status'=>0]);
        
         if($res)
          {
            return redirect()->back()->with('success', 'Order  Updated successfully!');
          }
          else
             {
                 return redirect('move_order_ship_to_inprocess_view')->withErrors(['' => 'Invalid Order id!']);   
             }
    }
    
    function get_vendor_loc_id()
    {
        $data= DB::table('vendor')->select('location_id')->where('unique_id',session('id'))->first();
        return $data;
    }
    
     
    //search_order
    public function search_order()
    { 
        return view('orders_search');
    }
 

    //filter_search_order
    /*public function filter_search_order(Request $request)
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

          $getfile = [];
$iteminfo = [];
$total_item = 0;

try {
    $file_path = 'sales_report/' . $id . '.jsonp';
    $file = Storage::disk('s3')->get($file_path);

    if ($file && strlen(trim($file)) > 0) {
        $decoded = json_decode($file, true);
        if (is_array($decoded)) {
            $getfile = $decoded;
        }
    }
} catch (\Throwable $e) {
    // Log or ignore, as needed
    $getfile = [];
}

if (!is_array($getfile) || count($getfile) === 0) {
    return redirect('search_order')->withErrors(['' => 'Order file not found or invalid.']);
}
            foreach($getfile as $data)
            {
              
                if(session('id')==$data['vendor_id'])
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
                    
                    $item_traking_status=OrderTrackingModel::select('courier_number','tracking_status','status')->where(['invoice_number'=>$id,'vendor_id'=>session('id'),'item_id'=>$data['id'],'item_type'=>$data['item_type']])->first();
                    $itemdata['tracking_status']=$item_traking_status->tracking_status;
                    $itemdata['courier_number']=$item_traking_status->courier_number;
                    $itemdata['item_trk_status']=$item_traking_status->status;
                    array_push($iteminfo,$itemdata);
                    $total_item++;
                }
            
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
              
              $data[$i]->tracking_status=$tracking_status;
              
              array_push($result,$data[$i]);  
              
           }
        }  
           return view('orders_search_by_user', ['orders' => $result]);
        }
        else
        {
               return redirect('search_order')->withErrors(['' => 'User not found with this phone number!']);   
        }
      }
          
      
      
    }*/
    public function filter_search_order(Request $request)
{
    if ($request->search_type == 1) {
        $id = $request->search_key;
        $where = ['orders.invoice_number' => $id];

        $order_data = DB::table('orders')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register', 'sale_tax_register.order_id', '=', 'orders.invoice_number')
            ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
            ->leftJoin('vendor', 'vendor.unique_id', '=', 'sale_tax_register.vendor_id')
            ->leftJoin('order_under_batch', 'order_under_batch.id', '=', 'sale_tax_register.batch_id')
            ->leftJoin('school', 'school.school_code', '=', 'users.school_code')
            ->select(
                'school.school_name', 'users.school_code', 'order_under_batch.batch_id', 'orders.grand_total',
                'orders.shipping_charge as total_shipping', 'orders.print_status', 'sale_tax_register.created_at as inv_created_at',
                'vendor.unique_id', 'sale_tax_register.bill_id', 'vendor.unique_id as vendor_unique_id', 'vendor.username as vendor_username',
                'vendor.email as vendor_email', 'vendor.phone_no as vendor_phone_no', 'vendor.gst_no as vendor_gst_no',
                'vendor.country as vendor_country', 'vendor.state as vendor_state', 'vendor.distt as vendor_distt',
                'vendor.city as vendor_city', 'vendor.landmark as vendor_landmark', 'vendor.pincode as vendor_pincode',
                'vendor.address as vendor_address', 'order_shipping_address.address_type as ship_address_type',
                'order_shipping_address.name as ship_name', 'order_shipping_address.phone_no as ship_phone_no',
                'order_shipping_address.school_code as ship_school_code', 'order_shipping_address.school_name as ship_school_name',
                'order_shipping_address.alternate_phone as ship_alternate_phone', 'order_shipping_address.village as ship_village',
                'order_shipping_address.address as ship_address', 'order_shipping_address.post_office as ship_post_office',
                'order_shipping_address.pincode as ship_pincode', 'order_shipping_address.city as ship_city',
                'order_shipping_address.state as ship_state', 'order_shipping_address.state_code as ship_state_code',
                'order_shipping_address.district as ship_district', 'sale_tax_register.total_amount', 'sale_tax_register.total_discount',
                'sale_tax_register.shipping_charge', 'orders.vendor_id', 'users.unique_id as user_id', 'users.user_type', 'users.name',
                'users.fathers_name', 'users.phone_no', 'users.school_code', 'users.classno', 'users.state', 'users.district', 'users.city',
                'users.post_office', 'users.village', 'users.address', 'users.landmark', 'users.pincode', 'orders.order_status',
                'orders.invoice_number', 'orders.mode_of_payment'
            )
            ->where($where)
            ->first();

        if ($order_data) {
            $paymentdata = DB::table('order_payment')
                ->select('transaction_id', 'transaction_date')
                ->where(['order_id' => $id])
                ->first();

            $order_data->transaction_id = $paymentdata->transaction_id ?? '';
            $order_data->transaction_date = $paymentdata->transaction_date ?? '';

            $getfile = [];
            $iteminfo = [];
            $total_item = 0;

            try {
                $file_path = 'sales_report/' . $id . '.jsonp';
                $file = Storage::disk('s3')->get($file_path);

                if ($file && strlen(trim($file)) > 0) {
                    $decoded = json_decode($file, true);
                    if (is_array($decoded)) {
                        $getfile = $decoded;
                    }
                }
            } catch (\Throwable $e) {
                // Optional: Log the error
                Log::warning("Unable to read sales report JSONP file: " . $e->getMessage());
            }

          if (!is_array($getfile) || count($getfile) === 0) {
    $getfile = []; // continue with empty items
}


            foreach ($getfile as $data) {
                if (session('id') == $data['vendor_id']) {
                    $itemdata = [];

                    if ($data['item_type'] == 1) {
                        $itemdata = [
                            'item_type' => 1,
                            'id' => $data['id'],
                            'item_id' => $data['itemcode'],
                            'itemname' => $data['itemname'],
                            'weight' => $data['item_weight'],
                            'cat' => $data['set_cat'],
                            'rate' => $data['unit_price'],
                            'discount_rate' => $data['unit_price'] - $data['item_discount'],
                            'discount' => $data['item_discount'],
                            'qty' => $data['item_qty'],
                            'gst' => $data['gst_title'],
                            'item_ship_chr' => $data['item_ship_chr'],
                            'class' => '',
                            'size_medium' => ''
                        ];

                        $discount_rate = $itemdata['discount_rate'];
                        $gstval = 100 + $data['gst_title'];
                        $itemdata['total_without_gst'] = $discount_rate - ($discount_rate * $data['gst_title'] / 100);
                        $itemdata['without_gst_rate'] = ($discount_rate / $gstval) * 100;
                        $itemdata['gst_rate'] = $discount_rate - ($discount_rate / $gstval) * 100;
                    } else {
                        $size_medium = '';
                        $size = managemastersizelistModel::where('id', $data['size'])->first();
                        if ($size) {
                            $size_medium = $size->title;
                        }

                        $discount_rate = $data['mrp'] - $data['discounted_price'];
                        $gstval = 100 + $data['gst_title'];

                        $itemdata = [
                            'item_type' => 0,
                            'id' => $data['id'],
                            'item_id' => $data['product_id'],
                            'itemname' => $data['product_name'],
                            'weight' => $data['net_weight'],
                            'cat' => $data['catone'],
                            'rate' => $data['mrp'],
                            'discount_rate' => $data['mrp'] - ($data['mrp'] * $data['discount'] / 100),
                            'discount' => ($data['mrp'] * $data['discount']) / 100,
                            'total_without_gst' => $discount_rate - ($discount_rate * $data['gst_title'] / 100),
                            'qty' => $data['item_qty'],
                            'gst' => $data['gst_title'],
                            'without_gst_rate' => ($data['discounted_price'] / $gstval) * 100,
                            'gst_rate' => $discount_rate - ($discount_rate / $gstval) * 100,
                            'item_ship_chr' => $data['shipping_charges'],
                            'class' => $data['class_title'],
                            'size_medium' => $size_medium
                        ];
                    }

                    $item_track = OrderTrackingModel::select('courier_number', 'tracking_status', 'status')
                        ->where([
                            'invoice_number' => $id,
                            'vendor_id' => session('id'),
                            'item_id' => $data['id'],
                            'item_type' => $data['item_type']
                        ])
                        ->first();

                    $itemdata['tracking_status'] = $item_track->tracking_status ?? '';
                    $itemdata['courier_number'] = $item_track->courier_number ?? '';
                    $itemdata['item_trk_status'] = $item_track->status ?? '';

                    $iteminfo[] = $itemdata;
                    $total_item++;
                }
            }

            $order_data->total_item = $total_item;

            return view('orders_details', [
                'order' => $order_data,
                'item_info' => $iteminfo,
                'tracking' => []
            ]);
        } else {
            return redirect('search_order')->withErrors(['debug' => 'Missing or invalid JSONP file.']);

        }
    } else {
        // search_type != 1 → search by phone
        $result = [];
        $where = ['users.phone_no' => $request->search_key];

        $data = DB::table('orders')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register', 'sale_tax_register.order_id', '=', 'orders.invoice_number')
            ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
            ->select(
                'orders.shipping_charge', 'orders.order_status', 'orders.print_status', 'sale_tax_register.bill_id',
                'order_shipping_address.address_type as ship_address_type', 'order_shipping_address.name as ship_name',
                'order_shipping_address.phone_no as ship_phone_no', 'order_shipping_address.school_code as ship_school_code',
                'order_shipping_address.school_name as ship_school_name', 'order_shipping_address.alternate_phone as ship_alternate_phone',
                'order_shipping_address.village as ship_village', 'order_shipping_address.address as ship_address',
                'order_shipping_address.post_office as ship_post_office', 'order_shipping_address.pincode as ship_pincode',
                'order_shipping_address.city as ship_city', 'order_shipping_address.state as ship_state',
                'order_shipping_address.state_code as ship_state_code', 'order_shipping_address.district as ship_district',
                'sale_tax_register.total_amount', 'sale_tax_register.total_discount', 'orders.vendor_id', 'users.user_type', 'users.name',
                'users.fathers_name', 'users.phone_no', 'users.school_code', 'users.state', 'users.district', 'users.city',
                'users.post_office', 'users.village', 'users.address', 'users.landmark', 'users.pincode',
                'orders.invoice_number', 'orders.mode_of_payment'
            )
            ->where($where)
            ->orderBy('sale_tax_register.id', 'desc')
            ->get();

        if ($data) {
            foreach ($data as $order) {
                if (in_array(session('id'), explode(',', $order->vendor_id))) {
                    $paymentdata = DB::table('order_payment')
                        ->select('transaction_id', 'transaction_date')
                        ->where('order_id', $order->invoice_number)
                        ->first();

                    $order->transaction_id = $paymentdata->transaction_id ?? '';
                    $order->transaction_date = $paymentdata->transaction_date ?? '';

                    $tracking_update_status = DB::table('order_tracking')
                        ->select('courier_number', 'tracking_status', 'updated_at')
                        ->where([
                            'invoice_number' => $order->invoice_number,
                            'vendor_id' => $order->vendor_id
                        ])
                        ->get();

                    $tracking_status = '';
                    foreach ($tracking_update_status as $track) {
                        $statustrk = match ($track->tracking_status) {
                            0 => 'Pending',
                            1 => 'In-process',
                            2 => 'In-production',
                            3 => 'Shipped',
                            4 => 'Out for delivery',
                            5 => 'Delivered',
                            default => 'Unknown'
                        };

                        $tracking_status .= '<p class="otiddiv mb-1 py-1 px-1 border border-1">' . $statustrk . '<br>' . $track->courier_number . '<br>' . $track->updated_at . '</p><br>';
                    }

                    $order->tracking_status = $tracking_status;
                    $result[] = $order;
                }
            }

            return view('orders_search_by_user', ['orders' => $result]);
        } else {
            return redirect('search_order')->withErrors(['' => 'User not found with this phone number!']);
        }
    }
}

    
	//new_order
   /* public function new_order()
    { 
        $result=array();
        $itemdata=[];
        $where=array('orders.pp_id'=>NULL,'orders.order_status'=>2,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        
        $data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->select('orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_amount','order_payment.transaction_date','orders.invoice_number','orders.grand_total','orders.mode_of_payment')
            ->where($where)
            ->orderBy('orders.id','desc')
            ->get();
            
            

            
        for($i=0;$i<count($data);$i++)
        {  
           if(in_array(session('id'),explode(',',$data[$i]->vendor_id)))
           {
               
               
            $file=Storage::disk('s3')->get('sales_report/'.$data[$i]->invoice_number.'.jsonp');
        // 	$getfile=json_decode ($file,true);
        	$getfile = json_decode($file, true) ?: [];

        	$vendor_total_amount=0;
        	
            foreach($getfile as $itemdata)
            {
                if(session('id')==$itemdata['vendor_id'])
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
            
            $myorderitem= OrderTrackingModel::where(['tracking_status'=>0,'vendor_id'=>session('id'),'invoice_number'=>$data[$i]->invoice_number])->get();
             if(count($myorderitem)!=0)
             {
        
              $data[$i]->vendor_total_amount=$vendor_total_amount;
              array_push($result,$data[$i]);  
              
             }
            
           }
        }  
        return view('orders_new', ['neworders' => $result]);
    }*/
    public function new_order()
{
    $result = [];
    $where = [
        'orders.pp_id' => NULL,
        'orders.order_status' => 2,
        'orders.payment_status' => 2,
        'order_payment.status' => 1,
        'orders.status' => 1
    ];

    $data = DB::table('orders')
        ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->select(
            'orders.vendor_id',
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
            'order_payment.transaction_amount',
            'order_payment.transaction_date',
            'orders.invoice_number',
            'orders.grand_total',
            'orders.mode_of_payment'
        )
        ->where($where)
        ->orderBy('orders.id', 'desc')
        ->get();

    for ($i = 0; $i < count($data); $i++) {
        $vendorIds = explode(',', $data[$i]->vendor_id);

        if (in_array(session('id'), $vendorIds)) {

            // Safely load the JSON file from S3
            try {
                $file = Storage::disk('s3')->get('sales_report/' . $data[$i]->invoice_number . '.jsonp');
                $getfile = json_decode($file, true) ?: [];
            } catch (\Exception $e) {
                // Skip if file not found or bad data
                continue;
            }

            $vendor_total_amount = 0;

            foreach ($getfile as $itemdata) {
                if ((string) session('id') === (string) $itemdata['vendor_id']) {
                    $itemrate_withship = 0;

                    if ($itemdata['item_type'] == 1) {
                        $itemrate_withship = (($itemdata['unit_price'] - $itemdata['item_discount']) * $itemdata['item_qty']) + $itemdata['item_ship_chr'];
                    } else {
                        $itemrate_withship = ($itemdata['discounted_price'] * $itemdata['item_qty']) + $itemdata['shipping_charges'];
                    }

                    $vendor_total_amount += $itemrate_withship;
                }
            }

            $myorderitem = OrderTrackingModel::where([
                'tracking_status' => 0,
                'vendor_id' => session('id'),
                'invoice_number' => $data[$i]->invoice_number
            ])->get();

            if (count($myorderitem) != 0) {
                // Always set vendor_total_amount to avoid null
                $data[$i]->vendor_total_amount = $vendor_total_amount ?? 0;

                // Optional: Debug logging
                // Log::info('Invoice: ' . $data[$i]->invoice_number . ' | Vendor ID: ' . session('id') . ' | Vendor Total: ' . $vendor_total_amount);

                $result[] = $data[$i];
            }
        }
    }

    return view('orders_new', ['neworders' => $result]);
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
                if(session('id')==$data['vendor_id'])
                {
                     // set item
                    if($data['item_type']==1)
                    {
                    // if(array_key_exists("set_cat",$data)){$set_cat=$data['set_cat'];}else{$set_cat="";}    
                    $itemdata['item_id']=$data['itemcode'];
                    $itemdata['itemname']=$data['itemname'];
                    $itemdata['weight']=$data['item_weight'];
                    $itemdata['cat']=$data['set_cat'];
                    $itemdata['rate']=$data['unit_price']*$data['item_qty'];
                    $itemdata['total_without_gst']=($data['unit_price']-($data['unit_price']*$data['gst_title']/100))*$data['item_qty'];
                    
                    // if(array_key_exists("item_discount",$data)){$item_discount=$data['item_discount'];}else{$item_discount=0;}
                    
                        $item_qty=$data['item_qty'];
                        $item_mrp=($data['unit_price']-$data['item_discount'])*$item_qty;
                        // $item_basic_price=$item_mrp-($item_mrp*$data['gst_title']/100);
                        // $item_dis=$data['item_discount'];
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
                    $itemdata['rate']=$data['discounted_price']*$data['item_qty'];
                    $itemdata['total_without_gst']=($data['discounted_price']-($data['discounted_price']*$data['gst_title']/100))*$data['item_qty'];
                   
                        $item_qty=$data['item_qty'];
                        // $item_mrpmrp=$data['mrp']*$item_qty;
                        $item_mrp=$data['discounted_price']*$item_qty;
                        // $item_basic_price=$item_mrp-($item_mrp*$data['gst_title']/100);
                        // $item_dis=($item_mrpmrp*$data['discount'])/100;
                        
                   
                      $itemdata['qty']=$item_qty;
                      $itemdata['item_ship_chr']=$data['shipping_charges'];
                      $item_ship=$data['shipping_charges'];
                  
                        
                    }
                    
                    $itemdata['gst']=$data['gst_title'];
                    
                    array_push($orderitem,$itemdata);
                    $totalamount+=$item_mrp;
                    // $total_wo_gst_amount+=$item_basic_price;
                    // $total_dis+=$item_dis;
                    $total_ship+=$item_ship;
                    }
            
             }
             
             
             
             $ship_base_amount = $total_ship / 1.18;
        	
        	if($order_data->mode_of_payment==1){$mop="Online";}else{$mop="COD";}
        	$order_data->total_amount=round($totalamount+$total_ship,2);
        // 	$order_data->total_wo_gst_amount=$total_wo_gst_amount+$ship_base_amount;
        // 	$order_data->total_discount=$total_dis;
        // 	$order_data->total_shipping=round($total_ship,2);
        	$order_data->mop=$mop;
        	
        	
            $this->output(array('item_info'=>$orderitem,'order_info'=>$order_data));
        }

    //accept_order
    public function accept_order(Request $request)
    {

          //sale tax register
            $filedata=array();
            $emailorderitems=[];
            $jsonfile=Storage::disk('s3')->get('sales_report/'.$request->order_id.'.jsonp');
        	$getfiledata=json_decode ($jsonfile,true);
            $totalamount=0;$total_discount=0;$shippcharges=0;$gst0=0;$gst5=0;$gst12=0;$gst18=0;$gst28=0;
            foreach($getfiledata as $filedata)
            {
              if($filedata['vendor_id']==session('id'))    
              {
              //inv
              
              
              
              
               if($filedata['item_type']==0)
               {
                  $mrp=($filedata['discounted_price'])*$filedata['item_qty'];
                  $discount=(($mrp*$filedata['discount'])/100)*$filedata['item_qty'];
                   $shippcharges+=$filedata['shipping_charges'];
                  
               }
               //set inv
               else
               {
                //   $disprize=($filedata['unit_price']*$filedata['item_discount'])*$filedata['item_qty'];
                   $mrp=($filedata['unit_price']-$filedata['item_discount'])*$filedata['item_qty'];
                   $discount=$filedata['item_discount']*$filedata['item_qty'];
                   $shippcharges+=$filedata['item_ship_chr'];
               }
               
                $totalamount+=$mrp;
                $total_discount+=$discount;
               
                $gst=$filedata['gst_title'];
                if($gst==0){$gst0+=$mrp;}elseif($gst==5){$gst5+=$mrp;}elseif($gst==12){$gst12+=$mrp;}elseif($gst==18){$gst18+=$mrp;}elseif($gst==28){$gst28+=$mrp;}
              
              }
                 
            }

            $OrdersModel = OrdersModel::where(['invoice_number'=>$request->order_id])->first();
            $useremail= ManageuserStudentModel::select('email')->where(['unique_id'=>$OrdersModel->user_id])->first();
            $userstatecode= OrderShippingAddressModel::select('state_code','name')->where(['user_id'=>$OrdersModel->user_id,'invoice_number'=>$request->order_id])->first();
            $vendorstatecode=  DB::table('vendor')->select('state_code')->where('unique_id',session('id'))->first();
            $lastbill=SaleTaxRegister::select('bill_no')->where('vendor_id',session('id'))->orderBy('id','desc')->first();
            if($vendorstatecode->state_code==$userstatecode->state_code){$gsttype=1;}else{$gsttype=2;}
            
            
            if($lastbill){$billno=$lastbill->bill_no+1;}else{$billno=1;}
            
            $gst18+=$shippcharges;
            $totalamount+=$shippcharges;
            
            $SaleTaxRegister=[
                'vendor_id'=>session('id'),
                'order_id'=>$request->order_id,
                'user_id'=>$OrdersModel->user_id,
                'bill_no'=>$billno,
                'bill_id'=>session('id').'-'.$billno,
                'total_amount'=>$totalamount,
                'total_discount'=>$total_discount,
                'shipping_charge'=>$shippcharges,
                'gst_type'=>$gsttype,
                'gst_0'=>$gst0,
                'gst_5'=>$gst5,
                'gst_12'=>$gst12,
                'gst_18'=>$gst18,
                'gst_28'=>$gst28,
                'order_status'=>3,
                'vendor_state_code'=>$vendorstatecode->state_code,
                'user_state_code'=>$userstatecode->state_code,
                ];
                
                
            $checkisexist=SaleTaxRegister::where(['order_id'=>$request->order_id,'vendor_id'=>session('id'),])->count();  
            if($checkisexist==0)
            {
              $salrreg=SaleTaxRegister::create($SaleTaxRegister);
            }
            // $salrreg=SaleTaxRegister::create($SaleTaxRegister);
            // if($salrreg)
            // {

             if($OrdersModel)
             {
                
                    $OrdersTrackingModel =OrderTrackingModel::where(['invoice_number'=>$request->order_id,'vendor_id'=>session('id')])->get();
                    $OrdersTrackingModelupdate =OrderTrackingModel::where(['invoice_number'=>$request->order_id,'vendor_id'=>session('id')]);
                    $count=count($OrdersTrackingModel);
                    $row=0;
                    for($i=0;$i<$count;$i++)
                    {
                       if($OrdersTrackingModel[$i]->item_type==0)
                       {
                           $inv=DB::table('inventory_new')->select('qty_available','product_name')->where(['vendor_id'=>session('id'),'id'=>$OrdersTrackingModel[$i]->item_id])->first();
                           DB::table('inventory_new')->where('id', $OrdersTrackingModel[$i]->item_id)->update(['qty_available' =>$inv->qty_available-1]);
                           
                            // array_push($emailorderitems,array("itemname"=>$inv->product_name,"itemqty"=>$OrdersTrackingModel[$i]->qty,"type"=>"item"));
                       }
                       else
                       {
                           if($i==0)
                           {
                               
                           $set_inv=DB::table('school_set_vendor')->distinct('set_id')->where(['vendor_id'=>session('id'),'set_id'=>$OrdersTrackingModel[$i]->set_id])->get();
                           foreach($set_inv as $totalset)
                           {
                             $upinv=DB::table('school_set_vendor')->select('set_qty')->where(['vendor_id'=>session('id'),'set_id'=>$totalset->set_id])->first();
                             DB::table('school_set_vendor')->where(['vendor_id'=>session('id'),'set_id'=>$totalset->set_id])->update(['set_qty' =>$upinv->set_qty-1]);
                           }
                               
                           }
                           
                           $setinv=DB::table('inventory')->select('itemname')->where(['id'=>$OrdersTrackingModel[$i]->item_id])->first();
                        //   array_push($emailorderitems,array("itemname"=>$setinv->itemname,"itemqty"=>$OrdersTrackingModel[$i]->qty,"type"=>"Set item"));
                       }
                        
                     
                     $row++;
                    }
                    
                    if($row==$count)
                    {
                        
                     $updatetracking=$OrdersTrackingModelupdate->update(['tracking_status'=>1]);   
                     if($updatetracking)
                     {
                         
                         $totalRowCounts = DB::table('order_tracking')->selectRaw('COUNT(invoice_number) 
                                           AS total_rows,SUM(CASE WHEN tracking_status = 1 THEN 1 ELSE 0 END) AS total_updated')
                                           ->where('invoice_number', '=', $request->order_id)
                                           ->first();
                         
                        if($totalRowCounts->total_rows==$totalRowCounts->total_updated)
                        {
                        $acceptorder=$OrdersModel->update(['order_status'=>3]);
                        if($acceptorder)
                        {
                        
                          //send mail 
                        //   $maildata=["name"=>$userstatecode->name,"ordernumber"=>$request->order_id,"orderitems"=>$emailorderitems];
                        //   Mail::to($useremail->email)->send(new OrderProcessMail($maildata));
                         //end
                        
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
                          //send mail 
                        //   $maildata=["name"=>$userstatecode->name,"ordernumber"=>$request->order_id,"orderitems"=>$emailorderitems];
                        //   Mail::to($useremail->email)->send(new OrderProcessMail($maildata));
                         //end 
                          
                        $response['success']=1;
                        $response['msg']='Order Item Accepted Successfully';
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
             
            // }else
            // {
            //      $response['success']=0;
            //         $response['msg']='Something Went Wrong 1!';
            //         $this->output($response); 
            // }
          
              
        }

    //cancle_order
    public function cancle_order(Request $request)
    {
                        $OrdersModel = OrdersModel::where(['invoice_number'=>$request->order_id])->first();
                        $cancle_order=$OrdersModel->update(['order_status'=>5,'status'=>0]);
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
            ->orderBy('orders.updated_at','desc')
            ->get();
            
            
        for($i=0;$i<count($data);$i++)
        {  
           if(in_array(session('id'),explode(',',$data[$i]->vendor_id)))
           {
              array_push($result,$data[$i]);  
           }
        }  
        return view('orders_cancelled', ['orders' => $result]);
    }
    
    //order_under_process
    public function order_under_process()
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
    
    //all_order
   /* public function all_order(Request $request)
    { 
        $result=array();
        $where=array('sale_tax_register.vendor_id'=>session('id'),'orders.payment_status'=>2,'orders.status'=>1);
        $data= DB::table('orders')
            // ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->select('order_shipping_address.school_code','orders.grand_total','orders.shipping_charge','orders.order_status','orders.print_status','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
            ->whereIn('sale_tax_register.order_status',[3,4,5])
            ->orderBy('orders.id','desc')
            ->get();
            
        
        for($i=0;$i<count($data);$i++)
        {  
           if(in_array(session('id'),explode(',',$data[$i]->vendor_id)))
           {
              $paymentdata= DB::table('order_payment')->select('transaction_id','transaction_date')->where('order_id',$data[$i]->invoice_number);
              
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
            //$tracking_update_status=OrderTrackingModel::distinct('courier_number','tracking_status')->where(['invoice_number'=>$data[$i]->invoice_number,'vendor_id'=>$data[$i]->vendor_id,'status'=>1])->get();
            //$tracking_update_status=DB::table('order_tracking')->select('courier_number','tracking_status','updated_at')->where('tracking_status',">=",1)->where(['invoice_number'=>$data[$i]->invoice_number,'vendor_id'=>$data[$i]->vendor_id])->distinct('courier_number','tracking_status','updated_at')->get();
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
               
               
               
               
               
               
                 $getsetclass=DB::table('order_tracking')->select('master_classes.title')
              ->leftJoin('school_set_vendor', 'school_set_vendor.set_id', '=', 'order_tracking.set_id')
              ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set_vendor.set_class')
              ->where(['order_tracking.invoice_number'=>$data[$i]->invoice_number])
              ->distinct('order_tracking.set_id')->get();
              
              $setclass="";
              for($s=0;$s<count($getsetclass);$s++)
              {
                  $setclass.=$getsetclass[$s]->title.",";
              }
           
              
              
              
              
              $data[$i]->tracking_status=$tracking_status;
              $data[$i]->setclass=$setclass;
              
              
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
     
        return view('orders_all', ['orders' => $result]);
    }*/
    
    /*public function all_order(Request $request)
{
    $result = [];
    $vendorId = session('id');

    $query = DB::table('orders')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->leftJoin('sale_tax_register', 'sale_tax_register.order_id', '=', 'orders.invoice_number')
        ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
        ->select(
            'order_shipping_address.school_code',
            'orders.grand_total',
            'orders.shipping_charge',
            'orders.order_status',
            'orders.print_status',
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
            'orders.vendor_id',
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
            'orders.invoice_number',
            'orders.mode_of_payment',
            'orders.created_at as orders_created_at'
        )
        ->where([
            ['sale_tax_register.vendor_id', '=', $vendorId],
            ['orders.payment_status', '=', 2],
            ['orders.status', '=', 1],
        ])
        ->whereIn('sale_tax_register.order_status', [3, 4, 5,6])
        ->orderByDesc('orders.id');

    // Date filtering
    if ($request->filled(['from_date', 'to_date'])) {
        $query->whereBetween('orders.created_at', [$request->from_date, $request->to_date]);
    } else {
        $query->limit(100);
    }

    $data = $query->get();

    foreach ($data as $order) {
        if (in_array($vendorId, explode(',', $order->vendor_id))) {
            // Get payment info
            $payment = DB::table('order_payment')
                ->select('transaction_id', 'transaction_date')
                ->where('order_id', $order->invoice_number)
                ->first();

            $order->transaction_id = $payment->transaction_id ?? '';
            $order->transaction_date = $payment->transaction_date ?? '';

            // Get tracking info
            $tracking_status = '';
            $tracking_updates = DB::table('order_tracking')
                ->select('courier_number', 'tracking_status', 'updated_at')
                ->where('tracking_status', '>=', 1)
                ->where([
                    'invoice_number' => $order->invoice_number,
                    'vendor_id' => $vendorId,
                ])
                ->distinct()
                ->get();

            foreach ($tracking_updates as $track) {
                $status_map = [
                    0 => "Pending",
                    1 => "In-process",
                    2 => "In-production",
                    3 => "Shipped",
                    4 => "Out for delivery",
                    5 => "Delivered"
                ];
                $status = $status_map[$track->tracking_status] ?? 'Unknown';
                $tracking_status .= "<p class='otiddiv mb-1 py-1 px-1 border border-1'>{$status}<br>{$track->courier_number}<br>{$track->updated_at}</p><br>";
            }

            // Get class titles
            $classes = DB::table('order_tracking')
                ->leftJoin('school_set_vendor', 'school_set_vendor.set_id', '=', 'order_tracking.set_id')
                ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set_vendor.set_class')
                ->where('order_tracking.invoice_number', $order->invoice_number)
                ->select('master_classes.title')
                ->distinct()
                ->get();

            $order->setclass = $classes->pluck('title')->implode(', ');
            $order->tracking_status = $tracking_status;

            // Get tax info
            $tax = DB::table('sale_tax_register')
                ->select('bill_id', 'total_amount', 'total_discount', 'shipping_charge')
                ->where([
                    'order_id' => $order->invoice_number,
                    'vendor_id' => $vendorId
                ])
                ->first();

            $order->bill_id = $tax->bill_id ?? '';
            $order->total_amount = $tax->total_amount ?? 0;
            $order->total_discount = $tax->total_discount ?? 0;
            $order->ven_shipping_charge = $tax->shipping_charge ?? 0;

            $result[] = $order;
        }
    }

    return view('orders_all', ['orders' => $result]);
}*/

public function all_order(Request $request)
{
    $result = [];
    $vendorId = session('id');

    $query = DB::table('vendor_orders')
        ->where('vendor_id', $vendorId)
        ->where('payment_status', 2) // optional: only if available in the view
        ->where('status', 1)         // optional: only if available in the view // from sale_tax_register
        ->orderByDesc('orders_created_at')
        ->limit(100); // always limit for safety

    // Date filter
    if ($request->filled(['from_date', 'to_date'])) {
        $query->whereBetween('orders_created_at', [$request->from_date, $request->to_date]);
    }


$data=$query->get();
    if ($data->isEmpty()) {
        return view('orders_all', ['orders' => []]);
    }

    $invoiceNumbers = $data->pluck('invoice_number')->toArray();

    // Batch fetch related data
    $payments = DB::table('order_payment')
        ->whereIn('order_id', $invoiceNumbers)
        ->get()
        ->keyBy('order_id');

    $trackings = DB::table('order_tracking')
        ->whereIn('invoice_number', $invoiceNumbers)
        ->where('tracking_status', '>=', 1)
        ->where('vendor_id', $vendorId)
        ->select('invoice_number', 'courier_number', 'tracking_status', 'updated_at')
        ->get()
        ->groupBy('invoice_number');

    $classData = DB::table('order_tracking')
        ->leftJoin('school_set_vendor', 'school_set_vendor.set_id', '=', 'order_tracking.set_id')
        ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set_vendor.set_class')
        ->whereIn('order_tracking.invoice_number', $invoiceNumbers)
        ->select('order_tracking.invoice_number', 'master_classes.title')
        ->get()
        ->groupBy('order_tracking.invoice_number');

    // Merge data
    foreach ($data as $order) {
        if (in_array($vendorId, explode(',', $order->vendor_id))) {
            $inv = $order->invoice_number;

            // Payment info
            $order->transaction_id = $payments[$inv]->transaction_id ?? '';
            $order->transaction_date = $payments[$inv]->transaction_date ?? '';

            // Tracking info
            $tracking_status = '';
            if (isset($trackings[$inv])) {
                foreach ($trackings[$inv] as $track) {
                    $status_map = [
                        0 => "Pending",
                        1 => "In-process",
                        2 => "In-production",
                        3 => "Shipped",
                        4 => "Out for delivery",
                        5 => "Delivered"
                    ];
                    $status = $status_map[$track->tracking_status] ?? 'Unknown';
                    $tracking_status .= "<p class='otiddiv mb-1 py-1 px-1 border border-1'>{$status}<br>{$track->courier_number}<br>{$track->updated_at}</p><br>";
                }
            }
            $order->tracking_status = $tracking_status;

            // Class titles
            $order->setclass = isset($classData[$inv]) ? $classData[$inv]->pluck('title')->implode(', ') : '';

            $result[] = $order;
        }
    }

    return view('orders_all', ['orders' => $result]);
}






    
    //order_under_process_cod
    public function order_under_process_cod()
    { 
        $result=array();
        $where=array('orders.pp_id'=>NULL,'sale_tax_register.vendor_id'=>session('id'),'orders.mode_of_payment'=>2,'sale_tax_register.batch_id'=>0,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->select('order_shipping_address.school_code','orders.grand_total','orders.shipping_charge','orders.order_status','orders.print_status','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
             ->where('sale_tax_register.order_status',3)
            ->orderBy('orders.id','desc')
            ->get();
            
        for($i=0;$i<count($data);$i++)
        {  
           if(in_array(session('id'),explode(',',$data[$i]->vendor_id)))
           {
              
              $tracking_status=''; 
            //$tracking_update_status=OrderTrackingModel::distinct('courier_number','tracking_status')->where(['invoice_number'=>$data[$i]->invoice_number,'vendor_id'=>$data[$i]->vendor_id,'status'=>1])->get();
            //$tracking_update_status=DB::table('order_tracking')->select('courier_number','tracking_status','updated_at')->where('tracking_status',">=",1)->where(['invoice_number'=>$data[$i]->invoice_number,'vendor_id'=>$data[$i]->vendor_id])->distinct('courier_number','tracking_status','updated_at')->get();
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
               
               
               
               
               
               
                 $getsetclass=DB::table('order_tracking')->select('master_classes.title')
              ->leftJoin('school_set_vendor', 'school_set_vendor.set_id', '=', 'order_tracking.set_id')
              ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set_vendor.set_class')
              ->where(['order_tracking.invoice_number'=>$data[$i]->invoice_number])
              ->distinct('order_tracking.set_id')->get();
              
              $setclass="";
              for($s=0;$s<count($getsetclass);$s++)
              {
                  $setclass.=$getsetclass[$s]->title.",";
              }
           
              
              
              
              
              $data[$i]->tracking_status=$tracking_status;
              $data[$i]->setclass=$setclass;
              
              
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
     
        return view('orders_under_process_cod', ['orders' => $result]);
    }
    
    
    //order_process_status
    public function order_process_status(Request $request,String $id)
    { 
        $result=array();
        $where=array('orders.invoice_number'=>$id,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $order_data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->leftJoin('vendor','vendor.unique_id','=','sale_tax_register.vendor_id')
            ->select('orders.custom_set_status','orders.grand_total','orders.shipping_charge as total_shipping','orders.print_status','sale_tax_register.created_at as inv_created_at','vendor.unique_id','sale_tax_register.bill_id','vendor.unique_id as vendor_unique_id',	'vendor.username as vendor_username',	'vendor.email as vendor_email',	'vendor.phone_no as vendor_phone_no',	'vendor.gst_no as vendor_gst_no',	'vendor.country as vendor_country',	'vendor.state as vendor_state',	'vendor.distt as vendor_distt',	'vendor.city as vendor_city',	'vendor.landmark as vendor_landmark',	'vendor.pincode as vendor_pincode',	'vendor.address as vendor_address',	'order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','sale_tax_register.total_amount','sale_tax_register.total_discount','sale_tax_register.shipping_charge','orders.vendor_id','users.unique_id as user_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.classno','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.order_status','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
            ->whereNotIn('orders.order_status',[1])
            ->first();
            
            
            $file=Storage::disk('s3')->get('sales_report/'.$id.'.jsonp');
        	$getfile=json_decode ($file,true);
        	$iteminfo=array();   
        	$total_item=0;
            foreach($getfile as $data)
            {
              
                if(session('id')==$data['vendor_id'])
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
                    
                    $item_traking_status=OrderTrackingModel::select('courier_number','tracking_status','status')->where(['invoice_number'=>$id,'vendor_id'=>session('id'),'item_id'=>$data['id'],'item_type'=>$data['item_type']])->first();
                    $itemdata['tracking_status']=$item_traking_status->tracking_status;
                    $itemdata['courier_number']=$item_traking_status->courier_number;
                    $itemdata['item_trk_status']=$item_traking_status->status;
                    array_push($iteminfo,$itemdata);
                    $total_item++;
                }
            
             }    
            
        $order_data->total_item=$total_item; 
        $tracking=array();
        $vendor_pickup_loc= DB::table('vendor')->select('pincode')->where(['status'=>1,'del_status'=>0,'pickup_loc_status'=>1])->first();   
        $indiapost_pickup=0;
        $indiapost_del=0;
        $am_pickup=0;
        $am_del=0;
        $sr_pickup=0;
        $sr_del=0;
        
        if($vendor_pickup_loc)
        {
            $courier_partner_assign=1;
            
            
            
            //check India Post
            $checlinpostpickup= DB::table('pincode_list_courier_patner')->select('id')->where(['partner'=>2,'type'=>1,'pincode'=>$vendor_pickup_loc->pincode])->first();   
            $checkinpostdelivery= DB::table('pincode_list_courier_patner')->select('id')->where(['partner'=>2,'type'=>1,'pincode'=>$order_data->ship_pincode])->first();        
            if($checlinpostpickup){$indiapost_pickup=1;} else { $indiapost_pickup=0; }
            if($checkinpostdelivery){$indiapost_del=1;} else { $indiapost_del=0; }
            //end
            
           
            //check Amazon
            $checkamzonpickup= DB::table('pincode_list_courier_patner')->select('id')->where(['partner'=>1,'type'=>1,'pincode'=>$vendor_pickup_loc->pincode])->first();   
            $checkamzondelivery= DB::table('pincode_list_courier_patner')->select('id')->where(['partner'=>1,'type'=>2,'pincode'=>$order_data->ship_pincode])->first();        
            if($checkamzonpickup){$am_pickup=1;} else { $am_pickup=0; }
            if($checkamzondelivery){$am_del=1;} else { $am_del=0; }
            //end
            
            //check shiprocket
                $checkshiprockpickup= DB::table('pincode_list_courier_patner')->select('id')->where(['partner'=>1,'type'=>1,'pincode'=>$vendor_pickup_loc->pincode])->first();   
                $checkshiprockdelivery= DB::table('pincode_list_courier_patner')->select('id')->where(['partner'=>3,'type'=>2,'pincode'=>$order_data->ship_pincode])->first();        
                if($checkshiprockpickup){$sr_pickup=1;} else { $sr_pickup=0; }
                if($checkshiprockdelivery){$sr_del=1;} else { $sr_del=0; }
    
            //end
 
            
        }
        else
        {
            $courier_partner_assign=0;
            $am_pickup=0;
            $am_del=0;
            $sr_pickup=0;
            $sr_del=0;
            
        }
        

        
        $courier_data=['courier_partner_assign'=>$courier_partner_assign,'indiapost_pickup'=>$indiapost_pickup,'indiapost_del'=>$indiapost_del,'amz_pickup'=>$am_pickup,'amz_del'=>$am_del,'sr_pickup'=>$sr_pickup,'sr_delivery'=>$sr_del];          
        return view('orders_update_status', ['order' => $order_data,'item_info'=>$iteminfo,'tracking'=>$tracking,'courier_data'=>$courier_data]);
    }
    
    
    //create_order_in_shiprocket
    function create_order_in_shiprocket($orderid,$cus_invoice_number, $orderdate, $pickup_location, $comment, $billing_customer_name, $billing_last_name, $billing_address, $billing_address_2, $billing_city, $billing_pincode, $billing_state, $billing_country, $billing_email, $billing_phone, $shipping_is_billing, $shipping_customer_name, $shipping_last_name, $shipping_address, $shipping_address_2, $shipping_city, $shipping_pincode, $shipping_country, $shipping_state, $shipping_email, $shipping_phone,$shipping_phone_alt,$order_items, $payment_method, $shipping_charges, $giftwrap_charges, $transaction_charges, $total_discount, $sub_total, $length, $breadth, $height, $weight,$batch_id,$order_print_no)
    {
        //Shiprocket
  
        $orderrowCount =$results = DB::table('order_tracking')->select('invoice_number', 'ship_order_id', 'shipment_id')->where('invoice_number', $orderid)->distinct()->get();
        $userdata=$this->get_token_shiprocket();
        $token =$userdata->token;
        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token,'Content-Type' => 'application/json'])->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', 
         [
                "order_id" => $orderid.":".count($orderrowCount),
                "parent_order_id"=>$orderid,
                "order_date" => date('Y-m-d H:i:s'),
                "shipment_date"=> date('Y-m-d H:i:s'), 
                // "pickup_location" => $pickup_location,
                "pickup_location_id"=>$pickup_location,
                "channel_id" => $userdata->channel_id,
                "comment" => $comment,
                "invoice_number" => $cus_invoice_number,
                "billing_customer_name" => $billing_customer_name,
                "billing_last_name" => $billing_last_name,
                "billing_address" => $billing_address,
                "billing_address_2" => $billing_address_2,
                "billing_city" => $billing_city,
                "billing_pincode" => $billing_pincode,
                "billing_state" => $billing_state,
                "billing_country" => $billing_country,
                "billing_email" => $billing_email,
                "billing_phone" => $billing_phone,
                "shipping_is_billing" => $shipping_is_billing,
                "shipping_customer_name" => $shipping_customer_name,
                "shipping_last_name" => $shipping_last_name,
                "shipping_address" => $shipping_address,
                "shipping_address_2" => $shipping_address_2,
                "shipping_city" => $shipping_city,
                "shipping_pincode" => $shipping_pincode,
                "shipping_country" => $shipping_country,
                "shipping_state" => $shipping_state,
                "shipping_email" => $shipping_email,
                "shipping_phone" => $shipping_phone,
                "shipping_alternate_number"=>$shipping_phone_alt,
                "order_items" => $order_items,
                "payment_method" => $payment_method,
                "shipping_charges" => $shipping_charges,
                "giftwrap_charges" => $giftwrap_charges,
                "transaction_charges" => $transaction_charges,
                "total_discount" => $total_discount,
                "sub_total" => $sub_total,
                "length" => $length,
                "breadth" => $breadth,
                "height" => $height,
                "weight" => $weight,
                "custom_fields" => [
                    "batch_id" => $batch_id,
                    "order_print_no" => $order_print_no
                ]
            ] );
        
    // Check for successful response
      if ($response->successful()) 
        {
          $responseData = $response->json();
            
                  if (isset($responseData['shipment_id'])) { $shipment_id = $responseData['shipment_id'];} else { $shipment_id=""; }
                  //ship_order_id
                  if (isset($responseData['order_id'])) { $shipment_order_id= $responseData['order_id']; } else {     $shipment_order_id=""; }
                
             
            $shiparray=['success'=>1,'shipment_id'=>$shipment_id,'shipment_order_id'=>$shipment_order_id,'msg'=>''];
           return $shiparray;
        }
        else
        {
            
                $errorResponse = $response->json();
                
                  if (isset($responseData['shipment_id'])) { $shipment_id = $responseData['shipment_id'];} else { $shipment_id=""; }
                 //ship_order_id
                  if (isset($responseData['order_id'])) { $shipment_order_id= $responseData['order_id']; } else {     $shipment_order_id=""; }
                 
                 
                 
                 
             
                    if (isset($errorResponse['message'])) {
                       $shiperror=$errorResponse['message'];
                    } else {
                        $shiperror='Something Went Wrong!';
                    }
        
              $shiparray=['success'=>0,'shipment_id'=>$shipment_id,'shipment_order_id'=>$shipment_order_id,'msg'=>$shiperror,'message_body'=>$response->body()];
    
              return $shiparray;
            // return false;
            // return response()->json(['error' => 'Failed to add pickup', 'message' => $response->body()], 500);
            // return redirect()->back()->withErrors(['' => $result->message]); 
            
        }
        
        
        
        
    }
    
    
    //get_price_ac_to_item_weight 
    public function get_price_ac_to_item_weight(Request $request)
    {
         $getprices= DB::table('shipping_rates')->select('title','type','rate')
         ->where(['status'=>1,'del_status'=>0])
         ->where('weight_from','<=',$request->item_total_weight)
         ->where('weight_to','>=',$request->item_total_weight)
         ->get();        
         
        $this->output($getprices); 
       
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
    
    function getorderdata($order_id)
    {
            $whereuser=array('sale_tax_register.vendor_id'=>session('id'),'orders.invoice_number'=>$order_id,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
            $order_data_main= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register', 'sale_tax_register.order_id', '=', 'orders.invoice_number')
            ->leftJoin('order_under_batch', 'order_under_batch.id', '=', 'sale_tax_register.batch_id')
            
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
             ->select('sale_tax_register.bill_no','order_under_batch.batch_id as batch_id_no','orders.batch_id',
            'order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no',
            'order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name',
            'order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village',
            'order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode',
            'order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code',
            'order_shipping_address.district as ship_district','orders.vendor_id','users.email','users.last_name','users.first_name','users.fathers_name',
            'users.phone_no','users.school_code','users.classno','users.state','users.district','users.city','users.post_office','users.village',
            'users.address','users.landmark','users.pincode',
            'orders.invoice_number','orders.mode_of_payment','orders.order_time','orders.batch_id')
            ->where($whereuser)
            ->first();
            
            return $order_data_main;
        
    }
    
    
    function get_item_prices_file($invoice_number,$getitemppforship)
    {
         $shiprocket_shipping_charges=0;
         $shiprocket_total_discount=0;
         $shiprocket_sub_total=0;
         $order_items=[];
         
            $file=Storage::disk('s3')->get('sales_report/'.$invoice_number.'.jsonp');
        	$getfile=json_decode ($file,true);
            $i=0;
            foreach($getfile as $data)
            {
                 $i++;
              
                if(session('id')==$data['vendor_id'])
                {
                   
                       if($data['item_type']==1){$sentitem_id=$data['itemcode'];}else{$sentitem_id=$data['product_id'];}  
                        $itemsent=0;
                        
                        foreach($getitemppforship as $checkitemship)
                        {
                           
                            
                           if($sentitem_id==$checkitemship[0] && $checkitemship[1]==$data['item_type'])
                           {
                                   $itemsent=1;
                           }
                         }
                    
                        if($itemsent==1)
                        {
                   
                        $item_ship_chr=0;
                        $discount=0;
                        $item_total=0;
                        $itemname=0;
                        $item_id=0;
                        $gst=0;
                        $hsncode=0;
                        $qty=0;
                        $item_dis=0;
                        $item_prize=0;
                         // set item
                        if($data['item_type']==1)
                        { 
                            $item_ship_chr=$data['item_ship_chr'];
                            $discount=$data['item_discount']*$data['item_qty'];
                            $item_total=$data['unit_price']*$data['item_qty'];
                            $itemname=$data['itemname'];
                            $item_id=$data['itemcode'].'-'.$i;
                            $gst=$data['gst_title'];
                            $hsncode=$data['hsncode'];
                            $qty=$data['item_qty'];
                            $item_prize=$data['unit_price']-$data['item_discount'];
                        
                        }
                        else
                        {
                            $item_ship_chr=$data['shipping_charges'];
                            $discount=(($data['mrp']*$data['discount'])/100)*$data['item_qty'];
                            // $item_total=$data['mrp']-($data['mrp']*$data['discount'])/100;
                            $item_total=$data['mrp']*$data['item_qty'];
                            $itemname=$data['product_name'];
                            $item_id=$data['product_id'].'-'.$i;
                            $gst=$data['gst_title'];
                            $hsncode=$data['hsncode'];
                            $qty=$data['item_qty'];
                            $item_dis=($data['mrp']*$data['discount'])/100;
                            $item_prize=$data['mrp']-$item_dis;
                           
                            
                        }  
                        
                        
                        $shiprocket_shipping_charges+=$item_ship_chr;
                        // $shiprocket_total_discount+=$discount;
                        $shiprocket_sub_total+=($item_total-$discount);
                              
                        array_push($order_items,["name" => $itemname, "sku" => $item_id,"units" => $qty,"selling_price" => $item_prize,"discount" => 0,"tax" => $gst,"hsn" => $hsncode]);  
                    }
                    
                }
            }
        
        return array('order_items'=>$order_items,'shiprocket_shipping_charges'=>$shiprocket_shipping_charges,'shiprocket_total_discount'=>$shiprocket_total_discount,'shiprocket_sub_total'=>$shiprocket_sub_total);
                
    }
    
    //update_order_item_status
    public function update_order_item_status(Request $request)
    {
        $itemid_type=$request->id_type;
        $invoice_number=$request->invoice_number;
        $vendor_id=$request->vendor_id;
        $user_id=$request->user_id;
        $order_item_status=$request->order_item_status;
        $courier_no=$request->courier_no;
        $shipper_name=$request->shipper_name;
        $shipper_address=$request->shipper_address;
        $total_item=$request->total_item;
        $row=0;
        $order_items=[];
        $shipment_id="";
        
        $date=date('Y-m-d');
        $emailorderitems=[];
        $countid=count($itemid_type);
        if($request->courier_patner==4)
        {
            $shipstatus=0;
        }
        else
        {$shipstatus=1;
        }
        
                
        if($countid>0)
        {
        $getitemdata=[];
        $getitemppforship=[];
        foreach($itemid_type as $item)
        {
            $item_array=explode(',',$item);
            
            
            $update_status=OrderTrackingModel::where(['invoice_number'=>$invoice_number,'vendor_id'=>$vendor_id,'item_id'=>$item_array[0],'item_type'=>$item_array[1],'status'=>0]);
            $get_status=OrderTrackingModel::select('product_id','item_type','courier_number','qty','in_process_on','in_production_on')->where(['invoice_number'=>$invoice_number,'vendor_id'=>$vendor_id,'item_id'=>$item_array[0],'item_type'=>$item_array[1],'status'=>0])->first();
            
            array_push($getitemppforship,array($get_status->product_id,$get_status->item_type));
           
     
      
     if($order_item_status==1)
        {
         $update_status->update(["in_process_on"=>$date,'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'courier_number'=>$courier_no,'shipper_address'=>$shipper_address,'courier_no_status'=>1]);
  
        }
        elseif($order_item_status==2)
        {     
            if($get_status->in_process_on==NULL)
            {
              $update_status->update(["in_process_on"=>$date,"in_production_on"=>$date,'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'courier_number'=>$courier_no,'shipper_address'=>$shipper_address,'courier_no_status'=>1]);
            }
            else
            {
                $update_status->update(["in_production_on"=>$date,'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'courier_number'=>$courier_no,'shipper_address'=>$shipper_address,'courier_no_status'=>1]);
      
            }
        }
        elseif($order_item_status==3)
        {
                
             
            
           if($get_status->in_process_on===NULL && $get_status->in_production_on===NULL)
            {
               $update_status->update(['status'=>$shipstatus,"in_process_on"=>$date,"in_production_on"=>$date,"shipped_on"=>$date,'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'courier_number'=>$courier_no,'shipper_address'=>$shipper_address,'courier_no_status'=>1]);

            }
            elseif($get_status->in_process_on!=NULL && $get_status->in_production_on==NULL)
            {
               $update_status->update(['status'=>$shipstatus,"in_production_on"=>$date,"shipped_on"=>$date,'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'courier_number'=>$courier_no,'shipper_address'=>$shipper_address,'courier_no_status'=>1]);

            }
            elseif($get_status->in_process_on==NULL && $get_status->in_production_on!=NULL)
            {
               $update_status->update(['status'=>$shipstatus,"in_process_on"=>$date,"shipped_on"=>$date,'tracking_status'=>$order_item_status,'shipper_name'=>$shipper_name,'courier_number'=>$courier_no,'shipper_address'=>$shipper_address,'courier_no_status'=>1]);

            }
            
            if($get_status->item_type==1)
            {
                $setinv=DB::table('inventory')->select('itemname')->where(['id'=>$item_array[0]])->first();
                $itemtype="Set Item";
                $itemname=$setinv->itemname;
            }
            else
            {
                $setinv=DB::table('inventory_new')->select('product_name')->where(['id'=>$item_array[0]])->first();
                $itemname=$setinv->product_name;
                $itemtype="Item";
            }
            
            
            array_push($emailorderitems,array("type"=>$itemtype,"itemname"=>$itemname,"itemqty"=>$get_status->qty,"tracknumber"=>$get_status->courier_number));
    
        }
          
     
      
      $row++;
    }
        
        
    if($order_item_status==3 && $request->courier_patner==4)
      {
            
            $OrdersDetails=$this->getorderdata($request->invoice_number);
            $vendor_pickup_id=$this->get_vendor_loc_id();
            
            if($OrdersDetails->mode_of_payment==1){$mode_of_payment='Prepaid';}else{$mode_of_payment='Postpaid';}
            
            if($OrdersDetails->email!='' || $OrdersDetails->email!=NULL){$shipemail=$OrdersDetails->email;}else{$shipemail='evyapari@outlook.com';}
            // if($OrdersDetails->pincode!='' || $OrdersDetails->pincode!=NULL){$billpincode=$OrdersDetails->pincode;}else{$billpincode=$OrdersDetails->ship_pincode;}
            // if($OrdersDetails->address!='' || $OrdersDetails->address!=NULL){$billaddress=$OrdersDetails->address;}else{$billaddress=$OrdersDetails->ship_address;}
            // if($OrdersDetails->village!='' || $OrdersDetails->village!=NULL){$billvillage=$OrdersDetails->village;}else{$billvillage=$OrdersDetails->ship_village;}
            // if($OrdersDetails->landmark!='' || $OrdersDetails->landmark!=NULL){$billlandmark=$OrdersDetails->landmark;}else{$billlandmark=$OrdersDetails->ship_city;}
            // if($OrdersDetails->city!='' || $OrdersDetails->city!=NULL){$billcity=$OrdersDetails->city.','.$OrdersDetails->district;}else{$billcity=$OrdersDetails->ship_city.','.$OrdersDetails->ship_district;}
            // if($OrdersDetails->landmark!='' || $OrdersDetails->landmark!=NULL){$billlandmark=$OrdersDetails->landmark;}else{$billlandmark=$OrdersDetails->ship_city;}
            
           
            
            $get_item_prices=$this->get_item_prices_file($request->invoice_number,$getitemppforship);
            
            $batch_id='BATCH-'.$OrdersDetails->batch_id;
            $order_print_no=$OrdersDetails->batch_id;
            $orderid = $OrdersDetails->invoice_number;
            $orderdate = $OrdersDetails->order_time;
            $pickup_location = $vendor_pickup_id->location_id;
            $comment = $request->comment;
            $cus_invoice_number=$OrdersDetails->batch_id_no.' - '.$OrdersDetails->bill_no;
           
            // $billing_customer_name = $OrdersDetails->first_name;
            // $billing_last_name =$OrdersDetails->last_name;
            // $billing_address = $billaddress.','.$billvillage;
            // $billing_address_2 = $billlandmark;
            // $billing_city =$billcity;
            // $billing_pincode = $billpincode;
            // $billing_state = $OrdersDetails->state;
            // $billing_country = 'India';
            // $billing_email = $shipemail;
            // $billing_phone = $OrdersDetails->phone_no;
            
            
            
            $billing_customer_name = $OrdersDetails->first_name;
            $billing_last_name =$OrdersDetails->last_name.' ('.$OrdersDetails->ship_name.')';
            $billing_address = $OrdersDetails->ship_address.",".$OrdersDetails->ship_village;
            $billing_address_2 =  $OrdersDetails->ship_district;
            $billing_city =$OrdersDetails->ship_city;
            $billing_pincode = $OrdersDetails->ship_pincode;
            $billing_state = $OrdersDetails->ship_state;
            $billing_country = 'India';
            $billing_email = $shipemail;
            $billing_phone = $OrdersDetails->phone_no;
            $shipping_is_billing = false;
            $shipping_customer_name = $OrdersDetails->ship_name;
            $shipping_last_name ="";
            $shipping_address = $OrdersDetails->ship_address.",".$OrdersDetails->ship_village;
            $shipping_address_2 = $OrdersDetails->ship_district;
            $shipping_city = $OrdersDetails->ship_city;
            $shipping_pincode = $OrdersDetails->ship_pincode;
            $shipping_country = 'India';
            $shipping_state = $OrdersDetails->ship_state;
            $shipping_email = $shipemail;
            $shipping_phone = $OrdersDetails->ship_phone_no;
            $shipping_phone_alt = $OrdersDetails->phone_no;
                        
            $payment_method = $mode_of_payment;
            
            $shipping_charges = $get_item_prices['shiprocket_shipping_charges'];
            $transaction_charges =0 ;
            $total_discount = $get_item_prices['shiprocket_total_discount'];
            $sub_total = $get_item_prices['shiprocket_sub_total'];



            $giftwrap_charges = 0;
            $length = $request->parcel_length;
            $breadth = $request->parcel_breadth;
            $height = $request->parcel_Height;
            $weight = $request->parcel_weight/1000;
            
           
            
            $checshoprocketstatus=$this->create_order_in_shiprocket($orderid,$cus_invoice_number, $orderdate, $pickup_location, $comment, $billing_customer_name, $billing_last_name, $billing_address, $billing_address_2, $billing_city, $billing_pincode, $billing_state, $billing_country, $billing_email, $billing_phone, $shipping_is_billing, $shipping_customer_name, $shipping_last_name, $shipping_address, $shipping_address_2, $shipping_city, $shipping_pincode, $shipping_country, $shipping_state, $shipping_email, $shipping_phone, $shipping_phone_alt,$get_item_prices['order_items'], $payment_method, $shipping_charges, $giftwrap_charges, $transaction_charges, $total_discount, $sub_total, $length, $breadth, $height, $weight,$batch_id,$order_print_no);
            if($checshoprocketstatus['success']==0)
            {
               $response['success']=0;
               $response['msg']=$checshoprocketstatus['message_body'];
               $this->output($response);     
            //   return response()->json(['message' => $checshoprocketstatus], 500); 
            }
            
        $shipment_id=$checshoprocketstatus['shipment_id'];
        $shipment_order_id=$checshoprocketstatus['shipment_order_id'];
        
        if(($shipment_id!="" || $shipment_id!=NULL) && ($shipment_order_id!='' || $shipment_order_id!=NULL)){
        foreach($itemid_type as $shipitem)
        {
            $item_array_ship=explode(',',$shipitem);
            $update_ship_status=OrderTrackingModel::where(['invoice_number'=>$invoice_number,'vendor_id'=>$vendor_id,'item_id'=>$item_array_ship[0],'item_type'=>$item_array_ship[1]]);
            $update_ship_status->update(['status'=>1,'shipped_status'=>1,"shipment_id"=>$shipment_id,'ship_order_id'=>$shipment_order_id]);
        }}
  
  
  
        }
        
        
 
        if($row==$countid)
        {
        // $Order=OrdersModel::where(['invoice_number'=>$invoice_number,'user_id'=>$user_id,'order_status'=>3]);
        // if($Order)
        // {
            // $Order->update(['order_status'=>4]);
            // return redirect()->back()->with('success', 'Order Status Updated successfully!');
            //  return redirect()->to('order_under_process');
             
             if($order_item_status==3)
             {
                $useremail= ManageuserStudentModel::select('name','email')->where(['unique_id'=>$user_id])->first();
                $maildata=["name"=>$useremail->name,"ordernumber"=>$invoice_number,"orderitems"=>$emailorderitems];
              Mail::to($useremail->email)->send(new OrderShipMail($maildata));
             }
                     
             
               $response['success']=1;
               $response['msg']='Order Status Updated successfully!';
               $this->output($response); 
               
        // }
        // else
        // {
        //   return redirect('set_type')->withErrors(['' => 'Order Already Deliverd!']);  
        // }
        }
        else
        {
           
            $response['success']=0;
               $response['msg']='Something Went Wrong!';
               $this->output($response); 
            // return redirect()->back()->with('success', 'Item Status Updated successfully!');
        }
        
        }
        else
        {
              $response['success']=0;
               $response['msg']='Select Item to update status !';
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
            ->select(DB::raw('COUNT(order_tracking.invoice_number) as order_no'),'order_tracking.invoice_number','orders.order_weight','order_tracking.courier_number','vendor.phone_no as vendor_phone','users.email','order_shipping_address.name','order_shipping_address.phone_no','order_shipping_address.village','order_shipping_address.address','order_shipping_address.post_office','order_shipping_address.pincode','order_shipping_address.city','order_shipping_address.state','order_shipping_address.district')
            ->where($where)
            ->where('order_tracking.courier_number','!=',NULL)
            ->groupBy('order_tracking.courier_number')
            ->orderBy('order_tracking.id','asc')
            ->get();
   
        return view('orders_in_batch_xsl', ['data'=>$data]);
        
        
    }
 



public function update_order_ship_address(Request $request)
{
     $order_address_data = [
                'name'=>$request->name,
                'phone_no'=>$request->phone_no,
                'village'=>$request->village,
                'address'=>$request->address,
                'post_office'=>$request->post_office,
                'pincode'=>$request->pincode,
                'city'=>$request->city,
                'state'=>$request->state,
                'district'=>$request->district,
            ];
         
            $update_to_shippingaddress= OrderShippingAddressModel::where(['invoice_number'=>$request->invoice_number,'user_id'=>$request->user_id]);
            $res=$update_to_shippingaddress->update($order_address_data);
          
            if($res)
             {
                 $response['success']=1;
                   $response['msg']=' Updated successfully!';
                   $this->output($response); 
                   
            }
            else
            {
                  $response['success']=0;
                   $response['msg']='Error!';
                   $this->output($response); 
            } 
         
        
       
       
}
	
}












