<?php
namespace App\Http\Controllers\Home;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Home;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Validation\Rule;

use App\Models\managemasterclassModel;
use App\Models\managemastersettypeModel;
use App\Models\managemastersetcatModel;
use App\Models\managemasterboardModel;
use App\Models\managemasterorganisationModel;
use App\Models\ManageuserSchoolModel;
use App\Models\managemastergradeModel;

use App\Models\SchoolSetModel;
use App\Models\InventoryModel;


use App\Models\aws_img_url_model;
use Illuminate\Support\Facades\Storage;

class SchoolController extends Controller

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
		 
			while ($i <= 10) {
				$num = rand() % 33;
				$tmp = substr($chars, $num, 1);
				$key = $key . $tmp;
				$i++;
			}
		 
			return $key;
		}


        //schoolset
    public function schoolset()
    {
        $data['class'] = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $data['set_cat'] = managemastersetcatModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $data['set_type'] = managemastersettypeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
 

    
        return view('schoolsetadd',$data);
    }
    
    //edit_school_set_view

    public function edit_school_set_view(string $id)
    {
        $result=array();
        $array2=array();
          
        $class = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $set_cat = managemastersetcatModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $set_type = managemastersettypeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $old_info= SchoolSetModel::where(['id'=>$id,'school_id'=>session('id')])->first();
        
        $itemarray=explode(',',$old_info->item_id);
        $itemarrayqty=explode(',',$old_info->item_qty);
        
        $count=count($itemarray);
        for($i=0;$i<$count;$i++)
        {
              $itemdata= InventoryModel::where(['id'=>$itemarray[$i]])->first();
              $array2=['item_id'=>$itemarray[$i],'itemname'=>$itemdata->itemname,'unit_price'=>$itemdata->unit_price,'qty'=>$itemarrayqty[$i]];
              array_push($result,$array2);
            
        }
     
    
        return view('schoolsetedit',array('set_id'=>$id,'class'=>$class,'set_cat'=>$set_cat,'set_type'=>$set_type,'old_info'=>$old_info,'item_array'=>$result));
    }
//school_set_view

  public function school_set_view()
    { 
          $where = array('school_set.school_id'=>session('id'),'school_set.del_status' => 0);
    
        $data['allset']= DB::table('school_set')
        ->leftJoin('master_classes', 'master_classes.id', '=', 'school_set.set_class')
        ->leftJoin('master_set_cat', 'master_set_cat.id', '=', 'school_set.set_category')
        ->leftJoin('master_set_type', 'master_set_type.id', '=', 'school_set.set_type')
        ->leftJoin('master_board', 'master_board.id', '=', 'school_set.board')
        ->leftJoin('master_orgnisation', 'master_orgnisation.id', '=', 'school_set.org')
        ->leftJoin('master_grade', 'master_grade.id', '=', 'school_set.grade')
        ->leftJoin('school', 'school.id', '=', 'school_set.school_id')
        ->select('school_set.set_id','school_set.status','school_set.id','school.school_name','school.school_code','school_set.school_id','master_classes.title as class','master_set_cat.title as cat','master_set_type.title as type','master_board.title as board','master_orgnisation.name as org','master_grade.title as grade')
        ->where($where)
        ->orderBy('school_set.id','desc')
        ->get();
            
        return view('schoolsetview', $data);
      
        
       
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

//add_school_set
public function add_school_set(Request $request)
{
    
       
       $school= ManageuserSchoolModel::where(['id'=>session('id'),'unique_id'=>session('unique_id'),'del_status'=> 0])->first();

       $setid=$this->createRandomKey().rand(10,1000);
       
        $setdata = array(
            "school_id"=>session('id'),
            'set_id'=>$setid,
            "org" => $school->organisation,
            "board" => $school->board,
            "grade" => $school->grade,
            "set_class" => $request->set_class,
            "set_category" => $request->set_cat,
            "set_type" => $request->set_type,
            "item_id" => implode(',',$request->itemid),
            "item_qty" => implode(',',$request->item_qty),
            "created_at"=>date('Y-m-d H:i:s')
        );
        
        $setdata = SchoolSetModel::create($setdata);
      if($setdata)
      {
        
       $data['success']=1;
       $data['success_msg']='Set created successfully .';
       
        $this->output($data);
      }
      else
      {
        $data['error']=1;
        $data['error_msg']='Something Went Wrong!';
        $this->output($data);
      }
   
}

public function edit_school_set(Request $request)
{
       
       $where = SchoolSetModel::where(["id"=>$request->id,'school_id'=>session('id')]);
       $school= ManageuserSchoolModel::where(['id'=>session('id'),'unique_id'=>session('unique_id'),'del_status'=> 0])->first();

        $setdata = array(
            "org" => $school->organisation,
            "board" => $school->board,
            "grade" => $school->grade,
            "set_class" => $request->set_class,
            "set_category" => $request->set_cat,
            "set_type" => $request->set_type,
            "item_id" => implode(',',$request->itemid),
            "item_qty" => implode(',',$request->item_qty)
        );
       
        
       $res = $where->update($setdata);
      if($res)
      {
        
       $data['success']=1;
       $data['success_msg']='Set updated successfully .';
       
        $this->output($data);
      }
      else
      {
        $data['error']=1;
        $data['error_msg']='Something Went Wrong!';
        $this->output($data);
      }
   
}
    
    
    //get_set_item
     public function get_set_item(Request $request)
    {

	   
        $data= SchoolSetModel::where(['set_id'=>$request->set_id,'school_id'=>session('id'),"del_status"=>0])->first();
      
        $result=[];
        $array2=[];
        
   

        $itemarray=explode(',',$data->item_id);
        $itemarrayqty=explode(',',$data->item_qty);
        
        $count=count($itemarray);
        for($i=0;$i<$count;$i++)
        {
              $itemdata= InventoryModel::where(['id'=>$itemarray[$i]])->first();
              $array2=['img'=>"<img style='height:50px;weight:50px;' src=".Storage::disk('s3')->url($itemdata->folder.'/'.$itemdata->cover_photo).">",'itemname'=>$itemdata->itemname,'unit_price'=>$itemdata->unit_price,'itemcode'=>$itemdata->itemcode,'qty'=>$itemarrayqty[$i],'cover_photo'=>$itemdata->cover_photo];
              array_push($result,$array2);
            
        }
          
       
           $this->output($result);
	
    }

   // delete set
      public function delete_school_set(Request $request)
      {

        $data= SchoolSetModel::where(['id'=>$request->id,'set_id'=>$request->set_id,'school_id'=>session('id')])->first();
        $res = $data->delete();

        if ($res) {

          return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

          return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
      }


}
