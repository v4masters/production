<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\API\InventoryImgModel;
use App\Models\API\InventoryVenImgModel;
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
   
class InventoryController extends BaseController
{
    
    public function paginate($items, $perPage = 8, $page = null, $options = ['path' => 'https://evyapari.com/admin/public/api/pageInventory'])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow, $total, $perPage, $page,$options);
    }
    
    public function getLastCategories(Request $request): JsonResponse
    {
        $cat_id=$request->cat_id; $subcat_id=$request->subcat_id; $subcat2_id=$request->subcat2_id;
        $cat_array= CatFour::select('id', 'title')->where(['cat_id'=>$cat_id,'sub_cat_id'=>$subcat_id,'sub_cat_id_two'=>$subcat2_id,'del_status'=>0])->get();
        return $this->sendResponse(1, $cat_array, 'success');
    }
    
    
    //pageInventory
  public function pageInventory(Request $request): JsonResponse
    {
        $cat_id=$request->cat_id; $subcat_id=$request->subcat_id; $subcat2_id=$request->subcat2_id;
        $subcat3_id=$request->subcat3_id;
        
        $array=[];
        $res=[];
        
        if(!empty($request->searchKeyword) && !empty($request->sortKeyword))
        {
            if($request->sortKeyword == 'price_desc')
            {
                $orderby='desc';
            } else {
                $orderby='asc';
            }
            $where = array('inventory_new.product_name' , 'LIKE', '%'.$request->searchKeyword.'%', 'inventory_new.del_status' => 0, 'inventory_new.status' => 1);
            $data= DB::table('inventory_new')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            ->where($where)
             ->where('qty_available', '>=', 1)
            ->orderBy('inventory_new.discounted_price', $orderby)
            ->get();
            
            
            // $where = ['inventory_new.del_status' => 0, 'inventory_new.status' => 1];
            // $data= DB::table('inventory_new')
            // ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            // ->where($where)
            // ->orderBy('inventory_new.id', 'desc')
            // ->get();
        }
        elseif(!empty($request->searchKeyword))
        {
            $where = array('inventory_new.del_status' => 0, 'inventory_new.status' => 1);
            $data= DB::table('inventory_new')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            ->where('inventory_new.product_name', 'LIKE', '%' . $request->searchKeyword . '%')
            ->where($where)
            ->orderBy('inventory_new.id', 'desc')
            
            ->get();
            // $where = [
            //     'inventory_new.del_status' => 0,
            //     'inventory_new.status' => 1
            // ];
        
            // // Querying the database
            // $data = DB::table('inventory_new')
            //     ->select(
            //         'inventory_new.cat_id as last_cat_id',
            //         'inventory_new.product_name',
            //         'inventory_new.description',
            //         'inventory_new.mrp',
            //         'inventory_new.id',
            //         'inventory_new.product_id',
            //         'inventory_new.shipping_charges',
            //         'inventory_new.discounted_price',
            //         'inventory_new.vendor_id'
            //     )
            //     ->where('inventory_new.product_name', 'LIKE', '%' . $request->searchKeyword . '%')
            //     ->where($where)
            //     // ->where('qty_available', '>=', 1)
            //     ->orderBy('inventory_new.id', 'desc')
            //     ->get();    
        } 
        elseif(!empty($request->sortKeyword))
        {
            if($request->sortKeyword == 'price_desc')
            {
                $orderby='desc';
            } else {
                $orderby='asc';
            }
            
            $where = array('inventory_new.del_status' => 0, 'inventory_new.status' => 1);
            $data= DB::table('inventory_new')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.discounted_price','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges', 'inventory_new.vendor_id')
            ->where($where)
            ->orderBy('inventory_new.discounted_price', $orderby)
            ->get();
        }
        elseif(!(empty($cat_id) && empty($subcat_id) && empty($subcat2_id)))
        {
            $cat_array= CatFour::select('id', 'title')->where(['cat_id'=>$cat_id,'sub_cat_id'=>$subcat_id,'sub_cat_id_two'=>$subcat2_id])->get();
            
            $data= DB::table('inventory_new')
            ->leftjoin('master_category_sub_three', 'master_category_sub_three.id', '=', 'inventory_new.cat_id')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            ->where(['master_category_sub_three.sub_cat_id_two'=>$subcat2_id,'inventory_new.del_status' => 0, 'inventory_new.status' => 1])
            ->orderBy('inventory_new.id', 'desc')
            ->get();

            $result['catData']=$cat_array;
        }
        elseif(!empty($subcat3_id))
        {
            $data= DB::table('inventory_new')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            ->where(['inventory_new.cat_id'=> $subcat3_id,'inventory_new.del_status' => 0, 'inventory_new.status' => 1])
            ->orderBy('inventory_new.id', 'desc')
            ->get();
        }
        else 
        {
            $where = ['inventory_new.del_status' => 0, 'inventory_new.status' => 1];
            $data= DB::table('inventory_new')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            ->where($where)
            ->orderBy('inventory_new.id', 'desc')
            ->get();
        }
        // return $this->sendResponse(1, $data, 'success');
        
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
            $newr=null;

                $reviews= DB::table('review')
                ->leftjoin('users', 'users.unique_id', '=', 'review.user_id')
                ->select('users.name as user_name', 'review.review_comment', 'review.rating', 'review.image')
                ->where($where)
                ->get();
                // if($reviews)
                // {
                //     $newr=$reviews;
                // }
                // else
                // {
                //     $newr=null;
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
// public function pageInventory(Request $request): JsonResponse
// {
//     $cat_id = $request->cat_id; 
//     $subcat_id = $request->subcat_id; 
//     $subcat2_id = $request->subcat2_id;
//     $subcat3_id = $request->subcat3_id;
    
//     $array = [];
//     $res = [];
    
//     if (!empty($request->searchKeyword) && !empty($request->sortKeyword)) {
//         $orderby = ($request->sortKeyword == 'price_desc') ? 'desc' : 'asc';

//         $where = [
//             'inventory_vendor.del_status' => 0,
//             'inventory_vendor.status' => 1
//         ];

//         $data = DB::table('inventory_vendor')
//             ->select(
//                 'inventory_vendor.cat_id as last_cat_id',
//                 'inventory_vendor.product_name',
//                 'inventory_vendor.description',
//                 'inventory_vendor.mrp',
//                 'inventory_vendor.id',
//                 'inventory_vendor.product_id',
//                 'inventory_vendor.shipping_charges',
//                 'inventory_vendor.discounted_price',
//                 'inventory_vendor.vendor_id'
//             )
//             ->where('inventory_vendor.product_name', 'LIKE', '%' . $request->searchKeyword . '%')
//             ->where($where)
//             ->where('qty_available', '>=', 1)
//             ->orderBy('inventory_vendor.discounted_price', $orderby)
//             ->get();
//     } elseif (!empty($request->searchKeyword)) {
//         $where = [
//             'inventory_vendor.del_status' => 0,
//             'inventory_vendor.status' => 1
//         ];

//         $data = DB::table('inventory_vendor')
//             ->select(
//                 'inventory_vendor.cat_id as last_cat_id',
//                 'inventory_vendor.product_name',
//                 'inventory_vendor.description',
//                 'inventory_vendor.mrp',
//                 'inventory_vendor.id',
//                 'inventory_vendor.product_id',
//                 'inventory_vendor.shipping_charges',
//                 'inventory_vendor.discounted_price',
//                 'inventory_vendor.vendor_id'
//             )
//             ->where('inventory_vendor.product_name', 'LIKE', '%' . $request->searchKeyword . '%')
//             ->where($where)
//             ->orderBy('inventory_vendor.id', 'desc')
//             ->get();
//     } elseif (!empty($request->sortKeyword)) {
//         $orderby = ($request->sortKeyword == 'price_desc') ? 'desc' : 'asc';

//         $where = [
//             'inventory_vendor.del_status' => 0,
//             'inventory_vendor.status' => 1
//         ];

//         $data = DB::table('inventory_vendor')
//             ->select(
//                 'inventory_vendor.cat_id as last_cat_id',
//                 'inventory_vendor.product_name',
//                 'inventory_vendor.description',
//                 'inventory_vendor.mrp',
//                 'inventory_vendor.discounted_price',
//                 'inventory_vendor.id',
//                 'inventory_vendor.product_id',
//                 'inventory_vendor.shipping_charges',
//                 'inventory_vendor.vendor_id'
//             )
//             ->where($where)
//             ->orderBy('inventory_vendor.discounted_price', $orderby)
//             ->get();
//     } elseif (!(empty($cat_id) && empty($subcat_id) && empty($subcat2_id))) {
//         $cat_array = CatFour::select('id', 'title')
//             ->where(['cat_id' => $cat_id, 'sub_cat_id' => $subcat_id, 'sub_cat_id_two' => $subcat2_id])
//             ->get();

//         $data = DB::table('inventory_vendor')
//             ->leftJoin('master_category_sub_three', 'master_category_sub_three.id', '=', 'inventory_vendor.cat_id')
//             ->select(
//                 'inventory_vendor.cat_id as last_cat_id',
//                 'inventory_vendor.product_name',
//                 'inventory_vendor.description',
//                 'inventory_vendor.mrp',
//                 'inventory_vendor.id',
//                 'inventory_vendor.product_id',
//                 'inventory_vendor.shipping_charges',
//                 'inventory_vendor.discounted_price',
//                 'inventory_vendor.vendor_id'
//             )
//             ->where([
//                 'master_category_sub_three.sub_cat_id_two' => $subcat2_id,
//                 'inventory_vendor.del_status' => 0,
//                 'inventory_vendor.status' => 1
//             ])
//             ->orderBy('inventory_vendor.id', 'desc')
//             ->get();

//         $result['catData'] = $cat_array;
//     } elseif (!empty($subcat3_id)) {
//         $data = DB::table('inventory_vendor')
//             ->select(
//                 'inventory_vendor.cat_id as last_cat_id',
//                 'inventory_vendor.product_name',
//                 'inventory_vendor.description',
//                 'inventory_vendor.mrp',
//                 'inventory_vendor.id',
//                 'inventory_vendor.product_id',
//                 'inventory_vendor.shipping_charges',
//                 'inventory_vendor.discounted_price',
//                 'inventory_vendor.vendor_id'
//             )
//             ->where([
//                 'inventory_vendor.cat_id' => $subcat3_id,
//                 'inventory_vendor.del_status' => 0,
//                 'inventory_vendor.status' => 1
//             ])
//             ->orderBy('inventory_vendor.id', 'desc')
//             ->get();
//     } else {
//         $where = [
//             'inventory_vendor.del_status' => 0,
//             'inventory_vendor.status' => 1
//         ];

//         $data = DB::table('inventory_vendor')
//             ->select(
//                 'inventory_vendor.cat_id as last_cat_id',
//                 'inventory_vendor.product_name',
//                 'inventory_vendor.description',
//                 'inventory_vendor.mrp',
//                 'inventory_vendor.id',
//                 'inventory_vendor.product_id',
//                 'inventory_vendor.shipping_charges',
//                 'inventory_vendor.discounted_price',
//                 'inventory_vendor.vendor_id'
//             )
//             ->where($where)
//             ->orderBy('inventory_vendor.id', 'desc')
//             ->get();
//     }

//     foreach ($data as $res) {
//     // Fetch image directly from inventory_images_vendor table
//     $inv_images = DB::table('inventory_images_vendor')
//         ->where([
//             'item_id' => $res->id,
//             'dp_status' => 1,
//             'del_status' => 0,
//             'status' => 1
//         ])
//         ->first();

//         if ($inv_images) {
//             $image = $inv_images->image;
//             $alt = $inv_images->alt;
//             $folder = $inv_images->folder;
//         } else {
//             $image = 'books.jpg';
//             $alt = '';
//             $folder = 'inventory';
//         }

//         $where = ['review.product_id' => $res->product_id, 'review.status' => 1];

//         $reviews = DB::table('review')
//             ->leftJoin('users', 'users.unique_id', '=', 'review.user_id')
//             ->select('users.name as user_name', 'review.review_comment', 'review.rating', 'review.image')
//             ->where($where)
//             ->get();

//         $cartData = CartModel::select('id', 'product_id')
//             ->where([
//                 'item_type' => 0,
//                 'user_id' => $request->user_id,
//                 'product_id' => $res->id,
//                 'del_status' => 0
//             ])
//             ->first();

//         $wishlistData = WishlistModel::select('id', 'product_id')
//             ->where([
//                 'user_id' => $request->user_id,
//                 'product_id' => $res->id,
//                 'del_status' => 0
//             ])
//             ->first();

//         $itemExistInCart = $cartData ? true : false;
//         $itemExistInWishlist = $wishlistData ? true : false;

//         $res = [
//             'last_cat_id' => $res->last_cat_id,
//             'id' => $res->id,
//             'product_id' => $res->product_id,
//             'product_name' => $res->product_name,
//             'discounted_price' => $res->discounted_price,
//             'mrp' => $res->mrp,
//             'image' => $image,
//             'reviews' => $reviews,
//             'alt' => $alt,
//             'folder' => $folder,
//             'vendor_id' => $res->vendor_id,
//             'description' => $res->description,
//             'shipping_charges' => $res->shipping_charges,
//             'itemExistInCart' => $itemExistInCart,
//             'itemExistInWishlist' => $itemExistInWishlist,
//         ];

//         array_push($array, $res);
//     }

//     $data = $this->paginate($array);
//     $result['pageData'] = $data;

//     return $this->sendResponse(1, $result, 'success');
// }


    public function testsearch(Request $request): JsonResponse
      {
        $cat_id=$request->cat_id; $subcat_id=$request->subcat_id; $subcat2_id=$request->subcat2_id;$subcat3_id=$request->subcat3_id;
        
        $array=[];
        $res=[];
        $where = ['inventory_new.del_status' => 0, 'inventory_new.status' => 1];
        if(!empty($request->searchKeyword))
        {
            $where = array('inventory_new.del_status' => 0, 'inventory_new.status' => 1);
            $data= DB::table('inventory_new')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            ->where('inventory_new.product_name' , 'LIKE', '%'.$request->searchKeyword.'%')
            ->orderBy('inventory_new.id', 'desc')
            ->get();
        } 
        elseif(!empty($subcat3_id))
        {
            $data= DB::table('inventory_new')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            ->where(['inventory_new.cat_id'=> $subcat3_id,'inventory_new.del_status' => 0, 'inventory_new.status' => 1])
            ->orderBy('inventory_new.id', 'desc')
            ->limit(50)
            ->get();
        }
        elseif(!(empty($cat_id) && empty($subcat_id) && empty($subcat2_id)))
        {
            $data= DB::table('inventory_new')
            ->leftJoin('master_category_sub_three', 'master_category_sub_three.id', '=', 'inventory_new.cat_id')
            ->leftJoin('master_category_sub_two', 'master_category_sub_two.id', '=', 'master_category_sub_three.sub_cat_id_two')
            ->leftJoin('master_category_sub', 'master_category_sub.id', '=', 'master_category_sub_two.sub_cat_id')
            ->leftJoin('master_category', 'master_category.id', '=', 'master_category_sub.cat_id')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            ->where(['master_category'=>$cat_id,'master_category_sub'=>$subcat_id,'master_category_sub_two'=>$subcat2_id,'inventory_new.del_status' => 0, 'inventory_new.status' => 1])
            ->orderBy('inventory_new.id', 'desc')
            ->limit(50)
            ->get();
        }
        else 
        {
            $data= DB::table('inventory_new')
            // ->leftJoin('master_category_sub_three', 'master_category_sub_three.id', '=', 'inventory_new.cat_id')
            // ->leftJoin('master_category_sub_two', 'master_category_sub_two.id', '=', 'master_category_sub_three.sub_cat_id_two')
            // ->leftJoin('master_category_sub', 'master_category_sub.id', '=', 'master_category_sub_two.sub_cat_id')
            // ->leftJoin('master_category', 'master_category.id', '=', 'master_category_sub.cat_id')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            ->where($where)
            ->limit(50)
            ->orderBy('inventory_new.id', 'desc')
            ->get();
        }
        
        foreach($data as $key => $res)
        {
            $img_array=array('item_id'=>$res->id,'dp_status'=>1);
            $inv_images = InventoryImgModel::where($img_array)->first();
        
            if($inv_images)
            {
                $image=$inv_images->image;
                $alt=$inv_images->alt;
                $folder=$inv_images->folder;
            }
            else
            {
                $image='books.jpg';
                $alt='Online Book Store';
                $folder='products';
            }
            
              $where = ['review.product_id'=>$res->product_id, 'review.status'=>1];
            $newr=null;
               
                $reviews= DB::table('review')
                ->leftjoin('users', 'users.unique_id', '=', 'review.user_id')
                ->select('users.name as user_name', 'review.review_comment', 'review.rating', 'review.image')
                ->where($where)
                ->get();
                if(count($reviews) != 0)
                {
                    $newr=$reviews;
                }
                else
                {
                    $newr=null;
                }
                
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
                'alt'=>$alt,
                'folder'=>$folder,
                'reviews'=>$newr,
                'vendor_id'=>$res->vendor_id,
                'description'=>$res->description,
                'shipping_charges'=>$res->shipping_charges, 
                'itemExistInCart'=>$itemExistInCart,
                'itemExistInWishlist'=>$itemExistInWishlist,
            );
        
            array_push($array,$res);
        }
        // $array2 = ['user_id'=>$request->user_id];
        return $this->sendResponse(1, $array, 'success');
}
    public function brand_model_search(Request $request)
    {  
        
    $brand_model=explode(",",$request->brand_model);
    
    if($brand_model[0]){$brand=$brand_model[0];}else{$brand="";}
    if(array_key_exists("1",$brand_model)){  $model=$brand_model[1];}else{   $model=""; }
    
    
    
    if($model!="" && $brand!="")    
    {
    $res= DB::table('vahicle_brand')
    ->join('vahicle_model', 'vahicle_model.brand_id', '=', 'vahicle_brand.id')
    ->select('vahicle_brand.folder','vahicle_brand.brand_logo','vahicle_model.id as model_id','vahicle_model.brand_id','vahicle_model.model')
    ->where(['vahicle_brand.brand_name' => str_replace(" ","",$brand),'vahicle_model.model' => str_replace(" ","",$model), 'vahicle_brand.del_status' => 0,'vahicle_brand.status'=>1,'vahicle_model.del_status' => 0,'vahicle_model.status'=>1])
    ->get();
    return response()->json($res, 200);
    }
    
    
    elseif($model=="" && $brand!="")
    {
    $res= DB::table('vahicle_brand')
    ->join('vahicle_model', 'vahicle_model.brand_id', '=', 'vahicle_brand.id')
    ->select('vahicle_brand.folder','vahicle_brand.brand_logo','vahicle_model.id as model_id','vahicle_model.brand_id','vahicle_model.model')
    ->where(['vahicle_brand.del_status' => 0,'vahicle_brand.status'=>1,'vahicle_model.del_status' => 0,'vahicle_model.status'=>1])
    ->Where('vahicle_brand.brand_name',$brand)
    ->orWhere('vahicle_model.model',$brand)
    ->get();
    
    
        
        return response()->json($res, 200);
    
    
    }
    
    
    else
    {
      $res= DB::table('vahicle_brand')
    ->join('vahicle_model', 'vahicle_model.brand_id', '=', 'vahicle_brand.id')
    ->select('vahicle_brand.folder','vahicle_brand.brand_logo','vahicle_model.id as model_id','vahicle_model.brand_id','vahicle_model.model')
    ->where(['vahicle_brand.del_status' => 0,'vahicle_brand.status'=>1,'vahicle_model.del_status' => 0,'vahicle_model.status'=>1])
    ->get();
    return response()->json($res, 200); 
    
    }
    
    }
    
    //homeInventory
    public function homeInventory(Request $request): JsonResponse
    {
        $array=[];
        $res=[];
        $where = ['inventory_new.del_status' => 0, 'inventory_new.status' => 1];
        
        $data= DB::table('inventory_new')
        ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
        ->where($where)
        ->limit(20)
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
        return $this->sendResponse(1, $array, 'success');
}
    public function schoolbagshomeInventory(Request $request): JsonResponse
    {
    $newarray = [];  
    
    $where1 = ['del_status' => 0, 'status' => 1];
    $cat_one = CatOne::where($where1)->get();
    
    $main_categories = []; 
    
    $where = ['master_category.del_status' => 0, 'master_category.status' => 1];
    $maincategories = DB::table('master_category')
        ->select('master_category.id', 'master_category.name')
        ->where($where)
        ->orderBy('master_category.id', 'asc')
        ->get();
    
    foreach ($maincategories as $main) {
        $printed_categories = []; 
        $where = ['inventory_cat.del_status' => 0, 'inventory_cat.status' => 1, 'inventory_cat.cat_one' =>  $main->id];
        $subcategory = DB::table('inventory_cat')
            ->select('inventory_cat.cat_one', 'inventory_cat.cat_four')
            ->where($where)
            ->get();
    
        foreach ($subcategory as $stcat) {
            if (!in_array($stcat->cat_four, $printed_categories)) {
                $printed_categories[] = $stcat->cat_four;  // Avoid duplicates.
            }
        }
        // print_r($printed_categories);
        $categoryProducts = [];  
        $where = ['inventory_new.del_status' => 0, 'inventory_new.status' => 1];
    
     
        $totalFetched = 0;
    
       $data = DB::table('inventory_new')
                    ->select('inventory_new.cat_id as last_cat_id', 'inventory_new.product_name', 'inventory_new.description', 
                             'inventory_new.mrp', 'inventory_new.id', 'inventory_new.product_id', 
                             'inventory_new.shipping_charges', 'inventory_new.discounted_price', 'inventory_new.vendor_id')
                    ->where($where)
                    ->whereIn('inventory_new.cat_id', $printed_categories)
                  
                    ->limit(20)  
                    ->orderBy('inventory_new.id', 'desc')
                    ->get();
    
            $where = ['inventory_new.del_status' => 0, 'inventory_new.status' => 1];
         
    
            foreach ($data as $res) {
                $where2 = ['item_id' => $res->id, 'dp_status' => 1];
                $inv_images = InventoryImgModel::where($where2)->first();
    
                if ($inv_images) {
                    $image = $inv_images->image;
                    $alt = $inv_images->alt;
                    $folder = $inv_images->folder;
                } else {
                    $image = 'books.jpg';
                    $alt = '';
                    $folder = 'inventory';
                }
    
                $cartData = CartModel::select('id', 'product_id')->where(['item_type' => 0, 'user_id' => $request->user_id, 'product_id' => $res->id, 'del_status' => 0])->first();
                $wishlistData = WishlistModel::select('id', 'product_id')->where(['user_id' => $request->user_id, 'product_id' => $res->id, 'del_status' => 0])->first();
                
                $itemExistInCart = $cartData ? true : false;
                $itemExistInWishlist = $wishlistData ? true : false;
    
                $productDetails = [
                    'last_cat_id' => $res->last_cat_id,
                    'id' => $res->id,
                    'product_id' => $res->product_id,
                    'product_name' => $res->product_name,
                    'discounted_price' => $res->discounted_price, 
                    'mrp' => $res->mrp,
                    'image' => $image,
                    'alt' => $alt,
                    'folder' => $folder,
                    'vendor_id' => $res->vendor_id,
                    'description' => $res->description,
                    'shipping_charges' => $res->shipping_charges, 
                    'itemExistInCart' => $itemExistInCart,
                    'itemExistInWishlist' => $itemExistInWishlist,
                ];
    
           
                array_push($categoryProducts, $productDetails);
    
           
                $totalFetched++;
    
              
                if ($totalFetched >= 20) {
                    break;
                }
            }
    
       
          
    
   
        $newarray[] = [
            'id' => $main->id,
            'name' => $main->name,
            'products' => $categoryProducts
        ];
    

        if ($totalFetched >= 20) {
            break;
        }
    }
    
 
    if (empty($newarray)) {
        return $this->sendResponse(0, $res1, 'No data found');
    }
    
 
    return $this->sendResponse(1, $newarray, 'Success');
}
    public function statioaryhomeInventory(Request $request): JsonResponse
    {
        $array=[];
        $res=[];
        $where = ['inventory_new.del_status' => 0, 'inventory_new.status' => 1];
        
        $data= DB::table('inventory_new')
        ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
        ->where($where)
        ->where('cat_id',179)
        ->limit(20)
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
        return $this->sendResponse(1, $array, 'success');
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
    
    
    //allInventory
    public function allInventory(Request $request): JsonResponse
    {
        $cat_id=$request->cat_id; $subcat_id=$request->subcat_id; $subcat2_id=$request->subcat2_id;$subcat3_id=$request->subcat3_id;
        
        $array=[];
        $res=[];
        $where = ['inventory_new.del_status' => 0, 'inventory_new.status' => 1];
        if(!empty($request->searchKeyword))
        {
            $where = array('inventory_new.del_status' => 0, 'inventory_new.status' => 1);
            $data= DB::table('inventory_new')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            ->where('inventory_new.product_name' , 'LIKE', '%'.$request->searchKeyword.'%')
            ->orderBy('inventory_new.id', 'desc')
            ->get();
        } 
        elseif(!empty($subcat3_id))
        {
            $data= DB::table('inventory_new')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            ->where(['inventory_new.cat_id'=> $subcat3_id,'inventory_new.del_status' => 0, 'inventory_new.status' => 1])
            ->orderBy('inventory_new.id', 'desc')
            ->limit(50)
            ->get();
        }
        elseif(!(empty($cat_id) && empty($subcat_id) && empty($subcat2_id)))
        {
            $data= DB::table('inventory_new')
            ->leftJoin('master_category_sub_three', 'master_category_sub_three.id', '=', 'inventory_new.cat_id')
            ->leftJoin('master_category_sub_two', 'master_category_sub_two.id', '=', 'master_category_sub_three.sub_cat_id_two')
            ->leftJoin('master_category_sub', 'master_category_sub.id', '=', 'master_category_sub_two.sub_cat_id')
            ->leftJoin('master_category', 'master_category.id', '=', 'master_category_sub.cat_id')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            ->where(['master_category'=>$cat_id,'master_category_sub'=>$subcat_id,'master_category_sub_two'=>$subcat2_id,'inventory_new.del_status' => 0, 'inventory_new.status' => 1])
            ->orderBy('inventory_new.id', 'desc')
            ->limit(50)
            ->get();
        }
        else 
        {
            $data= DB::table('inventory_new')
            // ->leftJoin('master_category_sub_three', 'master_category_sub_three.id', '=', 'inventory_new.cat_id')
            // ->leftJoin('master_category_sub_two', 'master_category_sub_two.id', '=', 'master_category_sub_three.sub_cat_id_two')
            // ->leftJoin('master_category_sub', 'master_category_sub.id', '=', 'master_category_sub_two.sub_cat_id')
            // ->leftJoin('master_category', 'master_category.id', '=', 'master_category_sub.cat_id')
            ->select('inventory_new.cat_id as last_cat_id','inventory_new.product_name','inventory_new.description','inventory_new.mrp','inventory_new.id','inventory_new.product_id','inventory_new.shipping_charges','inventory_new.discounted_price', 'inventory_new.vendor_id')
            ->where($where)
            ->limit(50)
            ->orderBy('inventory_new.id', 'desc')
            ->get();
        }
        
        foreach($data as $key => $res)
        {
            $img_array=array('item_id'=>$res->id,'dp_status'=>1);
            $inv_images = InventoryImgModel::where($img_array)->first();
        
            if($inv_images)
            {
                $image=$inv_images->image;
                $alt=$inv_images->alt;
                $folder=$inv_images->folder;
            }
            else
            {
                $image='books.jpg';
                $alt='Online Book Store';
                $folder='products';
            }
            
              $where = ['review.product_id'=>$res->product_id, 'review.status'=>1];
            $newr=null;
               
                $reviews= DB::table('review')
                ->leftjoin('users', 'users.unique_id', '=', 'review.user_id')
                ->select('users.name as user_name', 'review.review_comment', 'review.rating', 'review.image')
                ->where($where)
                ->get();
                // if(count($reviews) != 0)
                // {
                //     $newr=$reviews;
                // }
                // else
                // {
                //     $newr=null;
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
            
        
            $res=array(
                'last_cat_id'=>$res->last_cat_id,
                'id'=>$res->id,
                'product_id'=>$res->product_id,
                'product_name'=>$res->product_name,
                'discounted_price'=>$res->discounted_price, 
                'mrp'=>$res->mrp,
                'image'=>$image,
                'alt'=>$alt,
                'folder'=>$folder,
                'reviews'=>$reviews,
                'vendor_id'=>$res->vendor_id,
                'description'=>$res->description,
                'shipping_charges'=>$res->shipping_charges, 
                'itemExistInCart'=>$itemExistInCart,
                'itemExistInWishlist'=>$itemExistInWishlist,
            );
        
            array_push($array,$res);
        }
        // $array2 = ['user_id'=>$request->user_id];
        return $this->sendResponse(1, $array, 'success');
}



    //bestsallerinventory
   /* public function bestsallerinventory(): JsonResponse
    {
 
    $result = DB::table('order_tracking')
    ->select('product_id', DB::raw('COUNT(*) as count'))
    ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), '=', date('Y-m'))
    ->where('item_type',0)
    ->groupBy('product_id')
    ->orderBy('count', 'DESC')
    ->limit(1)
    ->first();
    
    $inventory_id= InventoryNewModel::select('id')->where(['product_id'=>$result->product_id])->first();
     
        $where = array('inventory_new.id' => $inventory_id->id);
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
            ->select('inventory_new.*','inventory_new.cat_id as last_cat_id','vendor.username as vendor_name','master_colour.title as product_color','size_list.title as product_size','master_classes.title as class_title','sizes.title as sizes_title','inventory_cat.cat_one as inv_cat_one','inventory_cat.cat_two as inv_cat_two','inventory_cat.cat_three as inv_cat_three','inventory_cat.cat_four as inv_cat_four', 'master_taxes.title as gst_title',  'master_qty_unit.title as qty_unit_title',  'master_brand.title as brand_title')
            ->where($where)
            ->first();
            
        $vendor_id=$data->vendor_id;
        $vendor_inventory = InventoryNewModel::where(['vendor_id'=>$vendor_id, 'del_status'=>0, 'status'=>1])->get();
        $total_vendor_inventory = count($vendor_inventory);
        
        $data->total_vendor_inventory = $total_vendor_inventory;
        
        
        if(!empty($data->color))
        {
            $color_class= DB::table('inventory_new')
            ->leftjoin('master_colour', 'master_colour.id', '=', 'inventory_new.color')
            ->select('inventory_new.id as inventory_id', 'inventory_new.color as color_class_id', 'master_colour.title as color_class_title')
            ->where(['inventory_new.product_name'=>$data->product_name, 'inventory_new.size'=>$data->size])
            ->get();
        }
        
        if(!empty($data->class))
        {
            $color_class= DB::table('inventory_new')
            ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
            ->select('inventory_new.id as inventory_id', 'inventory_new.class as color_class_id', 'master_classes.title as color_class_title')
            ->where(['inventory_new.product_name'=>$data->product_name, 'inventory_new.size'=>$data->size])
            ->get();
        }
        
        $data->color_class=$color_class;
        
        $data4= DB::table('inventory_new')
        ->leftjoin('size_list', 'size_list.id', '=', 'inventory_new.size')
        ->select('size_list.title as size_medium_title', 'inventory_new.size as size_medium_id')
        ->distinct()
        ->where(['inventory_new.product_name'=>$data->product_name])
        ->get();
        
         $reviewswhere = ['review.product_id'=>$result->product_id, 'review.status'=>1];
         $reviews= DB::table('review')
                ->leftjoin('users', 'users.unique_id', '=', 'review.user_id')
                ->select('users.name as user_name', 'review.review_comment', 'review.rating', 'review.image')
                ->where($reviewswhere)
                ->get();
        $data->size_medium = $data4;
        $data->reviews = $reviews;
            

        $inv_images = InventoryVenImgModel::select('image','alt','folder','dp_status')->where('item_id', $data->id)->get();

        $arraydata=array('inventory'=>$data,'inv_images'=>$inv_images);
       
        return $this->sendResponse(1, $arraydata, 'success');
           
}*/
public function bestsallerinventory(): JsonResponse
{
    $result = DB::table('order_tracking')
        ->select('product_id', DB::raw('COUNT(*) as count'))
        ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), '=', date('Y-m'))
        ->where('item_type', 0)
        ->groupBy('product_id')
        ->orderBy('count', 'DESC')
        ->limit(1)
        ->first();

    if (!$result) {
        return $this->sendResponse(0, null);
    }

    $inventory_id = InventoryNewModel::select('id')
        ->where(['product_id' => $result->product_id])
        ->first();

    if (!$inventory_id) {
        return $this->sendResponse(0, null);
    }

    // ✅ Continue with your existing logic
    $where = ['inventory_new.id' => $inventory_id->id];
    $data = DB::table('inventory_new')
        ->leftJoin('master_taxes', 'master_taxes.id', '=', 'inventory_new.gst')
        ->leftJoin('master_colour', 'master_colour.id', '=', 'inventory_new.color')
        ->leftJoin('size_list', 'size_list.id', '=', 'inventory_new.size')
        ->leftJoin('sizes', 'sizes.id', '=', 'size_list.size_id')
        ->leftJoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
        ->leftJoin('master_brand', 'master_brand.id', '=', 'inventory_new.brand')
        ->leftJoin('master_qty_unit', 'master_qty_unit.id', '=', 'inventory_new.qty_unit')
        ->leftJoin('inventory_cat', 'inventory_cat.id', '=', 'inventory_new.cat_id')
        ->leftJoin('vendor', 'vendor.unique_id', '=', 'inventory_new.vendor_id')
        ->select(
            'inventory_new.*',
            'inventory_new.cat_id as last_cat_id',
            'vendor.username as vendor_name',
            'master_colour.title as product_color',
            'size_list.title as product_size',
            'master_classes.title as class_title',
            'sizes.title as sizes_title',
            'inventory_cat.cat_one as inv_cat_one',
            'inventory_cat.cat_two as inv_cat_two',
            'inventory_cat.cat_three as inv_cat_three',
            'inventory_cat.cat_four as inv_cat_four',
            'master_taxes.title as gst_title',
            'master_qty_unit.title as qty_unit_title',
            'master_brand.title as brand_title'
        )
        ->where($where)
        ->first();

    if (!$data) {
        return $this->sendResponse(0, null, 'Inventory record not found.');
    }

    // Additional data appending logic (color_class, size_medium, reviews, etc.)
    $vendor_id = $data->vendor_id;
    $vendor_inventory = InventoryNewModel::where(['vendor_id' => $vendor_id, 'del_status' => 0, 'status' => 1])->get();
    $data->total_vendor_inventory = count($vendor_inventory);

    // Avoid overwriting $color_class on second if condition
   $color_class = collect(); // ✅ Laravel Collection


    if (!empty($data->color)) {
        $color_class = DB::table('inventory_new')
            ->leftJoin('master_colour', 'master_colour.id', '=', 'inventory_new.color')
            ->select('inventory_new.id as inventory_id', 'inventory_new.color as color_class_id', 'master_colour.title as color_class_title')
            ->where(['inventory_new.product_name' => $data->product_name, 'inventory_new.size' => $data->size])
            ->get();
    }

    if (!empty($data->class)) {
        $class_data = DB::table('inventory_new')
            ->leftJoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
            ->select('inventory_new.id as inventory_id', 'inventory_new.class as color_class_id', 'master_classes.title as color_class_title')
            ->where(['inventory_new.product_name' => $data->product_name, 'inventory_new.size' => $data->size])
            ->get();

        // Merge color + class into single array (if both exist)
        $color_class = $color_class->merge($class_data);
    }

    $data->color_class = $color_class;

    $data4 = DB::table('inventory_new')
        ->leftJoin('size_list', 'size_list.id', '=', 'inventory_new.size')
        ->select('size_list.title as size_medium_title', 'inventory_new.size as size_medium_id')
        ->distinct()
        ->where(['inventory_new.product_name' => $data->product_name])
        ->get();

    $reviews = DB::table('review')
        ->leftJoin('users', 'users.unique_id', '=', 'review.user_id')
        ->select('users.name as user_name', 'review.review_comment', 'review.rating', 'review.image')
        ->where([
            'review.product_id' => $result->product_id,
            'review.status' => 1
        ])
        ->get();

    $data->size_medium = $data4;
    $data->reviews = $reviews;

    $inv_images = InventoryVenImgModel::select('image', 'alt', 'folder', 'dp_status')
        ->where('item_id', $data->id)
        ->get();

    $arraydata = [
        'inventory' => $data,
        'inv_images' => $inv_images
    ];

    return $this->sendResponse(1, $arraydata, 'success');
}


    //inventoryDetail (see all feature)
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
            ->select('inventory_new.*','inventory_new.cat_id as last_cat_id','vendor.username as vendor_name','master_colour.title as product_color','size_list.title as product_size','master_classes.title as class_title','sizes.title as sizes_title','inventory_cat.cat_one as inv_cat_one','inventory_cat.cat_two as inv_cat_two','inventory_cat.cat_three as inv_cat_three','inventory_cat.cat_four as inv_cat_four', 'master_taxes.title as gst_title',  'master_qty_unit.title as qty_unit_title',  'master_brand.title as brand_title')
            ->where($where)
            ->first();
            
        $vendor_id=$data->vendor_id;
        $vendor_inventory = InventoryNewModel::where(['vendor_id'=>$vendor_id, 'del_status'=>0, 'status'=>1])->get();
        $total_vendor_inventory = count($vendor_inventory);
        
        $data->total_vendor_inventory = $total_vendor_inventory;
        $color_class=[];
        
        if(!empty($data->color))
        {
            $color_class= DB::table('inventory_new')
            ->leftjoin('master_colour', 'master_colour.id', '=', 'inventory_new.color')
            ->select('inventory_new.id as inventory_id', 'inventory_new.color as color_class_id', 'master_colour.title as color_class_title')
            ->where(['inventory_new.product_name'=>$data->product_name, 'inventory_new.size'=>$data->size])
            ->get();
        }
        
        if(!empty($data->class))
        {
            $color_class= DB::table('inventory_new')
            ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
            ->select('inventory_new.id as inventory_id', 'inventory_new.class as color_class_id', 'master_classes.title as color_class_title')
            ->where(['inventory_new.product_name'=>$data->product_name, 'inventory_new.size'=>$data->size])
            ->get();
        }
        
        $data->color_class=$color_class;
        
        $data4= DB::table('inventory_new')
        ->leftjoin('size_list', 'size_list.id', '=', 'inventory_new.size')
        ->select('size_list.title as size_medium_title', 'inventory_new.size as size_medium_id')
        ->distinct()
        ->where(['inventory_new.product_name'=>$data->product_name])
        ->get();
        
        $data->size_medium = $data4;
        // print_r($data4);
            

        $inv_images = InventoryImgModel::select('image','alt','folder','dp_status')->where('item_id', $data->id)->get();

        $arraydata=array('inventory'=>$data,'inv_images'=>$inv_images);
       
        return $this->sendResponse(1, $arraydata, 'success');
    }
