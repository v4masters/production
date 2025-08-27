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
use App\Models\API\ReviewModel;


use App\Models\API\Paytm;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Storage;
   
   
class ReviewController extends BaseController
{
    
    
  public function upload_image($file,$folder)
  {
      
    $image_name = date('YmdHis').'-'.time()."-".rand(10,100).'.'.$file->getClientOriginalExtension();
    $filePath = $folder.$image_name;
    $res=Storage::disk('s3')->put($filePath, file_get_contents($file));
    if($res)
    {
        return $image_name;
    }
    else
    {
        return false;
    }
   
    }
    
    
    
   //addReview
    public function addReview(Request $request)
    {
        
              if($request->file('review_image')) {
                  $reviewimage=$this->upload_image($request->file('review_image'),'review/'); 
                } 
                else {
                    $reviewimage = "";
                }
              
        $data = [	
            'product_id'=>$request->product_id,
            'user_id'=>$request->user_id,
            'vendor_id'=>$request->vendor_id,
            'item_type'=>$request->item_type,
            'rating'=>$request->rating,
            'review_comment'=>$request->review_comment,
            'image'=>$reviewimage,
            'on_date'=>$request->on_date,
            'status'=>2,
        ];
        
        $review = ReviewModel::create($data);
        if($review){
            $response = ['success' => 1,'message' => 'successfull','data' => $data,];
            return response()->json($response, 200);
        } else {
            $response = ['success' => 0,'message' => 'Something Went Wrong','data' => null,];
            return response()->json($response, 200);
        }
    }
    
    public function getProductReviews(Request $request)
    {
        
        // $data= DB::table('order_tracking')
        // ->leftjoin('inventory', 'order_tracking.item_id', '=', 'inventory.id') 
        // ->leftjoin('master_classes', 'master_classes.id', '=', 'inventory.class')
        // ->leftjoin('vendor', 'order_tracking.vendor_id', '=', 'vendor.unique_id')
        // ->select('order_tracking.qty','vendor.username as vendor_name','order_tracking.item_type','order_tracking.vendor_id','master_classes.title as class_title','inventory.cover_photo as image','inventory.itemname as product_name','inventory.discount','inventory.unit_price', 'inventory.description','inventory.id')
        // ->where(['order_tracking.invoice_number'=>$invoice_number,'order_tracking.item_type'=>1,'inventory.id'=>$all_items[$i]->item_id])
        // ->first(); 
        
        // $reviews = ReviewModel::where($where)->get();
        
        $where = ['review.product_id'=>$request->product_id, 'review.status'=>1];


        $reviews= DB::table('review')
        ->leftjoin('users', 'users.unique_id', '=', 'review.user_id')
        ->select('users.name as user_name', 'review.review_comment', 'review.rating', 'review.image')
        ->where($where)
        ->get();
        
        
        $response = ['success' => 1,'message' => 'successfull'.$request->product_id,'data' =>$reviews,];
        return response()->json($response, 200);
    }
}












