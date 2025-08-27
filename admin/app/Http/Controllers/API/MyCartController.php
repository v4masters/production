<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\API\CartModel;
use App\Models\API\WishlistModel;
use App\Models\API\UserAddressesModel;
use App\Models\API\InventoryNewModel;
use App\Models\API\SchoolModel;
use App\Models\API\Users;
use Illuminate\Support\Str;

use App\Models\API\SchoolSetVendorModel;

use Illuminate\Support\Facades\Auth;
use Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
   
class MyCartController extends BaseController
{
  // Add product and user id to cart
  public function addCartProduct(Request $request) : JsonResponse
  {
        if(isset($request->move_to_cart) && $request->move_to_cart==1 )
        {
            $item = WishlistModel::where(array('product_id'=>$request->product_id, 'user_id'=>$request->user_id))->first();
            $deleted = $item->delete();
        } 
      
        $existingProduct = CartModel::where(array('product_id'=>$request->product_id, 'item_type'=>0,'user_id'=>$request->user_id))->first();
        if ($existingProduct) {
            return $this->sendResponse(0, null,'Already Exist in Cart');
        }
        
        $item = InventoryNewModel::where(['id'=>$request->product_id, 'del_status'=>0, 'status'=>1])->first();
        
        $data=[
            "user_id"=>$request->user_id,
            "product_id"=>$request->product_id,
            "vendor_id"=>$item->vendor_id,
            "session_type"=>$request->session_type,
            "qty"=>$request->qty,
        ];

        $user = CartModel::create($data);
        $res = $data;
        
        return $this->sendResponse(1, $res, 'Item Added to Cart');
  }



