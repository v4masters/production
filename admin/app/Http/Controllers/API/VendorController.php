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
   
class VendorController extends BaseController
{
    //vendorDetails
    public function vendorDetails(Request $request): JsonResponse
    {
        $data = VendorModel::where(['unique_id'=>$request->vendor_id])->first();
        $where = array('inventory_new.vendor_id' => $request->vendor_id,'inventory_new.del_status' => 0, 'inventory_new.status' => 1);
        $inv = InventoryNewModel::where($where)->count();
        
        $data->total_vendor_inventory = $inv;
        
        return $this->sendResponse(1, $data, 'success');
    }

    //getVendorInventories
    public function getVendorInventories(Request $request): JsonResponse
    {
        $array=[];
        $res=[];
        $where = array('inventory_new.vendor_id' => $request->vendor_id,'inventory_new.del_status' => 0, 'inventory_new.status' => 1);
        $data= DB::table('inventory_new')
            // ->leftjoin('cart', 'cart.product_id', '=', 'inventory_new.id')
            // 'cart.product_id','cart.user_id',
            ->select('inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.shipping_charges','inventory_new.discounted_price')
            ->where($where)
            ->orderBy('inventory_new.id', 'desc')
            ->get();
        
        // $cartData = CartModel::where(array('user_id'=>$request->user_id))->first();
        
        foreach($data as $key => $res)
        {
            $img_array=array('item_id'=>$res->id,'dp_status'=>1);
            $inv_images = InventoryImgModel::where($img_array)->first();
        
            if($inv_images)
            {
                $image=$inv_images->image;
                $alt=$inv_images->alt;
                $folder=$inv_images->folder;
            // }
            // else
            // {
            //     $image='default_img.png';
            //     $alt='Online Book Store';
            //     $folder='products';
            // }
            
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
            
            $id=$res->id;
            $description=$res->description;
            $mrp=$res->mrp;
            $product_name=$res->product_name;
            $discounted_price=$res->discounted_price;
            $shipping_charges=$res->shipping_charges;
        
            $res=array('image'=>$image,'alt'=>$alt,'folder'=>$folder,'product_name'=>$product_name,'description'=>$description,'mrp'=>$mrp,'id'=>$id, 'discounted_price'=>$discounted_price, 'shipping_charges'=>$shipping_charges, 'itemExistInCart'=>$itemExistInCart,'itemExistInWishlist'=>$itemExistInWishlist) ;
        
            array_push($array,$res);
        }
        }
        // $array2 = ['user_id'=>$request->user_id];
        return $this->sendResponse(1, $array, 'success');
    }
    
    // inventoryDetail (see all feature)
    public function inventoryDetail(Request $request, string $id): JsonResponse
    {
        $where = array('inventory_new.id' => $id);
        $data= DB::table('inventory_new')
            ->leftjoin('master_taxes', 'master_taxes.id', '=', 'inventory_new.gst')
            ->leftjoin('master_colour', 'master_colour.id', '=', 'inventory_new.color')
            ->leftjoin('size_list', 'size_list.id', '=', 'inventory_new.size')
            ->leftjoin('sizes', 'sizes.id', '=', 'size_list.size_id')
            ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
            ->leftjoin('master_brand', 'master_brand.id', '=', 'inventory_new.brand')
            ->leftjoin('master_qty_unit', 'master_qty_unit.id', '=', 'inventory_new.qty_unit')
            ->leftjoin('inventory_cat', 'inventory_cat.id', '=', 'inventory_new.cat_id')
            ->leftjoin('vendor', 'vendor.unique_id', '=', 'inventory_new.vendor_id')
            ->select('vendor.username as vendor_name','master_colour.title as product_color','size_list.title as product_size','master_classes.title as class_title','sizes.title as sizes_title','inventory_cat.cat_one as inv_cat_one','inventory_cat.cat_two as inv_cat_two','inventory_cat.cat_three as inv_cat_three','inventory_cat.cat_four as inv_cat_four','inventory_new.*',  'master_taxes.title as gst_title',  'master_qty_unit.title as qty_unit_title',  'master_brand.title as brand_title')
            ->where($where)
            ->first();
            
        // $cat_one = CatOne::select('name')->where('id', $data->inv_cat_one)->first();
        // $cat_two = CatTwo::select('name')->where('id', $data->inv_cat_two)->first();
        // $cat_three = CatThree::select('title')->where('id', $data->inv_cat_three)->first();
        // $cat_four = CatFour::select('title')->where('id', $data->inv_cat_four)->first();

        $inv_images = InventoryImgModel::select('image','alt','folder','dp_status')->where('item_id', $data->id)->get();

        // $cat_detail=array('cat_one'=>$cat_one->name,'cat_two'=>$cat_two->name,'cat_three'=>$cat_three->title,'cat_four'=>$cat_four->title);
        // 'cat_detail'=>$cat_detail,
        $arraydata=array('inventory'=>$data,'inv_images'=>$inv_images);
       
        return $this->sendResponse(1, $arraydata, 'success');
    }
    
    
    
    //checkPincodeAvailability
    public function checkPincodeAvailability(Request $request): JsonResponse
    {
        $available = PincodeListModel::where('pincode',$request->pincode)->first();
        if($available)
        {
            $msg = true;
        }
        else
        {
            $msg = false;
        }
        return $this->sendResponse(1, null, $msg);
    }
}