//   public function inventoryDetail(Request $request, string $id): JsonResponse
// {
//     $where = array('inventory_vendor.id' => $id);
//     $data= DB::table('inventory_vendor')
//         ->leftjoin('master_taxes', 'master_taxes.id', '=', 'inventory_vendor.gst')
//         ->leftjoin('master_colour', 'master_colour.id', '=', 'inventory_vendor.color')
//         ->leftjoin('size_list', 'size_list.id', '=', 'inventory_vendor.size')
//         ->leftjoin('sizes', 'sizes.id', '=', 'size_list.size_id')
//         ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory_vendor.class')
//         ->leftjoin('master_brand', 'master_brand.id', '=', 'inventory_vendor.brand')
//         ->leftjoin('master_qty_unit', 'master_qty_unit.id', '=', 'inventory_vendor.qty_unit')
//         ->leftjoin('inventory_cat', 'inventory_cat.id', '=', 'inventory_vendor.cat_id')
//         ->leftjoin('vendor', 'vendor.unique_id', '=', 'inventory_vendor.vendor_id')
//         ->select('inventory_vendor.*','inventory_vendor.cat_id as last_cat_id','vendor.username as vendor_name','master_colour.title as product_color','size_list.title as product_size','master_classes.title as class_title','sizes.title as sizes_title','inventory_cat.cat_one as inv_cat_one','inventory_cat.cat_two as inv_cat_two','inventory_cat.cat_three as inv_cat_three','inventory_cat.cat_four as inv_cat_four', 'master_taxes.title as gst_title',  'master_qty_unit.title as qty_unit_title',  'master_brand.title as brand_title')
//         ->where($where)
//         ->first();
        
