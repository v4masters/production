<?php

namespace App\Http\Controllers\Home\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegisterModel;
use App\Models\User;

use App\Models\managemasterboardModel;
use App\Models\managemastergradeModel;
use App\Models\managemasterorganisationModel;
use App\Models\UsersOtpVerifyModel;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;



class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

 public function loginAction(Request $request)
    {
      
        // Attempt to authenticate the user
        if ( Auth::attempt(['school_code' => $request->school_code,'password' => $request->password,'del_status' => 0])){
            // Authentication successful



            $User= User::where(['school_code'=>$request->school_code,'del_status' => 0])->first();

            // Store the user's email in the session
           
            $request->session()->regenerateToken();
            $request->session()->put('school_name', $User['school_name']);
             $request->session()->put('school_banner', $User['school_banner']);
              $request->session()->put('school_code', $User['school_code']);
            $request->session()->put('id', $User['id']);
             $request->session()->put('unique_id', $User['unique_id']);
            
             $request->session()->put('admin_profile', $User['admin_profile']);
    
    
   
            // Regenerate the session ID for security
            $request->session()->regenerate();
    
            return redirect('/home')->with('success', 'Login successfully.');
        }
    
        // Authentication failed
        throw ValidationException::withMessages([
            'school_code' => trans('auth.failed'),
        ]);
    }
    
     public function register()
    {
        
    $board = managemasterboardModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

    $grade = managemastergradeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

    $organisation = managemasterorganisationModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        
        return view('auth.register', array('board' => $board, 'grade' => $grade, 'organisation' => $organisation));
    }
    
    
       //add register data
  public function registerSave(Request $request)
  {
        // $validator = Validator::make($request->all(), [
        //     'password' =>  'required|string|confirmed|min:8',
        // ]);
        
        
        
        
                  if($request->school_code!="")
                  {
                      $existingUser=RegisterModel::where(['school_code'=>$request->school_code,"del_status"=>0])->first();
                      if($existingUser) {
                        $res['school_code'] = $request->school_code;
                        return redirect('register')->withErrors(['' => 'School Code Already Registered!']);
                      }
                  }
                  
                  if($request->school_email!="")
                  {
                      $existingUser=RegisterModel::where(['school_email'=>$request->school_email,"del_status"=>0])->first();
                      if($existingUser) {
                        $res['school_email'] = $request->school_email;
                        return redirect('register')->withErrors(['' => 'Email Id Already Registered!']);
                      }
                  }
                  
                  
                  if($request->school_phone!="")
                  {
                      $existingUser=RegisterModel::where(['school_phone'=>$request->school_phone,"del_status"=>0])->first();
                      if($existingUser) {
                        $res['school_phone'] = $request->school_phone;
                        return redirect('register')->withErrors(['' => 'Phone Number Already Registered!']);
                      }
                  }
                  
        
        
        
    $data = RegisterModel::orderBy('id', 'DESC')->first();
    $uniqueid = "SCH-00" . $data->id + 1;
    
    $data = array(
      "unique_id" =>  $uniqueid,
      "school_name" => $request->school_name,
      
      "school_email" => $request->school_email,
      
      "school_phone" => $request->school_phone,
      
      "grade" => $request->grade,
       
      "board" => $request->board,
        
      "organisation" => $request->organisation,
      
      "state" => $request->state,
      
      "distt" => $request->distt,
      
      "school_code" => $request->school_code,
      
      "tehsil" => $request->tehsil,
      
      "village" => $request->village,
      
      "landline_no" => $request->landline_no,
      
      "post_office" => $request->post_office,
        
      "zipcode" => $request->zipcode,
      
      "landmark" => $request->landmark,
      
       "password" =>bcrypt($request->password),
       
       "status"=>1,

      "created_at" =>  date('Y-m-d H:i:s')

    );

    $res = RegisterModel::insert($data);

    if ($res) {

      return redirect()->back()->with('success', 'Submitted successfully.');
    } else {

      return redirect('register')->withErrors(['' => 'Somthing went wrong!']);
    }
    
  }
    
    
// logout

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
        $user = User::where(['school_phone'=>$request->phone_no, 'del_status'=>0])->first();
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
                    "user_type"=>2,
                    "otp"=>$otp,
                    "otp_type"=>'forgot_password',
                    "sent_at"=>date('Y-m-d H:i:s'),
                ];
        
                $otpdata = UsersOtpVerifyModel::create($otp_data);
                if($otpdata)
                {
                     return redirect()->route('forgot_password_verify_otp')->with(['success'=>'Otp Sent Successfully','otp'=>$otpdata->otp, 'school_unique_id'=>$otpdata->user_id]);
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
            "user_id"=>$request->school_unique_id,
            "user_type"=>2,
            "otp"=>$request->otp,
            "otp_type"=>'forgot_password',
            // "status"=>1,
        ];
        
        $user = User::where('unique_id',$request->school_unique_id)->first();
        
        $checkotp = UsersOtpVerifyModel::where($where)->orderBy('id', 'DESC')->first();
        
        print_r($checkotp);
        if($checkotp)
        {
            $status_updated = $user->update(['status'=>1]);
            
            if($status_updated) 
            {
                return redirect('/forgot_password_new_password')->with(['success', 'Otp Verified Successfully, Create New Password', 'school_unique_id'=>$user->unique_id]);
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
        
        $user = User::where('unique_id',$request->school_unique_id)->first();
        
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
