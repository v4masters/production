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
use App\Models\Users;
use App\Models\SaleTaxRegister;

   
class SalesReportController extends Controller
{
    
    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }
   
  //sale_tax_register
  public function sale_tax_register()
    { 
        $result=array();
        $datefrom="";
        $dateto="";
        $where=array('sale_tax_register.del_status'=>0,'sale_tax_register.status'=>1,'sale_tax_register.vendor_id'=>session('id'));
        $data= DB::table('sale_tax_register')
            // ->leftJoin('order_payment', 'order_payment.order_id', '=', 'sale_tax_register.order_id')
            ->leftJoin('orders', 'orders.invoice_number', '=', 'sale_tax_register.order_id')
            ->leftJoin('users', 'users.unique_id', '=', 'sale_tax_register.user_id')
            ->select('sale_tax_register.created_at as acc_created_at','sale_tax_register.gst_0','sale_tax_register.gst_5','sale_tax_register.gst_12','sale_tax_register.gst_18','sale_tax_register.gst_28','orders.order_time','sale_tax_register.order_id','sale_tax_register.bill_id','sale_tax_register.total_amount','sale_tax_register.shipping_charge','sale_tax_register.gst_type','orders.shipping_charge','users.user_type','users.name','sale_tax_register.user_state_code')
            ->where($where)
            ->orderBy('sale_tax_register.created_at','desc')
            ->get();
           
        return view('sale_tax_register', ['saletax' => $data ,'fromdate'=>$datefrom,'todate'=>$dateto]);
    }
    
    //sale_tax_register_date_wise
     public function sale_tax_register_date_wise(Request $request)
    { 
        $result=array();
        
        
         $datefrom=$request->from_date." 00:00:59";
	     $dateto=$request->to_date." 23:59:59";
	     
	     $datefromsend=$request->from_date;
	     $datetosend=$request->to_date;
	     
	     
	  
	  
        $where=array('sale_tax_register.del_status'=>0,'sale_tax_register.status'=>1,'sale_tax_register.vendor_id'=>session('id'));
        $data= DB::table('sale_tax_register')
            // ->leftJoin('order_payment', 'order_payment.order_id', '=', 'sale_tax_register.order_id')
            ->leftJoin('orders', 'orders.invoice_number', '=', 'sale_tax_register.order_id')
            ->leftJoin('users', 'users.unique_id', '=', 'sale_tax_register.user_id')
            ->select('sale_tax_register.created_at as acc_created_at','sale_tax_register.gst_0','sale_tax_register.gst_5','sale_tax_register.gst_12','sale_tax_register.gst_18','sale_tax_register.gst_28','orders.order_time','sale_tax_register.order_id','sale_tax_register.bill_id','sale_tax_register.total_amount','orders.shipping_charge','users.user_type','users.name','sale_tax_register.gst_type','sale_tax_register.user_state_code')
             ->where($where)
            ->whereBetween('sale_tax_register.created_at', [$datefrom, $dateto])
            ->orderBy('sale_tax_register.created_at','desc')
            ->get();
           
        return view('sale_tax_register', ['saletax' => $data,'fromdate'=>$datefromsend,'todate'=>$datetosend]);
    }
    
    

    //set_item_sale_report
   /* public function set_item_sale_report()
    { 
        $result=array();

        $where=array('order_tracking.vendor_id'=>session('id'),'order_tracking.item_type'=>1);
        $data= DB::table('order_tracking')
            ->leftJoin('inventory', 'inventory.itemcode', '=', 'order_tracking.product_id')
            ->leftJoin('master_classes', 'master_classes.id', '=', 'inventory.class')
            ->select('inventory.company_name as company','master_classes.title as class','inventory.hsncode','inventory.barcode','inventory.itemname','inventory.itemcode','order_tracking.product_id',DB::raw('COUNT(order_tracking.product_id) as saleitem'))
            ->where($where)
            ->where('order_tracking.tracking_status','>',0)
            ->groupBy('order_tracking.product_id')
            ->orderBy('master_classes.title','asc')
            ->get();

           
        return view('sale_set_item_report', ['item_sale' => $data]);
    }*/
    
    public function set_item_sale_report(Request $request)
{ 
    $where = [
        'order_tracking.vendor_id' => session('id'),
        'order_tracking.item_type' => 1
    ];

    $query = DB::table('order_tracking')
        ->leftJoin('inventory', 'inventory.itemcode', '=', 'order_tracking.product_id')
        ->leftJoin('master_classes', 'master_classes.id', '=', 'inventory.class')
        ->select(
            'inventory.company_name as company',
            'master_classes.title as class',
            'inventory.hsncode',
            'inventory.barcode',
            'inventory.itemname',
            'inventory.itemcode',
            'order_tracking.product_id',
            DB::raw('COUNT(order_tracking.product_id) as saleitem')
        )
        ->where($where)
        ->where('order_tracking.tracking_status', '>', 0);

    if ($request->from_date && $request->to_date) {
        $query->whereBetween(DB::raw('DATE(order_tracking.created_at)'), [$request->from_date, $request->to_date]);
    }

    $data = $query->groupBy('order_tracking.product_id')
                  ->orderBy('master_classes.title', 'asc')
                  ->get();

    return view('sale_set_item_report', [
        'item_sale' => $data,
        'from_date' => $request->from_date,
        'to_date' => $request->to_date
    ]);
}

    
    
    //inv_item_sale_report
    public function inv_item_sale_report()
    { 
        $result=array();

        $where=array('order_tracking.vendor_id'=>session('id'),'order_tracking.item_type'=>0);
        $data= DB::table('order_tracking')
            ->leftJoin('inventory_new', 'inventory_new.product_id', '=', 'order_tracking.product_id')
            ->leftJoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
            ->leftJoin('master_brand', 'master_brand.id', '=', 'inventory_new.brand')
            ->select('master_brand.title as company','master_classes.title as class','inventory_new.hsncode','inventory_new.barcode','inventory_new.product_name as itemname','inventory_new.product_id as itemcode',DB::raw('COUNT(order_tracking.product_id) as saleitem'))
            ->where($where)
            ->where('order_tracking.tracking_status','>',0)
            ->groupBy('order_tracking.product_id')
            ->orderBy('master_classes.title','asc')
            ->get();
            
            
        
           
        return view('sale_inv_item_report', ['item_sale' => $data]);
           
    }

}












