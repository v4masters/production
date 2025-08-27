<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\API\PickupPoint;
// use Response;
use Illuminate\Support\Facades\Storage;

class PickupApiPointController extends BaseController
{
    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }

    
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
    


    //view_pickup_point
    public function view_pickup_pointsnew(string $id):JsonResponse
    {
        $data=PickupPoint::where('id',$id)->first();
        //   $data['image']=$data['folder'].'/'.$data['images'];
        return $this->sendResponse(1, $data, '');
    }
    
}