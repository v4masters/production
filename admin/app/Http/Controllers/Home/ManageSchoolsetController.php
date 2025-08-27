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
use App\Models\CartModel;
use App\Models\SchoolSetVendorModel;


use File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;



class ManageSchoolsetController extends Controller

{


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
		 
			while ($i <= 10) {
				$num = rand() % 33;
				$tmp = substr($chars, $num, 1);
				$key = $key . $tmp;
				$i++;
			}
		 
			return $key;
		}

      // school set
    public function manageschoolset()
    {
        $data['class'] = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $data['set_cat'] = managemastersetcatModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $data['set_type'] = managemastersettypeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $data['board'] = managemasterboardModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $data['organisation'] = managemasterorganisationModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $data['grade'] = managemastergradeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        
        
        // $where = array('school_set.del_status' => 0);
        // $data['allset']= DB::table('school_set')
        // ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set.set_class')
        // ->leftJoin('master_set_cat', 'master_set_cat.id', '=', 'school_set.set_category')
        // ->leftJoin('master_set_type', 'master_set_type.id', '=', 'school_set.set_type')
        // ->leftJoin('master_board', 'master_board.id', '=', 'school_set.board')
        // ->leftJoin('master_orgnisation', 'master_orgnisation.id', '=', 'school_set.org')
        // ->leftJoin('school', 'school.id', '=', 'school_set.school_id')
        // ->leftJoin('master_grade', 'master_grade.id', '=', 'school_set.grade')
        // ->select('school_set.set_id','school_set.id','school.school_name','school_set.school_id','master_classes.title as class','master_set_cat.title as cat','master_set_type.title as type','master_board.title as board','master_orgnisation.name as org','master_grade.title as grade')
        // ->where($where)
        // ->orderBy('school_set.id','desc')
        // ->get();
            
    
        return view('schoolset', $data);
    }

//view_all_schoolset_org
public function view_all_schoolset_org(Request $request)
{ 
        $where = array('school_set.del_status' => 0);
        $data['organisation']= DB::table('school_set')
        ->leftJoin('master_orgnisation', 'master_orgnisation.id', '=', 'school_set.org')
        ->select('master_orgnisation.name','master_orgnisation.id as org_id')
        ->distinct('school_set.org')
        ->where($where)
        ->orderBy('school_set.id','desc')
        ->get();
        
        return view('view_all_schoolset_org', $data);
 }
      
//school_set_org_wise
public function school_set_org_wise(Request $request)
{ 
        $where = array('school_set.del_status' =>0);
        $data['organisation']= DB::table('school_set')
        ->leftJoin('master_orgnisation', 'master_orgnisation.id', '=', 'school_set.org')
        ->select('master_orgnisation.name','master_orgnisation.id as org_id')
        ->distinct('school_set.org')
        ->where($where)
        ->orderBy('school_set.id','desc')
        ->get();
            
     
        return view('view_all_schoolset_org', $data);
      
      }

//set_grad_wise
public function set_grad_wise(string $id)
{ 
        $data['organisation'] = managemasterorganisationModel::where('id', $id)->first();
    
        $where = array('school_set.org'=>$id,'school_set.del_status' =>0);
        $data['grade']= DB::table('school_set')
        
        ->leftJoin('master_grade', 'master_grade.id', '=', 'school_set.grade')
        ->select('master_grade.title')
        ->groupBy('master_grade.title')
        ->where($where)
        ->get();
            
            
        $data['allclass'] = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $data['setcat'] = managemastersetcatModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $data['settype'] = managemastersettypeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $data['board'] = managemasterboardModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('view_set_grade_wise', $data);
      
}


