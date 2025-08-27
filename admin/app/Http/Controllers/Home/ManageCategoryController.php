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
use Illuminate\Support\Facades\Storage;

class ManageCategoryController extends Controller
{




  public function upload_image($file,$folder)
  {
      
    $image_name = date('YmdHis').'-'.time()."-".rand(10,100).'.'.$file->getClientOriginalExtension();
    $filePath = $folder.$image_name;
    $res=Storage::disk('s3')->put($filePath, file_get_contents($file));
    // $res = Storage::disk('s3')->put($filePath, file_get_contents($file), ['ACL' => 'public-read']);
        
    if($res)
    {
        return $image_name;
    }
    else
    {
        return false;
    }
   
    }



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
  

  
  public function manageCategory()
  {

    return view('manageCategory');
  }

  public function add_category(Request $request)

  {

    $validatedData = $request->validate([
      'name' => 'required|unique:master_category,name,NULL,id,del_status,0',
    ]);
    
    
    if($request->file('img')!= ''){
    $image=$this->upload_image($request->file('img'),'category/');
    }else{
    $image="";  
    }
    
    $data = array(

      "name" =>  $request->name,

      "des" =>  $request->des,

      "market_fee" =>  $request->market_fee,

      "img" =>  $image,

    );

    $res = ManagecategoryModel::create($data);

    if ($res) {

      $sub_name = $request->sub_name;

      $sub_des = $request->sub_des;

      $market_fee = $request->sub_market_fee;

      $subimg = $request->file('sub_img');



      $subdata = [];

      $count = count($sub_name);

      for ($i = 0; $i < $count; $i++) {



        if(isset($subimg[$i])) 
        {
          $subimage = $this->upload_image($subimg[$i],'category/sub_category/');
        } 
        else
        {
          $subimage = "";
        }

        $validatedsubData = $request->validate([
          'name' => 'required|unique:master_category_sub,name,NULL,id,del_status,0',
        ]);
        
        
        
        
        
        $subdata[] = [

          'cat_id' => $res->id,

          'name' => $sub_name[$i],

          'des' => $sub_des[$i],

          'market_fee' => $market_fee[$i],

          'img' => $subimage,

        ];
      }

      $subres = managesubcategoryModel::insert($subdata);

      if ($subres) {

        return redirect()->back()->with('success', 'Submitted successfully.');
      } else {

        return redirect('manageCategory')->withErrors(['' => 'Somthing went wrong!']);
      }
    } else {

      return redirect('manageCategory')->withErrors(['' => 'Somthing went wrong!']);
    }
  }





  public function add_category_again(Request $request)

  {

    $sub_name = $request->sub_name;

    $sub_des = $request->sub_des;

    $market_fee = $request->sub_market_fee;

    $subimg = $request->file('sub_img');

    $subdata = [];


    $count = count($sub_name);

    for ($i = 0; $i < $count; $i++) {

      if (isset($subimg[$i])) {

       $subimage = $this->upload_image($subimg[$i],'category/sub_category/');
  
      } else {

        $subimage = "";
      }

      $subdata[] = [


        'cat_id' => $request->cat_id,

        'name' => $sub_name[$i],

        'des' => $sub_des[$i],

        'market_fee' => $market_fee[$i],

        'img' => $subimage,

      ];
    }

    $subres = managesubcategoryModel::insert($subdata);


    if ($subres) {

      return redirect()->back();
    }
  }



  public function view_Category()

  {

    $data = ManagecategoryModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

    return view('viewcategory', ['pagedata' => $data]);
  }


  public function edit_category(string $id)

  {

    $data = ManagecategoryModel::where('id', $id)->first();
    $category = ManagecategoryModel::where('id', $id)->first();
    return view('managecategory_edit',  array('pagedata' => $data, 'category' => $category));
  }


  public function update_category(Request $request)

  {

    $access = ManagecategoryModel::where("id", request('id'));



    // Validate the input data

    $validatedData = $request->validate([

      'name' => 'required|unique:master_category,name,' . $request->id . ',id,del_status,0',

    ]);

    if ($request->file('img') != '') {

      $image = $this->upload_image($request->file('img'),'category/');
      $data = array(
        "name" =>  $request->name,
        "status" => $request->status,
        "des" =>  $request->des,
        "market_fee" =>  $request->market_fee,
        "img" =>  $image,

      );
    } else {

      $data = array(

        "name" =>  $request->name,
        "status" => $request->status,

        "des" =>  $request->des,

        "market_fee" =>  $request->market_fee,

      );
    }




    // Update the data

    $res = $access->update($data);

    if ($res) {

      return redirect('view_Category')->with('success', 'Updated successfully.');
    } else {

      return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
    }
  }


  public function delete_category(Request $request)

  {

    $data = ManagecategoryModel::where('id', Request('id'));

    $updData = array(

      'del_status' => 1

    );

    $res = $data->update($updData);

    if ($res) {

      return redirect()->back()->with('success', 'Deleted successfully.');
    } else {

      return redirect()->withErrors(['' => 'Somthing went wrong!']);
    }
  }


