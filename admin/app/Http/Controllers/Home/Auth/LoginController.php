<?php

namespace App\Http\Controllers\Home\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\UsersOtpVerifyModel;


class LoginController extends Controller
{
    
    
    public function login()
    {
        return view('auth.login');
    }
    public function getView()
    {
        return view('auth.login');
    }


    public function loginAction(Request $request)
    {
        if( Auth::attempt(['username' => $request->username,'password' => $request->password,'status'=>1,'del_status' => 0])){
            // Authentication successful
            
            $User= User::where(['username'=>$request->username,'del_status' => 0])->first();
            // Store the user's email in the session
          
  
              $request->session()->put('name', $User['name']);
              $request->session()->put('email', $User['email']);
              $request->session()->put('profile_pic', $User['profile_pic']);
              $request->session()->put('unique_id', $User['unique_id']);
   
            // Regenerate the session ID for security
            $request->session()->regenerate();
    
            return redirect('/home')->with('success', 'Login successfully.');
        }
        
        // Authentication failed
        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }
    
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerateToken();
        return redirect('login');
    }
    
    
    
    // ------------------------Forgot Password------------------------ //
    
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