<?php
namespace App\Http\Controllers\Home;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Home;
use App\Models\VendorModel;
use Illuminate\Support\Facades\Hash;

use File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;



class ProfileController extends Controller
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



    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }


    //vendor profile
    public function profile()
    {
        $data = VendorModel::orderBy('id', 'DESC')->where('unique_id', session('id'))->first();
        return view('profile', ['pagedata' => $data]);
    }
    
    //changePassword
    public function changePassword(Request $request)
    {
        
        
        $old_password=$request->oldpassword;
        $new_password=$request->newpassword;
        $confirm_password=$request->confirmpassword;
        $school = VendorModel::where(['unique_id'=> session('id'), 'del_status'=>0])->first();
        
        if(!Hash::check($old_password, $school->password))
        {
            return redirect()->back()->withErrors(['' => 'Old Password is Incorrect']);
        }
        
        if($new_password!=$confirm_password)
        {
            return redirect()->back()->withErrors(['' => 'New Password and Confirm Password Does Not Match']);
        }
        
        if($new_password==$old_password)
        {
            return redirect()->back()->withErrors(['' => 'Old password same as New password']);
        }
        
        
        
        
        $setdata = array(
            "password" =>  bcrypt($new_password),
        );
        
        $res = $school->update($setdata);
        
        
        if ($res) {
            return redirect()->back()->with('success', 'Updated successfully.');
        } else {
            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    public function edit_profile(Request $request)
    {   
        $access = VendorModel::where("id", request('id'));

        if ($request->file('site_background_img') != "") {

       
            $image=$this->upload_image($request->file('site_background_img'),'vendor/');
            $data = array(
                'unique_id'=>$request->unique_id,
                'username'=>$request->username,
                'email'=>$request->email,
                'e_email'=>$request->e_email,
                'phone_no'=>$request->phone_no,
                'state'=>$request->state,
                'distt'=>$request->distt,
                'city'=>$request->city,
                'landmark'=>$request->landmark,
                'pincode'=>$request->pincode,
                'address'=>$request->address,
                "site_background_img" => $image
            );
        } else {
            $data = array(
                'unique_id'=>$request->unique_id,
                'username'=>$request->username,
                'email'=>$request->email,
                'e_email'=>$request->e_email,
                
                'phone_no'=>$request->phone_no,
                'state'=>$request->state,
                'distt'=>$request->distt,
                'city'=>$request->city,
                'landmark'=>$request->landmark,
                'pincode'=>$request->pincode,
                'address'=>$request->address,
            );
        }



        $res = $access->update($data);

        if ($res) {

            return redirect()->back()->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //admin profile
    public function adminsetting()

    {

        $data = RegisterModel::orderBy('id', 'DESC')->where('id', session('id'))->first();

        return view('admin_setting', ['pagedata' => $data]);
    }


    public function edit_admin_setting(Request $request)

    {
            
        $access = RegisterModel::where("id", request('id'));

        if ($request->file('admin_profile') != "") {

            $image=$this->upload_image($request->file('admin_profile'),'school/');
            $data = array(

                "admin_name" =>  $request->admin_name,
                "admin_email" =>  $request->admin_email,
                "admin_phone" =>  $request->admin_phone,
                "admin_address" =>  $request->admin_address,
                "admin_profile" => $image
            );
        } else {
            $data = array(

                "admin_name" =>  $request->admin_name,
                "admin_email" =>  $request->admin_email,
                "admin_phone" =>  $request->admin_phone,
                "admin_address" =>  $request->admin_address

            );
        }





        $res = $access->update($data);

        if ($res) {

            return redirect()->back()->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }
}