  // sub cactegory
  public function managesubCategory(string $id)

  {

    $array = array("del_status" => 0, "cat_id" => $id);

    $data = managesubcategoryModel::orderBy('id', 'DESC')->where($array)->get();

    $category = ManagecategoryModel::where('id', $id)->first();

    return view('subcategory_view', array('view' => $data, 'category' => $category));
  }


  public function edit_sub_category(string $cid, string $id)
  {

    $data = managesubcategoryModel::where('id', $id)->first();
    $category = ManagecategoryModel::where('id', $cid)->first();
    return view('sub_category_edit',  array('pagedata' => $data, 'category' => $category));
  }


  public function update_sub_category(Request $request)

  {

    $access = managesubcategoryModel::where("id", request('id'));

    // Validate the input data

    $validatedData = $request->validate([

      'name' => 'required|unique:master_category_sub,name,' . $request->id . ',id,del_status,0',
    ]);

    if ($request->file('img') != '') {

      $image = $this->upload_image($request->file('img'),'category/sub_category/');
      $data = array(

        "name" =>  $request->name,
        "status" => $request->status,
        "des" =>  $request->des,
        "market_fee" =>  $request->market_fee,
        "img" =>  $image,

      );
    } else {

      $data = array(

        "name" =>  $request->name,
        "status" => $request->status,

        "des" =>  $request->des,

        "market_fee" =>  $request->market_fee,

      );
    }




    // Update the data

    $res = $access->update($data);

    if ($res) {

      session()->flash('success', 'Updated successfully.');
      return redirect('managesubCategory/' . $request->cat_id);
    } else {

      return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
    }
  }


  public function delete_sub_category(Request $request)

  {

    $data = managesubcategoryModel::where('id', Request('id'));

    $updData = array(

      'del_status' => 1

    );

    $res = $data->update($updData);

    if ($res) {

      return redirect()->back()->with('success', 'Deleted successfully.');
    } else {

      return redirect()->withErrors(['' => 'Somthing went wrong!']);
    }
  }













  // add sub sub category

  public function add_two_sub_category(Request $request)

  {

    $sub_title = $request->sub_title;



    $subdata = [];

    $count = count($sub_title);

    for ($i = 0; $i < $count; $i++) {



      $subdata[] = [

        'sub_cat_id' => $request->sub_id,

        'cat_id' => $request->cat_id,

        'title' => $sub_title[$i],

      ];
    }

    $subres = managesubcategorytwoModel::insert($subdata);

    if ($subres) {

      return redirect()->back();
    }
  }



  public function managesubsubCategory(string $cat_id, string $sub_id)

  {

    $where = array("sub_cat_id" => $sub_id, "cat_id" => $cat_id, "del_status" => 0);

    $data = managesubcategorytwoModel::orderBy('id', 'DESC')->where($where)->get();


    $sizewhere = array("del_status" => 0, "status" => 1);

    $size = managemastersizeModel::orderBy('id', 'DESC')->where($sizewhere)->get();

    $form = MasterinventoryformsModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
    $category = ManagecategoryModel::orderBy('id', 'DESC')->where('id', $cat_id)->first();

    $subcategory = managesubcategoryModel::orderBy('id', 'DESC')->where('id', $sub_id)->first();



    return view('sub_sub_category', array('view' => $data, 'category' => $category, 'subcategory' => $subcategory, 'size' => $size, 'form' => $form));
  }

  public function delete_sub_sub_category(Request $request)

  {

    $data = managesubcategorytwoModel::where('id', Request('id'));

    $updData = array(

      'del_status' => 1

    );

    $res = $data->update($updData);

    if ($res) {

      return redirect()->back()->with('success', 'Deleted successfully.');
    } else {

      return redirect()->withErrors(['' => 'Somthing went wrong!']);
    }
  }


  public function edit_sub_sub_category(string $cid, string $sub_id, string $id)
  {

    $data = managesubcategorytwoModel::where('id', $id)->first();
    $category = ManagecategoryModel::where('id', $cid)->first();
    $subcategory = managesubcategoryModel::where('id', $sub_id)->first();
    $form = MasterinventoryformsModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

    return view('sub_sub_category_edit',  array('pagedata' => $data, 'category' => $category, 'subcategory' => $subcategory, 'form' => $form));
  }


  public function update_sub_sub_category(Request $request)

  {

    $access = managesubcategorytwoModel::where("id", request('id'));



    // Validate the input data

    $validatedData = $request->validate([

      'title' => 'required|unique:master_category_sub_two,title,' . $request->id . ',id,del_status,0',

    ]);


    $data = array(

      "title" =>  $request->title,
      "status" => $request->status,

    );

    // Update the data

    $res = $access->update($data);

    if ($res) {

      session()->flash('success', 'Updated successfully.');
      return redirect('managesubsubCategory/' . $request->cat_id . '/' . $request->sub_cat_id);
    } else {

      return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
    }
  }



  // add sub sub sub category

