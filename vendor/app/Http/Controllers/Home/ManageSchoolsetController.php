<?php



namespace App\Http\Controllers\Home;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Home;



use App\Models\managemasterclassModel;
use App\Models\managemasterboardModel;
use App\Models\managemasterorganisationModel;
use App\Models\ManageuserSchoolModel;
use App\Models\managemastergradeModel;
use App\Models\managemastersettypeModel;
use App\Models\managemastersetcatModel;
use App\Models\InventoryModel;
use App\Models\SchoolSetModel;
use App\Models\SchoolSetVendorModel;
use App\Models\CartModel;

use App\Models\PickupPoint\PickupPoint;



use File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Models\aws_img_url_model;
use Illuminate\Support\Facades\Storage;

class ManageSchoolsetController extends Controller

{
    
    
 public function aws_img_url()
  {
      $data = aws_img_url_model::where('id',1)->first();
      return $data->url;
     
  }



    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }
    

    
    public	function createRandomKey() {
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			srand((double)microtime()*1000000);
			$i = 0;
			$key = '' ;
		 
			while ($i <= 15) {
				$num = rand() % 33;
				$tmp = substr($chars, $num, 1);
				$key = $key . $tmp;
				$i++;
			}
		 
			return $key;
		}




// schoolset
public function schoolset(Request $request)
{ 
      $data= PickupPoint::orderBy('id', 'DESC')->where(['status'=>1,'del_status'=>0])->get();
      return view('schoolset',['pickuppoints'=>$data]);
      
}


// getsetdata
public function get_set_data_by_id(Request $request)
{ 
        $vendor_set_data= SchoolSetVendorModel::where(['set_id'=>$request->set_id,'vendor_id'=>session('id'),'del_status'=>0])->first();
        $item_weight=0;
        if($vendor_set_data)
        {
            $set_data= SchoolSetModel::where(['set_id'=>$request->set_id])->first();
            $array=array('set_id'=>$set_data->id);
            
            
            $result=[];
            $array2=[];
            $itemarray=explode(',',$vendor_set_data->item_id);
            $itemarrayqty=explode(',',$vendor_set_data->item_qty);
            $itemadiscount=explode(',',$vendor_set_data->item_discount);
            
            $count=count($itemarray);
            for($i=0;$i<$count;$i++)
            {
                  $itemdata= InventoryModel::where(['id'=>$itemarray[$i]])->first();
                  $array2=['img'=>"<img style='height:50px;weight:50px;'  src=".Storage::disk('s3')->url($itemdata->folder.'/'.$itemdata->cover_photo)." >",'itemname'=>$itemdata->itemname,'unit_price'=>$itemdata->unit_price,'itemcode'=>$itemdata->itemcode,'qty'=>$itemarrayqty[$i],'cover_photo'=>$itemdata->cover_photo,'discount'=>$itemadiscount[$i]];
                  array_push($result,$array2);
                  
                  $item_weight+=$itemdata->item_weight;
                
            }
              
             $setdetail= DB::table('school_set')
            ->leftJoin('school', 'school.id', '=', 'school_set.school_id')
            ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set.set_class')
            ->leftJoin('master_set_cat', 'master_set_cat.id', '=', 'school_set.set_category')
            ->leftJoin('master_set_type', 'master_set_type.id', '=', 'school_set.set_type')
            ->leftJoin('master_board', 'master_board.id', '=', 'school_set.board')
            ->leftJoin('master_orgnisation', 'master_orgnisation.id', '=', 'school_set.org')
            ->leftJoin('master_grade', 'master_grade.id', '=', 'school_set.grade')
            ->select('school.school_name','school.school_code','school_set.school_id','school_set.set_id','master_classes.title as setclass','master_classes.id as setclass_id','master_set_cat.title as cat_title','master_set_cat.id as cat_title_id','master_set_type.title as type_title','master_set_type.id as type_title_id','master_board.title as board','master_board.id as board_id','master_orgnisation.name as org_title','master_orgnisation.id as org_title_id','master_grade.title as grade','master_grade.id as grade_id')->where('school_set.id',$set_data->id)->first();
    
            $set_exist=1;
          
        }
        else
        {
            
            
            $set_data= SchoolSetModel::where(['set_id'=>$request->set_id])->first();

            $result=[];
            $array2=[];
            $itemarray=explode(',',$set_data->item_id);
            $itemarrayqty=explode(',',$set_data->item_qty);
            $count=count($itemarray);
            for($i=0;$i<$count;$i++)
            {
                  $itemdata= InventoryModel::where(['id'=>$itemarray[$i]])->first();
                  $array2=['img'=>"<img style='height:50px;weight:50px;'  src=".Storage::disk('s3')->url($itemdata->folder.'/'.$itemdata->cover_photo)."><input type='hidden' value='".$itemdata->id."' name='item_id[]'>",'itemname'=>$itemdata->itemname,'unit_price'=>$itemdata->unit_price,'itemcode'=>$itemdata->itemcode,'qty'=>'<input type="hidden" value="'.$itemarrayqty[$i].'" name="qty[]">'.$itemarrayqty[$i],'cover_photo'=>$itemdata->cover_photo,'discount'=>"<input type='number' value='0' min='0' required class='form-control' name='discount[]'>"];
                  array_push($result,$array2);
                  $item_weight+=$itemdata->item_weight;
                
            }
              
             $setdetail= DB::table('school_set')
            ->leftJoin('school', 'school.id', '=', 'school_set.school_id')
            ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set.set_class')
            ->leftJoin('master_set_cat', 'master_set_cat.id', '=', 'school_set.set_category')
            ->leftJoin('master_set_type', 'master_set_type.id', '=', 'school_set.set_type')
            ->leftJoin('master_board', 'master_board.id', '=', 'school_set.board')
            ->leftJoin('master_orgnisation', 'master_orgnisation.id', '=', 'school_set.org')
            ->leftJoin('master_grade', 'master_grade.id', '=', 'school_set.grade')
            ->select('school.school_name','school.school_code','school_set.school_id','school_set.set_id','master_classes.title as setclass','master_classes.id as setclass_id','master_set_cat.title as cat_title','master_set_cat.id as cat_title_id','master_set_type.title as type_title','master_set_type.id as type_title_id','master_board.title as board','master_board.id as board_id','master_orgnisation.name as org_title','master_orgnisation.id as org_title_id','master_grade.title as grade','master_grade.id as grade_id')->where('school_set.id',$set_data->id)->first();
             
            $set_exist=0;
        }
    
    
    
           $this->output(array("isSetExist"=>$set_exist,'item_weight'=>$item_weight,"setdetail"=>$setdetail,"items"=>$result));

      
}




