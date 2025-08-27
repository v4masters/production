<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\API\CartModel;
use App\Models\API\WishlistModel;
use App\Models\API\UserAddressesModel;
use App\Models\API\SchoolModel;
use App\Models\API\SchoolSetVendorModel;
use App\Models\API\InventoryModel;
use App\Models\API\InventoryNewModel;
use App\Models\API\OrdersModel;
use App\Models\API\OrderTrackingModel;
use App\Models\API\OrderShippingAddressModel;
use App\Models\API\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\API\CatOne;
use App\Models\API\InventoryImgModel;
use App\Models\API\CatTwo;
use App\Models\API\CatThree;
use App\Models\API\CatFour;
use App\Models\API\managemastersetcatModel;
use App\Models\PickupPoint\PickupPoint;
use App\Models\API\Paytm;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
   
   
class OrderController extends BaseController
{
    //Genrating unique number
    public function createRandomKey() {
        $vdata = OrdersModel::select('id')->orderBy('id', 'DESC')->first();
        if($vdata)
        {
            $vid=$vdata['id']+1;
        }
        else 
        {
            $vid=1;
        }
        
	   // return rand(0,9);
        return rand(10,99).$vid;
	}
	
	function generateReferenceNumber()
	{
        $prefix = "REF";
        $date = date("YmdHis");
        $ref_no = str_pad(rand(10,10000),4,"0",STR_PAD_LEFT);
        return $prefix.$date.$ref_no;
    }
 
	

