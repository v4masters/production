<?php



namespace App\Http\Controllers\Home;

use Intervention\Image\Facades\Image;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Home;

use App\Models\VendorBankDetailModel;

use App\Models\ManageuservendorModel;

use App\Models\VendorDocumentModel;
use File;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

class SettingController extends Controller

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

    
        public function setting()
    {
        $data['pagedata'] = VendorBankDetailModel::where('id', session('id'))->first();
        $data['vendor'] = ManageuservendorModel::where('id', session('id'))->first();
        $data['documents'] = VendorDocumentModel::where('id', session('id'))->first();

        return view('setting', $data);
    }
    
    
    public function bank_setting(Request $request)

    {

        $access = VendorBankDetailModel::where("vendor_id", request('id'));

        $data = array(
            
            "bank_name" =>  $request->bank_name,
            "bank_district" =>  $request->bank_district,
            "ifsc_code" =>  $request->ifsc_code,
            "bank_branch" =>  $request->bank_branch,
            "bank_address" =>  $request->bank_address,
            "acc_number" =>  $request->acc_number,
            "acc_holder_name" =>  $request->acc_holder_name

        );

        // Update the data

        $res = $access->update($data);

        if ($res) {

            return redirect('settings')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

  public function vendor_setting(Request $request)
    {
       
             if($request->file('site_background_img')!= ''){
                $site_background_img=$this->upload_image($request->file('site_background_img'),'vendor/');
                }else{
                $site_background_img=$request->site_background_img_old;
                }
    
            
             if($request->file('website_img')!= ''){
                $website_img=$this->upload_image($request->file('website_img'),'vendor/');
                }else{
                 $website_img=$request->website_img_old;
                }
                
              if($request->file('profile_img')!= ''){
                $profile_img=$this->upload_image($request->file('profile_img'),'vendor/');
                }else{
                 $profile_img=$request->profile_img_old;
                }
                
            


        $access = ManageuservendorModel::where("vendor_id", request('id'));

        $data = array(

            "website_vendor_url" =>  $request->website_vendor_url,
            "username" =>  $request->username,
            "email" =>  $request->email,
            "phone_no" =>  $request->phone_no,
            "address" =>  $request->address,
            "pincode" =>  $request->pincode,
            "site_background_img"=>$site_background_img,
            "website_img"=>$website_img,
            "profile_img"=>$profile_img,

        );

        // Update the data

        $res = $access->update($data);

        if ($res) {

            return redirect('settings')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }
    
    
 public function document_setting(Request $request)
    {

            
 if($request->file('adhar_card')!= ''){
    $adhar_card=$this->upload_image($request->file('adhar_card'),'vendor/personal_doc/');
    }else{
    $adhar_card=$request->adhar_card_old;
    }
    
    
    
            
            
 if($request->file('pan_card')!= ''){
    $pan_card=$this->upload_image($request->file('pan_card'),'vendor/personal_doc/');
    }else{
    $pan_card=$request->pan_card_old;
    }
            
          
            
            
 if($request->file('gst_number')!= ''){
    $gst_number=$this->upload_image($request->file('gst_number'),'vendor/personal_doc/');
    }else{
    $gst_number=$request->gst_number_old; 
    }
 
            
            
 if($request->file('shop_act_number')!= ''){
    $shop_act_number=$this->upload_image($request->file('shop_act_number'),'vendor/personal_doc/');
    }else{
   $shop_act_number=$request->shop_act_number_old;
    }
            
          
            
 if($request->file('cancelled_cheque')!= ''){
    $cancelled_cheque=$this->upload_image($request->file('cancelled_cheque'),'vendor/personal_doc/');
    }else{
    $cancelled_cheque=$request->cancelled_cheque_old;
    }
            


        $access = VendorDocumentModel::where("id", request('id'));

        $data = array(

            "adhar_card"=>$adhar_card,
            "pan_card"=>$pan_card,
            "gst_number"=>$gst_number,
            "shop_act_number"=>$shop_act_number,
            "cancelled_cheque"=>$cancelled_cheque,

        );

        // Update the data

        $res = $access->update($data);

        if ($res) {

            return redirect('settings')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }


   


   
}