//     $vendor_id = $data->vendor_id;
//     $vendor_inventory = InventoryNewModel::where(['vendor_id' => $vendor_id, 'del_status' => 0, 'status' => 1])->get();
//     $total_vendor_inventory = count($vendor_inventory);
    
//     $data->total_vendor_inventory = $total_vendor_inventory;
//     $color_class = [];

//     if (!empty($data->color)) {
//         $color_class = DB::table('inventory_vendor')
//             ->leftjoin('master_colour', 'master_colour.id', '=', 'inventory_vendor.color')
//             ->select('inventory_vendor.id as inventory_id', 'inventory_vendor.color as color_class_id', 'master_colour.title as color_class_title')
//             ->where(['inventory_vendor.product_name' => $data->product_name, 'inventory_vendor.size' => $data->size])
//             ->get();
//     }

//     if (!empty($data->class)) {
//         $color_class = DB::table('inventory_vendor')
//             ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory_vendor.class')
//             ->select('inventory_vendor.id as inventory_id', 'inventory_vendor.class as color_class_id', 'master_classes.title as color_class_title')
//             ->where(['inventory_vendor.product_name' => $data->product_name, 'inventory_vendor.size' => $data->size])
//             ->get();
//     }

//     $data->color_class = $color_class;

//     $data4 = DB::table('inventory_vendor')
//         ->leftjoin('size_list', 'size_list.id', '=', 'inventory_vendor.size')
//         ->select('size_list.title as size_medium_title', 'inventory_vendor.size as size_medium_id')
//         ->distinct()
//         ->where(['inventory_vendor.product_name' => $data->product_name])
//         ->get();

