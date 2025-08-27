<?php
namespace App\Http\Controllers\PickupPoint;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\PickupPoint;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\OrdersModel;
use App\Models\OrderBatch;
use App\Models\OrderTrackingModel;
use App\Models\managemastersizelistModel;
use App\Models\PickupPoint\PickupPoints;

use App\Mail\OrderShipMail;
use App\Mail\OrderProcessMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class PickupPointOrderController extends Controller
{
    
    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }
    

	//pp_new_orders
    public function pp_new_orders()
    { 
        $result=array();
        $itemdata=[];
        $where=array('orders.order_status'=>2,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        
        $data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('pickup_points', 'pickup_points.id', '=', 'orders.pp_id')
            ->select('pickup_points.pickup_point_name as pp_name','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_amount','order_payment.transaction_date','orders.invoice_number','orders.grand_total','orders.mode_of_payment')
            ->where($where)
            ->where('orders.pp_id','!=',NULL)
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
        return view('PickupPoint.pp_orders_new', ['neworders' => $result]);
    }

   

    //pp_order_under_process
    public function pp_order_under_process()
    {
        $result=array();
        
        
        $where=array('sale_tax_register.vendor_id'=>session('id'),'orders.mode_of_payment'=>1,'sale_tax_register.batch_id'=>0,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->leftJoin('pickup_points', 'pickup_points.id', '=', 'orders.pp_id')
            ->select('pickup_points.pickup_point_name as pp_name','orders.shipping_charge','orders.grand_total','orders.order_status','orders.print_status','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
            ->where('sale_tax_register.order_status',3)
            ->where('orders.pp_id',"!=",NULL)
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
        $ppdata=[];
        $ppdata= PickupPoints::orderBy('id', 'DESC')->where(['status'=>1,'del_status'=>0])->get();
        return view('PickupPoint.pp_orders_under_process', ['orders' => $result,'pp_data'=>$ppdata]);
    }
    
      public function pp_order_under_process_pp($id)
    {
        $result=array();
        
        
        $where=array('pickup_points.id'=>$id,'sale_tax_register.vendor_id'=>session('id'),'orders.mode_of_payment'=>1,'sale_tax_register.batch_id'=>0,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->leftJoin('pickup_points', 'pickup_points.id', '=', 'orders.pp_id')
            ->select('pickup_points.pickup_point_name as pp_name','orders.shipping_charge','orders.grand_total','orders.order_status','orders.print_status','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
            ->where('sale_tax_register.order_status',3)
            ->where('orders.pp_id',"!=",NULL)
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
        
        $ppdata=[];
        $ppdata= PickupPoints::orderBy('id', 'DESC')->where(['status'=>1,'del_status'=>0])->get();
        return view('PickupPoint.pp_orders_under_process', ['orders' => $result,'pp_data'=>$ppdata]);
 
    }
    
    //pp_order_under_process_cod
    public function pp_order_under_process_cod()
    { 
        $result=array();
        $where=array('sale_tax_register.vendor_id'=>session('id'),'orders.mode_of_payment'=>2,'sale_tax_register.batch_id'=>0,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->leftJoin('pickup_points', 'pickup_points.id', '=', 'orders.pp_id')
            ->select('pickup_points.pickup_point_name as pp_name','order_shipping_address.school_code','orders.grand_total','orders.shipping_charge','orders.order_status','orders.print_status','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
             ->where('sale_tax_register.order_status',3)
             ->where('orders.pp_id',"!=",NULL)
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
     
        $ppdata=[];
        $ppdata= PickupPoints::orderBy('id', 'DESC')->where(['status'=>1,'del_status'=>0])->get();
        return view('PickupPoint.pp_orders_under_process_cod', ['orders' => $result,'pp_data'=>$ppdata]);
    }
    
     public function pp_order_under_process_cod_pp($id)
    { 
        
        
        $result=array();
        $where=array('pickup_points.id'=>$id,'sale_tax_register.vendor_id'=>session('id'),'orders.mode_of_payment'=>2,'sale_tax_register.batch_id'=>0,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->leftJoin('pickup_points', 'pickup_points.id', '=', 'orders.pp_id')
            ->select('pickup_points.pickup_point_name as pp_name','order_shipping_address.school_code','orders.grand_total','orders.shipping_charge','orders.order_status','orders.print_status','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
             ->where('sale_tax_register.order_status',3)
             ->where('orders.pp_id',"!=",NULL)
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
        
        $ppdata=[];
        $ppdata= PickupPoints::orderBy('id', 'DESC')->where(['status'=>1,'del_status'=>0])->get();
        return view('PickupPoint.pp_orders_under_process_cod', ['orders' => $result,'pp_data'=>$ppdata]);

    }
    
    //pp_order_process_status
    public function pp_order_process_status(Request $request,String $id)
    { 
        $result=array();
        $where=array('orders.invoice_number'=>$id,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $order_data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->leftJoin('vendor','vendor.unique_id','=','sale_tax_register.vendor_id')
            ->select('vendor.update_pp_order_status','orders.custom_set_status','orders.grand_total','orders.shipping_charge as total_shipping','orders.print_status','sale_tax_register.created_at as inv_created_at','vendor.unique_id','sale_tax_register.bill_id','vendor.unique_id as vendor_unique_id',	'vendor.username as vendor_username',	'vendor.email as vendor_email',	'vendor.phone_no as vendor_phone_no',	'vendor.gst_no as vendor_gst_no',	'vendor.country as vendor_country',	'vendor.state as vendor_state',	'vendor.distt as vendor_distt',	'vendor.city as vendor_city',	'vendor.landmark as vendor_landmark',	'vendor.pincode as vendor_pincode',	'vendor.address as vendor_address',	'order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','sale_tax_register.total_amount','sale_tax_register.total_discount','sale_tax_register.shipping_charge','orders.vendor_id','users.unique_id as user_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.classno','users.state','users.district','users.city','users.post_office','users.village','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.order_status','orders.invoice_number','orders.mode_of_payment')
            ->where($where)
            ->whereIn('orders.order_status',[2,3])
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
        return view('PickupPoint.pp_orders_update_status', ['order' => $order_data,'item_info'=>$iteminfo,'tracking'=>$tracking,'courier_data'=>$courier_data]);
    }
    
    
    //pp_bacth_order
    public function pp_bacth_order()
    { 
        $where=array('order_under_batch.pp_status'=>1,'order_under_batch.status'=>0,'order_under_batch.vendor_id'=>session('id'));
        $data= DB::table('order_under_batch')
            ->leftJoin('sale_tax_register', 'sale_tax_register.batch_id', '=', 'order_under_batch.id')
            ->leftJoin('orders', 'orders.invoice_number', '=', 'sale_tax_register.order_id')
            ->select('order_under_batch.*')
            ->where($where)
            ->where('orders.pp_id',"!=",NULL)
            ->whereIn('sale_tax_register.order_status',[3,4])
            ->groupBy('sale_tax_register.batch_id')
            ->orderBy('order_under_batch.id','desc')
            ->get();
        return view('PickupPoint.pp_order_batch_in_proccess', ['batch' => $data]);
    }
    
    
    //pp_bacth_all_order
    public function pp_bacth_all_order(Request $request,$id,$bid)
    {   
        $result=array();
        $array_push=array();
        $where=array('sale_tax_register.batch_id'=>$id,'sale_tax_register.vendor_id'=>session('id'),'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $orderdata= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->leftJoin('users', 'users.unique_id', '=', 'orders.user_id')
            ->leftJoin('sale_tax_register','sale_tax_register.order_id','=','orders.invoice_number')
            ->leftJoin('order_shipping_address','order_shipping_address.invoice_number','=','orders.invoice_number')
            ->leftJoin('vendor','vendor.unique_id','=','sale_tax_register.vendor_id')
            ->leftJoin('pickup_points', 'pickup_points.id', '=', 'orders.pp_id')
            ->select('pickup_points.pickup_point_name as pp_name','orders.custom_set_status','orders.grand_total','vendor.unique_id as vendor_unique_id','sale_tax_register.created_at as inv_created_at','vendor.username as vendor_username',	'vendor.email as vendor_email',	'vendor.phone_no as vendor_phone_no',	'vendor.gst_no as vendor_gst_no',	'vendor.country as vendor_country',	'vendor.state as vendor_state',	'vendor.distt as vendor_distt',	'vendor.city as vendor_city',	'vendor.landmark as vendor_landmark',	'vendor.pincode as vendor_pincode',	'vendor.address as vendor_address',	'sale_tax_register.print_status','sale_tax_register.bill_id','order_shipping_address.address_type as ship_address_type','order_shipping_address.name as ship_name','order_shipping_address.phone_no as ship_phone_no','order_shipping_address.school_code as ship_school_code','order_shipping_address.school_name as ship_school_name','order_shipping_address.alternate_phone as ship_alternate_phone','order_shipping_address.village as ship_village','order_shipping_address.address as ship_address','order_shipping_address.post_office as ship_post_office','order_shipping_address.pincode as ship_pincode','order_shipping_address.city as ship_city','order_shipping_address.state as ship_state','order_shipping_address.state_code as ship_state_code','order_shipping_address.district as ship_district','sale_tax_register.total_amount','sale_tax_register.total_discount','sale_tax_register.shipping_charge','orders.vendor_id','users.user_type','users.name','users.fathers_name','users.phone_no','users.school_code','users.state','users.district','users.city','users.post_office','users.village','users.classno','users.address','users.landmark','users.pincode','order_payment.transaction_id','order_payment.transaction_date','orders.invoice_number','orders.mode_of_payment','orders.grand_total','orders.shipping_charge as total_shipping')
            ->where($where)
            ->whereIn('sale_tax_register.order_status',[3,4])
            ->where('orders.pp_id',"!=",NULL)
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
                    // $discount_rate=$data['mrp']-$data['discount'];
                    // $discount_rate= $itemdata['discount_rate'];
                    $itemdata['discount']=($data['mrp']*$data['discount'])/100;
                    $itemdata['total_without_gst']=$data['discounted_price']-($data['discounted_price']*$data['gst_title']/100);
                    $itemdata['qty']=$data['item_qty'];
                    $itemdata['gst']=$data['gst_title'];
                    
                    $gstval=100+$data['gst_title'];
                    $itemdata['without_gst_rate']=($data['discounted_price']/$gstval)*100;
                    $itemdata['gst_rate']=$data['discounted_price']-($data['discounted_price']/$gstval)*100;
                    
                    $itemdata['item_ship_chr']=$data['shipping_charges'];
                        
                    $itemdata['class']=$data['class_title'];
                    $itemdata['size_medium']=$size_medium;
                    }
                    
                    
                    array_push($iteminfo,$itemdata);
                
            }
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
        
        $batchModel=OrderBatch::where(['id'=>$request->id])->first();
        return view('PickupPoint.pp_orders_in_batch',['data'=>$result,'batch_id'=>$id,'bid'=>$bid,'print_status'=>$batchModel->print_status]);
    }
	
}












