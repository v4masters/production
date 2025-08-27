<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\API\CartModel;
use App\Models\API\WishlistModel;
use App\Models\API\UserAddressesModel;
use App\Models\API\SchoolModel;
use App\Models\API\InventoryModel;
use App\Models\API\OrdersModel;
use App\Models\API\OrderTrackingModel;
use App\Models\API\OrderShippingAddressModel;
use App\Models\API\Users;
use Illuminate\Support\Facades\Auth;
use Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
   
class OrderController extends BaseController
{
    //Genrating unique number
   public function placeOrder($discount_price,$coupon_code,$mode_of_payment,$order_status,$selected_class)
    {
       date_default_timezone_set('Asia/Calcutta'); 
        $return_array=array("error"=>0,"success"=>0,"invoice_number"=>"");
 	    $conn=$this->db->connect();
		if($coupon_code==""){$discount_coupon=0;}else{$discount_coupon=$coupon_code;}
		/** basic var**/
		$user_id=$_SESSION["user_id"];
		$un_id=$this->createRandomKey();
		$invoice_number=date("YmdHis")."-".$user_id.$un_id;
	    $order_date=date("d");
		$order_month=date("m");
		$order_year=date("Y");
		$order_time=date("Y-m-d H:i:s");
		$order_set_array=array();
			$order_array=array();
			$order_total=0;
			$total_sales_non_taxable=0;
			$total_sales_taxable_12=0;
			$total_sales_taxable_18=0;
			$total_sales_taxable_5=0;
			$total_sales_taxable_28=0;
			$payable_gst_12=0;
			$payable_gst_18=0;
		    $total_discount=0;
	        $total_shipping=0;
	        $customsetststus=0;
	        $school_set_order='No';
			$school_set='';
			$no_of_set=0;
			$ordertype=1;
        //end 
        
        //get set type
        $get_set_type=mysqli_query($conn,"select distinct(set_type) from cart where unique_id='".$user_id."' ");
    	$resultset_type=mysqli_fetch_array($get_set_type);
        
        //get vendor
	   	$vendor_id=array();
		$sql=mysqli_query($conn,"select itemcode from cart where unique_id='".$user_id."' ");
		while($sql_result=mysqli_fetch_array($sql))
		{
			$itemecode=$sql_result['itemcode'];
			// Get full info of item
			$item_info_query=mysqli_query($conn,"select uploader_id,uploaded_by from main_inventory where itemcode='".$itemecode."' ");
			$item_query_result=mysqli_fetch_assoc($item_info_query);
			$uploaded_by=$item_query_result['uploaded_by'];
			$uploader_id=$item_query_result['uploader_id'];
			$vendor_id[]=$uploader_id;
		}
		$uploader_ids=array_values(array_unique($vendor_id));
		$bill_no="BILL-".$invoice_number;
         //end
        
        //get total set
		$no_of_set_qty=mysqli_query($conn,"select distinct(set_id),vendor_id from cart where unique_id='".$user_id."' ");
		$num_Row_set_qty=mysqli_num_rows($no_of_set_qty);
		if($num_Row_set_qty!=0)
		{
		  $no_of_set=$num_Row_set_qty;
		   $school_set_order='Yes';
           $school_set='School Set';
			 
		}
	

		$cart_query=mysqli_query($conn,"select * from cart where unique_id='".$user_id."' order by id asc");
     	$totalcart=mysqli_num_rows($cart_query);
     	$firstsetid=mysqli_query($conn,"select distinct(set_id)  from cart where unique_id='".$user_id."' and custom_set_status='1' order by id asc limit 1");
	    $firstset=mysqli_fetch_assoc($firstsetid);
        $firsetrow=mysqli_query($conn,"select count(id) as totalitem from cart where unique_id='".$user_id."' and custom_set_status='1' and set_id='".$firstset['set_id']."'");
	    $firstset_rows=mysqli_fetch_assoc($firsetrow);
		$set_status=0;
	    $packet=5000;
	    $uniformpacket=20000;
	    $allsetweight=0;
	    $allunisetweight=0;
		if($cart_query!=0)
		{
		 
		 
		 
		
	       
			while($cart_result=mysqli_fetch_array($cart_query))
			{
			
			     $peritemexatwit=0;
				 $totalotherset_shp=0; 
				  $totalotheruniset_shp=0; 
				$itemcode=$cart_result['itemcode'];
				$item_qty=$cart_result['item_qty'];
				$set_uploader_id=$cart_result['vendor_id'];			
			    $set_id=$cart_result['set_id'];
				$statuss=$cart_result['statuss'];
			    $size=$cart_result['size'];
		        $shipping_chrg=0;
				   if($statuss==2)
				   {
				    //get size
				     $getsizequery=mysqli_query($conn,"select price,weight from uniform_size where size='".$cart_result['size']."' and itemcode='".$itemcode."' ");
					$set_size_result=mysqli_fetch_assoc($getsizequery);
				
				    if($cart_result['set_type']==2)
					{
					    
					    $ordertype=2;
					   //     $size=$cart_result['size'];
					        $peritemexatwit=$set_size_result['weight'];
	                        
				    //   if($cart_result['custom_set_status']==1)
				    //     { 
				    //         if($firstset['set_id']==$cart_result['set_id'])
				    //         {
				    //          $shipping_chrg=17/$firstset_rows['totalitem'];   
				    //          }
				    //         else
				    //         {
				    //       //get set total weight
				    //         $getothersetweight=mysqli_query($conn,"SELECT SUM(weight)as total_weight , COUNT(itemcode)as total_item FROM `cart` WHERE unique_id='".$user_id."' and set_id='".$cart_result['set_id']."' and vendor_id='".$cart_result['vendor_id']."' ");
	       //                 $fetchgetothersetweight=mysqli_fetch_assoc($getothersetweight);
	       //                   $getsetfirstitem=mysqli_query($conn,"SELECT itemcode from cart WHERE cart.unique_id='".$user_id."' and cart.set_id='".$cart_result['set_id']."' and cart.vendor_id='".$cart_result['vendor_id']."' ORDER by id asc LIMIT 1 ");
	       //                    $itemcodefirst=mysqli_fetch_assoc($getsetfirstitem);
	       //                      if($itemcodefirst['itemcode']==$cart_result['itemcode'])
	       //                      {
	       //                        $allunisetweight+=$fetchgetothersetweight['total_weight'];
	       //                      }  
	       //                 //if set weight less than 20000
	       //                 if($allunisetweight>$uniformpacket)
	       //                 {
	       //                    $getsetlastitem=mysqli_query($conn,"SELECT itemcode from cart WHERE cart.unique_id='".$user_id."' and cart.set_id='".$cart_result['set_id']."' and cart.vendor_id='".$cart_result['vendor_id']."' ORDER by id DESC LIMIT 1 ");
	       //                    $itemcodelast=mysqli_fetch_assoc($getsetlastitem);
	       //                     $shipping_chrg=(17/$fetchgetothersetweight['total_item']);   
	       //                      if($itemcodelast['itemcode']==$cart_result['itemcode']){$allunisetweight=0;} 
	       //                  }
	       //                 else
	       //                 {
	       //                 $totalotherset_shp=ceil($fetchgetothersetweight['total_weight']/500);
	       //                 $totalotheruniset_shp=$totalotherset_shp*18;
	       //                 $shipping_chrg=($totalotheruniset_shp/$fetchgetothersetweight['total_item']); 
	       //                 }
	                       
				    //       }
				            
				    //     }
				    //     else
				    //     {	        
				    //      $getsetrows=mysqli_query($conn,"select shipping_chrg from vendor_school_set where vendor_id='".$cart_result['vendor_id']."' and itemcode='".$cart_result['itemcode']."' and set_id='".$cart_result['set_id']."' ");
	       //              $reslshipping=mysqli_fetch_assoc($getsetrows);
			     //        $shipping_chrg=$reslshipping['shipping_chrg'];  
			     //        }
			     
			     $shipping_chrg=0;
				   	}
				   	else
				   	{
				   	    $size="";
				           //get wait per item
	                        $getperitemweight=mysqli_query($conn,"SELECT vendor_school_set.item_weight FROM `cart` RIGHT JOIN vendor_school_set ON cart.itemcode=vendor_school_set.itemcode and cart.set_id=vendor_school_set.set_id and cart.vendor_id=vendor_school_set.vendor_id WHERE cart.unique_id='".$user_id."' and cart.set_id='".$cart_result['set_id']."' and cart.vendor_id='".$cart_result['vendor_id']."' and cart.itemcode='".$cart_result['itemcode']."' ");
	                        $peritemweight=mysqli_fetch_assoc($getperitemweight);
	                        $peritemexatwit=$peritemweight['item_weight'];
	                        
				       if($cart_result['custom_set_status']==1)
				        { 
				            if($firstset['set_id']==$cart_result['set_id'])
				            {
				             $shipping_chrg=17/$firstset_rows['totalitem'];   
				             }
				            else
				            {
				           //get set total weight
				            $getothersetweight=mysqli_query($conn,"SELECT SUM(vendor_school_set.item_weight)as total_weight , COUNT(vendor_school_set.itemcode)as total_item FROM `cart` RIGHT JOIN vendor_school_set ON cart.set_id=vendor_school_set.set_id and cart.vendor_id=vendor_school_set.vendor_id and cart.itemcode=vendor_school_set.itemcode WHERE cart.unique_id='".$user_id."' and cart.set_id='".$cart_result['set_id']."' and cart.vendor_id='".$cart_result['vendor_id']."' ");
	                        $fetchgetothersetweight=mysqli_fetch_assoc($getothersetweight);
	                          $getsetfirstitem=mysqli_query($conn,"SELECT itemcode from cart WHERE cart.unique_id='".$user_id."' and cart.set_id='".$cart_result['set_id']."' and cart.vendor_id='".$cart_result['vendor_id']."' ORDER by id asc LIMIT 1 ");
	                           $itemcodefirst=mysqli_fetch_assoc($getsetfirstitem);
	                             if($itemcodefirst['itemcode']==$cart_result['itemcode'])
	                             {
	                               $allsetweight+=$fetchgetothersetweight['total_weight'];
	                             }  
	                        //if set weight less than 5000
	                        if($allsetweight>$packet)
	                        {
	                           $getsetlastitem=mysqli_query($conn,"SELECT itemcode from cart WHERE cart.unique_id='".$user_id."' and cart.set_id='".$cart_result['set_id']."' and cart.vendor_id='".$cart_result['vendor_id']."' ORDER by id DESC LIMIT 1 ");
	                           $itemcodelast=mysqli_fetch_assoc($getsetlastitem);
	                            $shipping_chrg=(17/$fetchgetothersetweight['total_item']);   
	                             if($itemcodelast['itemcode']==$cart_result['itemcode']){$allsetweight=0;} 
	                         }
	                        else
	                        {
	                        $totalotherset_shp=ceil($fetchgetothersetweight['total_weight']/100);
	                        $shipping_chrg=($totalotherset_shp/$fetchgetothersetweight['total_item']); 
	                        }
	                       
				          }
				            
				        }
				        else
				        {
				            	        
				         $getsetrows=mysqli_query($conn,"select shipping_chrg from vendor_school_set where vendor_id='".$cart_result['vendor_id']."' and itemcode='".$cart_result['itemcode']."' and set_id='".$cart_result['set_id']."' ");
	                     $reslshipping=mysqli_fetch_assoc($getsetrows);
			             $shipping_chrg=$reslshipping['shipping_chrg'];  
			             }
			      
				   	}
			              

				    
				// Get full info of item
				$set_info_query=mysqli_query($conn,"select * from school_set where set_id='".$set_id."' and itemcode='".$itemcode."' ");
				$numRowset=mysqli_num_rows($set_info_query);
				if($numRowset!=0)
				{
				   	    
				    
					$set_query_result=mysqli_fetch_assoc($set_info_query);
					$itemname=$set_query_result['itemname'];
					$hsncode="";
					$category=$set_query_result['category'];
					$publisher=$set_query_result['publisher'];				
					$class=$set_query_result['class'];
					
					$gst=$set_query_result['gst'];
					$stream=$set_query_result['stream'];
					$medium=$set_query_result['medium'];
					$qty=$set_query_result['qty'];
					$barcode=$set_query_result['barcode'];
					$edition='';
					
					$vendor_query=mysqli_query($conn,"select new_price,school_id,discount_per from  vendor_school_set where set_id='".$set_id."' and itemcode='".$itemcode."' and vendor_id='".$set_uploader_id."' ");
					$set_vendor_query=mysqli_fetch_assoc($vendor_query);

					if($cart_result['set_type']==2)
					{
					$unit_price=$set_size_result['price'];
					$new_sizediscountprice=($set_size_result['price']*$set_vendor_query['discount_per'])/100;
					$new_price=$set_size_result['price']-$new_sizediscountprice;
					$item_discount=$set_vendor_query['discount_per'];
					}
					else
					{
					$new_price=$set_vendor_query['new_price'];
					$unit_price=$set_query_result['unit_price']; 
					$discount_price=$unit_price-$new_price;
					$item_discount=($discount_price/$unit_price)*100;
					}
					
					$school_id=$set_vendor_query['school_id'];
					
			         
					$csl_gst=$unit_price*$gst/(100+$gst);
                    $base_price=$unit_price-$csl_gst;
            
					$order_billno=$bill_no."".$set_uploader_id;
					
					$gst_value=$unit_price-$base_price;
					$sgst_value=bcdiv($gst_value/2,1,2);
					$cgst_value=bcdiv($gst_value/2,1,2);
	
						// categeory market place fee
				$mar_fee_query=mysqli_query($conn,"select market_fee from  categories where category='".$category."' and status=0 ");
		     	$mar_fee_result=mysqli_fetch_assoc($mar_fee_query);
				$market_place_fee=$mar_fee_result['market_fee'];

					array_push($order_set_array,array("invoice_number"=>$invoice_number,"itemname"=>$itemname,"itemcode"=>$itemcode,"hsncode"=>$hsncode,"category"=>$category,"stream"=>$stream,"market_fee"=>$market_place_fee,"company_name"=>$publisher,"edition"=>$edition,"class"=>$class,"unit_price"=>$unit_price,"new_qtn_price"=>$new_price,"base_price"=>$base_price,"shipping_chrg"=>$shipping_chrg,"item_weight"=>$peritemexatwit,"item_qty"=>$item_qty,"gst"=>$gst,"gst_value"=>$gst_value,"sgst_value"=>$sgst_value,"cgst_value"=>$cgst_value,"item_discount"=>$item_discount,"uploaded_by"=>"Vendor","uploader_id"=>$set_uploader_id,"item_order_status"=>"Placed","mode_of_payment"=>$mode_of_payment,"order_billno"=>$order_billno,"set_size"=>$size,"set_id"=>$set_id,"school_id"=>$school_id,"size"=>$size));
					
					
					if($item_discount!=0)
                    {
												
				    $discount=$item_discount*$unit_price/100;
				    $net_dis=number_format((float)$discount, 2, '.', '');
                    $newprice= (round($unit_price-$discount,2));
				    $price=number_format((float)$newprice, 2, '.', '');
					}
					else
					{
					    $net_dis=0;
					      $price= number_format((float)$unit_price, 2, '.', '');
					    
					}
						
			    
			         $total_discount+=$net_dis*$item_qty;
			         
			         
			     // //   if($type_address=='School')
			     //    {
			     //     $total_shipping=0.0;
			     //    }
			     //    else
			     //    {
	                 $total_shipping+=$shipping_chrg;
			        // }
			    	 $titem_subtotal=$price*$item_qty;	
					 $item_subtotal=number_format((float)$titem_subtotal, 2, '.', '');
					 $order_total=$order_total+($item_subtotal);
				
					//shipping charges
					$afrieght=$total_shipping;
					$frieght=number_format((float)$afrieght, 2, '.', '');
					//total_amount
					$net_amt=$order_total+$frieght;
					$total_amount=number_format((float)$net_amt, 2, '.', '');
		
					if($gst==0)
						{
							$total_sales_non_taxable=$total_sales_non_taxable+$titem_subtotal;
						}
						elseif($gst==5)
						{
							$total_sales_taxable_5=$total_sales_taxable_5+$titem_subtotal;
						}
						elseif($gst==12)
						{
							$total_sales_taxable_12=$total_sales_taxable_12+$titem_subtotal;
						}
						
						elseif($gst==18)
						{
							$total_sales_taxable_18=$total_sales_taxable_18+$titem_subtotal;
						}
						elseif($gst==28)
						{
							$total_sales_taxable_28=$total_sales_taxable_28+$titem_subtotal;
							}
					
					
				
					$delete_from_cart=mysqli_query($conn,"update cart set del_status='1' where unique_id='".$user_id."' and itemcode='".$itemcode."' and set_id='".$set_id."' and vendor_id='".$set_uploader_id."'  ");
				 }
				 
			
				}
			
				else
				{
				
			 	// Get full info of item
				$item_info_query=mysqli_query($conn,"select * from main_inventory where itemcode='".$itemcode."' and avail_qty!=0 ");
				$numRows=mysqli_num_rows($item_info_query);
				if($numRows!=0)
				{
					$item_query_result=mysqli_fetch_assoc($item_info_query);
					
					$itemname=$item_query_result['itemname'];
					$hsncode=$item_query_result['hsncode'];
					$category=$item_query_result['category'];
					$company_name=$item_query_result['company_name'];
					$edition=$item_query_result['edition'];
					$class=$item_query_result['class'];
					$unit_price=$item_query_result['unit_price'];
					$base_price=$item_query_result['base_price'];
					$gst=$item_query_result['gst'];
					$item_discount=$item_query_result['discount'];
					$uploaded_by=$item_query_result['uploaded_by'];
					$uploader_id=$item_query_result['uploader_id'];
					$shipping_chrg=$item_query_result['shipping_chrg'];
					
					$gst_value=$unit_price-$base_price;
					$sgst_value=bcdiv($gst_value/2,1,2);
					$cgst_value=bcdiv($gst_value/2,1,2);
					
					if(in_array($uploader_id,$uploader_ids))
					{
						$order_billno=$bill_no."".$uploader_id;
					}
					
					
					$discount_price=$item_discount*$unit_price/100;
                    $new_price=$unit_price-$discount_price;
					
						// categeory market place fee
				$mar_fee_query=mysqli_query($conn,"select market_fee from  categories where category='".$category."' and status=0 ");
		     	$mar_fee_result=mysqli_fetch_assoc($mar_fee_query);
				$market_place_fee=$mar_fee_result['market_fee'];

					array_push($order_set_array,array("invoice_number"=>$invoice_number,"itemname"=>$itemname,"itemcode"=>$itemcode,"hsncode"=>$hsncode,"category"=>$category,"market_fee"=>$market_place_fee,"company_name"=>$company_name,"edition"=>$edition,"class"=>$class,"unit_price"=>$unit_price,"new_qtn_price"=>$new_price,"base_price"=>$base_price,"shipping_chrg"=>$shipping_chrg,"item_qty"=>$item_qty,"gst"=>$gst,"gst_value"=>$gst_value,"sgst_value"=>$sgst_value,"cgst_value"=>$cgst_value,"item_discount"=>$item_discount,"uploaded_by"=>$uploaded_by,"uploader_id"=>$uploader_id,"item_order_status"=>"Placed","mode_of_payment"=>$mode_of_payment,"order_billno"=>$order_billno,"stream"=>'Genreal'));
					
					
					if($item_discount!=0)
                    {
												
				    $discount=$item_discount*$unit_price/100;
				    $net_dis=number_format((float)$discount, 2, '.', '');
                      $newprice= (round($unit_price-$discount,2));
				    $price=number_format((float)$newprice, 2, '.', '');
					}
					else{
					    $net_dis=0;
					      $price= number_format((float)$unit_price, 2, '.', '');
					    
					}
			    
			         $total_discount+=$net_dis*$item_qty;
	                 $total_shipping+=$shipping_chrg;
			    
			    
			    	$titem_subtotal=$price*$item_qty;
					
					$item_subtotal=number_format((float)$titem_subtotal, 2, '.', '');
					$order_total=$order_total+($item_subtotal);
					
					//shipping charges
					$afrieght=$shipping_chrg*$item_qty;
					$frieght=number_format((float)$afrieght, 2, '.', '');
					//total_amount
					$net_amt=$order_total+$frieght;
					
					$total_amount=number_format((float)$net_amt, 2, '.', '');
					
					
					if($gst==0)
						{
							$total_sales_non_taxable=$total_sales_non_taxable+$titem_subtotal;
						}
						elseif($gst==5)
						{
							$total_sales_taxable_5=$total_sales_taxable_5+$titem_subtotal;
						}
						elseif($gst==12)
						{
							$total_sales_taxable_12=$total_sales_taxable_12+$titem_subtotal;
						}
						
						elseif($gst==18)
						{
							$total_sales_taxable_18=$total_sales_taxable_18+$titem_subtotal;
						}
						elseif($gst==28)
						{
							$total_sales_taxable_28=$total_sales_taxable_28+$titem_subtotal;
							}
					
					// Delete From Cart
				
					$delete_from_cart=mysqli_query($conn,"delete from cart where unique_id='".$user_id."' and itemcode='".$itemcode."' and statuss='1' ");
				}
				
				}
				
				
				
			}
			
			// Create Yearly Directory
			if (!file_exists('../../admin/sales_report/'.$order_year)) 
			{
				$old_mask = umask(0);
				mkdir('../../admin/sales_report/'.$order_year, 0777, TRUE);
				umask($old_mask);
			}
			// Create Monthly Directory
			if (!file_exists('../../admin/sales_report/'.$order_year."/".$order_month)) 
			{
				$old_mask = umask(0);
				mkdir('../../admin/sales_report/'.$order_year."/".$order_month, 0777, TRUE);
				umask($old_mask);
			}
			// Create Daily Directory
			if (!file_exists('../../admin/sales_report/'.$order_year."/".$order_month."/".$order_date)) 
			{
				$old_mask = umask(0);
				mkdir('../../admin/sales_report/'.$order_year."/".$order_month."/".$order_date, 0777, TRUE);
				umask($old_mask);
			}
			
			$file_name=$invoice_number.".jsonp";
			$file_path='../../admin/sales_report/'.$order_year."/".$order_month."/".$order_date."/".$file_name;
			
			$myfile = fopen($file_path, "w");
			$jsonEncode = json_encode($order_set_array, JSON_PRETTY_PRINT);
			fwrite($myfile,$jsonEncode);
			fclose($myfile);
			
			
			// Delete From Cart
		$delete_all_set_item_from_cart=mysqli_query($conn,"delete from cart where unique_id='".$user_id."' and del_status='1' and statuss='2'  ");
            // Inserting into Order table
            
        if($resultset_type['set_type']==1)
        {
    	$shipping_query=mysqli_query($conn,"select * from address_book where status='Active' and unique_id='".$user_id."'");
        }
        else
        {
    	$shipping_query=mysqli_query($conn,"select * from address_book where address_type='School' and unique_id='".$user_id."'  ");
        }
		$shipping_result=mysqli_fetch_assoc($shipping_query);
		$shipping_name=$shipping_result['full_name'];
		$shipping_city=$shipping_result['city'];
		$shipping_state=$shipping_result['state'];			
		$shipping_distt=$shipping_result['distt'];			
		$shipping_office=$shipping_result['post_office'];			
		$shipping_landmark=$shipping_result['landmark'];			
		$shipping_address=$shipping_result['address'];
		$type_address=$shipping_result['address_type'];
		$shipping_zipcode=$shipping_result['zipcode'];
		$shipping_phone_no=$shipping_result['phone_no'];
		//insert shipping details
		$insert_query=mysqli_query($conn,"insert into customer_shipping_address (invoice_number,unique_id,full_name,address,city,state,zipcode,phone_no,distt,post_office,landmark) values('".$invoice_number."','".$user_id."','".$shipping_name."','".$shipping_address."','".$shipping_city."','".$shipping_state."','".$shipping_zipcode."','".$shipping_phone_no."','".$shipping_distt."','".$shipping_office."','".$shipping_landmark."')");

 			if($insert_query)
			{	
			   $insert_order=mysqli_query($conn,"insert into orders(class,invoice_number,user_type,unique_id,order_total,mode_of_payment,shipping_charge,discount_coupon,discount,order_status,order_date,order_month,order_year,order_time,total_sales_taxable_5,total_sales_taxable_12,total_sales_taxable_18,total_sales_taxable_28,school_set_order,school_set,no_of_sets,custom_set_status,ordertype) values('".$selected_class."','".$invoice_number."','".$_SESSION["user_type"]."','".$user_id."','".$order_total."','".$mode_of_payment."','".$total_shipping."','".$discount_coupon."','".$total_discount."','".$order_status."','".$order_date."','".$order_month."','".$order_year."','".$order_time."','".$total_sales_taxable_5."','".$total_sales_taxable_12."','".$total_sales_taxable_18."','".$total_sales_taxable_28."','".$school_set_order."','".$school_set."','".$no_of_set."','".$customsetststus."','". $ordertype."')");			
                if($insert_order)
                {
				$return_array['success']=1;
				$return_array['invoice_number']=$invoice_number;
		   	 	$return_array['amount']=$total_amount;
		   	 	return $return_array;
                }
                else
                {
                    	$return_array['error']=1;
				return  $return_array;
                }
			}	
			else
			{
				$return_array['error']=1;
				return  $return_array;
			}
		}
		else
		{
			$return_array['error']=1;
			return  $return_array;
		}
   }
   
   
   
   
}