//grade_wise_set_ved
public function grade_wise_set_ved(Request $request)
{ 
$result=array();
$array2=array();
$data=array();
$setdata=array();

$getgarde=managemastergradeModel::where('title', $request->grade)->first();
$garde=$getgarde->id;

if($request->action_status==1)
{
    
   
        $data= DB::table('school_set')
        ->select('school_set.org','school_set.board','school_set.grade','school_set.set_class','school_set.set_category','school_set.set_type','school_set.item_id','school_set.item_qty') 
        ->distinct('school_set.org','school_set.board','school_set.grade','school_set.set_class','school_set.set_category','school_set.set_type','school_set.item_id','school_set.item_qty') 
        ->where(['school_set.org'=>$request->org,'school_set.board'=>$request->board,'school_set.grade'=>$garde,'school_set.set_category'=>$request->set_cat,'school_set.set_type'=>$request->set_type,'school_set.set_class'=>$request->set_class])
        ->first();
        
        if($data)
        {
         
         
        $set_class = managemasterclassModel::where('id', $data->set_class)->first();
        $set_cat = managemastersetcatModel::where('id', $data->set_category)->first();
        $set_type = managemastersettypeModel::where('id', $data->set_type)->first();
        $board = managemasterboardModel::where('id', $data->board)->first();
        $org = managemasterorganisationModel::where('id', $data->org)->first();
        $grade = managemastergradeModel::where('id', $data->grade)->first();
        
        $setdata=array('set_class'=>$set_class->title,'set_cat'=>$set_cat->title,'set_type'=>$set_type->title,'board'=>$board->title,'org'=>$org->name,'grade'=>$grade->title);

	
	   $item_qty=explode(",",$data->item_qty);
	   $item_id=explode(",",$data->item_id);
	   
	   for($i=0;$i<count($item_id);$i++)
	   {
	       
	          $itemdata= InventoryModel::where(['id'=>$item_id[$i]])->first();
              $array2=['alt'=>$itemdata->alt,'folder'=>$itemdata->folder,'itemname'=>$itemdata->itemname,'unit_price'=>$itemdata->unit_price,'itemcode'=>$itemdata->itemcode,'qty'=>$item_qty[$i],'cover_photo'=>$itemdata->cover_photo];
              
              array_push($result,$array2);
   
	   }
	   $is_data=1;
	   return view('view_set_item_grade_wise',array("set_info"=>$setdata,'items'=>$result,'is_data'=>$is_data));

    }
    else
    {
      $is_data=0;
      return redirect()->back()->withErrors(['' => "Set Doesn't exist with selected parameter!"]);
    }



}
elseif($request->action_status==2)
{
    
     
         $data= DB::table('school_set')
        ->select('school_set.org','school_set.board','school_set.grade','school_set.set_class','school_set.set_category','school_set.set_type','school_set.item_id','school_set.item_qty') 
        ->distinct('school_set.org','school_set.board','school_set.grade','school_set.set_class','school_set.set_category','school_set.set_type','school_set.item_id','school_set.item_qty') 
        ->where(['school_set.org'=>$request->org,'school_set.board'=>$request->board,'school_set.grade'=>$garde,'school_set.set_category'=>$request->set_cat,'school_set.set_type'=>$request->set_type,'school_set.set_class'=>$request->set_class])
        ->first();
        
        if($data)
        {
            
            
            $datalist['class'] = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
            $datalist['set_cat'] = managemastersetcatModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
            $datalist['set_type'] = managemastersettypeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
            $datalist['board'] = managemasterboardModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
            $datalist['organisation'] = managemasterorganisationModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
            $datalist['grade'] = managemastergradeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
           
            $datalist['old_info']=array('org'=>$data->org,'board'=>$data->board,'grade'=>$data->grade,'set_class'=>$data->set_class,'set_cat'=>$data->set_category,'set_type'=>$data->set_type);
            
             
    	    $item_qty=explode(",",$data->item_qty);
    	    $item_id=explode(",",$data->item_id);
	   
	   for($i=0;$i<count($item_id);$i++)
	   {
	       
	          $itemdata= InventoryModel::where(['id'=>$item_id[$i]])->first();
              $array2=["item_id"=>$item_id[$i],'alt'=>$itemdata->alt,'folder'=>$itemdata->folder,'itemname'=>$itemdata->itemname,'unit_price'=>$itemdata->unit_price,'itemcode'=>$itemdata->itemcode,'qty'=>$item_qty[$i],'cover_photo'=>$itemdata->cover_photo];
              
              array_push($result,$array2);
   
	   }
	   
	   $datalist['item_array']=$result;
	   $datalist['is_data']=1;
	   return view('view_set_item_grade_wise_edit',$datalist);

	   
    }
    else
    {
        $datalist['is_data']=0;
        return redirect()->back()->withErrors(['' => "Set Doesn't exist with selected parameter!"]);
    }




}
elseif($request->action_status==3)
{
  
     

        $set=SchoolSetModel::where(['org'=>$request->org,'board'=>$request->board,'grade'=>$garde,'set_category'=>$request->set_cat,'set_type'=>$request->set_type,'set_class'=>$request->set_class])->get();
        if(count($set)>0)
        {
        for($i=0;$i<count($set);$i++)
        {
           $vendorset=SchoolSetVendorModel::where(['set_id'=>$set[$i]->set_id])->get();
           $vendorset->delete();
           
           CartModel::where('set_id',$set[$i]->set_id)->delete();
        }
         
        $deleted=$set->delete();
        if($deleted)
          {
              return redirect()->back()->with('success', 'Set Deleted successfully .');
          }
          else
          {
            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
          }
        }
        else
        {
             return redirect()->back()->withErrors(['' => "Set Doesn't exist with selected parameter!"]);
        }
}
else
{
    return redirect()->withErrors(['' => 'Somthing went wrong!']); 
}




}