  public function add_three_sub_category(Request $request)
  {
    $sub_title = $request->sub_title;
    $subdata = [];

    for ($i = 0; $i <count($sub_title); $i++) {
     
      $name="sub_size_".$i;
      $subsizedata = implode(',',$request->$name);
   
      $subdata[] = [

        'sub_cat_id' => $request->sub_id,
        'cat_id' => $request->cat_id,
        'form_id'=>$request->form_id,
        'sub_cat_id_two' => $request->sub_id_two,
        'title' => $sub_title[$i],
        'size' => $subsizedata,
      ];
    }

    $subres = managesubcategorythreeModel::insert($subdata);

    if ($subres) {

       return redirect()->back()->with(['' => 'Added successfully']);
    }
  }




  //view sub sub sub category

  public function managesubsubsubCategory(string $catid, string $subid, string $id)

  {

    $where = array("cat_id" => $catid, "sub_cat_id" => $subid, "sub_cat_id_two" => $id, "del_status" => 0);

    $data = managesubcategorythreeModel::orderBy('id', 'DESC')->where($where)->get();

    $category = ManagecategoryModel::orderBy('id', 'DESC')->where('id', $catid)->first();

    $subcategory = managesubcategoryModel::orderBy('id', 'DESC')->where('id', $subid)->first();

    $subsubcategory = managesubcategorytwoModel::orderBy('id', 'DESC')->where('id', $id)->first();





    return view('sub_sub_sub_category_view', array('pagedata' => $data, 'category' => $category, 'subcategory' => $subcategory, 'subcategory_two' => $subsubcategory));
  }




  public function edit_sub_sub_sub_category(string $cid, string $sub_id, string $sub_cat_id_two, string $id)
  {

    $data = managesubcategorythreeModel::where('id', $id)->first();
    $category = ManagecategoryModel::where('id', $cid)->first();
    $subcategory = managesubcategoryModel::where('id', $sub_id)->first();
    $subsubcategory = managesubcategorytwoModel::where('id', $sub_cat_id_two)->first();
    $sizewhere = array("del_status" => 0, "status" => 1);
    $size = managemastersizeModel::orderBy('id', 'DESC')->where($sizewhere)->get();
    $form = MasterinventoryformsModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

    return view('sub_sub_sub_category_edit',  array('pagedata' => $data, 'category' => $category, 'subcategory' => $subcategory, 'subsubcategory' => $subsubcategory, 'size' => $size, 'form' => $form));
  }


  public function update_sub_sub_sub_category(Request $request)

  {

    $access = managesubcategorythreeModel::where("id", request('id'));



    // Validate the input data

    $validatedData = $request->validate([

      'title' => 'required|unique:master_category_sub_three,title,' . $request->id . ',id,del_status,0',

    ]);
    $subsizedata = implode(',',$request->size);

    $data = array(

      "title" =>  $request->title,
      "status" => $request->status,
      "size" => $subsizedata,
      "form_id" => $request->form_id,
      

    );

    // Update the data

    $res = $access->update($data);

    if ($res) {

      session()->flash('success', 'Updated successfully.');
      return redirect('managesubsubsubCategory/' . $request->cat_id . '/' . $request->sub_cat_id . '/' . $request->sub_cat_id_two);
    } else {

      return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
    }
  }


  public function delete_sub_sub_sub_category(Request $request)

  {

    $data = managesubcategorythreeModel::where('id', $request->id);

    $updData = array(

      'del_status' => 1

    );

    $res = $data->update($updData);

    if ($res) {

      return redirect()->back()->with('success', 'Deleted successfully.');
    } else {

      return redirect()->withErrors(['' => 'Somthing went wrong!']);
    }
  }

   //view sub sub sub category size

   public function viewsubsubsubCategorysize(string $cid, string $sub_id, string $sub_cat_id_two, string $id)
 
   {
 
     $where = array("cat_id" => $cid, "sub_cat_id" => $sub_id, "sub_cat_id_two" => $sub_cat_id_two, "id" => $id, "del_status" => 0);
 
     $category = ManagecategoryModel::orderBy('id', 'DESC')->where('id', $cid)->first();
 
     $subcategory = managesubcategoryModel::orderBy('id', 'DESC')->where('id', $sub_id)->first();
 
     $subsubcategory = managesubcategorytwoModel::orderBy('id', 'DESC')->where('id', $sub_cat_id_two)->first();
     
     $subsubsubcategory = managesubcategorythreeModel::orderBy('id', 'DESC')->where('id', $id)->first();
 
 
    $allsize=explode(',',$subsubsubcategory['size']);
    $countsize=count($allsize);
    $sizelist=array();

    for($i=0;$i<$countsize;$i++)
    {
      $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
      array_push($sizelist,$sizedata);
    }

  
 
     return view('sub_sub_sub_size', array('size_list'=>$sizelist,'category' => $category, 'subcategory' => $subcategory, 'subcategory_two' => $subsubcategory, 'subsubsubcategory' => $subsubsubcategory,''));
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


//test

public function test()

{

 
    return view('test');
}




}
