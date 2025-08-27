<?php
namespace App\Http\Controllers\Home;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Home;
use App\Models\Courier_partner;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CourierPartner extends Controller
{

    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }



   function  genratetokenshiprocket()
    {
             $url = "https://apiv2.shiprocket.in/v1/external/auth/login";
             $email = "kiirangummrah@gmail.com";  // Replace with your email
             $password = "Pjc@1213";        // Replace with your password
             $data = array("email" => $email,"password" => $password);
             $json_data = json_encode($data);
             $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json'
            ));
            $response = curl_exec($ch);
            curl_close($ch);
            if($response === false) {
                return  false;
            } else {
                $response_data = json_decode($response, true);
                return $response_data['token'];
            }
    
    }

     // Display the list of Courier_partner
    public function courier_partner()
    {
        $courier_partner = Courier_partner::orderBy('id', 'DESC')->where(['del_status'=>0])->get();
        return view('CourierPartner.courier_partner', ['pagedata' => $courier_partner]);
    }

  

//view_courier_partner
 public function view_courier_partner($id)
    {
        $data = Courier_partner::findOrFail($id);
        $data->ship_rocket_token=$this->genratetokenshiprocket();
        return view('CourierPartner.view_courier_partner', ['courierPartner' => $data]);
    }


    // Update  update_courier_partner
    public function update_courier_partner(Request $request)
    {
       
       $request->validate([
            'title' => 'required',
            // 'url' => 'required|url',
            'courier_partner' => 'required|integer',
            'username' => ['nullable','string', 'max:255', Rule::unique('admin_courier_partner')->ignore($request->id) ],
            'password' => ['nullable', 'string',    ],
            'token' => ['nullable', 'string',    ],
            'access_key' =>['nullable', 'string',    ],
            'secret_key' => ['nullable', 'string',    ],
            'status' => 'required|integer',
        ]);
         

        $courierPartner = Courier_partner::findOrFail($request->id);
        $res=$courierPartner->update($request->all());

          if ($res) {

                return redirect()->back()->with('success', 'Updated successfully.');
            } else {

                return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
            }
    }

    // Delete the location
    public function destroy_courier_partner(Request $request)
    {
           $pickupPoint = Courier_partner::where(['id'=>$request->id]);
        //   $pickupPoint->update(['del_status' => 1]);
           $pickupPoint->delete();
           return redirect()->back()->with('success', 'Deleted successfully.');
    }
    
    
    
    

}
