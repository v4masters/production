<?php
   
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\API\Users;
use App\Models\API\SchoolModel;
use App\Models\API\WishlistModel;
use App\Models\API\CartModel;
use App\Models\API\UserAddressesModel;
use App\Models\API\UsersOtpVerifyModel;
use App\Models\API\TestModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
   
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
class AuthController extends BaseController
{
    public function createRandomKey() {
        $vdata = Users::orderBy('id', 'DESC')->first();
        if($vdata)
        {
            $vid=$vdata['id']+1;
        }
        else {
            $vid=1;
        }
    
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
	 
		return $key.$vid;
	}
	
	

	
	
	//Generate Otp
	public function generateOtp($phone_number): JsonResponse
	{
        $phone_no=$phone_number;
        //Check phone exist
        $user = Users::where(['phone_no'=>$phone_no, 'del_status' =>0])->first();
        if(!$user) {
            return $this->sendResponse(0, null, "Phone number doesn't exist in our records");
        }
        
        //otp
        $phone="+91".$phone_number;
       $otp = rand(100000, 999999);
        $data = "apikey=NzQ0ODMyNzQ0OTM1Nzc0MjM2NGY3OTRhNTk2MzM1Mzc=&sender=vyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
    	$ch = curl_init('https://api.textlocal.in/send/?');
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	$result22 = curl_exec($ch); // This is the result from the API
    	
        if(empty($result22))
		{
             return $this->sendResponse(0, null, 'Somthing Went Wrong'); 
			 curl_close($ch);
		}
		else
		{
			curl_close($ch);
			     
            $otp_data=[
                "user_id"=>$user->unique_id,
                "user_type"=>1,
                "otp"=>$otp,
                "otp_type"=>'login',
                "sent_at"=>date('Y-m-d H:i:s'),
            ];
    
            $otpdata = UsersOtpVerifyModel::create($otp_data);
        
            if($otpdata)
            {
                $res['token'] = $user->createToken($otp)->plainTextToken;
                $res['name'] = $user->first_name." ".$user->last_name;
                $res['user_id'] = $user->unique_id;
                $res['otp'] = $otpdata->otp;
               return $this->sendResponse(1, $res, 'OTP sent successfully to Registerd Phone Number!'); 
            }
            else
            {
                 return $this->sendResponse(0, null, 'Somthig Went Wrong'); 
            }
	    }
	}
	
		
    //---------------------------User Registration---------------------------//
    public function register(Request $request): JsonResponse
    {
        $existingUser = Users::where(['email'=> $request->email,'del_status'=>0])->first();
        if ($existingUser && isset($existingUser->email)) {
            $res['exist'] = true;
            return $this->sendResponse(1, $res,'Already Registered! Please Login here');
        }
          
        $existingUser = Users::where(['phone_no'=>$request->phone_no,'del_status'=>0])->first();
        if ($existingUser) {
            $res['exist'] = true;
            return $this->sendResponse(1, $res,'Already Registered! Please Login here');
        }

        $data=[
            'unique_id'=> $this->createRandomKey(),
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'name'=>$request->first_name. " " .$request->last_name,
            'email'=>$request->email,
            'phone_no'=>$request->phone_no,
            'district'=>$request->district,
            'state'=>$request->state,
            'password'=>bcrypt($request->password),
            'status'=>0,
        ];
             
        $user = Users::create($data);
        
        if($user)
        {
            $phone="+91".$request->phone_no;
           $otp = rand(100000, 999999);
            $data = "apikey=NzQ0ODMyNzQ0OTM1Nzc0MjM2NGY3OTRhNTk2MzM1Mzc=&sender=vyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
        	$ch = curl_init('https://api.textlocal.in/send/?');
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	$result22 = curl_exec($ch); // This is the result from the API
        	
            if(empty($result22))
			{
                 return $this->sendResponse(0, null, 'Somthing Went Wrong'); 
				 curl_close($ch);
			}
			else
			{
				curl_close($ch);
    			     
                $otp_data=[
                    "user_id"=>$user->unique_id,
                    "user_type"=>1,
                    "otp"=>$otp,
                    "otp_type"=>'user_register',
                    "sent_at"=>date('Y-m-d H:i:s'),
                ];
            
                $otpdata = UsersOtpVerifyModel::create($otp_data);
            
                if($otpdata)
                {
                   $res['token'] = $user->createToken($request->phone_no)->plainTextToken;
                   $res['name'] = $user->first_name." ".$user->last_name;
                   $res['user_id'] = $user->unique_id;
                   $res['otp'] = $otpdata->otp;
                   $res['exist'] = false;
                   return $this->sendResponse(1, $res, 'OTP Sent Successfully to Registerd Phone Number!'); 
                }
                else
                {
                     return $this->sendResponse(0, null, 'Somthing Went Wrong'); 
                }
    	    }
        }
        else 
        {
            return $this->sendResponse(0, $res, 'Something Went Wrong');
        }
    }
    //---------------------------User Registration---------------------------//
    

