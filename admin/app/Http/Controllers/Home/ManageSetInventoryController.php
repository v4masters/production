<?php

namespace App\Http\Controllers\Home;

use Intervention\Image\Facades\Image;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Home;

use App\Models\managemasterclassModel;

use App\Models\managemasterboardModel;

use App\Models\managemasterorganisationModel;

use App\Models\managemastergstModel;

use App\Models\ManageuserSchoolModel;

use App\Models\ManageuservendorModel;

use App\Models\ManageuserStudentModel;

use App\Models\managemastergradeModel;

use App\Models\managemastercolourModel;

use App\Models\managemasterbrandModel;

use App\Models\InventoryuniformsizeModel;

use App\Models\managemastersettypeModel;

use App\Models\managemastersetcatModel;

use App\Models\managemasterstreamModel;

use App\Models\managemastersizeModel;

use App\Models\managemastersizelistModel;

use App\Models\InventoryModel;

use App\Models\InventoryformsModel;

use App\Models\MasterinventoryformsModel;

use App\Models\MasterformrouteModel;

use App\Models\managemasterqtyModel;
use App\Models\InventoryCatModel;


use App\Models\managesubcategorythreeModel;
use App\Models\InventoryImgModel;
use App\Models\InventoryColourModel;

use File;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;



class ManageSetInventoryController extends Controller
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
    
    
    

    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }



    //inventory

    public function inventory()

    {

        $data = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $setcategory = managemastersetcatModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $settype = managemastersettypeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();



        return view('inventory', array('classes' => $data, 'setcategory' => $setcategory, 'settype' => $settype, 'gst' => $gst));
    }


    public function addmaininventory(Request $request)
    {

        $lastprodata = InventoryModel::orderBy('id', 'DESC')->first();
        $product_id=rand(10,10000)."0".$lastprodata->id+1;
      

      

         if($request->file('cover_photo')!= ''){
            $image=$this->upload_image($request->file('cover_photo'),'inventory_set/');
            }else{
            $image="";  
            }
            


        $data = array(

            "barcode" => $request->barcode,

            "hsncode" => $request->hsncode,

            "cover_photo" => $image,

            "itemname" => $request->itemname,

            "company_name" => $request->company_name,

            "item_type" => $request->item_type,

            "class" => $request->class_name,

            "item_weight" => $request->item_weight,

            "avail_qty" => $request->avail_qty,

            "unit_price" => $request->unit_price,

            "gst" => $request->gst,

            "medium" => $request->medium,

            "description" => $request->description,

            "inventory_type" => 0,

            "created_at" =>  date('Y-m-d H:i:s'),

            "itemcode" =>$product_id

        );

        $res = InventoryModel::insert($data);

        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    // uniform set inventory
    public function uniformsetinventory()

    {

        $data = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $setcategory = managemastersetcatModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $settype = managemastersettypeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qty = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('Uniform_set_inventory', array('classes' => $data, 'setcategory' => $setcategory, 'settype' => $settype, 'gst' => $gst, 'qty' => $qty));
    }

    public function adduniformsetinventory(Request $request)

    {

     

         if($request->file('size_chart')!= ''){
            $imagesize_chart=$this->upload_image($request->file('size_chart'),'inventory_set/');
            }else{
            $imagesize_chart="";  
            }
            

            if($request->file('cover_photo')!= ''){
            $image=$this->upload_image($request->file('cover_photo'),'inventory_set/');
            }else{
            $image="";  
            }


        
          if($request->file('cover_photo_2')!= ''){
            $image2=$this->upload_image($request->file('cover_photo_2'),'inventory_set/');
            }else{
            $image2="";  
            }


          if($request->file('cover_photo_3')!= ''){
            $image3=$this->upload_image($request->file('cover_photo_3'),'inventory_set/');
            }else{
            $image3="";  
            }

        
         if($request->file('cover_photo_4')!= ''){
            $image4=$this->upload_image($request->file('cover_photo_4'),'inventory_set/');
            }else{
            $image4="";  
            }


        $lastprodata = InventoryModel::orderBy('id', 'DESC')->first();
        $product_id=$lastprodata->id.rand(10,10000)."0".$lastprodata->id;
      

        $data = array(

            // "barcode" => $request->barcode,

            // "hsncode" => $request->hsncode,

            "cover_photo" => $image,

            "size_chart" => $imagesize_chart,

            "cover_photo_2" => $image2,

            "cover_photo_3" => $image3,

            "cover_photo_4" => $image4,

            "itemname" => $request->itemname,

            "company_name" => $request->company_name,

            "item_type" => $request->item_type,

            "class" => $request->class_name,

            "inventory_type" => 1,

            "description" => $request->description,

            "created_at" =>  date('Y-m-d H:i:s'),
            
            "itemcode" =>$product_id

        );

        $res = InventoryModel::create($data);


        if ($res) {

            $uni_gst = $request->uni_gst;

            $uni_qty = $request->uni_qty;

            $uni_hsncode = $request->uni_hsncode;

            $uni_barcode = $request->uni_barcode;

            $size = $request->size;

            $price_per_size = $request->price_per_size;

            $weight = $request->weight;



            $subdata = [];

            $count = count($uni_gst);

            for ($i = 0; $i < $count; $i++) {


                $subdata[] = [

                    'item_id' => $res->id,

                    'uni_gst' => $uni_gst[$i],

                    'uni_qty' => $uni_qty[$i],

                    'uni_hsncode' => $uni_hsncode[$i],

                    'uni_barcode' => $uni_barcode[$i],

                    'size' => $size[$i],

                    'price_per_size' => $price_per_size[$i],

                    'weight' => $weight[$i],


                ];
            }

            $subres = InventoryuniformsizeModel::insert($subdata);

            if ($res) {

                return redirect()->back()->with('success', 'Submitted successfully.');
            } else {

                return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
            }
        }
    }


    public function edituniformsetitem(string $id)

    {
        $data['gst'] = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $data['classes'] = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $data['pagedata'] = InventoryModel::where('id', $id)->first();

        $data['sizedata'] = InventoryuniformsizeModel::where('item_id', $id)->get();

        return view('edit_uniform_set_item', $data);
    }
    
    
    
    
    

    // update uniform set item
    public function updateuniformsetitem(Request $request)
    {

            if ($request->file('size_chart')!="") {
            $size_chart =$this->upload_image($request->file('size_chart'),'inventory_set/');
            }
            else
            {
            $size_chart=$request->size_chart_old;
            }
            
            

            if ($request->file('cover_photo')!="") {
            $cover_photo = $this->upload_image($request->file('cover_photo'),'inventory_set/');
            }
            else
            {
            $cover_photo=$request->cover_photo_old;
            }
            
            
            if ($request->file('cover_photo_2')!="") {
            $cover_photo_2 = $this->upload_image($request->file('cover_photo_2'),'inventory_set/');
            }
            else
            {
            $cover_photo_2=$request->cover_photo_2_old;
            }
            
            
              if ($request->file('cover_photo_3')!="") {
            $cover_photo_3 =  $this->upload_image($request->file('cover_photo_3'),'inventory_set/');
            }
            else
            {
            $cover_photo_3=$request->cover_photo_3_old;
            }
            
            
            if ($request->file('cover_photo_4')!="") {
            $cover_photo_4 = $this->upload_image($request->file('cover_photo_4'),'inventory_set/');
            }
            else
            {
            $cover_photo_4=$request->cover_photo_4_old;
            }
            



        $data = array(
                "item_type" =>  $request->item_type,
                "itemname" =>  $request->itemname,
                "company_name" =>  $request->company_name,
                "class" =>  $request->class_name,
                "description" =>  $request->description,
                "status" => $request->status,
                "size_chart"=>$size_chart,
                "cover_photo"=>$cover_photo,
                "cover_photo_2"=>$cover_photo_2,
                "cover_photo_3"=>$cover_photo_3,
                "cover_photo_4"=>$cover_photo_4,
                
            );
            
            

        $access = InventoryModel::where("id", request('id'));
        $res = $access->update($data);
        if ($res) {
            
            $deleteold=InventoryuniformsizeModel::where('item_id',$request->id)->delete();
             
            $size=$request->size;
            $uni_gst = $request->uni_gst;
            $uni_qty = $request->uni_qty;
            $uni_hsncode = $request->uni_hsncode;
            $uni_barcode = $request->uni_barcode;
            $price_per_size = $request->price_per_size;
            $weight = $request->weight;

            $count = count($size);
            $subdata=[];
            for ($i = 0; $i < $count; $i++) {
                   $subdata[]=[
                    'item_id' => $request->id,
                    'uni_gst' => $uni_gst[$i],
                    'uni_qty' => $uni_qty[$i],
                    'uni_hsncode' => $uni_hsncode[$i],
                    'uni_barcode' => $uni_barcode[$i],
                    'size' => $size[$i],
                    'price_per_size' => $price_per_size[$i],
                    'weight' => $weight[$i],
                ];
            }
            
           $subres = InventoryuniformsizeModel::insert($subdata);

           
          return redirect('set_items')->with('success', 'Updated successfully.');
        } 
        else 
        {
         return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }



    // edit book set items
    public function editbooksetitem(string $id)

    {
        $data['gst'] = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $data['classes'] = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $data['pagedata'] = InventoryModel::where('id', $id)->first();

        return view('edit_book_set_item', $data);
    }



    // updatebooksetitem
    public function updatebooksetitem(Request $request)

    {

        $access = InventoryModel::where("id", request('id'));


        if ($request->file('cover_photo') != "") {

            $image =  $this->upload_image($request->file('cover_photo'),'inventory_set/');


            $data = array(

                "item_type" =>  $request->item_type,
                "cover_photo" => $image,
                "barcode" =>  $request->barcode,
                "hsncode" =>  $request->hsncode,
                "itemname" =>  $request->itemname,
                "company_name" =>  $request->company_name,
                "class" =>  $request->class_name,
                "avail_qty" =>  $request->avail_qty,
                "unit_price" =>  $request->unit_price,
                "item_weight" =>  $request->item_weight,
                "medium" =>  $request->medium,
                "gst" =>  $request->gst,
                "description" =>  $request->description,
                "status" => $request->status

            );
        } else {

            $data = array(

                "item_type" =>  $request->item_type,
                "barcode" =>  $request->barcode,
                "hsncode" =>  $request->hsncode,
                "itemname" =>  $request->itemname,
                "company_name" =>  $request->company_name,
                "class" =>  $request->class_name,
                "avail_qty" =>  $request->avail_qty,
                "unit_price" =>  $request->unit_price,
                "item_weight" =>  $request->item_weight,
                "medium" =>  $request->medium,
                "gst" =>  $request->gst,
                "description" =>  $request->description,
                "status" => $request->status

            );
        }

        $res = $access->update($data);

        if ($res) {

            return redirect('book_set_items')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    public function viewbooksetitem()
    {

        $where = array('inventory.del_status' => 0, 'inventory.inventory_type' => 0);
        $data['pagedata'] = DB::table('inventory')
            ->join('master_taxes', 'master_taxes.id', '=', 'inventory.gst')
            ->join('master_classes', 'master_classes.id', '=', 'inventory.class')
            ->select('inventory.*',  'master_taxes.title as gst_title',  'master_classes.title as class_title')
            ->where($where)
            ->orderBy('inventory.id', 'desc')
            ->get();

        //  $where = array("inventory_type" => 0, "del_status" => 0);

        // $data['pagedata'] = InventoryModel::orderBy('id', 'DESC')->where($where)->get();

        return view('view_book_set_items', $data);
    }

    public function viewauniformsetitem()
    {

        $where = array('inventory.del_status' => 0, 'inventory.inventory_type' => 1);
        $data['inventory'] = DB::table('inventory')
            ->join('master_classes', 'master_classes.id', '=', 'inventory.class')
            ->select('inventory.*',  'master_classes.title as class_title')
            ->where($where)
            ->orderBy('inventory.id', 'desc')
            ->get();


        // $where = array("inventory_type" => 1, "del_status" => 0);

        // $data['inventory'] = InventoryModel::orderBy('id', 'DESC')->where($where)->get();

        return view('view_uni_set_items', $data);
    }

    public function uni_setdetail(Request $request)
    {

        $where = array('inv_uni_size.del_status' => 0, 'inv_uni_size.status' => 1, 'inv_uni_size.item_id' =>  $request->id);
        $data = DB::table('inv_uni_size')
            ->join('master_taxes', 'master_taxes.id', '=', 'inv_uni_size.uni_gst')
            ->select('inv_uni_size.*',  'master_taxes.title as gst_title')
            ->where($where)
            ->orderBy('inv_uni_size.size', 'asc')
            ->get();


        // $array = array("del_status" => 0, 'status'=>1,"item_id" => $request->id);
        // $data = InventoryuniformsizeModel::orderBy('size', 'asc')->where($array)->get();
        // return response($data, 200)->header('Content-Type', 'text/plain');
        $this->output($data);
    }



}
