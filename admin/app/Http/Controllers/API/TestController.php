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
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
   
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;



class TestController extends BaseController
{
    public	function createRandomKey() {
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
	
		
    //---------------------------User Registration---------------------------//
    public function register(Request $request): JsonResponse
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
            'district'=>$request->district,
            'state'=>$request->state,
            'password'=>bcrypt($request->password),
            'status'=>0,
        ];
             
        $user = Users::create($data);
        
        if($user)
        {
            $phone="+91".$request->phone_no;
            $otp=rand(10,1000000);
            $data = "apikey=uKd4MhXyXB4-GLU8Gl3m3YWT2Hil2e2u2ItGijvguo&sender=evyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
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
                //   $res['token'] = $user->createToken($request->phone_no)->plainTextToken;
                //   $res['name'] = $user->first_name." ".$user->last_name;
                //   $res['user_id'] = $user->unique_id;
                    $res['otp'] = $otpdata->otp;
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
            return $this->sendResponse(1, $res, 'Something Went Wrong');
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
                return $this->sendResponse(0, $res,'Email Already Registered! ');
            }
        }
                  
        $existingUser = Users::where(['phone_no'=>$request->phone_no,'del_status'=>0])->first();
        if($existingUser) {
            $res= $request->phone_no;
            return $this->sendResponse(0, $res,'Phone Number Already Registered!');
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
                $otp=rand(10,1000000);
                $data = "apikey=uKd4MhXyXB4-GLU8Gl3m3YWT2Hil2e2u2ItGijvguo&sender=evyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
            	$ch = curl_init('https://api.textlocal.in/send/?');
            	curl_setopt($ch, CURLOPT_POST, true);
            	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            	$result22 = curl_exec($ch); // This is the result from the API
            	
                if(empty ($result22))
    			{
                     return $this->sendResponse(0, $res, 'Somthig Went Wrong'); 
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
                    //   $res['token'] = $user->createToken($request->first_name)->plainTextToken;
                    //   $res['name'] = $user->first_name." ".$user->last_name;
                    //   $res['user_id'] = $user->unique_id;
                    //   $res['school_code'] = $user->school_code;
                       
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
            'school_code'=>$request->school_code,
            'phone_no'=>$request->phone_no,
            'password'=>bcrypt($request->password),
            'user_type'=>$request->type,
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
            if($user->school_code) {
                $school = SchoolModel::where('school_code', $request->school_code)->first();
                
                $school_address=[
                    "user_id"=>$user->unique_id,
                    "address_type"=>2,
                    "default_address"=>1,
                    "school_code"=>$user->school_code,
                    "name"=>$user->first_name." ".$user->last_name,
                    "alternate_phone"=>$request->phone_no,
                    // "phone_no"=>$school->school_phone,
                    // "village"=>$school->village,
                    // "city"=>$school->city,
                    // "state"=>$school->state,
                    // "district"=>$school->distt,
                    // "post_office"=>$school->post_office,
                    // "pincode"=>$school->zipcode,
                    // "address"=>$school->address,
                ];
                
                UserAddressesModel::create($school_address);
            }
            
            // $addressdata = [
            //     'user_id'=>$user->unique_id,
            //     "address_type"=>1,
            //     "name"=>$user->first_name." ".$user->last_name,
            //     'phone_no'=>$request->phone_no,
            //     'state'=>$request->state,
            //     'district'=>$request->district,
            //     "post_office"=>$request->post_office,
            //     "landmark"=>$request->landmark,
            //     "village"=>$request->village,
            //     "city"=>$request->city,
            //     "pincode"=>$request->pincode,
            // ];
            
            // $address_created = UserAddressesModel::create($addressdata);
            
            
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
            $otp=rand(10,1000000);
            $data = "apikey=uKd4MhXyXB4-GLU8Gl3m3YWT2Hil2e2u2ItGijvguo&sender=evyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
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
                    // $res['token'] = $user->createToken($request->phone_no)->plainTextToken;
                    // $res['name'] = $user->first_name." ".$user->last_name;
                    // $res['user_id'] = $user->unique_id;
                    // $res['school_code']=$user->school_code;
                    $res['otp'] = $otpdata->otp;
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
    
    
    //---------------------------Forgot Password-----------------------------//
    //sendPasswordOtp
    public function sendPasswordOtp(Request $request):JsonResponse
    {
        $user = Users::where('phone_no',$request->phone_no)->first();
        
        if(!$user)
        {
             return $this->sendResponse(0, null,'Invalid Phone Number');
        }
        elseif($user)
        {
            $phone="+91".$request->phone_no;
            $otp=rand(10,1000000);
            $data = "apikey=uKd4MhXyXB4-GLU8Gl3m3YWT2Hil2e2u2ItGijvguo&sender=evyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
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
    
    
    //verifyOtp
    public function testverifyOtp(Request $request):JsonResponse
    {
        $where=[
            "user_id"=>$request->user_id,
            // "user_type"=>1,
            "otp"=>$request->otp,
            // "otp_type"=>$request->otp_type,
            "status"=>1,
        ];
        $user = Users::where('unique_id',$request->user_id)->first();

         $checkotp = UsersOtpVerifyModel::where($where)->first();
         if($checkotp)
         {
            $status_updated = $user->update(['status'=>1]);
            $res = [
                'token'=>$user->createToken($request->otp)->plainTextToken,
                'name'=>$user->first_name." ".$user->last_name,
                'user_id'=>$user->unique_id,
                'school_code'=>$user->school_code
            ];
            
            if($status_updated) 
            {
                return $this->sendResponse(1, $res, 'OTP Verified Successfully!');
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
    
    
    //resetPassword
    public function resetPassword(Request $request):JsonResponse
    {
        $user = Users::where('unique_id',$request->user_id)->first();
        $user_updated = $user->update(['password'=>bcrypt($request->new_password)]);
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
    
    
   //---------------------------------Login-------------------------------//

    public function testLogin(Request $request): JsonResponse
    {
        if(isset($request->otp_type))
        {
            $phone_no=$request->phone_no;
            //Check phone exist
            $user = Users::where(['phone_no'=>$phone_no, 'del_status' =>0])->first();
            if(!$user) {
                return $this->sendResponse(0, null, "Phone number doesn't exist in our records");
            }
            
            //otp
            $phone="+91".$request->phone_no;
            $otp=rand(10,1000000);
            $data = "apikey=uKd4MhXyXB4-GLU8Gl3m3YWT2Hil2e2u2ItGijvguo&sender=evyapr&numbers=$phone&message=Dear User , Your One Time Password for evyapari.com is $otp. Don't share OTP with anyone. Regards, Evyapari.com";
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
            //Check email or phone exist
            $user = Users::orWhere(['email' => $request->email,'phone_no'=>$request->email])->where('del_status',0)->first();
            if(!$user) {
                return $this->sendResponse(0, null, " Email or Phone number doesn't exist in our records"); 
            }
            elseif($user->status==0) {
                return $this->sendResponse(0, null, 'Otp verification Pending!');
            }
            elseif(!Hash::check($request->password, $user->password))
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
            
                $res['token'] = $user->createToken($request->email)->plainTextToken;
                $res['user_id'] = $user->unique_id;
                $res['name'] = $user->first_name." ".$user->last_name;
                $res['school_code'] = $user->school_code;
                
                $response = ['success' => 1,'message' => 'User is logged in successfully','data' => $res,];
                return response()->json($response, 200);
            }
        }
    }
    //---------------------------------Login-------------------------------//
    
    
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
}