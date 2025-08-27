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
  
    
}
