<?php
   
namespace App\Http\Controllers\API;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\API;
use Illuminate\Http\JsonResponse;
   

use App\Models\API\SchoolModel;
use App\Models\API\CartModel;
use App\Models\API\SchoolSetVendorModel;
use App\Models\API\managemasterclassModel;
use App\Models\API\managemasterboardModel;
use App\Models\API\managemasterorganisationModel;
use App\Models\API\managemastergradeModel;
use App\Models\API\managemastersettypeModel;
use App\Models\API\managemastersetcatModel;
use App\Models\API\InventoryModel;
use File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;





class SchoolSetController extends BaseController
{
    
    // -------------------------------My School Information-----------------------------//
    
    //getSchoolSet
   /* public function getSchoolSet(Request $request): JsonResponse
    {
        $cat_id=$request->cat_id;
        $class_id= $request->class_id;
        $result=[];
        $array2=[];
        $school_data=SchoolModel::where(['school_code'=>$request->school_code,'del_status'=>0])->first(); 
        
        
        
        if(!(empty($class_id) && empty($cat_id)))
        {
            $where = ['master_classes.id'=>$class_id,'master_set_cat.id'=>$cat_id,'school_set_vendor.school_id'=>$school_data->id,'school_set_vendor.del_status'=>0,'school_set_vendor.status'=>1];
        }
        else 
        {
            $where = ['school_set_vendor.school_id'=>$school_data->id,'school_set_vendor.del_status'=>0,'school_set_vendor.status'=>1];
        }
        
        $setdetail= DB::table('school_set_vendor')
        ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set_vendor.set_class')
        ->leftJoin('master_set_cat', 'master_set_cat.id', '=', 'school_set_vendor.set_category')
        ->leftJoin('master_set_type', 'master_set_type.id', '=', 'school_set_vendor.set_type')
        ->leftJoin('master_board', 'master_board.id', '=', 'school_set_vendor.board')
        ->leftJoin('master_orgnisation', 'master_orgnisation.id', '=', 'school_set_vendor.org')
        ->leftJoin('master_grade', 'master_grade.id', '=', 'school_set_vendor.grade')
        ->leftJoin('vendor', 'vendor.unique_id', '=', 'school_set_vendor.vendor_id')
        ->select('school_set_vendor.stock_status','school_set_vendor.id','school_set_vendor.set_id','school_set_vendor.vendor_id','vendor.username as vendor','school_set_vendor.item_id','school_set_vendor.item_discount','school_set_vendor.item_qty','master_classes.title as setclass','master_set_cat.title as cat_title','master_set_type.title as type_title','master_board.title as board','master_orgnisation.name as org_title','master_grade.title as grade')
        ->where($where)->get();
         
        
        for($i=0;$i<count($setdetail);$i++)
        {
            $item_id=explode(',',$setdetail[$i]->item_id);
            $item_qty=explode(',',$setdetail[$i]->item_qty);
            $item_discount=explode(',',$setdetail[$i]->item_discount);
             
            $count=count($item_id);
            $set_qty=0;
            $set_price=0;
            $discount=0;
            $total_dis=0;
            $itemprice=0;
            $set_dis_price=0;
            $array3=[];
            $setitem=[];
            
            for($j=0;$j<$count;$j++)
            {
                  $itemdata= InventoryModel::where(['id'=>$item_id[$j]])->first();
                  $classitem= managemasterclassModel::where(['id'=>$itemdata->class])->first();
                  
                  
                  $itemprice=$itemdata->unit_price*$item_qty[$j];
                  $discount=$itemprice*$item_discount[$j]/100;
                  
                  $set_qty+=$item_qty[$j];
                  $set_price+=$itemprice;
                  $set_dis_price+=$itemprice-$discount;
                  $total_dis+=$discount;
                  
                  
                  $setitem['img']=$itemdata->folder."/".$itemdata->cover_photo;
                  $setitem['itemname']=$itemdata->itemname;
                  $setitem['classno']=$classitem->title;
                  $setitem['price']=$itemprice;
                  $setitem['new_price']=$itemprice-$discount;
                  $setitem['discount']=$discount;
                  $setitem['company_name']=$itemdata->company_name;
                  $setitem['qty']=$item_qty[$j];
                    
                  array_push($array3,$setitem);
                  
            } 
        
        
            $set_price_final=round($set_price);
            $set_dis_price_final=round($set_dis_price);
              
            $array2=['id'=>$setdetail[$i]->id,'stock_status'=>$setdetail[$i]->stock_status,'set_id'=>$setdetail[$i]->set_id,'vendor_id'=>$setdetail[$i]->vendor_id,'set_qty'=>$set_qty,'vendor'=>$setdetail[$i]->vendor,'setclass'=>$setdetail[$i]->setclass,'cat_title'=>$setdetail[$i]->cat_title,'type_title'=>$setdetail[$i]->type_title,'board'=>$setdetail[$i]->board,'org_title'=>$setdetail[$i]->org_title,'grade'=>$setdetail[$i]->grade,'set_price'=>$set_price_final,'total_discount'=>$total_dis,'discounted_price'=>$set_dis_price_final];
            
            
            $array2['set_items']= $array3;
            array_push($result,$array2);  
            
        }
        
        return $this->sendResponse(1, $result, '');
    }*/
    public function getSchoolSet(Request $request): JsonResponse
{
    $cat_id = $request->cat_id;
    $class_id = $request->class_id;
    $school_code = $request->school_code;
    $result = [];

    $school_id = null;

    if (!empty($school_code)) {
        $school_data = SchoolModel::where([
            'school_code' => $school_code,
            'del_status' => 0
        ])->first();

        if (!$school_data) {
            return $this->sendResponse(0, null, 'Invalid school code.');
        }

        $school_id = $school_data->id;
    }

    // Base WHERE conditions
    $where = [
        'school_set_vendor.del_status' => 0,
        'school_set_vendor.status' => 1,
    ];

    if ($school_id) {
        $where['school_set_vendor.school_id'] = $school_id;
    }

    if (!empty($class_id)) {
        $where['master_classes.id'] = $class_id;
    }

    if (!empty($cat_id)) {
        $where['master_set_cat.id'] = $cat_id;
    }

    // Query
    $setdetail = DB::table('school_set_vendor')
        ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set_vendor.set_class')
        ->leftJoin('master_set_cat', 'master_set_cat.id', '=', 'school_set_vendor.set_category')
        ->leftJoin('master_set_type', 'master_set_type.id', '=', 'school_set_vendor.set_type')
        ->leftJoin('master_board', 'master_board.id', '=', 'school_set_vendor.board')
        ->leftJoin('master_orgnisation', 'master_orgnisation.id', '=', 'school_set_vendor.org')
        ->leftJoin('master_grade', 'master_grade.id', '=', 'school_set_vendor.grade')
        ->leftJoin('vendor', 'vendor.unique_id', '=', 'school_set_vendor.vendor_id')
        ->select(
            'school_set_vendor.stock_status', 'school_set_vendor.id', 'school_set_vendor.set_id',
            'school_set_vendor.vendor_id', 'vendor.username as vendor',
            'school_set_vendor.item_id', 'school_set_vendor.item_discount', 'school_set_vendor.item_qty',
            'master_classes.title as setclass', 'master_set_cat.title as cat_title',
            'master_set_type.title as type_title', 'master_board.title as board',
            'master_orgnisation.name as org_title', 'master_grade.title as grade'
        )
        ->where($where)
        ->get();

    foreach ($setdetail as $set) {
        $item_ids = explode(',', $set->item_id);
        $item_qtys = explode(',', $set->item_qty);
        $item_discounts = explode(',', $set->item_discount);

        $count = count($item_ids);
        $set_qty = 0;
        $set_price = 0;
        $total_dis = 0;
        $set_dis_price = 0;
        $items = [];

        for ($i = 0; $i < $count; $i++) {
            $item = InventoryModel::find($item_ids[$i]);
            $qty = $item_qtys[$i] ?? 0;
            $discountPercent = $item_discounts[$i] ?? 0;

            if (!$item) continue;

            $price = $item->unit_price * $qty;
            $discount = $price * $discountPercent / 100;

            $classitem = managemasterclassModel::find($item->class);

            $items[] = [
                'img' => $item->folder . '/' . $item->cover_photo,
                'itemname' => $item->itemname,
                'classno' => $classitem->title ?? '',
                'price' => $price,
                'new_price' => $price - $discount,
                'discount' => $discount,
                'company_name' => $item->company_name,
                'qty' => $qty,
            ];

            $set_qty += $qty;
            $set_price += $price;
            $total_dis += $discount;
            $set_dis_price += $price - $discount;
        }

        $result[] = [
            'id' => $set->id,
            'stock_status' => $set->stock_status,
            'set_id' => $set->set_id,
            'vendor_id' => $set->vendor_id,
            'set_qty' => $set_qty,
            'vendor' => $set->vendor,
            'setclass' => $set->setclass,
            'cat_title' => $set->cat_title,
            'type_title' => $set->type_title,
            'board' => $set->board,
            'org_title' => $set->org_title,
            'grade' => $set->grade,
            'set_price' => round($set_price),
            'total_discount' => round($total_dis),
            'discounted_price' => round($set_dis_price),
            'set_items' => $items
        ];
    }

    return $this->sendResponse(1, $result, 'Set list fetched successfully.');
}
    
