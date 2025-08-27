<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\PickupPoint;

use Response;
use Illuminate\Support\Facades\Storage;

class PickupPointController extends Controller
{
    
    
    
  public function upload_image($file,$folder)
  {
      
    $image_name = date('YmdHis')."-".rand(100, 999).'.'.$file->getClientOriginalExtension();
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




    public function view_pickup_points()
    {
        $pickupPoints = PickupPoint::orderBy('id', 'DESC')->where(['del_status'=>0])->get();
        return view('pickup_points', ['pagedata' => $pickupPoints]);
    }

    public function pickup_points()
    {
        return view('pickup_points_add');
    }

    public function add_pickup_points(Request $request)
    {
       
        $lastprodata = PickupPoint::orderBy('id', 'DESC')->first();
        if($lastprodata)
        {
        $uid='PP'.rand(10,10000)."0".$lastprodata->id+1;
        }else
        {
              $uid='PP'.rand(10,10000)."01";
        }
      


        $images = "";
        if ($request->hasFile('pickupPointImages')) {
            foreach ($request->file('pickupPointImages') as $image) {
             
                $subimage = $this->upload_image($image,'pickup_point/');
                $images.= $subimage.",";
            }
        }
        


        $res=PickupPoint::create([
            'uid' => $uid,
            'name' => $request->pickupPointName,
            'address' => $request->pickupPointAddress,
            'google_location' => $request->googleLocation,
            'contact_number' => $request->contactNumber,
            'opening_time' => $request->openingTime,
            'closing_time' => $request->closingTime,
            'notes' => $request->additionalNotes,
            'images' => $images,
             'created_at' => date('Y-m-d'),
        ]);


        if ($res) {

                return redirect()->back()->with('success', 'Pickup Point Addedd Successfully.');
            } else {

                return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
            }


    }

    public function edit_pickup_point(string $id)
    {
        $data['pagedata'] = PickupPoint::where(['id'=>$id])->first();
        return view('pickup_points_edit',$data);
    }

    public function edit_pickup_point_data(Request $request)
    {
       
      $pickupPoint=PickupPoint::where(['id'=>$request->id]);
      $pickupPointdata=PickupPoint::select('images')->where(['id'=>$request->id])->first();

        $images = $pickupPointdata->images;
        if ($request->hasFile('pickupPointImages')) {
            foreach ($request->file('pickupPointImages') as $image) {
             
                $subimage = $this->upload_image($image,'pickup_point/');
                $images.= $subimage.",";
            }
            $pickupPoint->update(['images' => $images]);
        }
        
        
        

       $res=$pickupPoint->update([
            'name' => $request->pickupPointName,
            'address' => $request->pickupPointAddress,
            'google_location' => $request->googleLocation,
            'contact_number' => $request->contactNumber,
            'opening_time' => $request->openingTime,
            'closing_time' => $request->closingTime,
            'notes' => $request->additionalNotes,
            'images' => $images,
            'status' => $request->status,
        ]);
         
        
         if ($res) {

                return redirect()->back()->with('success', 'Pickup Point updated successfully.');
            } else {

                return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
            }
    }
    
//delete_pickup_point_data
    public function delete_pickup_point_data(Request $request)
    {
           $pickupPoint = PickupPoint::where(['id'=>$request->id]);
           $pickupPoint->update(['del_status' => 1]);
           return redirect()->back()->with('success', 'Pickup Point deleted successfully.');
    }
    
    //delete_pickup_image
     public function delete_pickup_image(Request $request)
    {
        
           $getpickupPoint=PickupPoint::select('images')->where(['id'=>$request->id])->first();
           
           $allimages=$getpickupPoint->images;
           $exploadedimg=explode(',',$allimages);
           $images="";
           foreach($exploadedimg as $img)
           {
               if($img!=$request->imagename)
               {
                   $images.=$img.",";
               }
           
           }
           
           
           $pickupPoint = PickupPoint::where('id',$request->id);
           $res=$pickupPoint->update(['images' => $images]);
          
           if ($res) {

            $response['success'] = 1;
            $response['msg'] = 'Image Deleted Successfully!';
            $this->output($response);
        } else {
            $response['success'] = 0;
            $response['msg'] = 'Somthing went wrong!';
            $this->output($response);
           
        }
          
    }
}