    //-------------------------Student Registration-------------------------//
    public function registerStudent(Request $request): JsonResponse
    {
        $res=[];
      
        if(!empty($request->email))
        {
            $existingUser = Users::where(['email'=> $request->email,'del_status'=>0])->first();
            if ($existingUser) {
                $res['email'] = $request->email;
                return $this->sendResponse(0, $res,'email_registered');
            }
        }
                  
        $existingUser = Users::where(['phone_no'=>$request->phone_no,'del_status'=>0])->first();
        if($existingUser) {
            $res['phone_no']= $request->phone_no;
            return $this->sendResponse(0, $res,'phone_registered');
        }
                

        $student_data=[
             'unique_id'=>$this->createRandomKey(),
             'first_name'=>$request->first_name,
             'last_name'=>$request->last_name,
             'name'=>$request->first_name. " " .$request->last_name,
             'fathers_name'=>$request->fathers_name,
             'email'=>$request->email,
             'school_code'=>$request->school_code,
             'phone_no'=>$request->phone_no,
             'password'=>bcrypt($request->password),
             'user_type'=>$request->type,
             'state'=>$request->state,
             'district'=>$request->district,
             'status'=>0,
        ];
             
        $user = Users::create($student_data);
        
        if($user)
        {
            $school = SchoolModel::where('school_code', $request->school_code)->first();
            
            $school_address=[
                "user_id"=>$user->unique_id,
                "address_type"=>2,
                "default_address"=>1,
                "school_code"=>$request->school_code,
                "name"=>$user->first_name." ".$user->last_name,
                // "phone_no"=>$school->school_phone,
                "alternate_phone"=>$request->phone_no,
                // "village"=>$school->village,
                // "city"=>$school->city,
                // "state"=>$school->state,
                // "district"=>$school->distt,
                // "post_office"=>$school->post_office,
                // "pincode"=>$school->zipcode,
                // "address"=>$school->address,
            ];
            
            $useraddress = UserAddressesModel::create($school_address);
            if($useraddress)
            {  
                $phone="+91".$request->phone_no;
               $otp = rand(100000, 999999);
                $data = "apikey=NzQ0ODMyNzQ0OTM1Nzc0MjM2NGY3OTRhNTk2MzM1Mzc=&sender=vyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
            	$ch = curl_init('https://api.textlocal.in/send/?');
            	curl_setopt($ch, CURLOPT_POST, true);
            	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            	$result22 = curl_exec($ch); // This is the result from the API
            	
                if(empty ($result22))
    			{
                     return $this->sendResponse(0, $res, 'Somethig Went Wrong'); 
    				 curl_close($ch);
    			}
    			else
    			{
    				curl_close($ch);
        			     
                    $otp_data=[
                        "user_id"=>$user->unique_id,
                        "user_type"=>1,
                        "otp"=>$otp,
                        "otp_type"=>'student_register',
                        "sent_at"=>date('Y-m-d H:i:s'),
                    ];
            
                    $otpdata = UsersOtpVerifyModel::create($otp_data);
                
                    if($otpdata)
                    {
                       $res['token'] = $user->createToken($request->first_name)->plainTextToken;
                       $res['name'] = $user->first_name." ".$user->last_name;
                       $res['user_id'] = $user->unique_id;
                       $res['school_code'] = $user->school_code;
                       
                       $res['otp'] = $otpdata->otp;
                       return $this->sendResponse(1, $res, 'OTP sent successfully to registerd phone number!'); 
                    }
                    else
                    {
                        return $this->sendResponse(0, null, 'Somthig Went Wrong'); 
                    }
        	    }
            }
            else
            {
                 $msg='Somthig Went Wrong';
                 return $this->sendResponse(0, $res, $msg); 
            }
        }
        else
        {
           $msg='Somthig Went Wrong';
             return $this->sendResponse(0, $res, $msg); 
        }
    }
    //--------------------------Student Registration------------------------//
    
    
    //-------------------------Check Out Registration-----------------------//
    public function checkoutRegistration(Request $request):JsonResponse
    {
        $existingUser = Users::where(['email'=> $request->email,'del_status'=>0])->first();
        if ($existingUser && isset($existingUser->email)) {
            $res['email'] = $request->email;
            return $this->sendResponse(0, $res,' Email Id Already Exist.');
        }
          
        $existingUser = Users::where(['phone_no'=>$request->phone_no,'del_status'=>0])->first();
        if ($existingUser) {
            $res['phone_no'] = $request->phone_no;
            return $this->sendResponse(0, $res,'Phone No Already Exist.');
        }
       
        
        $data=[
            'unique_id'=> $this->createRandomKey(),
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'name'=>$request->first_name. " " .$request->last_name,
            'email'=>$request->email,
            'phone_no'=>$request->phone_no,
            'password'=>bcrypt($request->password),
            'user_type'=>1,
            'state'=>$request->state,
            'district'=>$request->district,
            "post_office"=>$request->post_office,
            "address"=>$request->address,
            "village"=>$request->village,
            "city"=>$request->city,
            "pincode"=>$request->pincode,
            "status"=>0,
        ];
             
        $user = Users::create($data);
        
        if($user) {
            //Update the guest_id to user_id in cart and wishlist
            $myGuestId = $request->user_id;
            $myUserId  = $user->unique_id;
            $updateData = [ 'user_id'=>$myUserId ];
            $cart_items = CartModel::where('user_id', $myGuestId);
            $cart_items->update($updateData);
            $wishlist_items = WishlistModel::where('user_id', $myGuestId);
            $wishlist_items->update($updateData);
            
            
            //Generating & Sending Otp
            $phone="+91".$request->phone_no;
           $otp = rand(100000, 999999);
            $data = "apikey=NzQ0ODMyNzQ0OTM1Nzc0MjM2NGY3OTRhNTk2MzM1Mzc=&sender=vyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
        	$ch = curl_init('https://api.textlocal.in/send/?');
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	$result22 = curl_exec($ch); // This is the result from the API
        	
            if(empty($result22))
			{
                 return $this->sendResponse(0, null, 'Somthing Went Wrong'); 
				 curl_close($ch);
			}
			else
			{
				curl_close($ch);
    			     
                $otp_data=[
                    "user_id"=>$user->unique_id,
                    "user_type"=>1,
                    "otp"=>$otp,
                    "otp_type"=>'checkout_register',
                    "sent_at"=>date('Y-m-d H:i:s'),
                ];
        
                $otpdata = UsersOtpVerifyModel::create($otp_data);
            
                if($otpdata)
                {
                    $res['token'] = $user->createToken($request->phone_no)->plainTextToken;
                    $res['name'] = $user->first_name." ".$user->last_name;
                    $res['user_id'] = $user->unique_id;
                    $res['otp'] = $otpdata->otp;
                    $res['school_code']=$user->school_code;
                    return $this->sendResponse(1, $res, 'OTP Sent Successfully to Registerd Phone Number!'); 
                }
                else
                {
                     return $this->sendResponse(0, null, 'Somthing Went Wrong'); 
                }
    	    }
        }
    }
    //------------------------Check Out Registration-------------------------//
    
