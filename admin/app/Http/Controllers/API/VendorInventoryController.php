<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\API\InventoryImgModel;
use App\Models\API\InventoryNewModel;
use App\Models\API\CartModel;
use App\Models\API\WishlistModel;
use App\Models\API\PincodeListModel;
use App\Models\API\VendorModel;
use App\Models\API\CatOne;
use App\Models\API\CatTwo;
use App\Models\API\CatThree;
use App\Models\API\CatFour;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
   
class VendorInventoryController extends BaseController
{
    
    public function paginate($items, $perPage = 8, $page = null, $options = ['path' => 'https://evyapari.com/admin/public/api/vendorInventory'])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow, $total, $perPage, $page,$options);
    }
  
    //vendorInventory
    public function vendorInventory(Request $request): JsonResponse
    {
        $array=[];
        $res=[];
        $where = ['inventory_new.vendor_id'=>$request->vendor_id,'inventory_new.del_status' => 0, 'inventory_new.status' => 1];
        
        $data= DB::table('inventory_new')
        ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
        ->where($where)
        ->orderBy('inventory_new.id', 'desc')
        ->get();
        
        foreach($data as  $res)
        {
            $where2=array('item_id'=>$res->id,'dp_status'=>1);
            $inv_images = InventoryImgModel::where($where2)->first();
        
            if($inv_images)
            {
                $image=$inv_images->image;
                $alt=$inv_images->alt;
                $folder=$inv_images->folder;
            }
            else
            {
                $image='books.jpg';
                $alt='';
                $folder='inventory';
            }
             $where = ['review.product_id'=>$res->product_id, 'review.status'=>1];


                $reviews= DB::table('review')
                ->leftjoin('users', 'users.unique_id', '=', 'review.user_id')
                ->select('users.name as user_name', 'review.review_comment', 'review.rating', 'review.image')
                ->where($where)
                ->get();
                
                
                $cartData = CartModel::select('id','product_id')->where(array('item_type'=>0,'user_id'=>$request->user_id,'product_id'=>$res->id,'del_status'=>0))->first();
                $wishlistData = WishlistModel::select('id','product_id')->where(array('user_id'=>$request->user_id,'product_id'=>$res->id,'del_status'=>0))->first();
                
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
        
                $res=array(
                    'last_cat_id'=>$res->last_cat_id,
                    'id'=>$res->id,
                    'product_id'=>$res->product_id,
                    'product_name'=>$res->product_name,
                    'discounted_price'=>$res->discounted_price, 
                    'mrp'=>$res->mrp,
                    'image'=>$image,
                     'reviews'=>$reviews,
                    'alt'=>$alt,
                    'folder'=>$folder,
                    'vendor_id'=>$res->vendor_id,
                    'description'=>$res->description,
                    'shipping_charges'=>$res->shipping_charges, 
                    'itemExistInCart'=>$itemExistInCart,
                    'itemExistInWishlist'=>$itemExistInWishlist,
                );
        
                array_push($array,$res);
        }
        
        $data = $this->paginate($array);
        $result['pageData']=$data;
        
        return $this->sendResponse(1, $result, 'success');
}
    
}