    //Add Set To Cart
    /*public function addSetToCart(Request $request): JsonResponse
    {
        $user_id=$request->user_id;
        $session_type=$request->session_type;
        $vendor_id=$request->vendor_id;
        $set_id=$request->set_id;
        
        if (!$set) {
    return $this->sendResponse(0, null, 'Set not found.');
}

        
        $checkset = CartModel::where(['user_id'=>$user_id, 'vendor_id'=>$vendor_id,'set_id'=>$set_id])->first();
        if($checkset)
        {
            return $this->sendResponse(0, null, 'Set Already Added to Cart');
        }
        else 
        {
            $set = SchoolSetVendorModel::where(['vendor_id'=>$vendor_id,'set_id'=>$set_id,'del_status'=>0,'status'=>1])->first();
        
            $item_id=explode(',',$set->item_id);
            $item_qty=explode(',',$set->item_qty);
            $count=count($item_id);
            
            $array = [];
            for($i=0;$i<$count;$i++)
            {
                // $inventory = DB::table('inventory')
                // ->leftJoin('size_list', 'inventory.size', '=', 'size_list.size_id')
                // ->leftJoin('sizes', 'size_list.size_id', '=', 'sizes.id')
                // ->select('sizes.title as size')
                // ->where('inventory.id',$item_id[$i])->first();
            
                $cartdata = [
                    'user_id'=>$user_id,
                    'session_type'=>$session_type,
                    'item_type'=>1,
                    'vendor_id'=>$vendor_id,
                    'set_id'=>$set_id,
                    'product_id'=>$item_id[$i],
                    // 'set_type'=>
                    // 'set_status'=>$itemdata->user_id,
                    'qty'=>$item_qty[$i],
                    // 'size'=>$inventory->size,
                ];
                 array_push($array,$cartdata);
                 
                CartModel::create($cartdata);
            } 
            
            return $this->sendResponse(1, $array, 'Set Added to Cart');
        }
    }*/
    public function addSetToCart(Request $request): JsonResponse
{
    $user_id = $request->user_id;
    $session_type = $request->session_type;
    $vendor_id = $request->vendor_id;
    $set_id = $request->set_id;

    $set = SchoolSetVendorModel::where([
        'vendor_id' => $vendor_id,
        'set_id' => $set_id,
        'del_status' => 0,
        'status' => 1
    ])->first();

    if (!$set) {
        return $this->sendResponse(0, null, 'Set not found.');
    }

    $checkset = CartModel::where([
        'user_id' => $user_id,
        'vendor_id' => $vendor_id,
        'set_id' => $set_id
    ])->first();

    if ($checkset) {
        return $this->sendResponse(0, null, 'Set Already Added to Cart');
    } else {
        $item_id = explode(',', $set->item_id);
        $item_qty = explode(',', $set->item_qty);
        $count = count($item_id);

        $array = [];
        for ($i = 0; $i < $count; $i++) {
            $cartdata = [
                'user_id' => $user_id,
                'session_type' => $session_type,
                'item_type' => 1,
                'vendor_id' => $vendor_id,
                'set_id' => $set_id,
                'product_id' => $item_id[$i],
                'qty' => $item_qty[$i],
            ];

            CartModel::create($cartdata);
            $array[] = $cartdata;
        }

        return $this->sendResponse(1, $array, 'Set Added to Cart');
    }
}

    
    //getSetCategories
    public function getSetCategories(Request $request): JsonResponse
    {
        $result=[];
        $school_data=SchoolModel::where(['school_code'=>$request->school_code,'del_status'=>0])->first(); 
         
        $data= DB::table('school_set_vendor')
        ->distinct('school_set_vendor.set_category')
        ->leftJoin('master_set_cat', 'master_set_cat.id', '=', 'school_set_vendor.set_category')
        ->select('master_set_cat.title as cat_title', 'master_set_cat.id as cat_id')
        ->where(['school_set_vendor.school_id'=>$school_data->id,'school_set_vendor.del_status'=>0,'school_set_vendor.status'=>1])->get();
        
       
        for($i=0;$i<count($data);$i++)
        {
            $cat=[];
            $cat['cat_title'] =$data[$i]->cat_title;
            $cat['cat_id'] =$data[$i]->cat_id;
         
            $classes= DB::table('school_set_vendor')
            ->distinct('school_set_vendor.set_class')
            ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set_vendor.set_class')
            ->select('master_classes.title as class_title', 'master_classes.id as class_id')
            ->where(['school_set_vendor.school_id'=>$school_data->id,'school_set_vendor.del_status'=>0,'school_set_vendor.status'=>1])->get();
        
            $classess=[];
            
            for($j=0;$j<count($classes);$j++)
            {
                $subcat=[];
                $subcat['class_title']= $classes[$j]->class_title;
                $subcat['class_id']= $classes[$j]->class_id;
                
                array_push($classess,$subcat);
            }
        
            $cat['subcats']=$classess;
            array_push($result,$cat);
                
        }
        
        return $this->sendResponse(1, $result, 'succcess');
    }
    
    
}