	//get_payment_status
    public function get_payment_status(Request $request) {
        
        if($request->user_id!="")
        {
  
           $payment_status= DB::table('order_payment')
                ->leftjoin('users','users.unique_id','=','order_payment.user_id')
                ->select('order_payment.pay_mode','order_payment.order_id','order_payment.status','order_payment.transaction_id','order_payment.transaction_amount','users.name')
                ->where(['order_payment.order_id'=>$request->order_id,'order_payment.user_id'=>$request->user_id])
                ->first();  
                
       
                
        if($payment_status->status==0)
        {
            $msg="Your payment is failed! reattempt the transaction.";
        }
        elseif($payment_status->status==1)
        {
            $msg="Your payment is successfull.";
        }
        elseif($payment_status->status==2)
        {
            $msg="Your payment is processing.";
        }
        else
        {
             $msg="Something went wrong!";
        }
        
        $response = ['success' => 1,'message'=>$msg,'data' => $payment_status,];
        return response()->json($response, 200);
        }
        else
        {
           return redirect()->away('https://evyapari.com/login');
        }
	}
	
	
   
   
    //proceedToCheckoutTest
    public function proceedToCheckout(Request $request)
    {
       
        if(isset($request->pp_status))
        {
            if($request->pp_status==1)
            {
                 $pp_status=1;
                 $pp_id=$request->pp_id;
            }
            else
            {
                 $pp_status=0;
                 $pp_id=NULL;
            }
            
            
            
        }
        else
        {
          $pp_status=0;
          $pp_id=NULL;
        }
        
        // $invoice_number="";
        // $in_date = date("YmdHis");
        // $in_ref_no = rand(10,10000);
        // $invoice_number=$in_date.$in_ref_no;
        
        $user_id = $request->user_id;
        $shipping_address_id = $request->shipping_address_id;
        $invoice_number=date("YmdHis").$this->createRandomKey();
        $order_date=date("d");
		$order_month=date("m");
		$order_year=date("Y");
		$order_time=date("Y-m-d H:i:s");
        $order_total_without_shipping=0;
        $shipping_charge=0;
        $order_weight=0;
        $totaldiscount=0;
        $bill_no="";
        $lastsetid="";
        $lastvendorid="";
        $orderarray=array();
        $total_weight=0;
		$firstset=0;
        $user = Users::where('unique_id',$user_id)->first();
        
        
        $vendorIds = CartModel::select('vendor_id')->where('user_id', $user_id)->orderBy('id', 'asc')->distinct()->pluck('vendor_id')->toArray(); 
        if (in_array('G0RFC6VUJ28', $vendorIds)) {
            
            $cart_items = CartModel::where(['user_id'=>$user_id,'vendor_id'=>'G0RFC6VUJ28'])->orderBy('id','asc')->get();
            $message='Order proceed successfully! You have items from another vendor in your cart. Please create a separate order to proceed.';
       
        }
        else
        {
          $cart_items = CartModel::where('user_id', $user_id)->orderBy('id','asc')->get();
          $message='Order proceed successfully.';
   
        }
        

        
        $allvendor_id=array();
        $oldvendor_id='';
        $per_item_ship_charges=0;
        $shipping_charge_gst=0;
        $custom_set_status=0;
        //Order Item
        foreach($cart_items as $cartitem)
        {
          
          
            if($cartitem->item_type==0)
            {
                $shipping_charge_gst=0;
                $data= DB::table('inventory_new')
                ->leftjoin('inventory_cat','inventory_cat.cat_four', '=', 'inventory_new.cat_id')
                ->leftjoin('master_taxes','master_taxes.id', '=', 'inventory_new.gst')
                ->leftjoin('master_brand','master_brand.id', '=', 'inventory_new.brand')
                ->leftjoin('master_stream','master_stream.id', '=', 'inventory_new.stream')
                ->leftjoin('master_classes','master_classes.id', '=', 'inventory_new.class')
                ->leftjoin('master_qty_unit','master_qty_unit.id', '=', 'inventory_new.qty_unit')
                ->select('inventory_new.*','master_classes.title as class_title','master_stream.title as stream_title','master_brand.title as brand_title','inventory_cat.cat_one','inventory_cat.cat_two','inventory_cat.cat_three','inventory_cat.cat_four','master_taxes.title as gst_title')
                ->where(['inventory_new.id'=>$cartitem->product_id])
                ->first();  
                
                //item cat
                $cat_one = CatOne::select('name')->where('id', $data->cat_one)->first();
                if($cat_one){$data->catone=$cat_one->name;}else{$data->catone='';}
               
                $cat_two = CatTwo::select('name')->where('id', $data->cat_two)->first();
                 if($cat_two){$data->cattwo=$cat_two->name;}else{$data->cattwo='';}
                
                $cat_three = CatThree::select('title')->where('id', $data->cat_three)->first();
                 if($cat_three){$data->catthree=$cat_three->title;}else{$data->catthree='';}
               
                $cat_four = CatFour::select('title')->where('id', $data->cat_four)->first();
                 if($cat_four){$data->catfour=$cat_four->title;}else{$data->catfour='';}
                 
                 
                 //item images
                 $allimages="";
                 $inv_images = InventoryImgModel::where(['item_id'=>$data->id])->get();
                 foreach($inv_images as $invimages)
                  {
                     $allimages.=$invimages->image.",";
 
                  }
                  
                 $data->item_order_status=1;
                 $data->order_billno='BILL-'.$invoice_number."-".$data->vendor_id;
                 $data->item_images=$allimages;
                 $data->item_type=0;
                 $data->item_qty=$cartitem->qty;
                 $data->item_ship_chr=0;
                  
                //  $order_total_without_shipping+=$data->mrp;
                //  $totaldiscount+=$data->mrp-$data->discounted_price;
                //  $shipping_charge+=$data->shipping_charges;
                //  $order_weight+=$data->net_weight;
                    $order_total_without_shipping+=($data->mrp)*$cartitem->qty;
                    $totaldiscount+=($data->mrp-$data->discounted_price)*$cartitem->qty;
                    
                    $shipping_charge_gst=(($data->shipping_charges*$cartitem->qty) * 18) / 100; 
                    $shipping_charge+=(($data->shipping_charges)*$cartitem->qty)+$shipping_charge_gst;
                    $order_weight+=$data->net_weight;
                    
                    $data->shipping_charges_gst=$shipping_charge_gst;
                    
                           
	                  //order tracking
	                    $inventory_new_item = InventoryNewModel::where('id', $cartitem->product_id)->first();
	                  
                        $order_tracking_data = [
                            'invoice_number'=>$invoice_number,
                            'product_id'=>$inventory_new_item->product_id,
                            'item_id'=>$inventory_new_item->id,
                            'item_type'=>0,
                            'qty'=>$cartitem->qty,
                            'vendor_id'=>$inventory_new_item->vendor_id,
                            'created_by'=>$inventory_new_item->created_by,
                        ];
                       OrderTrackingModel::create($order_tracking_data);
                       if($oldvendor_id!=$inventory_new_item->vendor_id){array_push($allvendor_id,$inventory_new_item->vendor_id);}
                       $oldvendor_id=$inventory_new_item->vendor_id;
            }
            else
            {
                if($cartitem->set_status==1){ $custom_set_status=1;   }
                $data= DB::table('inventory')
                ->leftjoin('master_taxes','master_taxes.id', '=', 'inventory.gst')
                ->leftjoin('master_classes','master_classes.id', '=', 'inventory.class')
                ->select('master_classes.title as class_title','master_taxes.title as gst_title','inventory.*')
                ->where(['inventory.id'=>$cartitem->product_id])
                ->first(); 
            
              
                $iteminfo=SchoolSetVendorModel::where(array('vendor_id'=>$cartitem->vendor_id,'set_id'=>$cartitem->set_id))->first(); 
                $master_set_cat=managemastersetcatModel::where('id',$iteminfo->set_category)->first(); 
                
               
                
                
                
                $item_id=explode(",",$iteminfo->item_id);
                $item_qty=explode(",",$iteminfo->item_qty);
                $item_discount=explode(",",$iteminfo->item_discount);
                
                
                $setdiscount=0;
                $setitemmrp=0;
                $set_total_weight=0; 
                $totalsetitem=0;   
                $rowrun=0;
                $setitemdiscount=0;
                
                
               
                
                
                for($j=0;$j<count($item_id);$j++)
                {
                    if($item_id[$j]==$cartitem->product_id)
                    {
                        $setdiscount=(($data->unit_price*$item_qty[$j])*$item_discount[$j])/100;
                        $setitemdiscount=($data->unit_price*$item_discount[$j])/100;
                        $setitemmrp=$data->unit_price*$item_qty[$j];
                        
                        
                        if($rowrun==0 && $iteminfo->set_id!=$lastsetid )
                        {
                             
                             $cart_items_is_cus= CartModel::select('product_id')->where(['user_id'=>$user_id,'set_id'=>$iteminfo->set_id])->get();
                             $product_ids = [];
                             foreach ($cart_items_is_cus as $cussetitem) {$product_ids[] = $cussetitem->product_id;}
                             

                                   
                             
                             
                             $set_item_total_mrp=0.0; 
                             for($p=0;$p<count($item_id);$p++)
                                {
                                    if(in_array($item_id[$p], $product_ids))
                                    {
                                     $pricedata= DB::table('inventory')->select('unit_price')->where(['inventory.id'=>$item_id[$p]])->first(); 
            
                                        $setdiscountsf=(($pricedata->unit_price*$item_qty[$p])*$item_discount[$p])/100;
                                        $set_item_total_mrp+=floatval($pricedata->unit_price)-$setdiscountsf;
                                    }
                                        
                                }
                                
                            
                              $last_per_item_ship_charges=0;
                              $per_item_ship_charges=0;
                              
                              $per_item_ship_charges_gst=0;
                              $gst_amount=0;
                              $totalgstship=0;
                              
                              $totalmysetitem=CartModel::where(['set_id'=>$iteminfo->set_id,'user_id'=>$user_id])->get();
                              $totalsetitem=count($totalmysetitem);
                              //get set item all weight
                               
                               
                                for($w=0;$w<$totalsetitem;$w++)
                                 {
                                     
                                        $getitemweightsetwise= InventoryModel::select('item_weight')->where(['id'=>$totalmysetitem[$w]->product_id])->first();
                                        $set_total_weight+=$getitemweightsetwise->item_weight;
             
                                 }
                            
                            
                            
                            //end
                            
                            
                            // shipping calculation
                         if($iteminfo->shipping_chr_type==1)
                            {
                                if($pp_status==1)
                                {
                                   $per_item_ship_charges=0; 
                                    $per_item_ship_charges_gst=0;
                                }
                                else
                                {
                                    if($cartitem->set_status==0)
                                    {
                                        //if not customized
                                          $vendor_ship_char=$iteminfo->shipping_charges;
                                          $gst_percentage = 18;  // GST percentage
                                          $gst_amount = ($vendor_ship_char * $gst_percentage) / 100;  // Calculate GST
                                          $totalgstship=$gst_amount/$totalsetitem;
                                          
                                          $per_item_ship_charges=($vendor_ship_char/$totalsetitem)+$totalgstship;
                                          $per_item_ship_charges_gst=$gst_percentage;
                                        
                                    }
                                    else
                                    {
                                        if($iteminfo->shipping_charges>0)
                                        {
                                              $vendor_ship_char=$iteminfo->shipping_charges;
                                              $gst_percentage = 18;  // GST percentage
                                              $gst_amount = ($vendor_ship_char * $gst_percentage) / 100;  // Calculate GST
                                              $totalgstship=$gst_amount/$totalsetitem;
                                              
                                              $per_item_ship_charges=($vendor_ship_char/$totalsetitem)+$totalgstship;
                                              $per_item_ship_charges_gst=$gst_percentage;
                                        }
                                        else
                                        {
                                            if($firstset==0)
                                            {
                                                // $per_item_ship_charges=20/$totalsetitem;  
                                             $vendor_ship_char=20;
                                              $gst_percentage = 18;  // GST percentage
                                              $gst_amount = ($vendor_ship_char * $gst_percentage) / 100;  // Calculate GST
                                              $totalgstship=$gst_amount/$totalsetitem;
                                              
                                              $per_item_ship_charges=($vendor_ship_char/$totalsetitem)+$totalgstship;
                                              $per_item_ship_charges_gst=$gst_percentage;
                                            }
                                            else
                                            {
                                                
                                            
                                              $setshipwewichrg=ceil($set_total_weight/100);
                                            //   $per_item_ship_charges=$setshipwewichrg/$totalsetitem;
                                                
                                              $gst_percentage = 18;  // GST percentage
                                              $gst_amount = ($setshipwewichrg * $gst_percentage) / 100;  // Calculate GST
                                              $totalgstship=$gst_amount/$totalsetitem;
                                              
                                              $per_item_ship_charges=($setshipwewichrg/$totalsetitem)+$totalgstship;
                                              $per_item_ship_charges_gst=$gst_percentage;
                                              
                                                $total_weight+=$set_total_weight;
                                                
                                            }  
                                            
                                            if($total_weight>5000)
                                            {
                                            $firstset=0;
                                            $total_weight=0;
                                            }
                                            else
                                            {
                                                $firstset++;
                                            }
                                        }
                                        
                                    }               
                                }
                                    
                        }
                        else
                        {
                             if($pp_status==1)
                                {
                                   $per_item_ship_charges=0; 
                                    $per_item_ship_charges_gst=0;
                                }
                                else
                                {
                            
                                     if($set_item_total_mrp>=1000.0)
                                    {
                                      if($cartitem->set_status==0)
                                      {
                                      $per_item_ship_charges=0;
                                      $per_item_ship_charges_gst=0;
                                      }
                                      else
                                      {
                                      $fixcharges=20;  
                                      $gst_percentage = 18;  // GST percentage
                                      $gst_amount = ($fixcharges * $gst_percentage) / 100;  // Calculate GST
                                      $totalgstship=$gst_amount/$totalsetitem;
                                      
                                      $per_item_ship_charges=($fixcharges/$totalsetitem)+$totalgstship;
                                      $per_item_ship_charges_gst=$gst_percentage;
                                      
                                  }
                                  
                                }
                                else
                                {
                                  $fixcharges=20;  
                                  $gst_percentage = 18;  // GST percentage
                                  $gst_amount = ($fixcharges * $gst_percentage) / 100;  // Calculate GST
                                  $totalgstship=$gst_amount/$totalsetitem;
                                  
                                  $per_item_ship_charges=($fixcharges/$totalsetitem)+$totalgstship;
                                  $per_item_ship_charges_gst=$gst_percentage;
                                }
                                
                          }
                        }
                            //end
                        }
                        else
                        {
                            $per_item_ship_charges=$last_per_item_ship_charges;
                        }
                        $rowrun++;
                    }
                }
                
                 $data->item_order_status=1;
                 $data->order_billno='BILL-'.$invoice_number."-".$cartitem->vendor_id;
                 $data->set_type=$cartitem->set_type;
                 $data->set_cat=$master_set_cat->title;
                 $data->set_id=$cartitem->set_id;
                 $data->vendor_id=$iteminfo->vendor_id;
                 $data->size=$cartitem->size;
                 $data->item_qty=$cartitem->qty;
                 $data->item_ship_chr=$per_item_ship_charges;
                  $data->item_ship_chr_gst=$per_item_ship_charges_gst;
                 $data->item_discount=$setitemdiscount;
                 
                 
                 
                 
                 $lastsetid=$iteminfo->set_id;
                 $last_per_item_ship_charges=$per_item_ship_charges;
                 $lastvendorid=$iteminfo->vendor_id;
                 $order_total_without_shipping+=$setitemmrp;
                 $totaldiscount+=$setdiscount;
                 $shipping_charge+=$per_item_ship_charges;
                 $order_weight+=$data->item_weight;
                 
                       
                       //order tracking
                        $inventory_item = InventoryModel::where('id', $cartitem->product_id)->first();
                        $order_tracking_data = [
                            'invoice_number'=>$invoice_number,
                            'product_id'=>$inventory_item->itemcode,
                            'item_id'=>$inventory_item->id,
                            'item_type'=>1,
                            'vendor_id'=>$cartitem->vendor_id,
                            'set_id'=>$cartitem->set_id,
                            'qty'=>$cartitem->qty,
                            // 'created_by'=>$inventory_item->created_by,
                        ];
                        OrderTrackingModel::create($order_tracking_data);
                        
                 if($oldvendor_id!=$cartitem->vendor_id){array_push($allvendor_id,$cartitem->vendor_id);}
                 $oldvendor_id=$cartitem->vendor_id;
            
            }
            
	      array_push($orderarray,$data);
	      
        //delete item from cart
         CartModel::where(['user_id'=>$user_id,'id'=>$cartitem->id])->delete();
        
        }
        
        
    $jsonData = json_encode($orderarray, JSON_PRETTY_PRINT);
    $writeFile = Storage::disk('s3')->put('sales_report/'.$invoice_number.'.jsonp', $jsonData);
    if ($writeFile) {
        
         //Order Shipping Address
         
         if($pp_status!=0 && $pp_id!=NULL)
         {
             $ppgetdata=PickupPoint::where('id', $pp_id)->first();
             if(!empty($ppgetdata->notes)){ $note="<br> Notes-".$ppgetdata->notes; }else{$note="";}
               $order_address_data = [
                'user_id'=>$user_id,
                'invoice_number'=>$invoice_number,
                'address_type'=>3,
                'name'=>$ppgetdata->pickup_point_name,
                'phone_no'=>$ppgetdata->contact_number,
                'school_code'=>$user->school_code,
                'address'=>$ppgetdata->address,
                'pincode'=>$ppgetdata->pincode,
                'city'=>$ppgetdata->google_location."<br>Open Time- ".$ppgetdata->opening_time."<br>Closing Time-".$ppgetdata->closing_time.$note,
            ];
            
         }
         else
         {
         
        if($shipping_address_id!=0){
            $address = UserAddressesModel::where(['user_id'=>$user_id, 'id'=>$shipping_address_id])->first();
            if($address->address_type=="1") 
            {
                $order_address_data = [
                    'user_id'=>$user_id,
                    'invoice_number'=>$invoice_number,
                    'address_type'=>$address->address_type,
                    'name'=>$address->name,
                    'phone_no'=>$address->phone_no,
                    'school_code'=>$address->school_code,
                    'alternate_phone'=>$address->alternate_phone,
                    'village'=>$address->village,
                    'address'=>$address->address,
                    'post_office'=>$address->post_office,
                    'pincode'=>$address->pincode,
                    'city'=>$address->city,
                    'state'=>$address->state,
                    'district'=>$address->district,
                ];  
            }
            else
            {
                $school = SchoolModel::where(['school_code'=>$address->school_code, 'del_status'=>0])->first();
                
                $order_address_data = [
                    'user_id'=>$user_id,
                    'invoice_number'=>$invoice_number,
                    'address_type'=>2,
                    'name'=>$address->name,
                    'phone_no'=>$school->school_phone,
                    'school_code'=>$address->school_code,
                    'school_name'=>$school->school_name,
                    'alternate_phone'=>$address->alternate_phone,
                    'village'=>$school->village,
                    'address'=>$school->landmark,
                    'post_office'=>$school->post_office,
                    'pincode'=>$school->zipcode,
                    'city'=>$school->city,
                    'state'=>$school->state,
                    'district'=>$school->distt,
                ];  
            }
            
        }
        else 
        {
            $order_address_data = [
                'user_id'=>$user_id,
                'invoice_number'=>$invoice_number,
                'address_type'=>1,
                'name'=>$user->name,
                'phone_no'=>$user->phone_no,
                'school_code'=>$user->school_code,
                // 'alternate_phone'=>$user->alternate_phone,
                'village'=>$user->village,
                'address'=>$user->address,
                'post_office'=>$user->post_office,
                'pincode'=>$user->pincode,
                'city'=>$user->city,
                'state'=>$user->state,
                'district'=>$user->district,
            ];
            
            
            $address = UserAddressesModel::where(['user_id'=>$user_id, 'default_address'=>1]);
            if($address)
            {
                $address->update(['default_address'=>0]);
            }
          
            $billing_address=[
                "user_id"=>$user_id,
                "address_type"=>1,
                "default_address"=>1,
                "name"=>$user->name,
                "phone_no"=>$user->phone_no,
                // "alternate_phone"=>$request->alternate_phone,
                "village"=>$user->village,
                "city"=>$user->city,
                "state"=>$user->state,
                "district"=>$user->district,
                "post_office"=>$user->post_office,
                "pincode"=>$user->pincode,
                "address"=>$user->address,
            ];  
        
            $add_to_shippingaddress= UserAddressesModel::create($billing_address);
        
        }
    }
       $store_ship_add=OrderShippingAddressModel::create($order_address_data);
       //Order Shipping Address end
       
       
       
        
        //orders
        $order_data = [
            'invoice_number'=>$invoice_number,
            'user_id'=>$user->unique_id,
            'vendor_id'=>implode(',',$allvendor_id),
            'user_type'=>$user->user_type,
            'class'=>$user->classno,
            'mode_of_payment'=>$request->mode_of_payment,
            'order_total'=>$order_total_without_shipping,
            'grand_total'=>($order_total_without_shipping-$totaldiscount)+$shipping_charge,
            'shipping_charge'=>$shipping_charge,
            'discount'=>$totaldiscount,
            'order_date'=>$order_date,
            'order_month'=>$order_month,
            'order_year'=>$order_year,
            'order_time'=>$order_time,
            'order_weight'=>$order_weight,
            'custom_set_status'=>$custom_set_status,
            'pp_id'=>$pp_id,
            
        ];
        $order=OrdersModel::create($order_data);
   
     
        $res = [
            'user_id'=>$user_id, 
            'shipping_address_id'=>$shipping_address_id,
            'invoice_number'=>$invoice_number,
            'order_time'=>$order_time,
            // 'transaction_id'=>$transaction_id,
        ];
        $response = ['success' => 1,'message'=>$message,'data' => $res,];
        return response()->json($response, 200);
        
    }
    else
    {
        
        $response = ['error' => 1,'message'=>'Something Went Wrong Pleas try again later!'];
        return response()->json($response, 200); 
        
    }
}
   
   
   
   
   
   
   //orderPreview
    public function orderPreview(Request $request)
    {
        $user_id = $request->user_id;
        $invoice_number=$request->invoice_number;
        $myorder= OrdersModel::where(['user_id'=>$user_id, 'invoice_number'=>$invoice_number])->first();
        $myaddress = OrderShippingAddressModel::where(['user_id'=>$user_id, 'invoice_number'=>$invoice_number])->first();
        
        $all_items = OrderTrackingModel::where(['invoice_number'=>$invoice_number])->get();
        $count=count($all_items);
        $ordered_items=[];
        for($i=0;$i<$count;$i++)
        {
            if($all_items[$i]->item_type==0)
            {
                $data= DB::table('order_tracking')
                ->leftjoin('inventory_new', 'order_tracking.item_id', '=', 'inventory_new.id') 
                ->leftjoin('inventory_images', 'inventory_images.item_id', '=', 'inventory_new.id')
                ->leftjoin('master_colour', 'master_colour.id', '=', 'inventory_new.color')
                ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
                ->leftjoin('vendor', 'inventory_new.vendor_id', '=', 'vendor.unique_id')
                ->leftjoin('size_list', 'size_list.id', '=', 'inventory_new.size')
                ->leftjoin('sizes', 'sizes.id', '=', 'size_list.size_id')
                ->select('order_tracking.qty','vendor.username as vendor_name','order_tracking.item_type','order_tracking.vendor_id','master_colour.title as product_color','size_list.title as product_size','master_classes.title as class_title','inventory_new.shipping_charges','inventory_new.product_name','inventory_new.discounted_price','inventory_new.mrp', 'inventory_new.description','inventory_new.id','inventory_images.image','inventory_images.folder','inventory_images.alt')
                ->where(['order_tracking.invoice_number'=>$invoice_number,'order_tracking.item_type'=>0,'order_tracking.item_id'=>$all_items[$i]->item_id,'inventory_new.id'=>$all_items[$i]->item_id,'inventory_images.dp_status'=>1])
                ->first();
            }
            else 
            {
                $data= DB::table('order_tracking')
                ->leftjoin('inventory', 'order_tracking.item_id', '=', 'inventory.id') 
                ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory.class')
                ->leftjoin('vendor', 'order_tracking.vendor_id', '=', 'vendor.unique_id')
                ->select('order_tracking.qty','vendor.username as vendor_name','order_tracking.item_type','order_tracking.vendor_id','master_classes.title as class_title','inventory.cover_photo as image','inventory.itemname as product_name','inventory.discount','inventory.unit_price', 'inventory.description','inventory.id')
                ->where(['order_tracking.invoice_number'=>$invoice_number,'order_tracking.item_type'=>1,'inventory.id'=>$all_items[$i]->item_id])
                ->first(); 
                
                $iteminfo=SchoolSetVendorModel::where(array('vendor_id'=>$all_items[$i]->vendor_id,'set_id'=>$all_items[$i]->set_id,'del_status'=>0))->first();
              
                $item_id=explode(",",$iteminfo->item_id);
                $item_qty=explode(",",$iteminfo->item_qty);
                $item_discount=explode(",",$iteminfo->item_discount);
                
                for($j=0;$j<count($item_id);$j++)
                {
                    if($item_id[$j]==$data->id)
                    {
                        // $discount=(($data->unit_price*$item_qty[$j])*$item_discount[$j])/100;
                        // $data->mrp=$data->unit_price*$item_qty[$j];
                        // $data->discounted_price=($data->unit_price*$item_qty[$j])-$discount;
                        
                         $discount=($data->unit_price*$item_discount[$j])/100;
                        $data->mrp=$data->unit_price;
                        $data->discounted_price=$data->unit_price-$discount;
                    }
                }
            }
             array_push($ordered_items, $data);
        }
        
        $res = [
            'order_address'=>$myaddress,
            'ordered_items' => $ordered_items,
            'invoice_number'=>$invoice_number,
            'shipping_charge'=>$myorder->shipping_charge, 
            'order_total_without_shipping'=>$myorder->order_total, 
            'discount'=>$myorder->discount, 
            'grand_total'=>$myorder->grand_total, 
            'order_date'=>$myorder->order_time, 
            'order_status'=>$myorder->order_status,
            'mode_of_pay'=>$myorder->mode_of_payment,
        ];
        $response = ['success' => 1,'message' => 'successfull','data' => $res,];
        return response()->json($response, 200);
    
    }
   
    
    //updateOrderShippingAddress
    public function updateOrderShippingAddress(Request $request)
    {
        $user_id = $request->user_id;
        $invoice_number=$request->invoice_number;
        $address_id = $request->address_id;
        
        $new_address = UserAddressesModel::where(['id'=>$address_id,'user_id'=>$user_id,])->first();
        $order_address = OrderShippingAddressModel::where(['user_id'=>$user_id, 'invoice_number'=>$invoice_number]);
        
        if($new_address->address_type==1)
        {
            $updateData = [
                'user_id'=>$user_id,
                'invoice_number'=>$invoice_number,
                'address_type'=>$new_address->address_type,
                'name'=>$new_address->name,
                'phone_no'=>$new_address->phone_no,
                'school_code'=>$new_address->school_code,
                'alternate_phone'=>$new_address->alternate_phone,
                'village'=>$new_address->village,
                'address'=>$new_address->address,
                'post_office'=>$new_address->post_office,
                'pincode'=>$new_address->pincode,
                'city'=>$new_address->city,
                'state'=>$new_address->state,
                'district'=>$new_address->district,
            ];
        }
        else 
        {
            $school = SchoolModel::where(['school_code'=>$new_address->school_code, 'del_status'=>0])->first();
            $updateData = [
                'user_id'=>$user_id,
                'invoice_number'=>$invoice_number,
                'address_type'=>2,
                'name'=>$new_address->name,
                'phone_no'=>$school->school_phone,
                'school_code'=>$new_address->school_code,
                'school_name'=>$school->school_name,
                'alternate_phone'=>$new_address->alternate_phone,
                'village'=>$school->village,
                'address'=>$school->landmark,
                'post_office'=>$school->post_office,
                'pincode'=>$school->zipcode,
                'city'=>$school->city,
                'state'=>$school->state,
                'district'=>$school->distt,
            ];  
        }
        
        $order_address->update($updateData);
        
        $response = ['success' => 1,'message' => 'successfull','data' => null];
        return response()->json($response, 200);
    }
    