    //getCartItems Test
    public function getCartItemstest(Request $request, $user_id): JsonResponse
    {
           $where=array('cart.user_id'=>$user_id,'inventory_images.dp_status'=>1);
       
           $data= DB::table('cart')
            ->leftjoin('inventory_new', 'inventory_new.id', '=', 'cart.product_id')
            ->leftjoin('inventory_images', 'inventory_images.item_id', '=', 'inventory_new.id')
            ->leftjoin('master_colour', 'master_colour.id', '=', 'inventory_new.color')
            ->leftjoin('size_list', 'size_list.id', '=', 'inventory_new.size')
            ->leftjoin('sizes', 'sizes.id', '=', 'size_list.size_id')
            ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
            ->select('master_colour.title as product_color','size_list.title as product_size','master_classes.title as class_title','cart.qty','cart.set_id','cart.vendor_id','cart.item_type','inventory_new.shipping_charges','inventory_new.product_name','inventory_new.discounted_price','inventory_new.mrp', 'inventory_new.description','inventory_new.id','inventory_images.image','inventory_images.folder','inventory_images.alt')
            ->where($where)
            ->orderBy('item_type','desc')
            ->get();
            
          return $this->sendResponse(1, $data, 'success');
    }
    
    
    //getCartItems
    public function getCartItems(Request $request): JsonResponse
    {
        $user_id = $request->user_id;
       
        $res=[];
        $data=[];
        $cart_all_item= CartModel::where('user_id',$user_id)->orderBy('id','desc')->get();
        $count=count($cart_all_item); 
        for($i=0;$i<$count;$i++)
        {
            if($cart_all_item[$i]->item_type==0)
            {
                $data= DB::table('inventory_new')
                ->leftjoin('cart', 'cart.product_id', '=', 'inventory_new.id') 
                ->leftjoin('inventory_images', 'inventory_images.item_id', '=', 'inventory_new.id')
                ->leftjoin('master_colour', 'master_colour.id', '=', 'inventory_new.color')
                ->leftjoin('size_list', 'size_list.id', '=', 'inventory_new.size')
                ->leftjoin('sizes', 'sizes.id', '=', 'size_list.size_id')
                ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
                ->select('cart.id as cart_id','cart.item_type','cart.vendor_id','cart.set_id','cart.qty','master_colour.title as product_color','size_list.title as product_size','master_classes.title as class_title','inventory_new.shipping_charges','inventory_new.product_name','inventory_new.discounted_price','inventory_new.mrp', 'inventory_new.description','inventory_new.id','inventory_images.image','inventory_images.folder','inventory_images.alt')
                ->where(['cart.id'=>$cart_all_item[$i]->id,'cart.item_type'=>0,'cart.user_id'=>$user_id,'inventory_new.id'=>$cart_all_item[$i]->product_id])
                // 'inventory_images.dp_status'=>1
                ->first();  
                $cartData = CartModel::select('id','product_id')->where(array('item_type'=>0,'user_id'=>$request->user_id,'product_id'=>$data->id,'del_status'=>0))->first();
                $wishlistData = WishlistModel::select('id','product_id')->where(array('user_id'=>$request->user_id,'product_id'=>$data->id,'del_status'=>0))->first();
                
                if($cartData) {
                    $itemExistInCart = true;
                } else {
                    $itemExistInCart = false;
                }
                
                if($wishlistData) {
                    $itemExistInWishlist = true;
                } else {
                    $itemExistInWishlist = false;
                }
            $data->itemExistInCart = $itemExistInCart;
            $data->itemExistInWishlist = $itemExistInWishlist;

                array_push($res,$data);
                
                
            }
            else
            {
                $data= DB::table('inventory')
                ->leftjoin('cart', 'cart.product_id', '=', 'inventory.id') 
                ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory.class')
                ->select('cart.id as cart_id','cart.product_id','cart.item_type','cart.vendor_id','cart.set_id','cart.qty','master_classes.title as class_title','inventory.shipping_charges','inventory.color as product_color','inventory.size as product_size','inventory.cover_photo as image','inventory.itemname as product_name','inventory.unit_price', 'inventory.description','inventory.id','inventory.alt','inventory.folder')
                ->where(['cart.id'=>$cart_all_item[$i]->id,'cart.item_type'=>1,'cart.user_id'=>$user_id,'inventory.id'=>$cart_all_item[$i]->product_id])
                ->first(); 
            
                $iteminfo=SchoolSetVendorModel::where(array('vendor_id'=>$cart_all_item[$i]->vendor_id,'set_id'=>$cart_all_item[$i]->set_id,'del_status'=>0))->first(); 
              
                $item_id=explode(",",$iteminfo->item_id);
                $item_qty=explode(",",$iteminfo->item_qty);
                $item_discount=explode(",",$iteminfo->item_discount);
                
                for($j=0;$j<count($item_id);$j++)
                {
                    if($item_id[$j]==$data->product_id)
                    {
                        // $discount=(($data->unit_price*$item_qty[$j])*$item_discount[$j])/100;
                        // $data->mrp=$data->unit_price*$item_qty[$j];
                        // $data->discounted_price=($data->unit_price*$item_qty[$j])-$discount;
                        
                        $discount=($data->unit_price*$item_discount[$j])/100;
                        $data->mrp=$data->unit_price;
                        $data->discounted_price=$data->unit_price-$discount;
                    }
                }
                array_push($res,$data);
            }
        }
        
        
        $ppdata=['pp_status'=>0,'pp_data'=>''];
        
        $cart_first_set = CartModel::select('set_id','vendor_id')->where(['item_type' => 1, 'user_id' => $user_id])->first();
        
        if($cart_first_set)
        {
            //get pickup point if exist
            $getsetppid= DB::table('school_set_vendor')->select('school_set_vendor.pickup_point')->where(['set_id'=>$cart_first_set->set_id,'vendor_id'=>$cart_first_set->vendor_id])->first();
            if(!empty($getsetppid->pickup_point))
            {
              $getppid=explode(',',$getsetppid->pickup_point);  
              $getsetppid= DB::table('pickup_points')->whereIn('id',$getppid)->get();
              $ppdata = ['pp_status' => 1, 'pp_data' => $getsetppid];   
            }
         }
                
          // Using usort() to sort by 'id' in desc order
        usort($res, function ($a, $b) {
            return $b->cart_id <=> $a->cart_id;
        });


                
        return $this->sendResponse(1, $res,$ppdata,'success');
        
        

    }
    
    
    
