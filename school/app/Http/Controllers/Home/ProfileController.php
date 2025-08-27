<?php
namespace App\Http\Controllers\Home;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Home;
use App\Models\RegisterModel;
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


    //school profile
    public function profile_setting()
    {

        $data = RegisterModel::orderBy('id', 'DESC')->where('id', session('id'))->first();

        return view('profile_setting', ['pagedata' => $data]);
    }
    
    //changePassword
    public function changePassword(Request $request)
    {
        $old_password=$request->oldpassword;
        $new_password=$request->newpassword;
        $confirm_password=$request->confirmpassword;
        $school = RegisterModel::where(['school_code'=> session('school_code'), 'del_status'=>0])->first();
        
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

    public function edit_profile_setting(Request $request)
    {   
        $access = RegisterModel::where("id", request('id'));

        if ($request->file('school_banner') != "") {

       
            $image=$this->upload_image($request->file('school_banner'),'school/');
            $data = array(

                "school_name" =>  $request->school_name,
                "school_email" =>  $request->school_email,
                "school_phone" =>  $request->school_phone,
                "school_address" =>  $request->school_address,
                "state" =>  $request->state,
                "distt" =>  $request->distt,
                "tehsil" =>  $request->tehsil,
                "village" =>  $request->village,
                "zipcode" =>  $request->zipcode,
                "school_code" =>  $request->school_code,
                "post_office" => $request->post_office,
                "school_banner" => $image
            );
        } else {
            $data = array(

                "school_name" =>  $request->school_name,
                "school_email" =>  $request->school_email,
                "school_phone" =>  $request->school_phone,
                "school_address" =>  $request->school_address,
                "state" =>  $request->state,
                "distt" =>  $request->distt,
                "tehsil" =>  $request->tehsil,
                "village" =>  $request->village,
                "zipcode" =>  $request->zipcode,
                "school_code" =>  $request->school_code,
                "post_office" => $request->post_office
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


    //   //add board data
    //   public function addmasterboard(Request $request)

    //   {
    //     $validatedData = $request->validate([

    //       'title' => 'required|unique:master_board,title,NULL,id,del_status,0',

    //     ]);

    //     $data = array(

    //       "title" => $request->title,

    //       "created_at" =>  date('Y-m-d H:i:s')

    //     );

    //     $res = managemasterboardModel::insert($data);

    //     if ($res) {

    //       return redirect()->back()->with('success', 'Submitted successfully.');
    //     } else {

    //       return redirect('manageboard')->withErrors(['' => 'Somthing went wrong!']);
    //     }

    //   }

    //   //edit board
    //   public function editmasterboard(string $id)

    //   {

    //     $data['pagedata'] = managemasterboardModel::where('id', $id)->first();

    //     return view('masterdata_board_edit', $data);
    //   }

    //   // Update board data
    //   public function updatemasterboard(Request $request)

    //   {

    //     $access = managemasterboardModel::where("id", request('id'));

    //     // Validate the input data

    //     $validatedData = $request->validate([

    //       'title' => 'required|unique:master_board,title,' . $request->id . ',id,del_status,0',
    //     ]);

    //     $data = array(

    //       "title" =>  $request->title,
    //       "status" => $request->status

    //     );

    //     $res = $access->update($data);

    //     if ($res) {

    //       return redirect('manageboard')->with('success', 'Updated successfully.');
    //     } else {

    //       return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
    //     }
    //   }

    //   // delete board
    //   public function deleteboard(Request $request)

    //   {

    //     $data = managemasterboardModel::where('id', Request('id'));

    //     $updData = array(

    //       'del_status' => 1

    //     );

    //     $res = $data->update($updData);

    //     if ($res) {

    //       return redirect()->back()->with('success', 'Deleted successfully.');
    //     } else {

    //       return redirect()->withErrors(['' => 'Somthing went wrong!']);
    //     }
    //   }


}