public function add_vendor_set(Request $request)
{
      
      $item_id=implode(',',$request->item_id);
      $discount=implode(',',$request->discount);
      $qty=implode(',',$request->qty);
      
      $getpickup_pointset= SchoolSetVendorModel::select('pickup_point')->where(['vendor_id'=>session('id'),'school_id'=>$request->school_id])->orderBy('id','asc')->first();
      if($getpickup_pointset)
      {
          $pickup_point=$getpickup_pointset->pickup_point;
      }
      else
      {
          $pickup_point=NULL;
      }
     
        $setdata = array(
              'school_id'=>$request->school_id,	
              'vendor_id'=>session('id'),
              'item_id'=>$item_id,
              'item_discount'=>$discount,
              'item_qty'=>$qty,
              'set_id'=>$request->set_id,
              'org'=>$request->org_title_id,	
              'board'=>	$request->board_id,
              'grade'=>$request->grade_id,	
              'set_class'=>$request->setclass_id,	
              'set_category'=>$request->cat_title_id,	
              'set_type'=>$request->type_title_id,	
              'shipping_charges'=>$request->shipping_charges,
              'shipping_chr_type'=>$request->shipping_chr_type,
              'pickup_point'=>$pickup_point,
              'created_at'	=>date('Y-m-d H:i:s')
        );
        
      $setitemres = SchoolSetVendorModel::create($setdata);
      if ($setitemres) {
          
        $updatesetdata= SchoolSetModel::where(['set_id'=>$request->set_id])->first();
        if($updatesetdata->vendor_id==NULL)
        {
           $vendor_id= session('id');
        }
        else
        {
           $vendor_id= $updatesetdata->vendor_id.",".session('id');
        }
        
        $upsetdData = array( 'vendor_status' => 3,'vendor_id' => $vendor_id);
        $resset= $updatesetdata->update($upsetdData);
        if($resset)
        {
          return redirect()->back()->with('success', 'Set Added successfully .');
        }
        else
        {
             return redirect('manageCategory')->withErrors(['' => 'Somthing went wrong!']);
        }
      
          
      return redirect()->back()->with('success', 'Set Added successfully .');
      }
      else
      {
        return redirect('manageCategory')->withErrors(['' => 'Somthing went wrong!']);
      }
      
}


//update_add_pickup_point
public function update_add_pickup_point(Request $request)
{
        if($request->pickup_point==0){$pickup_point=NULL;}else{$pickup_point=implode(',', $request->pickup_point);}
   
        $updatesetdata= SchoolSetVendorModel::where(['school_id'=>$request->school_id,'vendor_id'=>session('id')]);
        $resetpp= $updatesetdata->update(['pickup_point'=>$pickup_point]);
        if($resetpp)
        {
          $result['success']=1;  
          $result['msg']='Pickup Point Updated Successfully!';  
        
        }
        else
        {
           $result['success']=0;  
           $result['msg']='Somthing went wrong!';   
        }
        
       $this->output($result);
        
       
}