     public function getCartItemstest2(Request $request): JsonResponse
    {
         $user_id = $request->user_id;
       
        $res=[];
        
        $cart_all_item= CartModel::where('user_id',$user_id)->orderBy('id','desc')->get();
        $count=count($cart_all_item); 
        for($i=0;$i<$count;$i++)
        {
            if($cart_all_item[$i]->item_type==0)
            {
                $data= DB::table('inventory_new')
                ->leftjoin('cart', 'cart.product_id', '=', 'inventory_new.id') 
                ->leftjoin('inventory_images', 'inventory_images.item_id', '=', 'inventory_new.id')
                ->leftjoin('master_colour', 'master_colour.id', '=', 'inventory_new.color')
                ->leftjoin('size_list', 'size_list.id', '=', 'inventory_new.size')
                ->leftjoin('sizes', 'sizes.id', '=', 'size_list.size_id')
                ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
                ->select('cart.id as cart_id','cart.item_type','cart.vendor_id','cart.set_id','cart.qty','master_colour.title as product_color','size_list.title as product_size','master_classes.title as class_title','inventory_new.shipping_charges','inventory_new.product_name','inventory_new.discounted_price','inventory_new.mrp', 'inventory_new.description','inventory_new.id','inventory_images.image','inventory_images.folder','inventory_images.alt')
                ->where(['cart.item_type'=>0,'cart.user_id'=>$user_id,'inventory_new.id'=>$cart_all_item[$i]->product_id])
                // 'inventory_images.dp_status'=>1
                ->first();  
                $cartData = CartModel::select('id','product_id')->where(array('item_type'=>0,'user_id'=>$request->user_id,'product_id'=>$data->id,'del_status'=>0))->first();
                $wishlistData = WishlistModel::select('id','product_id')->where(array('user_id'=>$request->user_id,'product_id'=>$data->id,'del_status'=>0))->first();
                
                if($cartData) {
                    $itemExistInCart = true;
                } else {
                    $itemExistInCart = false;
                }
                
                if($wishlistData) {
                    $itemExistInWishlist = true;
                } else {
                    $itemExistInWishlist = false;
                }
            $data->itemExistInCart = $itemExistInCart;
            $data->itemExistInWishlist = $itemExistInWishlist;

                array_push($res,$data);
                
                
            }
            else
            {
                $data= DB::table('inventory')
                ->leftjoin('cart', 'cart.product_id', '=', 'inventory.id') 
                ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory.class')
                ->select('cart.id as cart_id','cart.product_id','cart.item_type','cart.vendor_id','cart.set_id','cart.qty','master_classes.title as class_title','inventory.shipping_charges','inventory.color as product_color','inventory.size as product_size','inventory.cover_photo as image','inventory.itemname as product_name','inventory.unit_price', 'inventory.description','inventory.id','inventory.alt','inventory.folder')
                ->where(['cart.item_type'=>1,'cart.user_id'=>$user_id,'inventory.id'=>$cart_all_item[$i]->product_id])
                ->first(); 
            
                $iteminfo=SchoolSetVendorModel::where(array('vendor_id'=>$cart_all_item[$i]->vendor_id,'set_id'=>$cart_all_item[$i]->set_id,'del_status'=>0))->first(); 
              
                $item_id=explode(",",$iteminfo->item_id);
                $item_qty=explode(",",$iteminfo->item_qty);
                $item_discount=explode(",",$iteminfo->item_discount);
                
                for($j=0;$j<count($item_id);$j++)
                {
                    if($item_id[$j]==$data->product_id)
                    {
                        // $discount=(($data->unit_price*$item_qty[$j])*$item_discount[$j])/100;
                        // $data->mrp=$data->unit_price*$item_qty[$j];
                        // $data->discounted_price=($data->unit_price*$item_qty[$j])-$discount;
                        
                        $discount=($data->unit_price*$item_discount[$j])/100;
                        $data->mrp=$data->unit_price;
                        $data->discounted_price=$data->unit_price-$discount;
                    }
                }
                array_push($res,$data);
            }
        }
        
        
        $ppdata=['pp_status'=>0,'pp_data'=>''];
        $check_user= DB::table('cart')->leftjoin('users', 'users.unique_id', '=', 'cart.user_id') ->select('users.id','cart.set_id')->where(['cart.item_type'=>1,'cart.user_id'=>$user_id,'users.userfrom'=>1])->first();
        if($check_user)
        {
            //get pickup point if exist
            $getsetppid= DB::table('school_set_vendor')->select('school_set_vendor.pickup_point')->where(['set_id'=>$check_user->set_id])->first();
            if(!empty($getsetppid->pickup_point))
            {
              $getppid=explode(',',$getsetppid->pickup_point);  
              $getsetppid= DB::table('pickup_points')->whereIn('id',$getppid)->get();
              $ppdata = ['pp_status' => 1, 'pp_data' => $getsetppid];   
            }
        
        }
                
         
   
        // Using usort() to sort by 'id' in ascending order
        usort($res, function ($a, $b) {
            return $a->cart_id <=> $b->cart_id;
        });

                
        return $this->sendResponse(1, $res,$ppdata,'success');
        
        
        
    }
    
