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
use App\Models\UsersOtpVerifyModel;


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
        
            if ($request->type == 1) {
                $credentials = [
                    'email' => $request->email,
                    'password' => $request->password,
                    'status' => 1,
                    'del_status' => 0
                ];
                $userColumn = 'email';
                $usertype=1;
            } else {
                $credentials = [
                    'e_email' => $request->email,
                    'password' => $request->password,
                    'status' => 1,
                    'del_status' => 0
                ];
                $userColumn = 'e_email';
                $usertype=2;
            }
            
            // Attempt to authenticate the user
            if (Auth::attempt($credentials)) {
                // Authentication successful
                $user = User::where([$userColumn => $request->email, 'del_status' => 0])->first();
            
                // Check if user exists and store session data
                if ($user) {
                    $request->session()->put([
                        'username' => $user->username,
                        'email' => $user->$userColumn,
                        'profile_img' => $user->profile_img,
                        'id' => $user->unique_id,
                        'website_img' => $user->website_img,
                        'user_type' => $usertype,
                    ]);
            
                    // Regenerate the session ID for security
                    $request->session()->regenerate();
            
                    // Redirect to home with success message
                    return redirect('/home')->with('success', 'Login successfully.');
                }
            }
            
            // Authentication failed
            throw ValidationException::withMessages([
                $userColumn => trans('auth.failed'),
            ]);


        // if ( Auth::attempt(['email' => $request->email,'password' => $request->password,'status'=>1,'del_status' => 0])){
        //     // Authentication successful
            
        //     $User= User::where(['email'=>$request->email,'del_status' => 0])->first();
        //     // Store the user's email in the session
            
        //      $request->session()->put('username', $User['username']);
        //      $request->session()->put('email', $User['email']);
        //      $request->session()->put('profile_img', $User['profile_img']);
        //      $request->session()->put('id', $User['unique_id']);
        //      $request->session()->put('website_img', $User['website_img']);
        //      $request->session()->put('e_status', $User['e_status']);
   
   
        //     // Regenerate the session ID for security
        //     $request->session()->regenerate();
    
        //     return redirect('/home')->with('success', 'Login successfully.');
        // }
    
        // // Authentication failed
        // throw ValidationException::withMessages([
        //     'email' => trans('auth.failed'),
        // ]);
    
      
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
    
    
    
    //forgot_password_send_otp_view
    public function forgot_password_send_otp_view(Request $request)
    {
        return view('auth.forgot_password_send_otp');
    }
    //forgot_password_new_password_view
    public function forgot_password_new_password(Request $request)
    {
        return view('auth.forgot_password_new_password');
    }
    
    //forgot_password_send_view
    public function forgot_password_verify_otp()
    {
        return view('auth.forgot_password_verify_otp');
    }
    
    //forgot_password_sendOtp
    public function forgot_password_sendOtp(Request $request)
    {
        $user = User::where(['phone_no'=>$request->phone_no, 'del_status'=>0])->first();
        if(!$user)
        {
          return redirect()->back()->withErrors(['' => 'Invalid Phone number!']);
        }
        else
        {
            $phone="+91".$request->phone_no;
            $otp=rand(10,1000000);
            $data = "apikey=uKd4MhXyXB4-GLU8Gl3m3YWT2Hil2e2u2ItGijvguo&sender=evyapr&numbers=$phone&message=$otp is your OTP for www.evyapari.com forgot password. Please do not share it with anyone. Regards, Evyapari.com";
        	$ch = curl_init('https://api.textlocal.in/send/?');
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	$result22 = curl_exec($ch); // This is the result from the API
        	
            if(empty($result22))
			{
                
                return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
				curl_close($ch);
			}
			else
			{
				curl_close($ch);
    			     
                $otp_data=[
                    "user_id"=>$user->unique_id,
                    "user_type"=>3,
                    "otp"=>$otp,
                    "otp_type"=>'forgot_password',
                    "sent_at"=>date('Y-m-d H:i:s'),
                ];
        
                $otpdata = UsersOtpVerifyModel::create($otp_data);
                if($otpdata)
                {
                     return redirect()->route('forgot_password_verify_otp')->with(['success'=>'Otp Sent Successfully','otp'=>$otpdata->otp, 'unique_id'=>$otpdata->user_id]);
                }
                else
                {
                   return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
                }
    	    }
        }
       
    }
    

    //forgot_password_verifyOtp
    public function forgot_password_verifyOtp(Request $request)
    {
        $where=[
            "user_id"=>$request->unique_id,
            "user_type"=>3,
            "otp"=>$request->otp,
            "otp_type"=>'forgot_password',
            // "status"=>1,
        ];
        
        $user = User::where('unique_id',$request->unique_id)->first();
        
        $checkotp = UsersOtpVerifyModel::where($where)->orderBy('id', 'DESC')->first();
        
        print_r($checkotp);
        if($checkotp)
        {
            $status_updated = $user->update(['status'=>1]);
            
            if($status_updated) 
            {
                return redirect('/forgot_password_new_password')->with(['success', 'Otp Verified Successfully, Create New Password', 'unique_id'=>$user->unique_id]);
                // return view('auth.forgot_password_new_password',[]);
            }
            else
            {
                throw ValidationException::withMessages([
                    '' => trans('Something Went Wrong'),
                ]);
            }
        }
        else
        {
            return redirect()->back()->withErrors(['' => 'Invalid Otp']);
        }
    }
    
    //New Password
    public function forgot_password_newPassword(Request $request)
    {
        
        $user = User::where('unique_id',$request->unique_id)->first();
        
        $password_updated = $user->update(['password'=>bcrypt($request->new_password),]);
            
        if($password_updated) 
        {
            return redirect('/login')->with('success', 'Password Updated, Login Now');
        }
        else
        {
            throw ValidationException::withMessages([
                '' => trans('Something Went Wrong'),
            ]);
        }
    }
}
