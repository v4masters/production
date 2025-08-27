<?php

namespace App\Http\Controllers\Home\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use App\Models\User;
use App\Models\StateModel;
use App\Models\ManageuservendorModel;


class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

  
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

 public function loginAction(Request $request)
    {


        if ( Auth::attempt(['email' => $request->email,'password' => $request->password,'status'=>1,'del_status' => 0])){
            // Authentication successful
            
            $User= User::where(['email'=>$request->email,'del_status' => 0])->first();
            // Store the user's email in the session
            
            $request->session()->put('username', $User['username']);
             $request->session()->put('email', $User['email']);
              $request->session()->put('profile_img', $User['profile_img']);
            $request->session()->put('id', $User['unique_id']);
             $request->session()->put('website_img', $User['website_img']);
   
            // Regenerate the session ID for security
            $request->session()->regenerate();
    
            return redirect('/home')->with('success', 'Login successfully.');
        }
    
        // Authentication failed
        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }
     public function register()
    {
         $data['state']= StateModel::get();
        
        return view('auth.registervendor',$data);
    }  
    
     public function registerSave(Request $request)
    {
        
        
        
          if($request->email!="")
                  {
                      $existingUser=ManageuservendorModel::where(['email'=>$request->email,"del_status"=>0])->first();
                      if($existingUser) {
                        $res['email'] = $request->email;
                        return redirect('register')->withErrors(['' => 'Email Id Already Registered!']);
                      }
                  }
                  
                  
                  if($request->phone_no!="")
                  {
                      $existingUser=ManageuservendorModel::where(['phone_no'=>$request->phone_no,"del_status"=>0])->first();
                      if($existingUser) {
                        $res['phone_no'] = $request->phone_no;
                        return redirect('register')->withErrors(['' => 'Phone Number Already Registered!']);
                      }
                  }
                  

        $vdata = ManageuservendorModel::orderBy('id', 'DESC')->first();
        $vid=$vdata['id']+1;
        $uniqueid = $this->createRandomKey().$vid;
       
        $state_data=explode(',',$request->state);
        $data = array(
            "unique_id" =>  $uniqueid,
            "username" => $request->username,
            "email" =>  $request->email,
            "password" =>bcrypt($request->password),
            "phone_no" =>  $request->phone_no,
            "state" =>  $state_data[1],
            "state_code" =>  $state_data[0],
            "pincode" =>  $request->pincode,
            "address" =>  $request->address,
            "gst_no" =>  $request->gst_no,
            "status" =>  1,
            "created_at" =>  date('Y-m-d H:i:s')
        );

        $res = ManageuservendorModel::insert($data);
        if ($res) {
            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {
            return redirect('register')->withErrors(['' => 'Somthing went wrong!']);
        }
    }
    
    
        public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