    //Delete Item permanently from cart
    // public function removeItemFromCart(Request $request):JsonResponse
    // {
    //     $user_id=$request->user_id;
    //     $product_id=$request->product_id;
    //     $where=array('user_id'=>$user_id, 'product_id'=>$product_id);
    //     $item = CartModel::where($where)->first();
        
    //     $deleted = $item->delete();

    //     if ($deleted) {
    //         return $this->sendResponse(1, null, 'Item Removed from Cart');
    //     } else {
    //         return $this->sendResponse(0, null, 'Something Went Wrong');
    //     }
    // }
    
     public function removeItemFromCart(Request $request):JsonResponse
    {
        $user_id=$request->user_id;
        $product_id=$request->product_id;
        
        if($request->item_type==1)
        {
              $where=array('user_id'=>$user_id, 'product_id'=>$product_id,'item_type'=>$request->item_type,'set_id'=>$request->set_id);
              $item = CartModel::where($where)->first();
              $update_cus_status=CartModel::where(['set_id'=>$request->set_id,'item_type'=>1,'user_id'=>$request->user_id]);
              $update_cus_status->update(['set_status'=>1]);

        }
        else
        {
              $where=array('user_id'=>$user_id, 'product_id'=>$product_id,'item_type'=>$request->item_type);
              $item = CartModel::where($where)->first();
        }
        
        $deleted = $item->delete();
        if ($deleted) {
            return $this->sendResponse(1, null, 'Item Removed from Cart  ');
        } else {
            return $this->sendResponse(0, null, 'Something Went Wrong');
        }
    }
    
    //Remove Set from Cart
    public function removeSetFromCart(Request $request):JsonResponse
    {
        $user_id=$request->user_id;
        $set_id=$request->set_id;
        $where=array('user_id'=>$user_id,'set_id'=>$set_id);
        $items = CartModel::where($where)->get();
        $count = count($items);
        $items_deleted = CartModel::where($where)->delete();
        if ($items_deleted) {
            return $this->sendResponse(1, $count, 'Set Removed from Cart');
        } else {
            return $this->sendResponse(0, null, 'Something Went Wrong');
        }
    }
    
    
    
    //saveForLater
    public function saveForLater(Request $request):JsonResponse
    {
        $where=array('user_id'=>$request->user_id, 'product_id'=>$request->product_id);
        
        //add to wishlist
        $existingProduct = WishlistModel::where($where)->first();
        if(!$existingProduct) {
            $data=[
                "user_id"=>$request->user_id,
                "product_id"=>$request->product_id,
                "session_type"=>$request->session_type,
            ];

            $user = WishlistModel::create($data);
        
            // return $this->sendResponse(1, $data, 'Item Added to Wishlist');
        }
        //remove from cart
        $item = CartModel::where($where)->first();
        $deleted = $item->delete();
        if ($deleted) {
            return $this->sendResponse(1, null, 'Item Added to Wishlist');
        } else {
            return $this->sendResponse(0, null, 'Something Went Wrong');
        }
    }
    
    //updateCartQuantity
    public function updateCartQuantity(Request $request):JsonResponse
    {
        $cartitem = CartModel::where(array('product_id'=>$request->product_id, 'user_id'=>$request->user_id))->first();
       
        if($request->scope=="inc"){
            if($cartitem->qty<10)
            {
                $cartitem->qty += 1;
            }
        }else if($request->scope=="dec"){
            if($cartitem->qty>1)
            {
                $cartitem->qty -= 1;
            }
        }
        $cartitem->update();
        return $this->sendResponse(1, null,'Successful');
    }
    
    
    //Check if product is there for a perticular user
    // public function productExist(Request $request): JsonResponse
    // {
    //     $productExist = CartModel::where(['product_id'=>$request->product_id, 'user_id'=>$request->user_id])->first();
    //     if($productExist) {
    //         $res['isExist']=true;
    //         return $this->sendResponse(1, $res, 'success');
    //     }
    //     else {
    //         $res['isExist']=false;
    //         return $this->sendResponse(1, $res, 'success');
    //     }
    // }
}