//school_org_wise
public function school_org_wise(string $id)
{ 
        $where = array('school.organisation' => $id,'school.del_status'=>0);
        $data['school']= DB::table('school')
        ->select('school.*')
        ->where($where)
        ->orderBy('school.id','desc')
        ->get();
         
         
        $data['organisation'] = managemasterorganisationModel::where('id', $id)->first();
        return view('view_all_school_org', $data);
      
      }



//view_all_schoolset
  public function view_all_schoolset(string $oid,string $id)
    { 
           $where = array('school_set.school_id'=>$id,'school_set.del_status' => 0);
    
        $data['allset']= DB::table('school_set')
        ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set.set_class')
        ->leftJoin('master_set_cat', 'master_set_cat.id', '=', 'school_set.set_category')
        ->leftJoin('master_set_type', 'master_set_type.id', '=', 'school_set.set_type')
        ->leftJoin('master_board', 'master_board.id', '=', 'school_set.board')
        ->leftJoin('master_orgnisation', 'master_orgnisation.id', '=', 'school_set.org')
        ->leftJoin('master_grade', 'master_grade.id', '=', 'school_set.grade')
        ->leftJoin('school', 'school.id', '=', 'school_set.school_id')
        ->select('school_set.id','school_set.set_id','school_set.status','school_set.market_place_fee','school_set.id','school.school_name','school.school_code','school_set.school_id','master_classes.title as class','master_set_cat.title as cat','master_set_type.title as type','master_board.title as board','master_orgnisation.name as org','master_grade.title as grade')
        ->where($where)
        ->orderBy('school_set.id','desc')
        ->get();
            
        $data['organisation'] = managemasterorganisationModel::where('id', $oid)->first();
        $data['school'] = DB::table('school')->select('school.school_name','school.id')->where('id',$id)->first();
        return view('schoolsetview', $data);
      
        
       
    }
    
    //delete_school_set
    
public function delete_school_set(Request $request)
  {

    $data = SchoolSetModel::where('id', Request('id'))->first();
    CartModel::where('set_id',$data->set_id)->delete();
    
    $res=$data->delete();
         
    if ($res) {
      return redirect()->back()->with('success', 'Set Deleted successfully.');
    } else {

      return redirect()->withErrors(['' => 'Somthing went wrong!']);
    }
  }
    

//get_schoolset_item
  public function get_schoolset_item(string $oid,string $sid,string $set_id)
    { 
        $array=array('id'=>$set_id);
        $data= SchoolSetModel::where($array)->first();
        $result=[];
        $array2=[];
        $itemarray=explode(',',$data->item_id);
        $itemarrayqty=explode(',',$data->item_qty);
        $count=count($itemarray);
        for($i=0;$i<$count;$i++)
        {
              $itemdata= InventoryModel::where(['id'=>$itemarray[$i]])->first();
              
              $array2=['itemname'=>$itemdata->itemname,'unit_price'=>$itemdata->unit_price,'itemcode'=>$itemdata->itemcode,'qty'=>$itemarrayqty[$i],'cover_photo'=>$itemdata->cover_photo];
              
              array_push($result,$array2);
            
        }
        
         $organisation= managemasterorganisationModel::where('id', $oid)->first();
         
         $school= DB::table('school_set')
        ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set.set_class')
        ->leftJoin('master_set_cat', 'master_set_cat.id', '=', 'school_set.set_category')
        // ->leftJoin('master_set_type', 'master_set_type.id', '=', 'school_set.set_type')
        // ->leftJoin('master_board', 'master_board.id', '=', 'school_set.board')
        // ->leftJoin('master_orgnisation', 'master_orgnisation.id', '=', 'school_set.org')
        // ->leftJoin('master_grade', 'master_grade.id', '=', 'school_set.grade')
        ->leftJoin('school', 'school.id', '=', 'school_set.school_id')
        ->select('school_set.set_id','school.school_name','master_classes.title as setclass','master_set_cat.title as cat_title')->where('school_set.id',$set_id)->first();
       
       
          return view('school_set_item_view', array("organisation"=>$organisation,"school"=>$school,"items"=>$result));
        
       
    }


