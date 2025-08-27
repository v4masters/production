<?php
   
namespace App\Http\Controllers\API\Shiprocket;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\API\OrderTrackingModel;
use App\Models\API\test_ship_rocket;
use App\Models\API\ShiprocketStatusCode;
use App\Models\API\VendorModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\JsonResponse;
   
   
class ShiprocketController extends BaseController
{
    
    public function getShipRocketTrackingData(Request $request)
    {
          $order_id = explode( ":", $request->order_id);
          $active_status=ShiprocketStatusCode::where(['status_code'=>$request->current_status_id])->first();
          if($request->current_status_id==7)
          {
            $data=[
              'shipping_partner'=>'Shiprocket',             
              'shipper_name'=>'https://shiprocket.co/tracking/'.$request->awb,
              'courier_number'=>$request->awb,
              'tracking_status'=>5,
              'delivered_on'=>date('Y-m-d H:i:s'),
              'active_status'=>$active_status->des,
              ];
          }
          elseif($request->current_status_id==17)
          {
              $data=[
              'shipping_partner'=>'Shiprocket',           
              'shipper_name'=>'https://shiprocket.co/tracking/'.$request->awb,
              'courier_number'=>$request->awb,
              'tracking_status'=>4,
              'out_for_delivery'=>date('Y-m-d H:i:s'),
              'active_status'=>$active_status->des,
              ];
          }
          else
          {
              $data=[
              'shipping_partner'=>'Shiprocket',      
              'shipper_name'=>'https://shiprocket.co/tracking/'.$request->awb,
              'courier_number'=>$request->awb,      
              'active_status'=>$active_status->des,
              ];
          }
          $updatetrackingstatus=OrderTrackingModel::where(['invoice_number'=>$order_id[0],'ship_order_id'=>$request->sr_order_id]);
          $updatetrackingstatus->update($data);

    }
}


