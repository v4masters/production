<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\API\WishlistModel;
use Illuminate\Support\Facades\Auth;
use Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
   
class WishlistController extends BaseController
{
  // add product and user id to cart
  public function addToWishlist(Request $request) : JsonResponse
  {
        $existingProduct = WishlistModel::where(array('product_id'=>$request->product_id, 'user_id'=>$request->user_id))->first();
        
        if($existingProduct) {
            if($existingProduct) {
                // $res = $existingProduct->update($updateData);
                return $this->sendResponse(0, null,'Already Exist in Wishlist');
            }
            else
            {
                return $this->sendResponse(0, null, 'Something Went Wrong');
            }
        }
          
        $data=[
            "user_id"=>$request->user_id,
            "product_id"=>$request->product_id,
            "session_type"=>$request->session_type,
        ];

        $user = WishlistModel::create($data);
        $res = $data;
        
        return $this->sendResponse(1, $res, 'Item Added to Wishlist');
  }
   
    // view wishlist products of perticular user
    public function viewWishlist(Request $request): JsonResponse
    {
          $where=array('wishlist.user_id'=>$request->user_id,'wishlist.del_status'=>0,'inventory_images.dp_status'=>1);
       
          $data= DB::table('wishlist')
            ->leftjoin('inventory_new', 'inventory_new.id', '=', 'wishlist.product_id')
            ->leftjoin('inventory_images', 'inventory_images.item_id', '=', 'inventory_new.id')
            ->select('inventory_new.product_name','inventory_new.mrp', 'inventory_new.description','inventory_new.id','inventory_images.image','inventory_new.discounted_price','inventory_images.folder','inventory_images.alt')
            ->where($where)
            ->get();
            
          return $this->sendResponse(1, $data, 'success');
    }
    
    //Remove from Wishlist
    public function removeWishlistItem(Request $request):JsonResponse
    {
        $user_id=$request->user_id;
        $product_id=$request->product_id;
        $where=array('user_id'=>$user_id, 'product_id'=>$product_id);
        $item = WishlistModel::where($where);
        
        $deleted = $item->delete();

        if ($deleted) {
            return $this->sendResponse(1, null, 'Item Removed from Wishlist');
        } else {
            return $this->sendResponse(0, null, 'Something Went Wrong');
        }
    }
    
    
    //Check if product is there for a perticular user
    public function productExist(Request $request): JsonResponse
    {
        $productExist = WishlistModel::where(['product_id'=>$request->product_id, 'user_id'=>$request->user_id])->first();
        if($productExist) {
            $res['isExist']=true;
            return $this->sendResponse(1, $res, 'success');
        }
        else {
            $res['isExist']=false;
            return $this->sendResponse(1, $res, 'success');
        }
    }
    
}