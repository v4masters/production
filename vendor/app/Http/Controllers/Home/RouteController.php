<?php
   
namespace App\Http\Controllers\Home;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Home;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;


use App\Models\ReviewModel;
use App\Models\RouteModel;
use App\Models\VendorModel;
use App\Models\managemastersizelistModel;
   
class RouteController extends Controller
{
    
    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }
    
    //Create Random Key
    public	function createRandomKey() {
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$key = '' ;
	 
		while ($i <= 8) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$key = $key . $tmp;
			$i++;
		}
	 
		return $key;
	}
    
    
    //route
    public function route()
    { 
        $vendor = VendorModel::where(['unique_id'=>session('id'), 'del_status'=>0, 'status'=>1])->first();
        $vendor_source = $vendor->username.', '.$vendor->address.', '.$vendor->pincode. ', '. $vendor->phone_no;
        
        $routes_data = RouteModel::where(['del_status'=>0, 'status'=>1])->get();
        return view('route', ['vendor_source'=>$vendor_source, 'routes_data'=>$routes_data]);
    }
    
    // create_route
    public function create_route(Request $request)
    { 
        $unique_id=$this->createRandomKey();
        $data = [
            'unique_id'=>mt_rand(1000000, 9999999),
            'source'=>$request->source,
            'destination'=> $request->destination,
            'vendor_id'=>session('id'),
            'google_source'=>$request->google_source,
            'google_destination'=>$request->google_destination,
            'source_latitude'=>$request->source_latitude,
            'source_longitude'=>$request->source_longitude,
            'destination_latitude'=>$request->source_latitude,
            'destination_longitude'=>$request->source_longitude,
        ];
        $route = RouteModel::create($data);
        return back()->with(['success' => 'Route Created successfully']);
    }
    
    //route_edit_view
    public function route_edit_view(Request $request, $id)
    {
        $route_data = RouteModel::where(['unique_id'=>$id, 'del_status'=>0, 'status'=>1])->first();
        return view('route_edit', ['route_data'=>$route_data]);
    }
    
    //route_edit
    public function route_edit(Request $request)
    {
        $update_data = [
            'source'=>$request->source,
            'destination'=> $request->destination,
        ];
        $route = RouteModel::where(['unique_id'=>$request->id, 'del_status'=>0, 'status'=>1]);
        $route->update($update_data);
        return back()->with(['success' => 'Route Updated successfully']);
    }
}












