<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\API\Users;
use App\Models\API\UserAddressesModel;
use App\Models\API\SchoolModel;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class MyProfileController extends BaseController
{
    
    
  public function upload_image($file,$folder)
  {
      
    $image_name = date('YmdHis').'-'.time()."-".rand(10,100).'.'.$file->getClientOriginalExtension();
    $filePath = $folder.$image_name;
    $res=Storage::disk('s3')->put($filePath, file_get_contents($file));
    if($res)
    {
        return $image_name;
    }
    else
    {
        return false;
    }
   
    }
    
    // -------------------------------Information-----------------------------//
    //updateInformation
    public function updateInformation(Request $request, string $user_id): JsonResponse
    {
        $checkaddress = UserAddressesModel::where(['user_id'=>$user_id,'del_status' =>0, 'default_address'=>1])->first();
        if($checkaddress)
        {
            $default=0;
        }
        else
        {
            $default=1;
        }
        
        $user_update_data=[
            "first_name"=>$request->first_name,
            "last_name"=>$request->last_name,
            'name'=>$request->first_name." ".$request->last_name,
            "email"=>$request->email,
            "phone_no"=>$request->phone_no,
            // "dob"=>$request->dob,
            "school_code"=>$request->school_code,
            "state"=>$request->state,
            "district"=>$request->district,
            "post_office"=>$request->post_office,
            "address"=>$request->address,
            "village"=>$request->village,
            "city"=>$request->city,
            "pincode"=>$request->pincode,
            "classno"=>$request->classno,
        ];
        
        $user = Users::where('unique_id', $user_id)->first();
        // return $this->sendResponse(0, null, 'School Code');
        
        //if school code is not empty
        if($request->school_code!="")
        {
            $school_code_exist = SchoolModel::where(['school_code'=> $request->school_code, 'del_status'=>0])->first();
            //if school code does not exist
            if(!$school_code_exist)
            {
                return $this->sendResponse(0, null, 'No School Found with this Code');
            }
             
            //if school code exist
            else
            {
                 $new_school_code=$request->school_code;
                  
                //users old school code is null 
                //(update user & check if address is there for this user or not, 
                //if it is there update del_status to 0 and if not there add school address to user addresses)
                if($user->school_code==null)
                {
                      
                      $user_updated = $user->update($user_update_data);
                     
                     
                     
                      $school = SchoolModel::where(['school_code'=> $new_school_code, 'del_status'=>0])->first();
                      $school_address = [
                            "user_id"=>$user->unique_id,
                            "address_type"=>2,
                            "default_address"=>$default,
                            "school_code"=>$new_school_code,
                            "name"=>$user->first_name." ".$user->last_name,
                            "alternate_phone"=>$request->phone_no,
                            "del_status"=>0
                        ];
                        
                      
                        $address=UserAddressesModel::where(['user_id'=>$user->unique_id, 'address_type'=>2])->first();
                        if($address) {
                            // $address->update(['del_status'=>0]);
                            $address->update($school_address);
                            $res['school_code']=$user->school_code;
                            return $this->sendResponse(1, $res, 'Information & address Updated');;
                        }
                        else 
                        {
                            UserAddressesModel::create($school_address);
                            $res['school_code']=$user->school_code;
                            return $this->sendResponse(1, $res, 'Information Updated successfully & address created');
                        }
                  }
                else
                //if users old school code is not null
                {
                    $user_old_school_code = $user->school_code;
                    //users school code is equal to new school code (update user, not user address)
                    if($user_old_school_code==$new_school_code)
                    {
                        $user->update($user_update_data);
                        $res['school_code']=$user->school_code;
                        return $this->sendResponse(1, $res, 'Information Successfully Updated');
                    }
                    else
                    //users school code is not equal to new school code (update user & user address)
                    {
                    //  return $this->sendResponse(1, $user_old_school_code, 'Successfully');
                        $user_updated = $user->update($user_update_data);
                     
                        if($user_updated)
                        {
                            //  $address = UserAddressesModel::where(['user_id'=>$user->id, 'school_code'=>$new_school_code])->first();
                            //  if($address)
                            //  {
                            //      $address->update(['del_status'=>0]);
                            
                            //     $res['school_code']=$user->school_code;
                            //     return $this->sendResponse(1, $res, 'Information & address Updated');
                            //  }
                            $old_school_address=UserAddressesModel::where(['user_id'=>$user->unique_id, 'school_code'=>$user_old_school_code])->first();
                            
                            $school = SchoolModel::where('school_code', $new_school_code)->first();
                            $newschool_address_data = [
                                "user_id"=>$user->unique_id,
                                "address_type"=>2,
                                "default_address"=>$default,
                                "school_code"=>$new_school_code,
                                "name"=>$user->first_name." ".$user->last_name,
                                "alternate_phone"=>$request->phone_no,
                                // "phone_no"=>$school->school_phone,
                                // "village"=>$school->village,
                                // "city"=>$school->city,
                                // "state"=>$school->state,
                                // "district"=>$school->distt,
                                // "post_office"=>$school->post_office,
                                // "pincode"=>$school->zipcode,
                                // "address"=>$school->school_address,
                            ];
                            $old_school_address->update($newschool_address_data);
                            
                            $res['school_code']=$user->school_code;
                            return $this->sendResponse(1, $res, 'Information & address Updated');
                        }
                    }
                }
            }
        }
        else
        {
            
            $user_updated = $user->update($user_update_data);
            $address=UserAddressesModel::where(['user_id'=>$user->unique_id, 'address_type'=>2])->first();
            if($address)
            {
                $address->update(['del_status'=>1]);
            } 
                                
            if($user_updated) {
                $res['school_code']=$user->school_code;
                return $this->sendResponse(1, $res, 'Information Updated successfully');
            }
            else
            {
                return $this->sendResponse(0, $address, 'Something Went Wrong');
            }
            
        }
    }
   
   
   //profile
   public function updateProfileInformation(Request $request): JsonResponse
    {
            $user = Users::where('unique_id', $request->user_id)->first();
            
               if($request->file('profile_image')) {
                  $profile_image=$this->upload_image($request->file('profile_image'),'user/'); 
                } 
                else {
                  $profile_image = "";
                }
            
            
            
            $user_update_data=["profile"=>$profile_image];
            $user_updated = $user->update($user_update_data);
            if($user_updated) {
                // return $this->sendResponse(1, 'Profile Updated successfully');
                return $this->sendResponse(1, $user,'Profile Updated successfully');
            }
            else
            {
                return $this->sendResponse(0, $user, 'Something Went Wrong');
                // return $this->sendResponse(0, $address, 'Something Went Wrong');
            }
            
        
    }
   
   
    
    //getInformation
    public function getInformation(Request $request, string $user_id): JsonResponse
    {
        // $user = Users::where('unique_id', $user_id)->first();
        // return $this->sendResponse(1, $user, null);
       
          $user= DB::table('users')
                ->leftjoin('school', 'school.school_code','=','users.school_code') 
                ->select('users.*','users.cod_status as user_cod_status','school.cash_on_delivery as cod_status')
                ->where(['users.unique_id'=>$user_id])
                ->first();  
          return $this->sendResponse(1, $user, null);
    }
    //delete user 
     public function deleteUserInformation(Request $request, string $user_id): JsonResponse
    {
       $user = Users::where('unique_id', $request->user_id)->first();
       if($request->email) {
            $email = '';
        } 
               
            
           //md5($request->psswd)
            
          
            
    }
    // -------------------------------Information-----------------------------//
    
    
    
    // -------------------------------Address-----------------------------//
    //add Address
    public function addAddress(Request $request): JsonResponse
    {
        $user_id=$request->user_id;
        $checkaddress = UserAddressesModel::where(['user_id'=>$user_id,'del_status' =>0, 'default_address'=>1]);
        $reset_res = $checkaddress->update(['default_address'=>0]);
       
            
        $data=[
            "user_id"=>$user_id,
            "address_type"=>1,
            "default_address"=>1,
            "name"=>$request->name,
            "phone_no"=>$request->phone_no,
            "alternate_phone"=>$request->alternate_phone,
            "village"=>$request->village,
            "city"=>$request->city,
            "state"=>$request->state,
            "district"=>$request->district,
            "post_office"=>$request->post_office,
            "pincode"=>$request->pincode,
            "address"=>$request->address,
        ];  
        
        $user = UserAddressesModel::create($data);
        $res = $user;
        
        return $this->sendResponse(1, $res, 'Address Added successfully');
    }
       public function addAddresstest(Request $request): JsonResponse
    {
        $user_id=$request->user_id;
        $checkaddress = UserAddressesModel::where(['user_id'=>$user_id,'del_status' =>0, 'default_address'=>1]);
        $reset_res = $checkaddress->update(['default_address'=>0]);
       
            
        $data=[
            "user_id"=>$user_id,
            "address_type"=>1,
            "default_address"=>1,
            "name"=>$request->name,
            "phone_no"=>$request->phone_no,
            "alternate_phone"=>$request->alternate_phone,
            "village"=>$request->village,
            "city"=>$request->city,
            "state"=>$request->state,
            "district"=>$request->district,
            "post_office"=>$request->post_office,
            "pincode"=>$request->pincode,
            "address"=>$request->address,
        ];  
        
        $user = UserAddressesModel::create($data);
        $res = $data;
        // echo $user;
        return $this->sendResponse(1, $res, 'Address Added successfully');
    }
    //get addresses
    public function getAllShippingAddress(Request $request ): JsonResponse
    {
        $res=[];
        $user_id=$request->user_id;
        $addresses = UserAddressesModel::where(['user_id'=>$user_id,'del_status' =>0])->orderBy('default_address','desc')->get();
        $count=count($addresses);
        
        for($i=0;$i<$count;$i++)
        {
            if($addresses[$i]->address_type==1)
            {
                $data['id']=$addresses[$i]->id;
                $data['address_type']=$addresses[$i]->address_type;
                $data['default_address']=$addresses[$i]->default_address;	
                $data['school_code']=$addresses[$i]->school_code;	
                $data['name']=$addresses[$i]->name;	
                $data['school_name']="";	
                $data['phone_no']=$addresses[$i]->phone_no;	
                $data['alternate_phone']=$addresses[$i]->alternate_phone;	
                $data['village']=$addresses[$i]->village;	
                $data['city']=$addresses[$i]->city;	
                $data['state']=$addresses[$i]->state;	
                $data['district']=$addresses[$i]->district;	
                $data['post_office']=$addresses[$i]->post_office;	
                $data['pincode']=$addresses[$i]->pincode;	
                $data['address']=$addresses[$i]->address;	
	
            }
            else
            {
                $school_addresses = SchoolModel::where(['school_code'=>$addresses[$i]->school_code,'del_status' =>0])->first();
                $data['id']=$addresses[$i]->id;
                $data['address_type']=$addresses[$i]->address_type;
                $data['default_address']=$addresses[$i]->default_address;		
                $data['school_code']=$school_addresses->school_code;	
                $data['name']=$addresses[$i]->name;	
                $data['school_name']=$school_addresses->school_name;	
                $data['phone_no']=$school_addresses->school_phone;	
                $data['alternate_phone']=$addresses[$i]->alternate_phone;	
                $data['village']=$school_addresses->village;	
                $data['city']=$school_addresses->city;	
                $data['state']=$school_addresses->state;	
                $data['district']=$school_addresses->distt;	
                $data['post_office']=$school_addresses->post_office;	
                $data['pincode']=$school_addresses->zipcode;	
                $data['address']=$school_addresses->landmark;
                
            }
         
           array_push($res,$data);
        }
        
        return $this->sendResponse(1, $res, 'success');
    }
    
    //view address by id
    public function getAddressById(Request $request): JsonResponse
    {
        $address_id = $request->address_id;
        $address = UserAddressesModel::where('id', $address_id)->first();
        return $this->sendResponse(1, $address, 'success');
    }
    
    //home Address count
    public function getHomeAddressCount(Request $request): JsonResponse
    {
        $user_id=$request->user_id;
        $user = UserAddressesModel::where(['user_id'=>$user_id,'address_type'=>1, 'del_status'=>0])->get()->count();
        return $this->sendResponse(1, $user, 'Success');
    }
    
    //update Address
    public function updateAddress(Request $request): JsonResponse
    {
        $address_id = $request->address_id;
        $data=[
            "address_type"=>$request->address_type,
            "name"=>$request->name,
            "phone_no"=>$request->phone_no,
            "alternate_phone"=>$request->alternate_phone,
            "village"=>$request->village,
            "city"=>$request->city,
            "state"=>$request->state,
            "district"=>$request->district,
            "post_office"=>$request->post_office,
            "pincode"=>$request->pincode,
            "address"=>$request->address,
        ];

        $address = UserAddressesModel::where('id', $address_id);
        $res = $address->update($data);
        
        return $this->sendResponse(1, null, 'Address Updated successfully');
    }
    
    //remove address
    public function removeAddress(Request $request): JsonResponse 
    {
        $address_id = $request->address_id;
        $address = UserAddressesModel::where('id', $address_id);
        $address_updated = $address->update(['del_status' => 1]);
        if($address_updated) {
            return $this->sendResponse(1, null, 'Address Deleted successfully');
        }
    }
    // defaultAddress
    public function defaultAddress(Request $request):JsonResponse
    {
        $user_id = $request->user_id;
        $address_id = $request->address_id;
        $old_default_address = UserAddressesModel::where(['user_id'=> $user_id, 'default_address'=> 1])->first();
        if($old_default_address)
        {
            $update_old = $old_default_address->update(['default_address' => 0]);
            if($update_old) 
            {
                $new_default_address = UserAddressesModel::where('id', $address_id)->first();
                $update_new = $new_default_address->update(['default_address' => 1]);
                if($update_new) {
                    return $this->sendResponse(1, null, 'Default Address is set Successfully');
                }
                else {
                return $this->sendResponse(0, null, 'Something Went Wrong');
                }
            }
            else {
                return $this->sendResponse(0, null, 'Something Went Wrong');
            }
        }
        else
        {
            $address = UserAddressesModel::where('id', $address_id)->first();
            $default_address = $address->update(['default_address' => 1]);
            if($default_address) {
                return $this->sendResponse(1, null, 'Default Address is set Successfully');
            }
            else {
                return $this->sendResponse(0, null, 'Something Went Wrong');
            }
        }
        
    }
    
    //getBillingAddress
    public function getBillingAddress(Request $request, string $user_id): JsonResponse
    {
        $user = Users::where('unique_id', $user_id)->first();
        return $this->sendResponse(1, $user, 'success');
    }
    
    
    // -------------------------------Add Address-----------------------------//
    
    // delete user
    public function deleteuser(Request $request): JsonResponse
    {
        $user_id=$request->user_id;
          $user = Users::orWhere(['email' => $request->email,'phone_no'=>$request->email])
           ->where('unique_id', $user_id)
           ->first();
      
        $username=$request->email;
        if($user){
            if(Hash::check($request->password, $user->password)){
                $data=['del_status'=>1,'status'=>0];
                
                $res = $user->update($data);
                if($res){
                    return $this->sendResponse(1, null, 'delete successfully');
                }else{
                    return $this->sendResponse(0,null,'Something Went Wrong');
                }
            }
            else{
                    return $this->sendResponse(0,null,  'Please Enter a valid username password!');
                }
            
        }
        else{
            return $this->sendResponse(0,null,  'Please Enter a valid username password');
                }
    }
}