//get_school_list
   public function get_school_list(Request $request)
    {
        $array=array('organisation'=>$request->org,'board'=>$request->board,'grade'=>$request->grade,'del_status'=>0,'status'=>1);
        $data= ManageuserSchoolModel::orderBy('id', 'DESC')->where($array)->get();
      
        $this->output($data);
    }
    
   
    
       
   public function searchItem(Request $request)
   {
    $filterData = DB::table('inventory')->select('id as value','itemname as label')->where('itemname','LIKE','%'.$request->search.'%')->get();
    
    $this->output($filterData);
   }
   
    /*
	* SearchItem
   **/
   
   public function getItemDetails(Request $request)
   {
        $filterData = DB::table('inventory')->where('id',$request->itemid)->first();
        $this->output($filterData);
        
	     

   }


 
public function add_school_set(Request $request)
{
       $school=$request->school;
       
       $count=count($school);
       $row=0;
       $existmsg="";
       for($i=0;$i<$count;$i++)
       {
        
        $existarray=array('school_id'=>$school[$i],'org'=>$request->organisation,"board" => $request->board,"grade" => $request->grade, "set_class" => $request->set_class,"set_category" => $request->set_cat,"set_type" => $request->set_type);
        $issetexist=SchoolSetModel::where($existarray)->first();
        if($issetexist)
        {
              $schoolname=ManageuserSchoolModel::where('id',$school[$i])->first();
              $existmsg.="<p class='text-danger'>".$schoolname->school_name." School Set Already Exist With Same Set type,cat,class. </p>";
        }
        else
        {
        $setid=$this->createRandomKey().rand(10,10000).$school[$i];
        $setdata = array(
            "school_id"=>$school[$i],
            'set_id'=>$setid,
            "org" => $request->organisation,
            "board" => $request->board,
            "grade" => $request->grade,
            "set_class" => $request->set_class,
            "set_category" => $request->set_cat,
            "set_type" => $request->set_type,
            "item_id" => implode(',',$request->itemid),
            "item_qty" => implode(',',$request->item_qty),
            "created_at"=>date('Y-m-d H:i:s')
        );
         $setdata = SchoolSetModel::create($setdata);
   
       
        }
        
        $row++;
        } 
     
      if ($row==$count) {
        
       $data['success']=1;
       $data['alertmsg']=$existmsg;
       
       $data['success_msg']='Set created successfully for selected school.';
       
        $this->output($data);
      }
      else
      {
        $data['error']=1;
        $data['error_msg']='Something Went Wrong!';
        $this->output($data);
      }
      
}
  
  
  
//edit_school_set
public function edit_school_set(Request $request)
{
        $where= SchoolSetModel::where(["org" => $request->old_organisation,"board" => $request->old_board,"grade" => $request->old_grade,"set_class" => $request->old_set_class,"set_category" => $request->old_set_cat,"set_type" => $request->old_set_type]);
        
        $setdata = array(
            "org" => $request->organisation,
            "board" => $request->board,
            "grade" => $request->grade,
            "set_class" => $request->set_class,
            "set_category" => $request->set_cat,
            "set_type" => $request->set_type,
            "item_id" => implode(',',$request->itemid),
            "item_qty" => implode(',',$request->item_qty),
        );
      
      
      
      
      $update_setdata = $where->update($setdata);
      
      if($update_setdata) {
       $data['success']=1;
       $data['success_msg']='Set updated successfully.';
     
       $this->output($data);
      }
      else
      {
        $data['error']=1;
        $data['error_msg']='Something Went Wrong!';
        $this->output($data);
      }
      
}
 
//update_set_market_place_fee
public function update_set_market_place_fee(Request $request)
{
        $where= SchoolSetModel::where(["set_id" => $request->set_id]);
        $setdata = array( "market_place_fee" => $request->feevalue);
      
      
      $update_setdata = $where->update($setdata);
      if($update_setdata) {
       $data['success']=1;
       $data['msg']='Set Market Place Fee updated successfully.';
     
       $this->output($data);
      }
      else
      {
        $data['error']=1;
        $data['msg']='Something Went Wrong!';
        $this->output($data);
      }
      
}
 

}
