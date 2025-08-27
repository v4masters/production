<?php
namespace App\Http\Controllers\Home;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Home;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

use App\Models\managemasterclassModel;
use App\Models\managemastersettypeModel;
use App\Models\managemastersetcatModel;
use App\Models\managemasterboardModel;
use App\Models\managemasterorganisationModel;
use App\Models\ManageuserSchoolModel;
use App\Models\managemastergradeModel;
use App\Models\OrderTrackingModel;
use App\Models\SchoolSetModel;
use App\Models\InventoryModel;
use App\Models\UserModel;


use App\Models\aws_img_url_model;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller

{
    public function aws_img_url()
    {
        $data = aws_img_url_model::where('id',1)->first();
        return $data->url;
    }


    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }
    
    public	function createRandomKey() {
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$key = '' ;
	 
		while ($i <= 10) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$key = $key . $tmp;
			$i++;
		}
	 
		return $key;
	}


    //schoolset
    public function schoolset()
    {
        $data['class'] = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $data['set_cat'] = managemastersetcatModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $data['set_type'] = managemastersettypeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        return view('schoolsetadd',$data);
    }
    
    public function editStudent(Request $request)
    {
       $user = UserModel::where(["unique_id"=>$request->id,])->first();
       $school= ManageuserSchoolModel::where(['id'=>session('id'),'unique_id'=>session('unique_id'),'del_status'=> 0])->first();

        $setdata = array(
            "first_name" => $user->first_name,
            "last_name" => $request->last_name,
            "fathers_name" => $request->fathers_name,
            "email" => $request->email,
            "phone_no" => $request->phone_no,
            // "class_no" => $request->class_no,
            // "item_id" => implode(',',$request->itemid),
            // "item_qty" => implode(',',$request->item_qty)
        );
       
       $res = $user->update($setdata);
         if ($res) {

            return redirect()->back()->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
   
    }
    
    //editStudentView
    public function editStudentView(string $id)
    {
        $data['pagedata'] = UserModel::where('unique_id', $id)->first();
        return view('StudentEdit', $data);
    }
    
    
    //edit_school_set_view
    public function edit_school_set_view(string $id)
    {
        $result=array();
        $array2=array();
          
        $class = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $set_cat = managemastersetcatModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $set_type = managemastersettypeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $old_info= SchoolSetModel::where(['id'=>$id,'school_id'=>session('id')])->first();
        
        $itemarray=explode(',',$old_info->item_id);
        $itemarrayqty=explode(',',$old_info->item_qty);
        
        $count=count($itemarray);
        for($i=0;$i<$count;$i++)
        {
              $itemdata= InventoryModel::where(['id'=>$itemarray[$i]])->first();
              $array2=['item_id'=>$itemarray[$i],'itemname'=>$itemdata->itemname,'unit_price'=>$itemdata->unit_price,'qty'=>$itemarrayqty[$i]];
              array_push($result,$array2);
            
        }
     
    
        return view('schoolsetedit',array('set_id'=>$id,'class'=>$class,'set_cat'=>$set_cat,'set_type'=>$set_type,'old_info'=>$old_info,'item_array'=>$result));
    }


    //student view
    public function viewStudents()
    { 
        $where = array('users.school_code'=>session('school_code'),'users.del_status' => 0);
        
        $data['students']= DB::table('users')
        ->leftJoin('school', 'school.school_code', '=', 'users.school_code')
        ->select('users.unique_id','users.first_name','users.last_name','users.fathers_name','users.email','users.phone_no', 'users.classno','users.status', 'school.zipcode as pincode', 'school.landmark as address')
        ->where($where)
        ->orderBy('users.id','desc')
        ->get();
            
        return view('StudentView', $data);
    }
    
    
    //saleReportView
  /*  public function ordersView(Request $request)
    { 
        $order_status = $request->order_status;
        
        if(isset($order_status))
        {
            $where = array('users.school_code'=>session('school_code'),'orders.order_status'=>$order_status,'orders.del_status' => 0);
        }
        else
        {
            $where = array('users.school_code'=>session('school_code'),'orders.del_status' => 0);
        }
        
        
        
        $data['students']= DB::table('orders')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->select('users.first_name','users.last_name','orders.user_id','orders.invoice_number','orders.vendor_id','orders.batch_id','orders.class','orders.order_total','orders.grand_total', 'orders.discount','orders.shipping_charge', 'orders.mode_of_payment', 'orders.order_status', 'orders.order_time', 'orders.delivery_status','orders.status')
        ->where($where)
        ->orderBy('orders.id','desc')
        ->get();
            
        return view('OrdersView', $data);
    }*/
    
/* public function ordersView(Request $request)
    {
        $order_status = $request->order_status;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
    
        // Base query
        $query = DB::table('orders')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->select(
                'users.first_name',
                'users.last_name',
                'orders.user_id',
                'orders.invoice_number',
                'orders.vendor_id',
                'orders.batch_id',
                'orders.class',
                'orders.order_total',
                'orders.grand_total',
                'orders.discount',
                'orders.shipping_charge',
                'orders.mode_of_payment',
                'orders.order_status',
                'orders.order_time',
                'orders.delivery_status',
                'orders.status'
            )
            ->where('users.school_code', session('school_code'))
            ->where('orders.del_status', 0);
    
        // Filter by order status
        if (!empty($order_status)) {
            $query->where('orders.order_status', $order_status);
        }
    
        // Filter by date range
        if (!empty($from_date) && !empty($to_date)) {
            $query->whereBetween(DB::raw('DATE(orders.created_at)'), [$from_date, $to_date]);
        }
    
        $data['students'] = $query->orderBy('orders.id', 'desc')->get();
    
        return view('OrdersViewnew', $data);
    }*/
    
   /*   public function ordersView(Request $request)
{
    $order_status = $request->order_status;
    $from_date = $request->from_date;
    $to_date = $request->to_date;

    $query = DB::table('orders')
    ->distinct()
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->leftJoin('order_tracking', 'order_tracking.invoice_number', '=', 'orders.invoice_number') // Join using invoice number
        ->select(
            'users.first_name',
            'users.last_name',
            'orders.user_id',
            'orders.invoice_number',
            'orders.vendor_id',
            'orders.batch_id',
           'users.classno',
            'orders.order_total',
            'orders.grand_total',
            'orders.discount',
            'orders.shipping_charge',
            'orders.mode_of_payment',
            'orders.order_status',
            'orders.order_time',
            'orders.delivery_status',
            'orders.status',
            'orders.updated_at',
            'order_tracking.courier_number'
      // Add tracking/courier number
        )
        ->where('users.school_code', session('school_code'))
        ->where('orders.del_status', 0);

    if (!empty($order_status)) {
        $query->where('orders.order_status', $order_status);
    }

    if (!empty($from_date) && !empty($to_date)) {
        $query->whereBetween(DB::raw('DATE(orders.created_at)'), [$from_date, $to_date]);
    }

    $data['students'] = $query->orderBy('orders.id', 'desc')->limit(100)->get();

    return view('OrdersViewnew', $data);
}*/




public function ordersView(Request $request)
{
    $order_status = $request->order_status;
    $from_date = $request->from_date;
    $to_date = $request->to_date;

    // Subquery: Group DISTINCT tracking numbers per invoice
    $trackingSubquery = DB::table('order_tracking')
        ->select(DB::raw('GROUP_CONCAT(DISTINCT courier_number SEPARATOR ", ") as courier_number'), 'invoice_number')
        ->groupBy('invoice_number');

    // Main query
    $query = DB::table('orders')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->leftJoinSub($trackingSubquery, 'tracking_combined', function ($join) {
            $join->on('tracking_combined.invoice_number', '=', 'orders.invoice_number');
        })
        ->select(
            'users.first_name',
            'users.last_name',
            'orders.user_id',
            'orders.invoice_number',
            'orders.vendor_id',
            'orders.batch_id',
            'users.classno',
            'orders.order_total',
            'orders.grand_total',
            'orders.discount',
            'orders.shipping_charge',
            'orders.mode_of_payment',
            'orders.order_status',
            'orders.order_time',
            'orders.delivery_status',
            'orders.status',
            'orders.updated_at',
            'tracking_combined.courier_number'
        )
        ->where('users.school_code', session('school_code'))
        ->where('orders.del_status', 0);

    // Apply order status filter
    if (!empty($order_status)) {
        $query->where('orders.order_status', $order_status);
    }

    // Apply date range filter
    if (!empty($from_date) && !empty($to_date)) {
        $query->whereBetween(DB::raw('DATE(orders.created_at)'), [$from_date, $to_date]);
    }

    // Final result
    $data['students'] = $query
        ->orderBy('orders.id', 'desc')
        ->get();

    return view('OrdersViewnew', $data);
}

/*public function ordersView($school_code)
{
    // Fetch the most recent order for the given school code
    $order = DB::table('orders')
        ->leftJoin('order_payment', 'orders.id', '=', 'order_payment.order_id')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->select(
            'orders.id',
            'orders.invoice_number',
            'orders.created_at',
            'orders.mode_of_payment',
            'users.first_name',
            'order_payment.transaction_id'
        )
        ->where('users.school_code', $school_code)
        ->orderBy('orders.created_at', 'desc')
        ->first();

    // Redirect if no order found
    if (!$order) {
        return redirect()->back()->with('error', 'No orders found for this school');
    }

    // Load JSON from S3 based on invoice number
    $file_path = 'sales_report/' . $order->invoice_number . '.jsonp';

    if (!Storage::disk('s3')->exists($file_path)) {
        return view('OrdersViewnew', compact('order'))->with('error', 'Item data not found');
    }

    try {
        $file_contents = Storage::disk('s3')->get($file_path);
        $items = json_decode($file_contents, true);

        if (!is_array($items)) {
            throw new \Exception('Invalid JSON format');
        }

    } catch (\Exception $e) {
        Log::error('Failed to load order items: ' . $e->getMessage());
        return view('OrdersViewnew', compact('order'))->with('error', 'Failed to load item details');
    }

    return view('OrdersViewnew', compact('order', 'items'));
}*/




    
   public function showDetail($invoice_number)
{
    // Fetch the order and related user
    $order = DB::table('orders')
        ->leftJoin('order_payment', 'orders.id', '=', 'order_payment.order_id')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->select('orders.id', 'orders.invoice_number', 'orders.created_at', 'orders.mode_of_payment', 'users.first_name',  'order_payment.transaction_id')
        ->where('orders.invoice_number', $invoice_number)
        ->first();

    // Redirect if order not found
    if (!$order) {
        return redirect()->back()->with('error', 'Order not found');
    }

    // S3 JSON file path
    $file_path = 'sales_report/' . $invoice_number . '.jsonp';

    // Check if file exists
    if (!Storage::disk('s3')->exists($file_path)) {
        return view('orders', compact('order'))->with('error', 'Item data not found');
    }

    // Read and decode item JSON
    try {
        $file_contents = Storage::disk('s3')->get($file_path);
        $items = json_decode($file_contents, true);

        // Ensure it's an array
        if (!is_array($items)) {
            throw new \Exception('Invalid JSON format');
        }

    } catch (\Exception $e) {
        Log::error('Failed to load order items: ' . $e->getMessage());
        return view('orders', compact('order'))->with('error', 'Failed to load item details');
    }

    return view('orders', compact('order', 'items'));
}
/*public function showDetail($invoice_number)
{
    // Fetch order joined with user and payment
    $order = DB::table('orders')
        ->leftJoin('order_payment', 'orders.id', '=', 'order_payment.order_id')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->select(
            'orders.id',
            'orders.invoice_number',
            'orders.created_at',
            'orders.mode_of_payment',
            'orders.product_id', // assuming this column exists
            'users.first_name',
            'order_payment.transaction_id'
        )
        ->where('orders.invoice_number', $invoice_number)
        ->first();

    if (!$order) {
        return redirect()->back()->with('error', 'Order not found');
    }

    // Fetch product details from inventory table
    $product = null;
    if ($order->product_id) {
        $product = DB::table('inventory')
            ->where('product_id', $order->product_id)
            ->first();
    }

    return view('orders', compact('order', 'product'));
}*/



    
    
    //saleReportView
    /*public function saleReportView()
    { 
        // $where = array('users.school_code'=>session('school_code'),'orders.order_status'=>4,'orders.del_status' => 0);
        // $orders= DB::table('orders')
        // ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        // ->select('orders.invoice_number')
        // ->where($where)
        // ->orderBy('orders.id','asc')
        // ->get();
        
        // $ordered_items=[];
        // $mydata = [];
        // 	$array=[];
        //     $array2=[];
            $final_array=[];
//         foreach($orders as $order)
//         {
            
            
//             $orderfile=Storage::disk('s3')->get('sales_report/'.$order->invoice_number.'.jsonp');
//         	$getfile=json_decode ($orderfile,true);
//         	$count=count($getfile);
        	
        
        	
//             foreach($getfile as $data)
//             {
//                 if($data['item_type']==1)
//                 {
//                     $product_name=$data['itemname'];
//                     $product_id=$data['itemcode'];
//                     $class_title=$data['class_title'];
//                     $mrp=$data['unit_price'];
//                     $discounted_price=$data['unit_price']-$data['item_discount'];
//                     $qty=$data['item_qty'];
//                     $brand_title=$data['company_name'];
//                  }
//                 else
//                 { 
//                     $product_name=$data['product_name'];
//                     $product_id=$data['product_id'];
//                     $class_title=$data['class_title'];
//                     $mrp=$data['mrp'];
//                     $discounted_price=$data['discounted_price'];
//                     $qty=$data['item_qty'];
//                     $brand_title=$data['brand_title'];
                    
                   
//                 }
              
//             array_push($array,array("unit_price"=>$discounted_price,"product_id"=>$product_id));
// 			array_push($array2,array("brand_title"=>$brand_title,"itemname"=>$product_name,"class"=>$class_title,"item_qty"=>$qty));

                    
//             }
            
            
//         }
            
//         $count_total=count($array);
//         if($count_total!=0)
//         {
// 		$uni_array=array_unique($array,SORT_REGULAR);
// 		$unique_array=array_combine(range(1, count($uni_array)), array_values($uni_array));
// 		$count_unique_item=count($unique_array);
// 		for($j=1;$j<=$count_unique_item;$j++)
// 		{
// 		    $uniuqitem=0;
// 			$item_total_qty=0;
// 			$total_amount=0;
// 			for($k=0;$k<$count_total;$k++)
// 			{
// 				if($array[$k]['product_id']==$unique_array[$j]['product_id'] && $array[$k]['unit_price']==$unique_array[$j]['unit_price'] )
// 				{
				    
// 					$item_total_qty=$item_total_qty+$array2[$k]['item_qty'];
// 					$uniuqitem=1;
// 					$total_amount=$item_total_qty*$unique_array[$j]['unit_price'];
// 					$itemname=$array2[$k]['itemname'];
//                     $class=$array2[$k]['class'];
//                     $brandtitle=$array2[$k]['brand_title'];
// 				}
// 			}
// 			if($uniuqitem==1)
// 			{
// 			array_push($final_array,array("brand_title"=>$brandtitle,"total_amount"=>$total_amount,"unit_price"=>$unique_array[$j]['unit_price'],"itemname"=>$itemname,"class"=>$class,"itemcode"=>$unique_array[$j]['product_id'],"qty_sold"=>$item_total_qty));
// 		    }
// 		}
// 		}
      
      return view('SaleReportView', array('itemdata'=>$final_array,"date_from"=>"","date_to"=>""));
    }*/
    
    public function saleReportView(Request $request)
    {
        $schoolCode = session('school_code');
    
        // Initialize query builder for orders
        $query = DB::table('orders')
            ->join('users', 'users.unique_id', '=', 'orders.user_id')
            ->where([
                'users.school_code' => $schoolCode,
                'orders.order_status' => 4,  // Delivered
                'orders.del_status' => 0
            ])
            ->select('orders.invoice_number')
            ->orderBy('orders.id', 'desc');
    
        // Apply date filters if provided
        if ($request->isMethod('post')) {
            // Apply date filtering logic
            if ($request->has('from_date') && $request->has('to_date')) {
                $fromDate = Carbon::parse($request->from_date)->startOfDay();
                $toDate = Carbon::parse($request->to_date)->endOfDay();
    
                // Add date filtering to query
                $query->whereBetween('orders.created_at', [$fromDate, $toDate]);
            }
        } else {
            // Default limit of 100 records if no date filter
            $query->limit(100);
        }
    
        // Fetch orders
        $orders = $query->get();
    
        // Initialize SKU items array
        $skuItems = [];
    
        // Step 2: Loop through orders and check cache for preprocessed data
        foreach ($orders as $order) {
            $cacheKey = 'invoice_data_' . $order->invoice_number;
    
            // Check if the data is already cached (pre-processed)
            $items = Cache::get($cacheKey);
    
            if (!$items) {
                // If not cached, fetch from S3
                $filePath = 'sales_report/' . $order->invoice_number . '.jsonp';
                
                // If file exists in S3, fetch the content
                if (Storage::disk('s3')->exists($filePath)) {
                    $content = Storage::disk('s3')->get($filePath);
                    $items = json_decode($content, true);
    
                    // Cache the decoded JSON data for future use
                    Cache::put($cacheKey, $items, now()->addHours(1));  // Cache for 1 hour or as needed
                } else {
                    continue;  // Skip this file if it doesn't exist
                }
            }
    
            // Process the items (only if they are in valid format)
            if (is_array($items)) {
                foreach ($items as $item) {
                    $sku = $item['item_type'] == 1 ? $item['itemcode'] : $item['product_id'];
                    $price = $item['item_type'] == 1 ? ($item['unit_price'] - $item['item_discount']) : $item['discounted_price'];
                    $itemQty = (int) $item['item_qty'];
    
                    if ($itemQty <= 0) continue;
    
                    $key = $sku . '_' . $price;
    
                    // Initialize the entry if not already set
                    if (!isset($skuItems[$key])) {
                        $skuItems[$key] = [
                            'itemcode' => $sku,
                            'itemname' => $item['item_type'] == 1 ? $item['itemname'] : $item['product_name'],
                            'class' => $item['class_title'],
                            'brand_title' => $item['item_type'] == 1 ? $item['company_name'] : $item['brand_title'],
                            'unit_price' => $price,
                            'qty_sold' => 0,
                            'total_amount' => 0
                        ];
                    }
    
                    // Accumulate quantities and total amounts
                    $skuItems[$key]['qty_sold'] += $itemQty;
                    $skuItems[$key]['total_amount'] = $skuItems[$key]['qty_sold'] * $price;
                }
            }
        }
    
        // Step 3: Sort and return results
 

$final_array = array_values($skuItems);
usort($final_array, function ($a, $b) {
    if ($a['total_amount'] == $b['total_amount']) {
        return 0;
    }
    return ($a['total_amount'] < $b['total_amount']) ? 1 : -1;
});

return view('SaleReportViewnew', [
    'itemdata' => $final_array,
    'date_from' => $request->from_date ?? '',
    'date_to' => $request->to_date ?? ''
]);


    }
    
    


// DateWisesaleReportView

  public function DateWisesaleReportView(Request $request)
    { 
        $where = array('users.school_code'=>session('school_code'),'orders.order_status'=>4,'orders.del_status' => 0);
        $orders= DB::table('orders')
        ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
        ->select('orders.invoice_number')
        ->where($where)
        ->orderBy('orders.id','asc')
        ->get();
        
        $ordered_items=[];
        $mydata = [];
        	$array=[];
            $array2=[];
            $final_array=[];
        foreach($orders as $order)
        {
            
            
            $orderfile=Storage::disk('s3')->get('sales_report/'.$order->invoice_number.'.jsonp');
        	$getfile=json_decode ($orderfile,true);
        	$count=count($getfile);
        	
        
        	
            foreach($getfile as $data)
            {
                
                if($data['item_type']==1)
                {
                    $product_name=$data['itemname'];
                    $product_id=$data['itemcode'];
                    $class_title=$data['class_title'];
                    $mrp=$data['unit_price'];
                    $discounted_price=$data['unit_price']-$data['item_discount'];
                    $qty=$data['item_qty'];
                    $brand_title=$data['company_name'];
                }
                else
                {
                   
                    $product_name=$data['product_name'];
                    $product_id=$data['product_id'];
                    $class_title=$data['class_title'];
                    $mrp=$data['mrp'];
                    $discounted_price=$data['discounted_price'];
                    $qty=$data['item_qty'];
                    $brand_title=$data['brand_title'];
                }
                
                $OrderTrackingModel = OrderTrackingModel::where('product_id', $product_id)
                                    ->whereBetween('delivered_on', [$request->from_date, $request->to_date])
                                    ->count();
    
                
                if($OrderTrackingModel>0)
                {
               
                    array_push($array,array("unit_price"=>$discounted_price,"product_id"=>$product_id));
        			array_push($array2,array("brand_title"=>$brand_title,"itemname"=>$product_name,"class"=>$class_title,"item_qty"=>$qty));

                }
            }
            
            
        }
            
        $count_total=count($array);
        if($count_total!=0)
        {
		$uni_array=array_unique($array,SORT_REGULAR);
		$unique_array=array_combine(range(1, count($uni_array)), array_values($uni_array));
		$count_unique_item=count($unique_array);
		for($j=1;$j<=$count_unique_item;$j++)
		{
		    $uniuqitem=0;
			$item_total_qty=0;
			$total_amount=0;
			for($k=0;$k<$count_total;$k++)
			{
				if($array[$k]['product_id']==$unique_array[$j]['product_id'] && $array[$k]['unit_price']==$unique_array[$j]['unit_price'] )
				{
				    
					$item_total_qty=$item_total_qty+$array2[$k]['item_qty'];
					$uniuqitem=1;
					$total_amount=$item_total_qty*$unique_array[$j]['unit_price'];
					$itemname=$array2[$k]['itemname'];
                    $class=$array2[$k]['class'];
                    $brandtitle=$array2[$k]['brand_title'];
				}
			}
			if($uniuqitem==1)
			{
			array_push($final_array,array("brand_title"=>$brandtitle,"total_amount"=>$total_amount,"unit_price"=>$unique_array[$j]['unit_price'],"itemname"=>$itemname,"class"=>$class,"itemcode"=>$unique_array[$j]['product_id'],"qty_sold"=>$item_total_qty));
		    }
		}
		}
      
      return view('SaleReportView', array('itemdata'=>$final_array,"date_from"=>$request->from_date,"date_to"=>$request->to_date));
    }
    








public function searchItem(Request $request)
   {
    $filterData = DB::table('inventory')->select('id as value','itemname as label')->where('itemname','LIKE','%'.$request->search.'%')->get();
    
    $this->output($filterData);
   }
   
    /*
	* SearchItem
   **/
   
   public function getItemDetails(Request $request)
   {
        $filterData = DB::table('inventory')->where('id',$request->itemid)->first();
        $this->output($filterData);
        
	     

   }

//add_school_set
public function add_school_set(Request $request)
{
    
       
       $school= ManageuserSchoolModel::where(['id'=>session('id'),'unique_id'=>session('unique_id'),'del_status'=> 0])->first();

       $setid=$this->createRandomKey().rand(10,1000);
       
        $setdata = array(
            "school_id"=>session('id'),
            'set_id'=>$setid,
            "org" => $school->organisation,
            "board" => $school->board,
            "grade" => $school->grade,
            "set_class" => $request->set_class,
            "set_category" => $request->set_cat,
            "set_type" => $request->set_type,
            "item_id" => implode(',',$request->itemid),
            "item_qty" => implode(',',$request->item_qty),
            "created_at"=>date('Y-m-d H:i:s')
        );
        
        $setdata = SchoolSetModel::create($setdata);
      if($setdata)
      {
        
       $data['success']=1;
       $data['success_msg']='Set created successfully .';
       
        $this->output($data);
      }
      else
      {
        $data['error']=1;
        $data['error_msg']='Something Went Wrong!';
        $this->output($data);
      }
   
}

public function edit_school_set(Request $request)
{
       
       $where = SchoolSetModel::where(["id"=>$request->id,'school_id'=>session('id')]);
       $school= ManageuserSchoolModel::where(['id'=>session('id'),'unique_id'=>session('unique_id'),'del_status'=> 0])->first();

        $setdata = array(
            "org" => $school->organisation,
            "board" => $school->board,
            "grade" => $school->grade,
            "set_class" => $request->set_class,
            "set_category" => $request->set_cat,
            "set_type" => $request->set_type,
            "item_id" => implode(',',$request->itemid),
            "item_qty" => implode(',',$request->item_qty)
        );
       
        
       $res = $where->update($setdata);
      if($res)
      {
        
       $data['success']=1;
       $data['success_msg']='Set updated successfully .';
       
        $this->output($data);
      }
      else
      {
        $data['error']=1;
        $data['error_msg']='Something Went Wrong!';
        $this->output($data);
      }
   
}
    
    
    //get_set_item
     public function get_set_item(Request $request)
    {

	   
        $data= SchoolSetModel::where(['set_id'=>$request->set_id,'school_id'=>session('id'),"del_status"=>0])->first();
      
        $result=[];
        $array2=[];
        
   

        $itemarray=explode(',',$data->item_id);
        $itemarrayqty=explode(',',$data->item_qty);
        
        $count=count($itemarray);
        for($i=0;$i<$count;$i++)
        {
              $itemdata= InventoryModel::where(['id'=>$itemarray[$i]])->first();
              $array2=['img'=>"<img style='height:50px;weight:50px;' src=".Storage::disk('s3')->url($itemdata->folder.'/'.$itemdata->cover_photo).">",'itemname'=>$itemdata->itemname,'unit_price'=>$itemdata->unit_price,'itemcode'=>$itemdata->itemcode,'qty'=>$itemarrayqty[$i],'cover_photo'=>$itemdata->cover_photo];
              array_push($result,$array2);
            
        }
          
       
           $this->output($result);
	
    }

   // delete set
      public function delete_school_set(Request $request)
      {

        $data= SchoolSetModel::where(['id'=>$request->id,'set_id'=>$request->set_id,'school_id'=>session('id')])->first();
        $res = $data->delete();

        if ($res) {

          return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

          return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
      }


}