    //getMyOrders
    // public function getMyOrders(Request $request)
    // {
    //     $user_id = $request->user_id;
    //     $orders = OrdersModel::where(['user_id'=>$user_id])->orderBy('id','desc')->get();
    //     $response = ['success' => 1,'message' => 'successfull','data' => $orders,];
    //     return response()->json($response, 200);
    // }
    
    public function getMyOrders(Request $request)
    {
        $user_id = $request->user_id;
        $orderdata = OrdersModel::where(['user_id'=>$user_id])->orderBy('id','desc')->get();
        
        for($i=0;$i<count($orderdata);$i++)
        {
            $tracking_status='';
            $tracking_update_status=DB::table('order_tracking')->select('courier_number','tracking_status','updated_at')->where(['invoice_number'=>$orderdata[$i]->invoice_number,'vendor_id'=>$orderdata[$i]->vendor_id])->distinct('courier_number','tracking_status','updated_at')->get();
            if($tracking_update_status)
            {
                foreach($tracking_update_status as $trkingstatus)
                {
                    if($trkingstatus->tracking_status==0){$statustrk="Placed";}
                    elseif($trkingstatus->tracking_status==1){$statustrk="In-process";}
                    elseif($trkingstatus->tracking_status==2){$statustrk="In-production";}
                    elseif($trkingstatus->tracking_status==3){$statustrk="Shipped";}
                    elseif($trkingstatus->tracking_status==4){$statustrk="Out for delivery";}
                    elseif($trkingstatus->tracking_status==5){$statustrk="Deliverd";}
                    $tracking_status.='<p  class="mb-1 py-1 px-1 text-success fw-bold"  >'.$statustrk.'<br>'.$trkingstatus->courier_number.'</p><br>';
                }
            }
            
            if($orderdata[$i]->order_status==1 || $orderdata[$i]->order_status==5)
            {
                if($orderdata[$i]->order_status==1)
                {
                    $orderdata[$i]->tracking_status='<span class="text-warning fw-bold">Pending</span>';
                }
                if($orderdata[$i]->order_status==5)
                {
                    $orderdata[$i]->tracking_status='<span class="text-danger fw-bold">Cancelled</span>';
                }
                
            }
            else 
            {
                $orderdata[$i]->tracking_status=$tracking_status;
            }
              
            
        }
        
        $response = ['success' => 1,'message' => 'successfull','data' => $orderdata,];
        return response()->json($response, 200);
    }
    
