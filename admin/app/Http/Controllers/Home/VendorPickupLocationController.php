<?php
namespace App\Http\Controllers\Home;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Home;
use App\Models\VendorPickupLocation;
use App\Models\VendorModel;
use App\Models\Courier_partner;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class VendorPickupLocationController extends Controller
{
    
    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }

function getShipRocketToken()
{
        $userdata = Courier_partner::select('token')->where(['courier_partner'=>3,'status'=>1,'del_status'=>0])->first();
        $token =$userdata->token;
        return $token;
        
}
 
public function get_vendor_pp()
{
        $token =$this->getShipRocketToken();
        $pickupPoints=[];
        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token,])->get('https://apiv2.shiprocket.in/v1/external/settings/company/pickup');
  
        // Check if the request was successful
        if ($response->successful()) {
            $pickupPoints = json_decode($response->body(), true); 
            return view('vendor_pickup_location.vendor_pickup_points', ['pagedata' => $pickupPoints['data']['shipping_address']]);
            // print_r($pickupPoints['data']['shipping_address']);
            
        }
        else
        {
         return view('vendor_pickup_location.vendor_pickup_points', ['pagedata' => $pickupPoints]);
      
        }
}


    // Show form to create a new location
    public function create_vendor_pp()
    {
                $data = VendorModel::orderBy('id', 'DESC')->where(['status'=>1,'pickup_loc_status'=>0,'del_status'=>0])->get();
                return view('vendor_pickup_location.vendor_pickup_points_add',['vendors' => $data]);
    }

    // Store new location
    public function store_vendor_pp(Request $request)
    {
        $token =$this->getShipRocketToken();
        $vendor_id_name=explode(",", $request->vendor_id);
        $VendorModel = VendorModel::select('unique_id')->where(['unique_id'=>$vendor_id_name[0]])->first();
       
        //Shiprocket
        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token,'Content-Type' => 'application/json'])->post('https://apiv2.shiprocket.in/v1/external/settings/company/addpickup', [
            'pickup_location' => $request->pickup_location,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone_no,
            'address' => $request->address,
            'address_2' => $request->addresstwo,
            'city' => $request->city_town_vill,
            'state' => $request->state,
            'country' => 'India',
            'pin_code' => $request->pincode,
            "user_id" => $VendorModel->unique_id,
            "created_at" => now(),
        ]);
    
        // Check for successful response
       if($response->successful()) {
           
           
            $pickupdata = $response->json();
            if (isset($pickupdata['pickup_id'])) {
                $pickup_id=$pickupdata['pickup_id'];
               
            } else {
              $pickup_id='';
            }
        
         $vendorlocation = VendorModel::where(['unique_id'=>$VendorModel->unique_id]);
         $vendorlocation->update(['pickup_loc_status'=>1,'location_id'=>$pickup_id,'pickup_location'=>$request->pickup_location]);
         return redirect()->back()->with('success', ' Vendor Pickup Location Addedd Successfully.');
        }
        else
        {
            // return response()->json(['error' => 'Failed to add pickup', 'message' => $response->body()], 500);
            return redirect()->back()->withErrors(['' =>$response->body()]); 
        }
    }

}




