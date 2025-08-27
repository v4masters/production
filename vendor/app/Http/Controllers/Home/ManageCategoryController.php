<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Home;
use App\Models\ManagecategoryModel;
use App\Models\managesubcategoryModel;
use App\Models\managesubcategorytwoModel;
use App\Models\managesubcategorythreeModel;
use App\Models\managemastersizeModel;

use App\Models\MasterinventoryformsModel;
use Response;

class ManageCategoryController extends Controller

{

//catalog_cat_one
  public function catalog_cat_one(Request $request)
  {
    $array = array("del_status" => 0, 'status'=>1,"cat_id" => $request->id);
    $data = managesubcategoryModel::orderBy('name', 'asc')->where($array)->get();
    return response($data, 200)->header('Content-Type', 'text/plain');
    
  }
  
  //catalog_cat_two
    public function catalog_cat_two(Request $request)
  {
    $array = array("del_status" => 0, 'status'=>1,"cat_id" => $request->id,"sub_cat_id"=>$request->sub_id);
    $data = managesubcategorytwoModel::orderBy('title', 'asc')->where($array)->get();
    return response($data, 200)->header('Content-Type', 'text/plain');
    
  }
  
  //catalog_cat_three
    public function catalog_cat_three(Request $request)
  {
    $array = array("del_status" => 0, 'status'=>1,"cat_id" => $request->id,"sub_cat_id"=>$request->sub_id,"sub_cat_id_two"=>$request->csub_id);
    $data = managesubcategorythreeModel::orderBy('title', 'asc')->where($array)->get();
    return response($data, 200)->header('Content-Type', 'text/plain');
    
  }
  


  public function category_catalog()

  {

    $category = ManagecategoryModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
    $subcategory = managesubcategoryModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
    $subsubcategory = managesubcategorytwoModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
    $subsubsubcategory = managesubcategorythreeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
    return view('category_catalog', array('category' => $category,'subcategory' =>$subcategory,'subsubcategory' =>$subsubcategory,'subsubsubcategory' =>$subsubsubcategory));
  }



  public function get_category_catalog(string $id)

  {
    $array = array('del_status' => 0, 'status' => 1, 'cat_id' => $id);

    $category = managesubcategoryModel::orderBy('id', 'DESC')->where($array)->get();

    return json_encode($category);
  }





}