    //getOrderDetails
    public function getOrderDetails(Request $request)
    {
        $itemdata=[];
        $ordered_items=[];
        $user_id = $request->user_id;
        $invoice_number=$request->invoice_number;
        
        $myorder= OrdersModel::where(['user_id'=>$user_id, 'invoice_number'=>$invoice_number])->first();
        $myaddress = OrderShippingAddressModel::where(['user_id'=>$user_id, 'invoice_number'=>$invoice_number])->first();
        $ordered_payment=Paytm::select('order_id','status','transaction_id','transaction_amount')->where(['order_id'=>$request->invoice_number,'user_id'=>$request->user_id])->first();
     
            
        if($myorder->order_status!=1)
        {
            
            $orderfile=Storage::disk('s3')->get('sales_report/'.$invoice_number.'.jsonp');
        	$getfile=json_decode ($orderfile,true);
            foreach($getfile as $data)
            {
                    // set item
                    if($data['item_type']==1)
                    {
                        $item_type=1;
                        $product_id=$data['itemcode'];
                        $vendor_id=$data['vendor_id'];
                        $product_name=$data['itemname'];
                        $vendor_name='';
                        $class_title=$data['class_title'];
                        $mrp=$data['unit_price'];
                        $discounted_price=$data['unit_price']-$data['item_discount'];
                        $qty=$data['item_qty'];
                        $this_items = OrderTrackingModel::select('tracking_status','shipping_partner','shipper_name','courier_number','shipper_address')->where(['invoice_number'=>$invoice_number,'item_type'=>1,'item_id'=>$data['id']])->first();
                        $tracking_status=$this_items->tracking_status;
                        $shipper_name=$this_items->shipper_name;
                         $shipping_partner=$this_items->shipping_partner;
                        $courier_number=$this_items->courier_number;
                        $shipper_address=$this_items->shipper_address;
                    }
                    else
                    {
                        //inventory item 
                        $item_type=0;
                        $product_id=$data['product_id'];
                        $vendor_id=$data['vendor_id'];
                        $product_name=$data['product_name'];
                        $vendor_name='';
                        $class_title=$data['class_title'];
                        $mrp=$data['mrp'];
                        $discounted_price=$data['discounted_price'];
                        $qty=$data['item_qty'];
                        $this_items = OrderTrackingModel::select('tracking_status','shipping_partner','shipper_name','courier_number','shipper_address')->where(['invoice_number'=>$invoice_number,'item_type'=>0,'item_id'=>$data['id']])->first();
                        $tracking_status=$this_items->tracking_status;
                        $shipping_partner=$this_items->shipping_partner;
                         $shipper_name=$this_items->shipper_name;
                        $courier_number=$this_items->courier_number;
                        $shipper_address=$this_items->shipper_address;   
                    }
                    
                    
                    array_push($ordered_items,array('vendor_id'=>$vendor_id,'product_id'=>$product_id,'item_type'=>$item_type,'product_name'=>$product_name,'vendor_name'=>$vendor_name,'class_title'=>$class_title,'mrp'=>$mrp,'discounted_price'=>$discounted_price,'qty'=>$qty,'tracking_status'=>$tracking_status,"shipping_partner"=>$shipping_partner,'shipper_name'=>$shipper_name,'courier_number'=>$courier_number,'shipper_address'=>$shipper_address));
                    
            }
            
             
                 
            $res = [ 
            'ordered_payment_info' => $ordered_payment,
            'order_address'=>$myaddress,
            'ordered_items' => $ordered_items,
            'invoice_number'=>$invoice_number,
            'shipping_charge'=>$myorder->shipping_charge, 
            'order_total_without_shipping'=>$myorder->order_total, 
            'discount'=>$myorder->discount, 
            'grand_total'=>$myorder->grand_total, 
            'order_date'=>$myorder->order_time, 
            'order_status'=>$myorder->order_status,
        ];
            $response = ['success' => 1,'message' => 'successfull','data' => $res,];
            return response()->json($response, 200);
        }
        else
        {
            // $res = ['address'=>$user_id];
            $response = ['success' => 1,'message' => 'placed','data' => $myorder,];
            return response()->json($response, 200);
        }
    }
   
  
    //orderShippingAddress
    public function orderShippingAddress(Request $request)
    {
        $user_id = $request->user_id;
        $invoice_number=$request->invoice_number;
        
        $address = OrderShippingAddressModel::where(['user_id'=>$user_id, 'invoice_number'=>$invoice_number])->first();
        
        $response = ['success' => 1,'message' => 'successfull','data' => $address,];
        return response()->json($response, 200);
    }
    
    
    //cancelOrder
    public function cancelOrder(Request $request)
    {
        $user_id = $request->user_id;
        $invoice_number=$request->invoice_number;
        
        $order = OrdersModel::where(['user_id'=>$user_id, 'invoice_number'=>$invoice_number]);
        
        $updateData = ['order_status' => 5];
        
        $order->update($updateData);
        
        $response = ['success' => 1,'message' => 'Order Cancelled','data' => null];
        return response()->json($response, 200);
    }
}