//view_school_wise_set
 public function view_school_wise_set(Request $request)
    {
         $setdetail= DB::table('school_set_vendor')
        ->leftJoin('school', 'school.id', '=', 'school_set_vendor.school_id')
        ->leftJoin('pickup_points', 'pickup_points.id', '=', 'school_set_vendor.pickup_point')
        ->select('pickup_points.name as pickup_name','school_set_vendor.pickup_point','school.id','school.school_name','school.state','school.distt','school.city','school.tehsil','school.village','school.post_office','school.zipcode','school.school_code')
        ->where(['school_set_vendor.vendor_id'=>session('id'),'school.status'=>1,'school.del_status'=>0])
        ->groupBy('school_set_vendor.school_id')
        ->orderBy('school_set_vendor.id','desc')
        ->get();
      $ppdata= PickupPoint::orderBy('id', 'DESC')->where(['status'=>1,'del_status'=>0])->get();
      return view('school_wise_set',['all_set'=>$setdetail,'pp_data'=>$ppdata]);
    }
    
    
    
//view_vendor_school_set
    public function view_vendor_school_set(String $id)
    {
         
         $setdetail['all_set']= DB::table('school_set_vendor')
        ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set_vendor.set_class')
        ->leftJoin('master_set_cat', 'master_set_cat.id', '=', 'school_set_vendor.set_category')
        ->leftJoin('master_set_type', 'master_set_type.id', '=', 'school_set_vendor.set_type')
        ->leftJoin('master_board', 'master_board.id', '=', 'school_set_vendor.board')
        ->leftJoin('master_orgnisation', 'master_orgnisation.id', '=', 'school_set_vendor.org')
        ->leftJoin('master_grade', 'master_grade.id', '=', 'school_set_vendor.grade')
        ->leftJoin('school', 'school.id', '=', 'school_set_vendor.school_id')
        ->select('school_set_vendor.stock_status','school_set_vendor.shipping_charges','school_set_vendor.shipping_chr_type','school_set_vendor.id','school_set_vendor.set_qty','school.school_name','school.state','school.distt','school.city','school.tehsil','school.village','school.post_office','school.zipcode','school.school_code','school_set_vendor.set_id','master_classes.title as setclass','master_set_cat.title as cat_title','master_set_type.title as type_title','master_board.title as board','master_orgnisation.name as org_title','master_grade.title as grade')
        ->where(['school.id'=>$id,'school_set_vendor.vendor_id'=>session('id'),'school_set_vendor.del_status'=>0])->get();
         
          return view('school_set_vendor', $setdetail);

    }
    
    
    

public function update_vendor_set_ship(Request $request)
{
      

        $updatesetdata= SchoolSetVendorModel::where(['vendor_id'=>session('id'),'set_id'=>$request->set_id])->first();
        $upsetdData = array( 'shipping_charges' => $request->shipping_charges,'shipping_chr_type' => $request->shipping_chr_type);
        $resset= $updatesetdata->update($upsetdData);
        if($resset)
         {
          
          return redirect()->back()->with('success', 'Updated successfully .');
          }
          else
          {
            return redirect('view_all_schoolset')->withErrors(['' => 'Somthing went wrong!']);
          }
      
}
    
	
	//get_set_item

   public function get_set_item(Request $request)
    {

	   
        $data= SchoolSetVendorModel::where(['set_id'=>$request->set_id,"del_status"=>0])->first();
        $result=[];
        $array2=[];
        $itemarray=explode(',',$data->item_id);
        $itemarrayqty=explode(',',$data->item_qty);
        $item_discount=explode(',',$data->item_discount);
        
        $count=count($itemarray);
        for($i=0;$i<$count;$i++)
        {
              $itemdata= InventoryModel::where(['id'=>$itemarray[$i]])->first();
              $array2=['img'=>"<img style='height:50px;weight:50px;'  src=".Storage::disk('s3')->url($itemdata->folder.'/'.$itemdata->cover_photo).">",'itemname'=>$itemdata->itemname,'unit_price'=>$itemdata->unit_price,'itemcode'=>$itemdata->itemcode,'qty'=>$itemarrayqty[$i],'cover_photo'=>$itemdata->cover_photo,'discount'=>$item_discount[$i]];
              array_push($result,$array2);
            
        }
          
       
           $this->output($result);
	
    }
    
    
    //delete_vendor_set
    public function delete_vendor_set(Request $request)
    {

	    $setVendor=SchoolSetVendorModel::where(['id'=>$request->id,'set_id'=>$request->set_id,'vendor_id'=>session('id')])->first();
	    CartModel::where(['set_id'=>$setVendor->set_id,'vendor_id'=>session('id')])->delete();
        $deleted=$setVendor->delete();
        
        if($deleted)
        
          {
              return redirect()->back()->with('success', 'Set Deleted successfully .');
          }
          else
          {
            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
          }
       
	
    }
    
    
public function update_stock_status(Request $request)
{
    
        $result=array();
        $updatesetdata= SchoolSetVendorModel::where(['vendor_id'=>session('id'),'set_id'=>$request->set_id,'id'=>$request->id])->first();
        $resset= $updatesetdata->update(['stock_status'=>$request->status]);
        if($resset)
        {
          $result['success']=1;  
          $result['msg']='Set Stock Status Updated successfully.';  
        
        }
        else
        {
           $result['success']=0;  
           $result['msg']='Somthing went wrong!';   
        }
        
       $this->output($result);
      
}
  

}