    //---------------------------------Login-------------------------------//
    public function login(Request $request): JsonResponse
    {
        if(isset($request->otp_type))
        {
            $phone_no = $request->phone_no;
            //Check phone exist
            $user = Users::where(['phone_no'=>$phone_no, 'del_status' =>0])->first();
            if(!$user) {
                return $this->sendResponse(0, null, "Phone number doesn't exist in our records");
            }
            
            //otp
            $phone="+91".$phone_no;
           $otp = rand(100000, 999999);
            $data = "apikey=NzQ0ODMyNzQ0OTM1Nzc0MjM2NGY3OTRhNTk2MzM1Mzc=&sender=vyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
        	$ch = curl_init('https://api.textlocal.in/send/?');
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	$result22 = curl_exec($ch); // This is the result from the API
        	
            if(empty($result22))
    		{
                 return $this->sendResponse(0, null, 'Somthing Went Wrong'); 
    			 curl_close($ch);
    		}
    		else
    		{
    			curl_close($ch);
    			     
                $otp_data=[
                    "user_id"=>$user->unique_id,
                    "user_type"=>1,
                    "otp"=>$otp,
                    "otp_type"=>'login',
                    "sent_at"=>date('Y-m-d H:i:s'),
                ];
        
                $otpdata = UsersOtpVerifyModel::create($otp_data);
            
                if($otpdata)
                {
                    $res['token'] = $user->createToken($otp)->plainTextToken;
                    $res['name'] = $user->first_name." ".$user->last_name;
                    $res['user_id'] = $user->unique_id;
                    $res['otp'] = $otpdata->otp;
                   return $this->sendResponse(1, $res, 'OTP sent successfully to Registerd Phone Number!'); 
                }
                else
                {
                     return $this->sendResponse(0, null, 'Somthig Went Wrong'); 
                }
    	    }
        }
        else
        {
            //Check email or phone exist
            $user = Users::orWhere(['email' => $request->email,'phone_no'=>$request->email])->where('del_status',0)->first();
            
            if(!$user) {
                return $this->sendResponse(0, null, " Email or Phone number doesn't exist in our records");
            }
            elseif(!Hash::check($request->password, $user->password))
            {
                return $this->sendResponse(0, null, 'Invalid Password');
            }
            elseif($user->status==0) {
                $phone_no=$request->email;
                //Check phone exist
                $user = Users::where(['phone_no'=>$phone_no, 'del_status' =>0])->first();
                if(!$user) {
                    return $this->sendResponse(0, null, "Phone number doesn't exist in our records");
                }
                
                //otp
                $phone="+91".$request->phone_no;
               $otp = rand(100000, 999999);
                $data = "apikey=NzQ0ODMyNzQ0OTM1Nzc0MjM2NGY3OTRhNTk2MzM1Mzc=&sender=vyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
            	$ch = curl_init('https://api.textlocal.in/send/?');
            	curl_setopt($ch, CURLOPT_POST, true);
            	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            	$result22 = curl_exec($ch); // This is the result from the API
            	
                if(empty($result22))
    			{
                     return $this->sendResponse(0, null, 'Somthing Went Wrong'); 
    				 curl_close($ch);
    			}
    			else
    			{
    				curl_close($ch);
        			     
                    $otp_data=[
                        "user_id"=>$user->unique_id,
                        "user_type"=>1,
                        "otp"=>$otp,
                        "otp_type"=>'login',
                        "sent_at"=>date('Y-m-d H:i:s'),
                    ];
            
                    $otpdata = UsersOtpVerifyModel::create($otp_data);
                
                    if($otpdata)
                    {
                        $res['token'] = $user->createToken($otp)->plainTextToken;
                        $res['name'] = $user->first_name." ".$user->last_name;
                        $res['user_id'] = $user->unique_id;
                        $res['otp'] = $otpdata->otp;
                        $res['status'] = $user->status;
                        return $this->sendResponse(1, $res, 'Otp verification Pending');
                    }
                    else
                    {
                        return $this->sendResponse(0, null, 'Somthig Went Wrong'); 
                    }
        	    }
                
            }
            else
            {
                //Update the guest_id to user_id in cart and wishlist
                $myGuestId = $request->user_id;
                $myUserId  = $user->unique_id;
                $updateData = [
                    'user_id'=>$myUserId,
                    'session_type'=>'user'
                ];
                
                
                   
                $check_cart_items = CartModel::where('user_id', $myGuestId)->get();
                $count=count($check_cart_items);
                for($i=0;$i<$count;$i++)
                {
                     $check_cart_items_guest = CartModel::where(['user_id'=>$myUserId,"product_id"=>$check_cart_items[$i]->product_id])->first();
                     if($check_cart_items_guest)
                     {
                          $item = CartModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items[$i]->product_id])->first();
                          $deleted = $item->delete();
                     }
                     else
                     {
                           $cart_items = CartModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items[$i]->product_id]);
                           $cart_items->update($updateData);
                     }
                }
                
                
                $check_cart_items_wish = WishlistModel::where('user_id', $myGuestId)->get();
                $countw=count($check_cart_items_wish);
                for($i=0;$i<$countw;$i++)
                {
                     $check_cart_items_guest_wish = WishlistModel::where(['user_id'=>$myUserId,"product_id"=>$check_cart_items_wish[$i]->product_id])->first();
                     if($check_cart_items_guest_wish)
                     {
                          $item_wish = WishlistModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items_wish[$i]->product_id])->first();
                          $wishdeleted = $item_wish->delete();
                     }
                     else
                     {
                           $cart_items_wish = WishlistModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items_wish[$i]->product_id]);
                           $cart_items_wish->update($updateData);
                     }
                }
            
            
            
                $token=$user->createToken($request->email)->plainTextToken;
                $updateTokenData=['remember_token'=>$token];
                $user->update($updateTokenData);
                
                
                $res['token'] = $token;
                $res['user_id'] = $user->unique_id;
                $res['name'] = $user->first_name." ".$user->last_name;
                $res['school_code'] = $user->school_code;
                $res['status'] = $user->status;
                
                $response = ['success' => 1,'message' => 'User is logged in successfully','data' => $res,];
                return response()->json($response, 200);
            }
        }
    }
    //---------------------------------Login-------------------------------//
    
    //verifyOtp
    public function verifyOtp(Request $request):JsonResponse
    {
        $where=[
            "user_id"=>$request->user_id,
            "user_type"=>1,
            "otp"=>$request->otp,
            "otp_type"=>$request->otp_type,
            // "status"=>1,
        ];
        $user = Users::where('unique_id',$request->user_id)->first();
        $user_update = Users::where('unique_id',$request->user_id)->first();
         $checkotp = UsersOtpVerifyModel::where($where)->orderBy('id', 'DESC')->first();
         if($checkotp)
         {
            $status_updated = $user_update->update(['status'=>1]);
            $res = [
                'token'=>$user->createToken($request->otp)->plainTextToken,
                'name'=>$user->first_name." ".$user->last_name,
                'user_id'=>$user->unique_id,
                'school_code'=>$user->school_code
            ];
            
            if($status_updated) 
            {
                if($request->otp_type=="user_register")
                {
                    
                    $emaildata=[
                          "name"=>$user->first_name." ".$user->last_name,
                        ];
                    
                   Mail::to($user->email)->send(new RegisterMail($emaildata));
                
                }
                
                return $this->sendResponse(1, $res, 'OTP Verified Successfullyr!');
            }
            else
            {
                return $this->sendResponse(1, null, 'Something Went Wrong');
            }
         }
         else
         {
             return $this->sendResponse(0, null, 'Invalid OTP'); 
         }
    }
    
    
    //---------------------------Forgot Password-----------------------------//
    //sendPasswordOtp
    public function sendPasswordOtp(Request $request):JsonResponse
    {
        $user = Users::where('phone_no',$request->phone_no) ->where('del_status', 0)->first();
        
        if(!$user)
        {
             return $this->sendResponse(0, null,'Invalid Phone Number');
        }
        elseif($user)
        {
            $phone="+91".$request->phone_no;
            $otp = rand(100000, 999999);
            $data = "apikey=NzQ0ODMyNzQ0OTM1Nzc0MjM2NGY3OTRhNTk2MzM1Mzc=&sender=vyapr&numbers=$phone&message=$otp is your OTP for www.evyapari.com forgot password. Please do not share it with anyone. Regards, Evyapari.com";
        	$ch = curl_init('https://api.textlocal.in/send/?');
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	$result22 = curl_exec($ch); // This is the result from the API
        	
            if(empty($result22))
			{
                 return $this->sendResponse(0, null, 'Somthing Went Wrong'); 
				 curl_close($ch);
			}
			else
			{
				curl_close($ch);
    			     
                $otp_data=[
                    "user_id"=>$user->unique_id,
                    "user_type"=>1,
                    "otp"=>$otp,
                    "otp_type"=>'forgot_password',
                    "sent_at"=>date('Y-m-d H:i:s'),
                ];
        
                $otpdata = UsersOtpVerifyModel::create($otp_data);
            
                if($otpdata)
                {
                   $res['token'] = $user->createToken($request->phone_no)->plainTextToken;
                   $res['name'] = $user->first_name." ".$user->last_name;
                   $res['user_id'] = $user->unique_id;
                   $res['otp'] = $otpdata->otp;
                   return $this->sendResponse(1, $res, 'OTP sent successfully to Registerd Phone Number!'); 
                }
                else
                {
                     return $this->sendResponse(0, null, 'Somthig Went Wrong'); 
                }
    	    }
        }
        else
        {
            return $this->sendResponse(0, null, 'Somthig Went Wrong'); 
        }
    }
    
    
    //resetPassword
    public function resetPassword(Request $request):JsonResponse
    {
        $user = Users::where('unique_id',$request->user_id)->first();
        $user_updated = $user->update(['password'=>bcrypt($request->new_password),'status'=>1]);
        if($user_updated)
        {
            return $this->sendResponse(1, null, 'Password Reset Successfully'); 
        }
        else
        {
            return $this->sendResponse(1, $res, 'Something Went Wrong'); 
        }
    }
    //----------------------Forgot Password--------------------------------//
    
    
    //----------------------------Change Password--------------------------//
    public function changePassword(Request $request) : jsonResponse
    {
        // $email = $request->input('email');
        $user_id=$request->user_id;
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');
    
        // Retrieve the user by id
        $user = Users::where('unique_id', $user_id)->first();
    
        // Check if the user exists
        if (!$user) {
            return $this->sendResponse(0, null, 'user does not exist');
        }
    
        // Use Laravel's built-in Auth system to verify the old password
        if (!Hash::check($currentPassword, $user->password)) {
            return $this->sendResponse(0, null, 'Current Password Is Incorrect');
        }
        
        // Update the user's password
        $user->password = bcrypt($newPassword);
        $user->save();
    
         return $this->sendResponse(1, null, 'Password changed successfully');
    }
    
    
     public function decodeToken(Request $request):jsonResponse
     {
      $base64Token=$request->token;  
 $base64Token = str_replace('?token=', '', $base64Token);
        // TestModel::create(['email'=>"abc@gmail.com",'phone_no'=>'9887675656','token'=>$base64Token]);
         
        $decodedToken = base64_decode($base64Token);
        // echo $decodedToken;
        if ($decodedToken === false) {
            return  $this->sendResponse(0, null,'Invalid Token!');
        }
      
        $data = json_decode($decodedToken, true);
        //echo $data;
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->sendResponse(0, null,'Invalid JSON in token'.$base64Token);
        }

        // Step 3: Extract the email field
        $email = $data['email'] ?? NULL;
        $phone = $data['phone'] ;
        $schoolCode = $data['school_code'];
        $fullName = $data['student_name'];
        $state = $data['student_name'];
        $school_code = $data['school_code'];
        $father_name = $data['father_name']?? NULL;
        $billing_address = $data['billing_address'] ?? NULL;
        $billing_city = $data['billing_city'] ?? NULL;
        $billing_state = $data['billing_state'] ?? NULL;
        $billing_district = $data['billing_district'] ?? NULL;
        $billing_pincode = $data['billing_pincode'] ?? NULL;
     
        $shipping_address = $data['shipping_address'] ?? NULL;
        $shipping_city = $data['shipping_city'] ?? NULL;
        $shipping_state = $data['shipping_state'] ?? NULL;
        $shipping_district = $data['shipping_district'] ?? NULL;
        $shipping_pincode = $data['shipping_pincode'] ?? NULL;
        if($billing_state=='HP' || $shipping_state=='HP'||$billing_state=='H.P.' || $shipping_state=='H.P.')
        {
            $billing_state='Himachal Pradesh';
            $shipping_state='Himachal Pradesh';
        }
        if(strlen($billing_pincode) < 6)
        {
         $billing_pincode=NULL;
        }
        if(strlen($shipping_pincode) < 6)
        {
            if($billing_pincode){
                $shipping_pincode=$billing_pincode;
            }
            else
            {
                   $shipping_pincode=NULL;
            }
        }
        if(!$shipping_address)
        {
            $shipping_address=$billing_address;
        }
        if(!$shipping_city)
        {
            $shipping_city=$billing_city;
        }
        if(!$shipping_district)
        {
            $shipping_district=$billing_district;
        }
           if(!$shipping_state)
        {
            $shipping_state=$billing_state;
        }
   
        $decodedPassword = base64_decode($data['password']);   
        if (empty($fullName)) {
            return  $this->sendResponse(0, null,'Student Name is required');
        }
        // Trim and split the name by spaces
        $nameParts = array_filter(explode(' ', trim($fullName))); // Removes extra spaces
        $nameParts = array_values($nameParts); // Reindex the array

        // Extract the parts of the name
        $lastName = count($nameParts) > 1 ? $nameParts[count($nameParts) - 1] : ''; // Last name
        $firstName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 0, -1)) : $nameParts[0]; // First name + middle name

        // return response()->json([
        //     'first_name' => $firstName,
        //     'last_name' => $lastName
        // ]);
  
        // return $this->sendResponse(1,$decodedToken, 'Token is valid');
        $existingSchool = SchoolModel::where(['school_code'=>$school_code,'del_status'=>0])->first();
    
        if(!$existingSchool) {
            return $this->sendResponse(0, null,'School not found at this school Code!');
        }
            $res=[];
     
            //Check email or phone exist
            // $user = Users::orWhere(['email' => $email])->where('del_status',0)->first();
            
            $user = Users::where(['email' => $email,'status'=>1,'userfrom'=>1,'del_status'=>0])->first();
            if($user) {
            $userupdatepass = Users::where(['email' => $email,'status'=>1,'userfrom'=>1,'del_status'=>0]);
            $userupdatepass->update(['password'=>bcrypt($decodedPassword)]);
            }
            
            if(!$user) {
                $student_data=[
                     'unique_id'=>$this->createRandomKey(),
                     'first_name'=>$firstName,
                     'last_name'=>$lastName,
                     'name'=>$fullName,
                     'fathers_name'=>$father_name,
                     'email'=>$email,
                     'school_code'=>$school_code,
                     'phone_no'=>$phone,
                     'password'=>bcrypt($decodedPassword),
                     'user_type'=>2,
                     'address'=>$billing_address,
                     'state'=>$billing_state,
                     'district'=>$billing_district,
                     'pincode'=>$billing_pincode,
                     'city'=>$billing_city,      
                     'status'=>1,
                     'userfrom'=>1,
                ];
                
                $userCreated = Users::create($student_data);
                $usertokenCreated =  TestModel::create(['email'=>$email,'phone_no'=>$phone,'token'=>$base64Token]);
                if($userCreated)
                {
                        if(  $shipping_address != NULL || $shipping_city != NULL || $shipping_state != NULL || $shipping_district != NULL || $shipping_pincode !=NULL)
                        {
                            $school = SchoolModel::where('school_code', $school_code)->first();
                            // $shipping_address = [
                            //          "user_id"=>$userCreated->unique_id,
                            //          "address_type"=>1,
                            //          "default_address"=>1,
                            //          "name"=>$userCreated->first_name." ".$userCreated->last_name,
                            //         "phone_no"=>$phone,
                            //         "address"=>$shipping_address,
                            //         "city"=>$shipping_city,
                            //         "state"=>$shipping_state,
                            //         "district"=>$shipping_district,
                            //         "pincode"=>$shipping_pincode,
                            //     ];
                            $school_address=[
                                "user_id"=>$userCreated->unique_id,
                                "address_type"=>2,
                                "default_address"=>1,
                                "school_code"=>$school_code,
                                "name"=>$userCreated->first_name." ".$userCreated->last_name,
                                // "phone_no"=>$school->school_phone,
                                "alternate_phone"=>$userCreated->phone_no,
                                // "village"=>$school->village,
                                // "city"=>$school->city,
                                // "state"=>$school->state,
                                // "district"=>$school->distt,
                                // "post_office"=>$school->post_office,
                                // "pincode"=>$school->zipcode,
                                // "address"=>$school->address,
                            ];
                            // $userdefault_address = UserAddressesModel::create($shipping_address);
                            $useraddress = UserAddressesModel::create($school_address);
                        }
                        else 
                        {
                            $school = SchoolModel::where('school_code', $school_code)->first();
                            
                            $school_address=[
                                "user_id"=>$userCreated->unique_id,
                                "address_type"=>2,
                                "default_address"=>1,
                                "school_code"=>$school_code,
                                "name"=>$userCreated->first_name." ".$userCreated->last_name,
                                // "phone_no"=>$school->school_phone,
                                "alternate_phone"=>$userCreated->phone_no,
                                // "village"=>$school->village,
                                // "city"=>$school->city,
                                // "state"=>$school->state,
                                // "district"=>$school->distt,
                                // "post_office"=>$school->post_office,
                                // "pincode"=>$school->zipcode,
                                // "address"=>$school->address,
                            ];
                            
                            $useraddress = UserAddressesModel::create($school_address);
                        }
                      
                        if($useraddress)
                        {  
                            $phone="+91".$phone;
                            $otp = rand(100000, 999999);
             
                    			     
                                $otp_data=[
                                    "user_id"=>$userCreated->unique_id,
                                    "user_type"=>2,
                                    "otp"=>$otp,
                                    "otp_type"=>'student_register',
                                    "sent_at"=>date('Y-m-d H:i:s'),
                                ];
                        
                                $otpdata = UsersOtpVerifyModel::create($otp_data);
                            
                                if($otpdata)
                                {
                                  $res['token'] = $userCreated->createToken($userCreated->first_name)->plainTextToken;
                                  $res['name'] = $userCreated->first_name." ".$userCreated->last_name;
                                  $res['user_id'] = $userCreated->unique_id;
                                  $res['school_code'] = $userCreated->school_code;
                                   
                                  $res['otp'] = $otpdata->otp;
                                  return $this->sendResponse(1, $res, 'User registered successfully!'); 
                                }
                                else
                                {
                                    return $this->sendResponse(0, null, 'Somthig Went Wrong'); 
                                }
                    	   // }
                        }
                        else
                        {
                             $msg='Somthig Went Wrong';
                             return $this->sendResponse(0, $res, $msg); 
                        }
                    }
                else
                {
                  $msg='Somthig Went Wrong';
                     return $this->sendResponse(0, $res, $msg); 
                }
                return $this->sendResponse(0, null, " Email or Phone number doesn't exist in our records");
            }
            elseif(!Hash::check($decodedPassword, $user->password))
            {
                return $this->sendResponse(0, null, 'Invalid Password');
            }
            else
            {
                //Update the guest_id to user_id in cart and wishlist
                $myGuestId = $user->unique_id;
                $myUserId  = $user->unique_id;
                $updateData = [
                    'user_id'=>$myUserId,
                    'session_type'=>'user'
                ];
                
                
                   
                $check_cart_items = CartModel::where('user_id', $myGuestId)->get();
                $count=count($check_cart_items);
                for($i=0;$i<$count;$i++)
                {
                     $check_cart_items_guest = CartModel::where(['user_id'=>$myUserId,"product_id"=>$check_cart_items[$i]->product_id])->first();
                     if($check_cart_items_guest)
                     {
                          $item = CartModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items[$i]->product_id])->first();
                          $deleted = $item->delete();
                     }
                     else
                     {
                          $cart_items = CartModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items[$i]->product_id]);
                          $cart_items->update($updateData);
                     }
                }
                
                
                $check_cart_items_wish = WishlistModel::where('user_id', $myGuestId)->get();
                $countw=count($check_cart_items_wish);
                for($i=0;$i<$countw;$i++)
                {
                     $check_cart_items_guest_wish = WishlistModel::where(['user_id'=>$myUserId,"product_id"=>$check_cart_items_wish[$i]->product_id])->first();
                     if($check_cart_items_guest_wish)
                     {
                          $item_wish = WishlistModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items_wish[$i]->product_id])->first();
                          $wishdeleted = $item_wish->delete();
                     }
                     else
                     {
                          $cart_items_wish = WishlistModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items_wish[$i]->product_id]);
                          $cart_items_wish->update($updateData);
                     }
                }
            
            
            
                $token=$user->createToken($email)->plainTextToken;
                $updateTokenData=['remember_token'=>$token];
                $user->update($updateTokenData);
                
                
                $res['token'] = $token;
                $res['user_id'] = $user->unique_id;
                $res['name'] = $user->first_name." ".$user->last_name;
                $res['school_code'] = $user->school_code;
                $res['status'] = $user->status;
                
                $response = ['success' => 1,'message' => 'User is logged in successfully','data' => $res,];
                return response()->json($response, 200);
            }
              
    
    }
  public function decodeTokentest(Request $request): JsonResponse
      {
        $base64Token = $request->input('token');
        $decodedToken = base64_decode($base64Token);
        // echo $decodedToken;
        if ($decodedToken === false) {
            return  $this->sendResponse(0, null,'Invalid Token!');
        }
      
        $data = json_decode($decodedToken, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->sendResponse(0, null,'Invalid JSON in token');
        }

        // Step 3: Extract the email field
        $email = $data['email'] ;
        $phone = $data['phone'] ;
        $schoolCode = $data['school_code'];
        $fullName = $data['student_name'];
        $state = $data['student_name'];
        $school_code = $data['school_code'];
        $father_name = $data['father_name'];
        $billing_address = $data['billing_address'] ?? NULL;
        $billing_city = $data['billing_city'] ?? NULL;
        $billing_state = $data['billing_state'] ?? NULL;
        $billing_district = $data['billing_district'] ?? NULL;
        $billing_pincode = $data['billing_pincode'] ?? NULL;
     
        $shipping_address = $data['shipping_address'] ?? NULL;
        $shipping_city = $data['shipping_city'] ?? NULL;
        $shipping_state = $data['shipping_state'] ?? NULL;
        $shipping_district = $data['shipping_district'] ?? NULL;
        $shipping_pincode = $data['shipping_pincode'] ?? NULL;
        if($billing_state=='HP' || $shipping_state=='HP')
        {
            $billing_state='Himachal Pradesh';
            $shipping_state='Himachal Pradesh';
        }
        if(strlen($billing_pincode) < 6)
        {
         $billing_pincode=NULL;
        }
        if(strlen($shipping_pincode) < 6)
        {
            if($billing_pincode){
                $shipping_pincode=$billing_pincode;
            }
            else
            {
                   $shipping_pincode=NULL;
            }
        }
        if(!$shipping_address)
        {
            $shipping_address=$billing_address;
        }
        if(!$shipping_city)
        {
            $shipping_city=$billing_city;
        }
        if(!$shipping_district)
        {
            $shipping_district=$billing_district;
        }
           if(!$shipping_state)
        {
            $shipping_state=$billing_state;
        }
    //     echo    $billing_address ;
    //   echo $billing_city;
    //   echo $billing_state ;
    //   echo $billing_district ;
    //   echo $billing_pincode ;
     
    //   echo  $shipping_address ;
    //   echo  $shipping_city ;
    //  echo   $shipping_state;
    //  echo   $shipping_district  ;
    //   echo  $shipping_pincode ;
        $decodedPassword = base64_decode($data['password']);   
        if (empty($fullName)) {
            return response()->json(['error' => 'Student name is required'], 400);
        }
        // Trim and split the name by spaces
        $nameParts = array_filter(explode(' ', trim($fullName))); // Removes extra spaces
        $nameParts = array_values($nameParts); // Reindex the array

        // Extract the parts of the name
        $lastName = count($nameParts) > 1 ? $nameParts[count($nameParts) - 1] : ''; // Last name
        $firstName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 0, -1)) : $nameParts[0]; // First name + middle name

        // return response()->json([
        //     'first_name' => $firstName,
        //     'last_name' => $lastName
        // ]);
  
        // return $this->sendResponse(1,$decodedToken, 'Token is valid');
        $existingSchool = SchoolModel::where(['school_code'=>$school_code,'del_status'=>0])->first();
    
        if(!$existingSchool) {
            return $this->sendResponse(0, null,'School not found at this school Code!');
        }
            $res=[];
     
            //Check email or phone exist
            $user = Users::orWhere(['email' => $email])->where('del_status',0)->first();
            if(!$user) {
                $student_data=[
                     'unique_id'=>$this->createRandomKey(),
                     'first_name'=>$firstName,
                     'last_name'=>$lastName,
                     'name'=>$fullName,
                     'fathers_name'=>$father_name,
                     'email'=>$email,
                     'school_code'=>$school_code,
                     'phone_no'=>$phone,
                     'password'=>bcrypt($decodedPassword),
                     'user_type'=>2,
                     'address'=>$billing_address,
                     'state'=>$billing_state,
                     'district'=>$billing_district,
                     'pincode'=>$billing_pincode,
                     'city'=>$billing_city,      
                     'status'=>1,
                     'userfrom'=>1,
                     'lmstoken'=>$base64Token,
                ];
             
                $userCreated = Users::create($student_data);
        
                if($userCreated)
                {
                        if(  $shipping_address != NULL || $shipping_city != NULL || $shipping_state != NULL || $shipping_district != NULL || $shipping_pincode !=NULL)
                        {
                            $school = SchoolModel::where('school_code', $school_code)->first();
                            // $shipping_address = [
                            //          "user_id"=>$userCreated->unique_id,
                            //          "address_type"=>1,
                            //          "default_address"=>1,
                            //          "name"=>$userCreated->first_name." ".$userCreated->last_name,
                            //         "phone_no"=>$phone,
                            //         "address"=>$shipping_address,
                            //         "city"=>$shipping_city,
                            //         "state"=>$shipping_state,
                            //         "district"=>$shipping_district,
                            //         "pincode"=>$shipping_pincode,
                            //     ];
                            $school_address=[
                                "user_id"=>$userCreated->unique_id,
                                "address_type"=>2,
                                "default_address"=>1,
                                "school_code"=>$school_code,
                                "name"=>$userCreated->first_name." ".$userCreated->last_name,
                                // "phone_no"=>$school->school_phone,
                                "alternate_phone"=>$request->phone_no,
                                // "village"=>$school->village,
                                // "city"=>$school->city,
                                // "state"=>$school->state,
                                // "district"=>$school->distt,
                                // "post_office"=>$school->post_office,
                                // "pincode"=>$school->zipcode,
                                // "address"=>$school->address,
                            ];
                            // $userdefault_address = UserAddressesModel::create($shipping_address);
                            $useraddress = UserAddressesModel::create($school_address);
                        }
                        else 
                        {
                            $school = SchoolModel::where('school_code', $school_code)->first();
                            
                            $school_address=[
                                "user_id"=>$userCreated->unique_id,
                                "address_type"=>2,
                                "default_address"=>1,
                                "school_code"=>$school_code,
                                "name"=>$userCreated->first_name." ".$userCreated->last_name,
                                // "phone_no"=>$school->school_phone,
                                "alternate_phone"=>$request->phone_no,
                                // "village"=>$school->village,
                                // "city"=>$school->city,
                                // "state"=>$school->state,
                                // "district"=>$school->distt,
                                // "post_office"=>$school->post_office,
                                // "pincode"=>$school->zipcode,
                                // "address"=>$school->address,
                            ];
                            
                            $useraddress = UserAddressesModel::create($school_address);
                        }
                      
                        if($useraddress)
                        {  
                            $phone="+91".$phone;
                            $otp = rand(100000, 999999);
             
                    			     
                                $otp_data=[
                                    "user_id"=>$userCreated->unique_id,
                                    "user_type"=>2,
                                    "otp"=>$otp,
                                    "otp_type"=>'student_register',
                                    "sent_at"=>date('Y-m-d H:i:s'),
                                ];
                        
                                $otpdata = UsersOtpVerifyModel::create($otp_data);
                            
                                if($otpdata)
                                {
                                  $res['token'] = $userCreated->createToken($userCreated->first_name)->plainTextToken;
                                  $res['name'] = $userCreated->first_name." ".$userCreated->last_name;
                                  $res['user_id'] = $userCreated->unique_id;
                                  $res['school_code'] = $userCreated->school_code;
                                   
                                  $res['otp'] = $otpdata->otp;
                                  return $this->sendResponse(1, $res, 'User registered successfully!'); 
                                }
                                else
                                {
                                    return $this->sendResponse(0, null, 'Somthig Went Wrong'); 
                                }
                    	   // }
                        }
                        else
                        {
                             $msg='Somthig Went Wrong';
                             return $this->sendResponse(0, $res, $msg); 
                        }
                    }
                else
                {
                  $msg='Somthig Went Wrong';
                     return $this->sendResponse(0, $res, $msg); 
                }
                return $this->sendResponse(0, null, " Email or Phone number doesn't exist in our records");
            }
            elseif(!Hash::check($decodedPassword, $user->password))
            {
                return $this->sendResponse(0, null, 'Invalid Password');
            }
            else
            {
                //Update the guest_id to user_id in cart and wishlist
                $myGuestId = $request->user_id;
                $myUserId  = $user->unique_id;
                $updateData = [
                    'user_id'=>$myUserId,
                    'session_type'=>'user'
                ];
                
                
                   
                $check_cart_items = CartModel::where('user_id', $myGuestId)->get();
                $count=count($check_cart_items);
                for($i=0;$i<$count;$i++)
                {
                     $check_cart_items_guest = CartModel::where(['user_id'=>$myUserId,"product_id"=>$check_cart_items[$i]->product_id])->first();
                     if($check_cart_items_guest)
                     {
                          $item = CartModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items[$i]->product_id])->first();
                          $deleted = $item->delete();
                     }
                     else
                     {
                          $cart_items = CartModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items[$i]->product_id]);
                          $cart_items->update($updateData);
                     }
                }
                
                
                $check_cart_items_wish = WishlistModel::where('user_id', $myGuestId)->get();
                $countw=count($check_cart_items_wish);
                for($i=0;$i<$countw;$i++)
                {
                     $check_cart_items_guest_wish = WishlistModel::where(['user_id'=>$myUserId,"product_id"=>$check_cart_items_wish[$i]->product_id])->first();
                     if($check_cart_items_guest_wish)
                     {
                          $item_wish = WishlistModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items_wish[$i]->product_id])->first();
                          $wishdeleted = $item_wish->delete();
                     }
                     else
                     {
                          $cart_items_wish = WishlistModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items_wish[$i]->product_id]);
                          $cart_items_wish->update($updateData);
                     }
                }
            
            
            
                $token=$user->createToken($email)->plainTextToken;
                $updateTokenData=['remember_token'=>$token];
                $user->update($updateTokenData);
                
                
                $res['token'] = $token;
                $res['user_id'] = $user->unique_id;
                $res['name'] = $user->first_name." ".$user->last_name;
                $res['school_code'] = $user->school_code;
                $res['status'] = $user->status;
                
                $response = ['success' => 1,'message' => 'User is logged in successfully','data' => $res,];
                return response()->json($response, 200);
            }
              
    
    }
    
    
     public function logintest(Request $request): JsonResponse
    {
        if(isset($request->otp_type))
        {
            $phone_no = $request->phone_no;
            //Check phone exist
            $user = Users::where(['phone_no'=>$phone_no, 'del_status' =>0])->first();
            if(!$user) {
                return $this->sendResponse(0, null, "Phone number doesn't exist in our records");
            }
            
            //otp
            $phone="+91".$phone_no;
           $otp = rand(100000, 999999);
            $data = "apikey=NzQ0ODMyNzQ0OTM1Nzc0MjM2NGY3OTRhNTk2MzM1Mzc=&sender=vyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
        	$ch = curl_init('https://api.textlocal.in/send/?');
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	$result22 = curl_exec($ch); // This is the result from the API
        	
            if(empty($result22))
    		{
                 return $this->sendResponse(0, null, 'Somthing Went Wrong'); 
    			 curl_close($ch);
    		}
    		else
    		{
    			curl_close($ch);
    			     
                $otp_data=[
                    "user_id"=>$user->unique_id,
                    "user_type"=>1,
                    "otp"=>$otp,
                    "otp_type"=>'login',
                    "sent_at"=>date('Y-m-d H:i:s'),
                ];
        
                $otpdata = UsersOtpVerifyModel::create($otp_data);
            
                if($otpdata)
                {
                    $res['token'] = $user->createToken($otp)->plainTextToken;
                    $res['name'] = $user->first_name." ".$user->last_name;
                    $res['user_id'] = $user->unique_id;
                    $res['otp'] = $otpdata->otp;
                   return $this->sendResponse(1, $res, 'OTP sent successfully to Registerd Phone Number!'); 
                }
                else
                {
                     return $this->sendResponse(0, null, 'Somthig Went Wrong'); 
                }
    	    }
        }
        else
        {
            //Check email or phone exist
            $user = Users::orWhere(['email' => $request->email,'phone_no'=>$request->email])->where('del_status',0)->first();
            
            if(!$user) {
                return $this->sendResponse(0, null, " Email or Phone number doesn't exist in our records");
            }
            elseif($user->userfrom==1){
                     $users = Users::orWhere(['email' => $request->email,'phone_no'=>$request->email])->where('del_status',0)->get();
                      if(!$users) {
                            return $this->sendResponse(0, null, " Email or Phone number doesn't exist in our records");
                        }
                        $user = null;
                        foreach ($users as $newuser) {
                            if (Hash::check($request->password, $newuser->password)) {
                             $user = $newuser;
                             break;
                            }
                        }
                         if($user==null) {
                            return $this->sendResponse(0, null, "Invalid Password");
                        }elseif(!Hash::check($request->password, $user->password))
                        {
                            return $this->sendResponse(0, null, 'Invalid Password');
                        }
                        elseif($user->status==0) {
                            $phone_no=$request->email;
                            //Check phone exist
                            $user = Users::where(['phone_no'=>$phone_no, 'del_status' =>0])->first();
                            if(!$user) {
                                return $this->sendResponse(0, null, "Phone number doesn't exist in our records");
                            }
                            
                            //otp
                            $phone="+91".$request->phone_no;
                          $otp = rand(100000, 999999);
                            $data = "apikey=NzQ0ODMyNzQ0OTM1Nzc0MjM2NGY3OTRhNTk2MzM1Mzc=&sender=vyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
                        	$ch = curl_init('https://api.textlocal.in/send/?');
                        	curl_setopt($ch, CURLOPT_POST, true);
                        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        	$result22 = curl_exec($ch); // This is the result from the API
                        	
                            if(empty($result22))
                			{
                                 return $this->sendResponse(0, null, 'Somthing Went Wrong'); 
                				 curl_close($ch);
                			}
                			else
                			{
                				curl_close($ch);
                    			     
                                $otp_data=[
                                    "user_id"=>$user->unique_id,
                                    "user_type"=>1,
                                    "otp"=>$otp,
                                    "otp_type"=>'login',
                                    "sent_at"=>date('Y-m-d H:i:s'),
                                ];
                        
                                $otpdata = UsersOtpVerifyModel::create($otp_data);
                            
                                if($otpdata)
                                {
                                    $res['token'] = $user->createToken($otp)->plainTextToken;
                                    $res['name'] = $user->first_name." ".$user->last_name;
                                    $res['user_id'] = $user->unique_id;
                                    $res['otp'] = $otpdata->otp;
                                    $res['status'] = $user->status;
                                    return $this->sendResponse(1, $res, 'Otp verification Pending');
                                }
                                else
                                {
                                    return $this->sendResponse(0, null, 'Somthig Went Wrong'); 
                                }
                    	    }
                            
                        }
                        else
                        {
                            //Update the guest_id to user_id in cart and wishlist
                            $myGuestId = $request->user_id;
                            $myUserId  = $user->unique_id;
                            $updateData = [
                                'user_id'=>$myUserId,
                                'session_type'=>'user'
                            ];
                            
                            
                               
                            $check_cart_items = CartModel::where('user_id', $myGuestId)->get();
                            $count=count($check_cart_items);
                            for($i=0;$i<$count;$i++)
                            {
                                 $check_cart_items_guest = CartModel::where(['user_id'=>$myUserId,"product_id"=>$check_cart_items[$i]->product_id])->first();
                                 if($check_cart_items_guest)
                                 {
                                      $item = CartModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items[$i]->product_id])->first();
                                      $deleted = $item->delete();
                                 }
                                 else
                                 {
                                      $cart_items = CartModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items[$i]->product_id]);
                                      $cart_items->update($updateData);
                                 }
                            }
                            
                            
                            $check_cart_items_wish = WishlistModel::where('user_id', $myGuestId)->get();
                            $countw=count($check_cart_items_wish);
                            for($i=0;$i<$countw;$i++)
                            {
                                 $check_cart_items_guest_wish = WishlistModel::where(['user_id'=>$myUserId,"product_id"=>$check_cart_items_wish[$i]->product_id])->first();
                                 if($check_cart_items_guest_wish)
                                 {
                                      $item_wish = WishlistModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items_wish[$i]->product_id])->first();
                                      $wishdeleted = $item_wish->delete();
                                 }
                                 else
                                 {
                                      $cart_items_wish = WishlistModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items_wish[$i]->product_id]);
                                      $cart_items_wish->update($updateData);
                                 }
                            }
                        
                        
                        
                            $token=$user->createToken($request->email)->plainTextToken;
                            $updateTokenData=['remember_token'=>$token];
                            $user->update($updateTokenData);
                            
                            
                            $res['token'] = $token;
                            $res['user_id'] = $user->unique_id;
                            $res['name'] = $user->first_name." ".$user->last_name;
                            $res['school_code'] = $user->school_code;
                            $res['status'] = $user->status;
                            
                            $response = ['success' => 1,'message' => 'User is logged in successfully','data' => $res,];
                            return response()->json($response, 200);
                        }
                    }
            elseif(!Hash::check($request->password, $user->password))
            {
                return $this->sendResponse(0, null, 'Invalid Password');
            }
            elseif($user->status==0) {
                $phone_no=$request->email;
                //Check phone exist
                $user = Users::where(['phone_no'=>$phone_no, 'del_status' =>0])->first();
                if(!$user) {
                    return $this->sendResponse(0, null, "Phone number doesn't exist in our records");
                }
                
                //otp
                $phone="+91".$request->phone_no;
               $otp = rand(100000, 999999);
                $data = "apikey=NzQ0ODMyNzQ0OTM1Nzc0MjM2NGY3OTRhNTk2MzM1Mzc=&sender=vyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
            	$ch = curl_init('https://api.textlocal.in/send/?');
            	curl_setopt($ch, CURLOPT_POST, true);
            	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            	$result22 = curl_exec($ch); // This is the result from the API
            	
                if(empty($result22))
    			{
                     return $this->sendResponse(0, null, 'Somthing Went Wrong'); 
    				 curl_close($ch);
    			}
    			else
    			{
    				curl_close($ch);
        			     
                    $otp_data=[
                        "user_id"=>$user->unique_id,
                        "user_type"=>1,
                        "otp"=>$otp,
                        "otp_type"=>'login',
                        "sent_at"=>date('Y-m-d H:i:s'),
                    ];
            
                    $otpdata = UsersOtpVerifyModel::create($otp_data);
                
                    if($otpdata)
                    {
                        $res['token'] = $user->createToken($otp)->plainTextToken;
                        $res['name'] = $user->first_name." ".$user->last_name;
                        $res['user_id'] = $user->unique_id;
                        $res['otp'] = $otpdata->otp;
                        $res['status'] = $user->status;
                        return $this->sendResponse(1, $res, 'Otp verification Pending');
                    }
                    else
                    {
                        return $this->sendResponse(0, null, 'Somthig Went Wrong'); 
                    }
        	    }
                
            }
            else
            {
                //Update the guest_id to user_id in cart and wishlist
                $myGuestId = $request->user_id;
                $myUserId  = $user->unique_id;
                $updateData = [
                    'user_id'=>$myUserId,
                    'session_type'=>'user'
                ];
                
                
                   
                $check_cart_items = CartModel::where('user_id', $myGuestId)->get();
                $count=count($check_cart_items);
                for($i=0;$i<$count;$i++)
                {
                     $check_cart_items_guest = CartModel::where(['user_id'=>$myUserId,"product_id"=>$check_cart_items[$i]->product_id])->first();
                     if($check_cart_items_guest)
                     {
                          $item = CartModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items[$i]->product_id])->first();
                          $deleted = $item->delete();
                     }
                     else
                     {
                           $cart_items = CartModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items[$i]->product_id]);
                           $cart_items->update($updateData);
                     }
                }
                
                
                $check_cart_items_wish = WishlistModel::where('user_id', $myGuestId)->get();
                $countw=count($check_cart_items_wish);
                for($i=0;$i<$countw;$i++)
                {
                     $check_cart_items_guest_wish = WishlistModel::where(['user_id'=>$myUserId,"product_id"=>$check_cart_items_wish[$i]->product_id])->first();
                     if($check_cart_items_guest_wish)
                     {
                          $item_wish = WishlistModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items_wish[$i]->product_id])->first();
                          $wishdeleted = $item_wish->delete();
                     }
                     else
                     {
                           $cart_items_wish = WishlistModel::where(['user_id'=>$myGuestId,"product_id"=>$check_cart_items_wish[$i]->product_id]);
                           $cart_items_wish->update($updateData);
                     }
                }
            
            
            
                $token=$user->createToken($request->email)->plainTextToken;
                $updateTokenData=['remember_token'=>$token];
                $user->update($updateTokenData);
                
                
                $res['token'] = $token;
                $res['user_id'] = $user->unique_id;
                $res['name'] = $user->first_name." ".$user->last_name;
                $res['school_code'] = $user->school_code;
                $res['status'] = $user->status;
                
                $response = ['success' => 1,'message' => 'User is logged in successfully','data' => $res,];
                return response()->json($response, 200);
            }
        }
    }

    
}