//     $data->size_medium = $data4;

//   $inv_images = DB::table('inventory_images_vendor')
//     ->select('image', 'alt', 'folder', 'dp_status')
//     ->where('item_id', $data->id)
//     ->where('del_status', 0) // Optional but typically required
//     ->where('status', 1)     // Optional for active records
//     ->get();


//     $arraydata = array('inventory' => $data, 'inv_images' => $inv_images);

//     return $this->sendResponse(1, $arraydata, 'success');
// }

    
    public function getInventoryColorClasses(Request $request): JsonResponse
    {
        $inventory = InventoryNewModel::where(['inventory_new.product_name'=>$request->product_name, 'inventory_new.size'=>$request->size_medium_id])->first();
        if(!empty($inventory->color))
        {
            $data= DB::table('inventory_new')
            ->leftjoin('master_colour', 'master_colour.id', '=', 'inventory_new.color')
            ->select('inventory_new.id as inventory_id', 'inventory_new.color as color_class_id', 'master_colour.title as color_class_title')
            ->where(['inventory_new.product_name'=>$request->product_name, 'inventory_new.size'=>$request->size_medium_id])
            ->get();
        }
        
        if(!empty($inventory->class))
        {
            $data= DB::table('inventory_new')
            ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
            ->select('inventory_new.id as inventory_id', 'inventory_new.class as color_class_id', 'master_classes.title as color_class_title')
            ->where(['inventory_new.product_name'=>$request->product_name, 'inventory_new.size'=>$request->size_medium_id])
            ->get();
        }
        
         
        return $this->sendResponse(1, $data, 'success');
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
    
    //getVendors
    public function getVendors(Request $request): JsonResponse
    {
        $vendors = VendorModel::where(['del_status' => 0, 'status' => 1])->get();
        return $this->sendResponse(1, $vendors, 'success');
        
    }
    
    public function homeInventorynew(Request $request): JsonResponse
    {
    $newarray = [];  
    
    $where1 = ['del_status' => 0, 'status' => 1];
    $cat_one = CatOne::where($where1)->get();
    
    $main_categories = []; 
    
    $where = ['master_category.del_status' => 0, 'master_category.status' => 1];
    $maincategories = DB::table('master_category')
        ->select('master_category.id', 'master_category.name')
        ->where($where)
        ->orderBy('master_category.id', 'asc')
        ->get();
    
    foreach ($maincategories as $main) {
        $printed_categories = []; 
        $where = ['inventory_cat.del_status' => 0, 'inventory_cat.status' => 1, 'inventory_cat.cat_one' =>  $main->id];
        $subcategory = DB::table('inventory_cat')
            ->select('inventory_cat.cat_one', 'inventory_cat.cat_four')
            ->where($where)
            ->get();
    
        foreach ($subcategory as $stcat) {
            if (!in_array($stcat->cat_four, $printed_categories)) {
                $printed_categories[] = $stcat->cat_four;  // Avoid duplicates.
            }
        }
    
        $categoryProducts = [];  
        $where = ['inventory_new.del_status' => 0, 'inventory_new.status' => 1];
    
     
        $totalFetched = 0;
    
        // foreach ($printed_categories as $item2) {
          
        //     if ($totalFetched >= 20) {
        //         break;
        //     }
    
            $where = ['inventory_new.del_status' => 0, 'inventory_new.status' => 1];
            $data = DB::table('inventory_new')
                    ->select('inventory_new.cat_id as last_cat_id', 'inventory_new.product_name', 'inventory_new.description', 
                             'inventory_new.mrp', 'inventory_new.id', 'inventory_new.product_id', 
                             'inventory_new.shipping_charges', 'inventory_new.discounted_price', 'inventory_new.vendor_id')
                    ->where($where)
                    ->whereIn('inventory_new.cat_id', $printed_categories)
                    ->limit(20)  
                    ->orderBy('inventory_new.id', 'desc')
                    ->get();
    
            // if($main->id != 17){
            //     $data = DB::table('inventory_new')
            //         ->select('inventory_new.cat_id as last_cat_id', 'inventory_new.product_name', 'inventory_new.description', 
            //                  'inventory_new.mrp', 'inventory_new.id', 'inventory_new.product_id', 
            //                  'inventory_new.shipping_charges', 'inventory_new.discounted_price', 'inventory_new.vendor_id', 'inventory_new.hsncode' )
            //         ->where($where)
            //         ->where('inventory_new.cat_id', $item2)
            //         ->limit(20 - $totalFetched) 
            //         ->orderBy('inventory_new.id', 'desc')
            //         ->get();
            // } else {
            //     $data = DB::table('inventory_new')
            //         ->select('inventory_new.cat_id as last_cat_id', 'inventory_new.product_name', 'inventory_new.description', 
            //                  'inventory_new.mrp', 'inventory_new.id', 'inventory_new.product_id', 
            //                  'inventory_new.shipping_charges', 'inventory_new.discounted_price', 'inventory_new.vendor_id')
            //         ->where($where)
            //         ->where('hsncode',4901)
            //         // ->limit(20 - $totalFetched)  
            //         ->orderBy('inventory_new.id', 'desc')
            //         ->get();
            // }
    
            foreach ($data as $res) {
                $where2 = ['item_id' => $res->id, 'dp_status' => 1];
                $inv_images = InventoryImgModel::where($where2)->first();
                $where = ['review.product_id'=>$res->product_id, 'review.status'=>1];


                $reviews= DB::table('review')
                ->leftjoin('users', 'users.unique_id', '=', 'review.user_id')
                ->select('users.name as user_name', 'review.review_comment', 'review.rating', 'review.image')
                ->where($where)
                ->get();
                if ($inv_images) {
                    $image = $inv_images->image;
                    $alt = $inv_images->alt;
                    $folder = $inv_images->folder;
                } else {
                    $image = 'books.jpg';
                    $alt = '';
                    $folder = 'inventory';
                }
    
                $cartData = CartModel::select('id', 'product_id')->where(['item_type' => 0, 'user_id' => $request->user_id, 'product_id' => $res->id, 'del_status' => 0])->first();
                $wishlistData = WishlistModel::select('id', 'product_id')->where(['user_id' => $request->user_id, 'product_id' => $res->id, 'del_status' => 0])->first();
                
                $itemExistInCart = $cartData ? true : false;
                $itemExistInWishlist = $wishlistData ? true : false;
    
                $productDetails = [
                    'last_cat_id' => $res->last_cat_id,
                    'id' => $res->id,
                    'product_id' => $res->product_id,
                    'product_name' => $res->product_name,
                    'discounted_price' => $res->discounted_price, 
                    'mrp' => $res->mrp,
                    'image' => $image,
                    'reviews'=>$reviews,
                    'alt' => $alt,
                    'folder' => $folder,
                    'vendor_id' => $res->vendor_id,
                    'description' => $res->description,
                    'shipping_charges' => $res->shipping_charges, 
                    'itemExistInCart' => $itemExistInCart,
                    'itemExistInWishlist' => $itemExistInWishlist,
                ];
    
           
                array_push($categoryProducts, $productDetails);
    
           
                $totalFetched++;
    
              
                if ($totalFetched >= 20) {
                    break;
                }
            }
    
       
        //     if ($totalFetched >= 20) {
        //         break;
        //     }
        // }
    
   
        $newarray[] = [
            'id' => $main->id,
            'name' => $main->name,
            'products' => $categoryProducts
        ];
    

        // if ($totalFetched >= 20) {
        //     break;
        // }
    }
    
 
    if (empty($newarray)) {
        return $this->sendResponse(0, $res1, 'No data found');
    }
    
 
    return $this->sendResponse(1, $newarray, 'Success');
}


// facebook_share
    public function facebook_share(Request $request): JsonResponse
    {
        
    }


// whatsapp_share
 public function whatsapp_share(Request $request): JsonResponse
    {
        
    }
}