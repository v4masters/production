<?php
namespace App\Http\Controllers\Home;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Home;
use App\Models\managemasterclassModel;
use App\Models\managemasterboardModel;
use App\Models\managemasterorganisationModel;
use App\Models\managemastergstModel;
use App\Models\ManageuserSchoolModel;
use App\Models\VendorBankDetailModel;
use App\Models\ManageuservendorModel;
use App\Models\VendorDocumentModel;
use App\Models\ManageuserStudentModel;
use App\Models\managemastergradeModel;
use App\Models\managemastercolourModel;
use App\Models\managemasterbrandModel;
use App\Models\InventoryuniformsizeModel;
use App\Models\managemastersettypeModel;
use App\Models\managemastersetcatModel;
use App\Models\managemasterstreamModel;
use App\Models\managemastersizeModel;
use App\Models\managemastersizelistModel;
use App\Models\InventoryModel;
use App\Models\InventoryformsModel;
use App\Models\MasterinventoryformsModel;
use App\Models\MasterformrouteModel;
use App\Models\managemasterqtyModel;
use App\Models\InventoryCatModel;
use App\Models\ManagecategoryModel;
use App\Models\managesubcategoryModel;
use App\Models\managesubcategorytwoModel;
use App\Models\managesubcategorythreeModel;
use App\Models\InventoryImgModel;
use App\Models\InventoryColourModel;
use App\Models\InventoryNewModel;
use App\Models\VendorModel;
use App\Models\InventoryVendorModel;


use File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ManagemasterclassController extends Controller

{
    public function upload_image($file,$folder)
    {
          
        $image_name = date('YmdHis').'-'.time()."-".rand(10,100).'.'.$file->getClientOriginalExtension();
        $filePath = $folder.$image_name;
        $res=Storage::disk('s3')->put($filePath, file_get_contents($file));
        // $res = Storage::disk('s3')->put($filePath, file_get_contents($file), ['ACL' => 'public-read']);
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

    // master set cat
    public function setcat()

    {

        $data = managemastersetcatModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('masterdata_setcat', ['pagedata' => $data]);
    }

    // add master set cat
    public function addsetcat(Request $request)

    {
        $validatedData = $request->validate([

            'title' => 'required|unique:master_set_cat,title,NULL,id,del_status,0',

        ]);

        $data = array(

            "title" => $request->title,

            "created_at" =>  date('Y-m-d H:i:s')

        );

        $res = managemastersetcatModel::insert($data);

        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('set_type')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //edit set Cat
    public function editsetcat(string $id)

    {

        $data['pagedata'] = managemastersetcatModel::where('id', $id)->first();

        return view('masterdata_setcat_edit', $data);
    }

    // Update set type cat
    public function updatesetcat(Request $request)

    {

        $access = managemastersetcatModel::where("id", request('id'));

        $validatedData = $request->validate([

            'title' => 'required|unique:master_set_cat,title,' . $request->id . ',id,del_status,0',
        ]);

        $data = array(

            "title" =>  $request->title,
            "status" => $request->status

        );

        $res = $access->update($data);

        if ($res) {

            return redirect('set_cat')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    // delete set cat
    public function deletesetcat(Request $request)

    {

        $data = managemastersetcatModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    // master set type
    public function settype()

    {

        $data = managemastersettypeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('masterdata_settype', ['pagedata' => $data]);
    }

    // add master set type
    public function addsettype(Request $request)

    {
        $validatedData = $request->validate([

            'title' => 'required|unique:master_set_type,title,NULL,id,del_status,0',

        ]);

        $data = array(

            "title" => $request->title,

            "created_at" =>  date('Y-m-d H:i:s')

        );

        $res = managemastersettypeModel::insert($data);

        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('set_type')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //edit set type
    public function editsettype(string $id)

    {

        $data['pagedata'] = managemastersettypeModel::where('id', $id)->first();

        return view('masterdata_settype_edit', $data);
    }

    // Update set type data
    public function updatesettype(Request $request)

    {

        $access = managemastersettypeModel::where("id", request('id'));

        $validatedData = $request->validate([

            'title' => 'required|unique:master_set_type,title,' . $request->id . ',id,del_status,0',
        ]);

        $data = array(

            "title" =>  $request->title,
            "status" => $request->status

        );

        $res = $access->update($data);

        if ($res) {

            return redirect('set_type')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    // delete set type
    public function deletesettype(Request $request)

    {

        $data = managemastersettypeModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    // user school
    public function manageuser_school()
    {
             $data= DB::table('school')
            ->leftJoin('master_board', 'master_board.id', '=', 'school.board')
            ->leftJoin('master_grade', 'master_grade.id', '=', 'school.grade')
            ->leftJoin('master_orgnisation', 'master_orgnisation.id', '=', 'school.organisation')
            ->select('school.*',  'master_board.title as school_board',  'master_grade.title as school_grade',  'master_orgnisation.name as school_organisation')
            ->where(['school.del_status' => 0])
            ->orderBy('school.id', 'desc')
            ->get();
        
        // $data = ManageuserSchoolModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        return view('manageusers_school', ['pagedata' => $data]);
    }
    
    
    
    
    


    //edit user school
    public function edituser_school(string $id)
    {
        $data['pagedata'] = ManageuserSchoolModel::where('id', $id)->first();
        return view('manageusers_school_edit', $data);
    }

    // Update user school data
    public function updateuser_school(Request $request)
    {
        $access = ManageuserSchoolModel::where("id", request('id'));

        $data = array(
            "school_name" =>  $request->school_name,
            "school_email" =>  $request->school_email,
            "school_phone" =>  $request->school_phone,
            "country" =>  $request->country,
            "state" =>  $request->state,
            "distt" =>  $request->distt,
            "city" =>  $request->city,
            "tehsil" =>  $request->tehsil,
            "village" =>  $request->village,
            "post_office" =>  $request->post_office,
            "school_code" =>  $request->school_code,
            "landmark" =>  $request->landmark,
            "zipcode" =>  $request->zipcode,
            "address" =>  $request->address,
            "status" => $request->status,
            "cash_on_delivery" => $request->cod_status
        );

        $res = $access->update($data);

        if ($res) {
            return redirect('user_school')->with('success', 'Updated successfully.');
        } else {
            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    // delete user school
    public function deleteuser_school(Request $request)

    {

        $data = ManageuserSchoolModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    // user vendor
    public function manageuser_vendor()

    {

        $data = ManageuservendorModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('manageusers_vendor', ['pagedata' => $data]);
    }
    
    // view user vendor
    public function viewuser_vendor(string $id)
    {
        $data['pagedata'] = ManageuservendorModel::where('unique_id', $id)->first();
        $data['bankdetail'] = VendorBankDetailModel::where('vendor_id', $id)->first();
        $data['documents'] = VendorDocumentModel::where('vendor_id', $id)->first();
        return view('manageusers_vendor_view',$data);
    }

    //edit user vendor
    public function edituser_vendor(string $id)

    {

        $data['pagedata'] = ManageuservendorModel::where('id', $id)->first();

        return view('manageusers_vendor_edit', $data);
    }



    // Update user vendor data
    public function updateuser_vendor(Request $request)

    {

        $access = ManageuservendorModel::where("id", request('id'));

        $data = array(

            "username" =>  $request->username,
            "email" =>  $request->email,
            "password" =>  $request->password,
            "phone_no" =>  $request->phone_no,
            "gst_no" =>  $request->gst_no,
            "country" =>  $request->country,
            "state" =>  $request->state,
            "distt" =>  $request->distt,
            "city" =>  $request->city,
            "landmark" =>  $request->landmark,
            "pincode" =>  $request->pincode,
            "address" =>  $request->address,
            "status" => $request->status,
            "update_pp_order_status" => $request->update_pp_order_status

        );

        $res = $access->update($data);

        if ($res) {

            return redirect('user_vendor')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    // delete user vendor
    public function deleteuser_vendor(Request $request)

    {

        $data = ManageuservendorModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    // user student
    public function manageuser_student()

    {
         $data= DB::table('users')
            ->leftJoin('school', 'school.school_code', '=', 'users.school_code')
            ->select('users.*',  'school.school_name as school_name',  'school.school_address as school_address')
            ->where(['users.del_status' => 0])
            ->orderBy('users.id', 'desc')
            ->get();

        // $data = ManageuserStudentModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('manageusers_student', ['pagedata' => $data]);
    }

    //edit user student
    public function edituser_student(string $id)
    {
        $data['pagedata'] = ManageuserStudentModel::where('id', $id)->first();
        return view('manageusers_student_edit', $data);
    }

    // Update user student data
    public function updateuser_student(Request $request)
    {
        $access = ManageuserStudentModel::where("id", request('id'));

        $data = array(
            "first_name" =>  $request->first_name,
            "last_name" =>  $request->last_name,
            "email" =>  $request->email,
            "password" =>  $request->password,
            "phone_no" =>  $request->phone_no,
            "dob" =>  $request->dob,
            "country" =>  $request->country,
            "state" =>  $request->state,
            "district" =>  $request->distt,
            "city" =>  $request->city,
            "landmark" =>  $request->landmark,
            "pincode" =>  $request->pincode,
            "address" =>  $request->address,
            "cod_status" =>  $request->cod_status,
            "status" => $request->status
        );

        $res = $access->update($data);

        if ($res) {

            return redirect('user_student')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    // delete user student
    public function deleteuser_student(Request $request)

    {

        $data = ManageuserStudentModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    //board
    public function manage_board()

    {

        $data = managemasterboardModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('masterdata_board', ['pagedata' => $data]);
    }

    //add board data
    public function addmasterboard(Request $request)

    {
        $validatedData = $request->validate([

            'title' => 'required|unique:master_board,title,NULL,id,del_status,0',

        ]);

        $data = array(

            "title" => $request->title,

            "created_at" =>  date('Y-m-d H:i:s')

        );

        $res = managemasterboardModel::insert($data);

        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('manageboard')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //edit board
    public function editmasterboard(string $id)

    {

        $data['pagedata'] = managemasterboardModel::where('id', $id)->first();

        return view('masterdata_board_edit', $data);
    }

    // Update board data
    public function updatemasterboard(Request $request)

    {

        $access = managemasterboardModel::where("id", request('id'));

        $validatedData = $request->validate([

            'title' => 'required|unique:master_board,title,' . $request->id . ',id,del_status,0',
        ]);

        $data = array(

            "title" =>  $request->title,
            "status" => $request->status

        );

        $res = $access->update($data);

        if ($res) {

            return redirect('manageboard')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    // delete board
    public function deleteboard(Request $request)

    {
        $data = managemasterboardModel::where('id', Request('id'));
        $updData = array(
            'del_status' => 1
        );
        $res = $data->update($updData);
        if ($res) {
            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {
            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //organisation
    public function manage_organisation()

    {
        $data = managemasterorganisationModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        return view('masterdata_organisation', ['pagedata' => $data]);
    }

    // add master organisation
    public function addmasterorganisation(Request $request)

    {
        $validatedData = $request->validate([

            'name' => 'required|unique:master_orgnisation,name,NULL,id,del_status,0',

        ]);

        $data = array(

            "name" => $request->name,

            "email" => $request->email,

            "phone" => $request->phone,

            "whatsapp_number" => $request->whatsapp_number,

            "address" => $request->address,

            "city" => $request->city,

            "country" => $request->country,

            "state" => $request->state,

            "zip_code" => $request->zip_code,

            "created_at" =>  date('Y-m-d H:i:s')

        );

        $res = managemasterorganisationModel::insert($data);

        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('masterdata_class')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //edit master organisation
    public function editmasterorganisation(string $id)

    {

        $data['pagedata'] = managemasterorganisationModel::where('id', $id)->first();

        return view('masterdata_organisation_edit', $data);
    }

    // Update organisation data
    public function updatemasterorganisation(Request $request)

    {

        $access = managemasterorganisationModel::where("id", request('id'));

        // Validate the input data

        $validatedData = $request->validate([

            'name' => 'required|unique:master_orgnisation,name,' . $request->id . ',id,del_status,0',
        ]);

        $data = array(

            "name" =>  $request->name,
            "email" =>  $request->email,
            "phone" =>  $request->phone,
            "address" =>  $request->address,
            "city" =>  $request->city,
            "state" =>  $request->state,
            "country" =>  $request->country,
            "zip_code" =>  $request->zip_code,
            "whatsapp_number" =>  $request->whatsapp_number,
            "status" => $request->status

        );

        $res = $access->update($data);

        if ($res) {

            return redirect('manageorganisation')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //delete organisation
    public function deleteorganisation(Request $request)

    {

        $data = managemasterorganisationModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //grade
    public function manage_grade()

    {

        $data = managemastergradeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('masterdata_grade', ['pagedata' => $data]);
    }

    // add master grade
    public function addmastergrade(Request $request)

    {
        $validatedData = $request->validate([

            'title' => 'required|unique:master_grade,title,NULL,id,del_status,0',

        ]);

        $data = array(

            "title" => $request->title,

            "created_at" =>  date('Y-m-d H:i:s')

        );

        $res = managemastergradeModel::insert($data);

        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('masterdata_class')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //edit master grade
    public function editmastergrade(string $id)

    {

        $data['pagedata'] = managemastergradeModel::where('id', $id)->first();

        return view('masterdata_grade_edit', $data);
    }

    // Update grade data
    public function updatemastergrade(Request $request)

    {

        $access = managemastergradeModel::where("id", request('id'));

        $validatedData = $request->validate([

            'title' => 'required|unique:master_grade,title,' . $request->id . ',id,del_status,0',
        ]);

        $data = array(

            "title" =>  $request->title,
            "status" => $request->status

        );

        $res = $access->update($data);

        if ($res) {

            return redirect('managegrade')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //delete grade
    public function deletegrade(Request $request)

    {

        $data = managemastergradeModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    // class
    public function manageClass()

    {

        $data = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('masterdata_class', ['pagedata' => $data]);
    }

    // add master class
    public function addmasterclass(Request $request)

    {
        $validatedData = $request->validate([

            'title' => 'required|unique:master_classes,title,NULL,id,del_status,0',

        ]);

        $data = array(

            "title" => $request->title,

            "created_at" =>  date('Y-m-d H:i:s')

        );

        $res = managemasterclassModel::insert($data);

        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('masterdata_class')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //edit master class
    public function editmasterclass(string $id)

    {

        $data['pagedata'] = managemasterclassModel::where('id', $id)->first();

        return view('masterdata_class_edit', $data);
    }

    // Update class data
    public function updatemasterclass(Request $request)

    {

        $access = managemasterclassModel::where("id", request('id'));

        // Validate the input data

        $validatedData = $request->validate([

            'title' => 'required|unique:master_classes,title,' . $request->id . ',id,del_status,0',
        ]);

        $data = array(

            "title" =>  $request->title,
            "status" => $request->status

        );

        $res = $access->update($data);

        if ($res) {

            return redirect('manageClass')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    //delete class
    public function deleteclass(Request $request)

    {

        $data = managemasterclassModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    //colour
    public function manageColour()

    {

        $data = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('masterdata_colour', ['pagedata' => $data]);
    }


    //add colour
    public function addmastercolour(Request $request)

    {
        $validatedData = $request->validate([

            'title' => 'required|unique:master_colour,title,NULL,id,del_status,0',

        ]);

        $data = array(

            "title" => $request->title,

            "created_at" =>  date('Y-m-d H:i:s')

        );

        $res = managemastercolourModel::insert($data);

        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('masterdata_class')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //delete colour
    public function deletecolour(Request $request)

    {

        $data = managemastercolourModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //quantity unit
    public function manage_qty_unit()

    {

        $data = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('masterdata_qty_unit', ['pagedata' => $data]);
    }
    // add qty unit
    public function addmaster_qty_unit(Request $request)

    {
        $validatedData = $request->validate([

            'title' => 'required|unique:master_qty_unit,title,NULL,id,del_status,0',

        ]);

      
        
        
         if($request->file('unit_chart')!= ''){
            $image=$this->upload_image($request->file('unit_chart'),'unit_chart/');
            }else{
            $image="";  
            }
        

        $data = array(

            "title" => $request->title,
            "unit_chart" => $image,
            "created_at" =>  date('Y-m-d H:i:s')

        );

        $res = managemasterqtyModel::insert($data);

        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('masterdata_qty_unit')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    public function edit_qty_unit(string $id)

    {

        $data['pagedata'] = managemasterqtyModel::where('id', $id)->first();

        return view('masterdata_qty_unit_edit', $data);
    }

    public function update_qty_unit(Request $request)

    {

        $access = managemasterqtyModel::where("id", request('id'));

        $validatedData = $request->validate([

            'title' => 'required|unique:master_qty_unit,title,' . $request->id . ',id,del_status,0',
        ]);


        if ($request->file('unit_chart') != "") {

            $image=$this->upload_image($request->file('unit_chart'),'unit_chart/');
            $data = array(

                "title" =>  $request->title,
                "unit_chart" =>  $image,
                "status" => $request->status,

            );
        } else {
            $data = array(

                "title" =>  $request->title,
                "status" => $request->status,
            );
        }

        // Update the data

        $res = $access->update($data);

        if ($res) {

            return redirect('manageqtyunit')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //delete qty unit
    public function delete_qty_unit(Request $request)

    {
        $data = managemasterqtyModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //gst

    public function manageGST()

    {

        $data = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('masterdata_GST', ['pagedata' => $data]);
    }



    public function addgst(Request $request)

    {

        $validatedData = $request->validate([

            'title' => 'required|unique:master_taxes,title,NULL,id,del_status,0',

        ]);

        $data = array(

            "title" => $request->title,

            "created_at" =>  date('Y-m-d H:i:s')

        );

        $res = managemastergstModel::insert($data);

        if ($res) {

            // $response['success'] = 1;
            // $response['success_msg'] = 'GST Added successfully.';
            // $this->output($response);
            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {
            // $response['error'] = 1;
            // $response['error_msg'] = 'Somthing went wrong!';
            // $this->output($response);
            return redirect('masterdata_GST')->withErrors(['' => 'Somthing went wrong!']);
        }
    }



    public function editgst(string $id)

    {

        $data['pagedata'] = managemastergstModel::where('id', $id)->first();

        return view('masterdata_GST_edit', $data);
    }



    public function updategst(Request $request)
    {


        $access = managemastergstModel::where("id", request('id'));

        // Validate the input data
        $validatedData = $request->validate([
            'title' => 'required|unique:master_taxes,title,' . $request->id . ',id,del_status,0',
        ]);


        $data = array(
            "title" =>  $request->title,
            "status" => $request->status

        );

        // Update the data

        $res = $access->update($data);

        if ($res) {

            return redirect('manageGST')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }



    public function deletegst(Request $request)

    {

        $data = managemastergstModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }



    //brand

    public function managebrand()

    {

        $data = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('masterdata_brand', ['pagedata' => $data]);
    }



    public function addbrand(Request $request)

    {
        // Validate the input data

        $validatedData = $request->validate([

            'title' => 'required|unique:master_brand,title,NULL,id,del_status,0',

        ]);

     
        
         if($request->file('brand_logo')!= ''){
            $image=$this->upload_image($request->file('brand_logo'),'brand/');
            }else{
            $image="";  
            }



        $data = array(

            "title" => $request->title,
            "brand_logo" => $image,
            "created_at" =>  date('Y-m-d H:i:s')
        );



        $res = managemasterbrandModel::insert($data);



        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('masterdata_brand')->withErrors(['' => 'Somthing went wrong!']);
        }
    }



    public function editbrand(string $id)

    {

        $data['pagedata'] = managemasterbrandModel::where('id', $id)->first();

        return view('masterdata_brand_edit', $data);
    }




    public function updatebrand(Request $request)
    {

        $access = managemasterbrandModel::where("id", request('id'));


        // Validate the input data
        $validatedData = $request->validate([
            'title' => 'required|unique:master_brand,title,' . $request->id . ',id,del_status,0',

        ]);


        if ($request->file('brandlogo') != "") {

            $image=$this->upload_image($request->file('brandlogo'),'brand/');
            $data = array(

                "title" =>  $request->title,
                "brand_logo" =>  $image,
                "status" => $request->status,

            );
        } else {
            $data = array(

                "title" =>  $request->title,
                "status" => $request->status,
            );
        }



        // Update the data

        $res = $access->update($data);

        if ($res) {

            return redirect('managebrand')->with('success', 'Updated Successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }



    public function deletebrand(Request $request)

    {

        $data = managemasterbrandModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }



    //stream

    public function managestream()

    {

        $data = managemasterstreamModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('masterdata_stream', ['pagedata' => $data]);
    }



    public function addstream(Request $request)

    {

        $validatedData = $request->validate([

            'title' => 'required|unique:master_stream,title,NULL,id,del_status,0',

        ]);

        $data = array(

            "title" => $request->title,

            "created_at" =>  date('Y-m-d H:i:s')
        );



        $res = managemasterstreamModel::insert($data);



        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('masterdata_stream')->withErrors(['' => 'Somthing went wrong!']);
        }
    }



    public function editstream(string $id)

    {

        $data['pagedata'] = managemasterstreamModel::where('id', $id)->first();

        return view('masterdata_stream_edit', $data);
    }



    public function updatestream(Request $request)

    {

        $access = managemasterstreamModel::where("id", request('id'));



        // Validate the input data

        $validatedData = $request->validate([

            'title' => 'required|unique:master_stream,title,' . $request->id . ',id,del_status,0',

        ]);

        $data = array(

            "title" =>  $request->title,
            "status" => $request->status

        );

        // Update the data

        $res = $access->update($data);

        if ($res) {

            return redirect('managestream')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }



    public function deletestream(Request $request)

    {

        $data = managemasterstreamModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );





        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }





    //add size

    public function add_master_size(Request $request)

    {
        $validatedData = $request->validate([

            'title' => 'required|unique:sizes,title,NULL,id,del_status,0',

        ]);



         if($request->file('chart')!= ''){
            $image=$this->upload_image($request->file('chart'),'size_chart/');
            }else{
            $image="";  
            }
            

        $data = array(

            "title" =>  $request->title,
            "chart" =>  $image,
            "created_at" =>  date('Y-m-d H:i:s')
        );



        $res = managemastersizeModel::create($data);

        if ($res) {

            $sub_title = $request->sub_title;



            $subdata = [];

            $count = count($sub_title);

            for ($i = 0; $i < $count; $i++) {



                $subdata[] = [

                    'size_id' => $res->id,

                    'title' => $sub_title[$i],

                ];
            }

            $subres = managemastersizelistModel::insert($subdata);

            if ($subres) {

                return redirect('managesize')->with('success', 'Submitted successfully.');
            } else {

                return redirect('managesize')->withErrors(['' => 'Somthing went wrong!']);
            }
        } else {

            return redirect('managesize')->withErrors(['' => 'Somthing went wrong!']);
        }
    }



    public function view_size()

    {

        $data = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('masterdata_size', ['pagedata' => $data]);
    }



    public function editmastersize(string $id)

    {

        $data['pagedata'] = managemastersizeModel::where('id', $id)->first();

        return view('masterdata_size_edit', $data);
    }



    public function updatemastersize(Request $request)

    {

        $access = managemastersizeModel::where("id", request('id'));



        // Validate the input data

        $validatedData = $request->validate([

            'title' => 'required|unique:sizes,title,' . $request->id . ',id,del_status,0',

        ]);



        if ($request->file('chart') != "") {
            $image=$this->upload_image($request->file('chart'),'size_chart/');
            $data = array(

                "title" =>  $request->title,
                "chart" =>  $image,
                "status" => $request->status,

            );
        } else {
            $data = array(

                "title" =>  $request->title,
                "status" => $request->status

            );
        }




        // Update the data

        $res = $access->update($data);

        if ($res) {

            return redirect('managesize')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    public function deletesize(Request $request)

    {

        $data = managemastersizeModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }



    public function add_sizelist_again(Request $request)

    {

        $sub_title = $request->sub_title;

        $subdata = [];

        $count = count($sub_title);

        for ($i = 0; $i < $count; $i++) {

            $subdata[] = [

                'size_id' => $request->size_id,

                'title' => $sub_title[$i],
            ];
        }

        $subres = managemastersizelistModel::insert($subdata);


        if ($subres) {

            return redirect()->back();
        }
    }



    //sizelist

    public function view_sizelist(string $id)

    {
        $array = array("del_status" => 0, "size_id" => $id);
        $data = managemastersizelistModel::orderBy('id', 'DESC')->where($array)->get();

        $size = managemastersizeModel::where('id', $id)->first();

        return view('masterdata_sizelist', array('pagedata' => $data, 'size' => $size));
    }





    public function editmastersizelist(string $id)

    {

        $data['pagedata'] = managemastersizelistModel::where('id', $id)->first();

        return view('masterdata_sizelist_edit', $data);
    }



    public function updatemastersizelist(Request $request)

    {

        $access = managemastersizelistModel::where("id", request('id'));



        // Validate the input data

        $validatedData = $request->validate([

            'title' => 'required|unique:size_list,title,' . $request->id . ',id,del_status,0',


        ]);


        $data = array(

            "title" =>  $request->title,
            "status" => $request->status

        );

        // Update the data

        $res = $access->update($data);

        if ($res) {
            session()->flash('success', 'Updated successfully.');
            return redirect('view_sizelist/' . $request->size_id);
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    public function deletesizelist(Request $request)

    {

        $data = managemastersizelistModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    // inventoryforms
    public function manageinventoryforms()

    {

        $data = MasterinventoryformsModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $route = MasterformrouteModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('master_inventoryform', array('pagedata' => $data, 'route' => $route));
    }


    public function addmasterinventoryforms(Request $request)

    {
        $validatedData = $request->validate([

            'title' => 'required|unique:master_inventory_form,title,NULL,id,del_status,0',


        ]);

        $data = array(

            "title" => $request->title,

            "route_name" => $request->route_name,

            "created_at" =>  date('Y-m-d H:i:s')

        );



        $res = MasterinventoryformsModel::insert($data);



        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('manageinventoryforms')->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    public function editmasterinventoryform(string $id)

    {

        $data = MasterinventoryformsModel::where('id', $id)->first();
        $route = MasterformrouteModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        return view('master_inventoryform_edit', array('pagedata' => $data, 'route' => $route));
    }


    public function updatemasterinventoryform(Request $request)

    {

        $access = MasterinventoryformsModel::where("id", request('id'));



        // Validate the input data

        $validatedData = $request->validate([

            'title' => 'required|unique:master_inventory_form,title,' . $request->id . ',id,del_status,0',
            'route_name' => 'required',
        ]);

        $data = array(

            "title" =>  $request->title,
            "route_name" =>  $request->route_name,
            "status" => $request->status

        );

        // Update the data

        $res = $access->update($data);

        if ($res) {

            return redirect('inventoryforms')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    public function deleteinventoryform(Request $request)

    {

        $data = MasterinventoryformsModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    
    //  public function viewMapCourses()
    // {

    //   $where=array('courses.del_status'=>0);  

    //   $data['pagedata']=DB::table('courses')
    //   ->join('course_category', 'courses.course_category', '=', 'course_category.id')
    //   ->join('course_type', 'course_type.id', '=', 'courses.course_type')
    //   ->select('courses.id','courses.course_name','course_category.course_category','course_type.type')
    //   ->where($where)
    //   ->orderBy('courses.id','desc')
    //   ->get();


    //     return view('map_courses',$data);
    // }





    public function inventory_book(string $id)

    {
        $stream = managemasterstreamModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtychart = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->first();

        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $class = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }



        return view('inventory_books', array('size_list' => $sizelist, 'stream' => $stream, 'brand' => $brand, 'gst' => $gst, 'size' => $size, 'class' => $class, 'categoryid' => $categoryid, 'qtyunit' => $qtyunit, 'qtychart' => $qtychart, 'colour' => $colour));
    }



    public function inventory_stationery(string $id)

    {
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();


        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }



        return view('inventory_office_supplies_and_statioinery', array('size_list' => $sizelist, 'categoryid' => $categoryid, 'colour' => $colour, 'brand' => $brand, 'gst' => $gst, 'size' => $size, 'qtyunit' => $qtyunit));
    }

    public function add_inventory_stationery(Request $request)

    {
        $validatedData = $request->validate([

            'product_name' => 'required|unique:inventory_new,product_name,NULL,id,del_status,0',
            'barcode' => 'unique:inventory_new',
            'isbn' => 'unique:inventory_new',

        ]);

        $data = array(

            "net_weight" => $request->net_weight,
            "product_id" => $request->product_id,
            "product_name" => $request->product_name,
            "size" => $request->size,
            "barcode" => $request->barcode,
            "description" => $request->description,
            "mrp" => $request->mrp,
            "discount" => $request->discount,
            "discounted_price" => $request->discounted_price,
            "sales_price" => $request->sales_price,
            "shipping_charges" => $request->shipping_charges,
            "hsncode" => $request->hsncode,
            "gst" => $request->gst,
            "country_of_origin" => $request->country_of_origin,
            "color" => $request->color,
            "type" => $request->type,
            "manufacturer_detail" => $request->manufacturer_detail,
            "packer_detail" => $request->packer_detail,
            "manufacturing_date" => $request->manufacturing_date,
            "brand" => $request->brand,
            "material_type" => $request->material_type,
            "paper_finish" => $request->paper_finish,
            "paper_size" => $request->paper_size,
            "importer_detail" => $request->importer_detail,
            "created_at" =>  date('Y-m-d H:i:s'),
            "cat_id" => $request->cat_id

        );



        $res = InventoryformsModel::insert($data);



        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('inventory_office_supplies_and_statioinery')->withErrors(['' => 'Somthing went wrong!']);
        }
    }





    public function inventory_office(string $id)

    {
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();



        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }


        return view('inventory_craft_and_coloring', array('size_list' => $sizelist, 'categoryid' => $categoryid, 'brand' => $brand, 'colour' => $colour, 'gst' => $gst, 'size' => $size, 'qtyunit' => $qtyunit));
    }

    public function add_inventory_office(Request $request)

    {
        $validatedData = $request->validate([

            'product_name' => 'required|unique:inventory_new,product_name,NULL,id,del_status,0',
            'barcode' => 'unique:inventory_new',
            'isbn' => 'unique:inventory_new',

        ]);

        $data = array(

            "net_weight" => $request->net_weight,
            "product_id" => $request->product_id,
            "product_name" => $request->product_name,
            "size" => $request->size,
            "barcode" => $request->barcode,
            "description" => $request->description,
            "mrp" => $request->mrp,
            "discount" => $request->discount,
            "discounted_price" => $request->discounted_price,
            "sales_price" => $request->sales_price,
            "shipping_charges" => $request->shipping_charges,
            "hsncode" => $request->hsncode,
            "gst" => $request->gst,
            "country_of_origin" => $request->country_of_origin,
            "color" => $request->color,
            "type" => $request->type,
            "manufacturer_detail" => $request->manufacturer_detail,
            "packer_detail" => $request->packer_detail,
            "net_quantity" => $request->net_quantity,
            "brand" => $request->brand,
            "material_type" => $request->material_type,
            "weight_unit" => $request->weight_unit,
            "product_weight" => $request->product_weight,
            "paper_size" => $request->paper_size,
            "importer_detail" => $request->importer_detail,
            "created_at" =>  date('Y-m-d H:i:s'),
            "cat_id" => $request->cat_id

        );



        $res = InventoryformsModel::insert($data);



        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('inventory_craft_and_coloring')->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    public function inventory_bags(string $id)

    {
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();



        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }



        return view('inventory_bag', array('size_list' => $sizelist, 'brand' => $brand, 'gst' => $gst, 'size' => $size, 'colour' => $colour, 'categoryid' => $categoryid, 'qtyunit' => $qtyunit));
    }

    public function add_inventory_bag(Request $request)

    {
        $validatedData = $request->validate([

            'product_name' => 'required|unique:inventory_new,product_name,NULL,id,del_status,0',
            'barcode' => 'unique:inventory_new',
            'isbn' => 'unique:inventory_new',
        ]);

        $data = array(

            "net_weight" => $request->net_weight,
            "product_id" => $request->product_id,
            "product_name" => $request->product_name,
            "size" => $request->size,
            "barcode" => $request->barcode,
            "description" => $request->description,
            "mrp" => $request->mrp,
            "discount" => $request->discount,
            "discounted_price" => $request->discounted_price,
            "sales_price" => $request->sales_price,
            "shipping_charges" => $request->shipping_charges,
            "hsncode" => $request->hsncode,
            "gst" => $request->gst,
            "country_of_origin" => $request->country_of_origin,
            "color" => $request->color,
            "type" => $request->type,
            "manufacturer_detail" => $request->manufacturer_detail,
            "packer_detail" => $request->packer_detail,
            "net_quantity" => $request->net_quantity,
            "brand" => $request->brand,
            "laptop_capacity" => $request->laptop_capacity,
            "material" => $request->material,
            "warranty" => $request->warranty,
            "water_resistant" => $request->water_resistant,
            "importer_detail" => $request->importer_detail,
            "created_at" =>  date('Y-m-d H:i:s'),
            "cat_id" => $request->cat_id


        );



        $res = InventoryformsModel::insert($data);



        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('inventory_bag')->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    public function inventory_grocery(string $id)

    {
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();



        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }



        return view('inventory_grocery', array('size_list' => $sizelist, 'categoryid' => $categoryid, 'brand' => $brand,  'colour' => $colour, 'gst' => $gst, 'size' => $size, 'qtyunit' => $qtyunit));
    }

    public function add_inventory_grocery(Request $request)

    {
        $validatedData = $request->validate([

            'product_name' => 'required|unique:inventory_new,product_name,NULL,id,del_status,0',
            'barcode' => 'unique:inventory_new',
            'isbn' => 'unique:inventory_new',
        ]);

        $data = array(

            "net_weight" => $request->net_weight,
            "product_id" => $request->product_id,
            "product_name" => $request->product_name,
            "size" => $request->size,
            "barcode" => $request->barcode,
            "description" => $request->description,
            "mrp" => $request->mrp,
            "discount" => $request->discount,
            "discounted_price" => $request->discounted_price,
            "sales_price" => $request->sales_price,
            "shipping_charges" => $request->shipping_charges,
            "hsncode" => $request->hsncode,
            "gst" => $request->gst,
            "country_of_origin" => $request->country_of_origin,
            "fssai_license_number" => $request->fssai_license_number,
            "shelf_life" => $request->shelf_life,
            "veg_nonveg" => $request->veg_nonveg,
            "packer_detail" => $request->packer_detail,
            "manufacturer_detail" => $request->manufacturer_detail,
            "brand" => $request->brand,
            "importer_detail" => $request->importer_detail,
            "created_at" =>  date('Y-m-d H:i:s'),
            "cat_id" => $request->cat_id

        );



        $res = InventoryformsModel::insert($data);



        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('inventory_grocery')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    public function inventory_sports(string $id)

    {
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();




        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }



        return view('inventory_sports_and_fitness', array('size_list' => $sizelist, 'categoryid' => $categoryid, 'brand' => $brand, 'colour' => $colour, 'gst' => $gst, 'size' => $size, 'qtyunit' => $qtyunit));
    }

    public function add_inventory_sports(Request $request)

    {
        $validatedData = $request->validate([

            'product_name' => 'required|unique:inventory_new,product_name,NULL,id,del_status,0',
            'barcode' => 'unique:inventory_new',
            'isbn' => 'unique:inventory_new',

        ]);

        $data = array(

            "net_weight" => $request->net_weight,
            "product_id" => $request->product_id,
            "product_name" => $request->product_name,
            "size" => $request->size,
            "barcode" => $request->barcode,
            "description" => $request->description,
            "mrp" => $request->mrp,
            "discount" => $request->discount,
            "discounted_price" => $request->discounted_price,
            "sales_price" => $request->sales_price,
            "shipping_charges" => $request->shipping_charges,
            "hsncode" => $request->hsncode,
            "gst" => $request->gst,
            "country_of_origin" => $request->country_of_origin,
            "material" => $request->material,
            "net_quantity" => $request->net_quantity,
            "manufacturer_detail" => $request->manufacturer_detail,
            "packer_detail" => $request->packer_detail,
            "net_quantity" => $request->net_quantity,
            "brand" => $request->brand,
            "product_length" => $request->product_length,
            "product_type" => $request->product_type,
            "product_unit" => $request->product_unit,
            "type" => $request->type,
            "importer_detail" => $request->importer_detail,
            "created_at" =>  date('Y-m-d H:i:s'),
            "cat_id" => $request->cat_id

        );



        $res = InventoryformsModel::insert($data);



        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('inventory_sports_and_fitness')->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    public function inventory_kids(string $id)

    {
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();




        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }



        return view('inventory_kids', array('size_list' => $sizelist, 'categoryid' => $categoryid, 'brand' => $brand, 'colour' => $colour, 'gst' => $gst, 'size' => $size, 'qtyunit' => $qtyunit));
    }

    public function add_inventory_kids(Request $request)

    {
        $validatedData = $request->validate([

            'product_name' => 'required|unique:inventory_new,product_name,NULL,id,del_status,0',
            'barcode' => 'unique:inventory_new',
            'isbn' => 'unique:inventory_new',

        ]);

        $data = array(

            "net_weight" => $request->net_weight,
            "product_id" => $request->product_id,
            "product_name" => $request->product_name,
            "size" => $request->size,
            "barcode" => $request->barcode,
            "description" => $request->description,
            "mrp" => $request->mrp,
            "discount" => $request->discount,
            "discounted_price" => $request->discounted_price,
            "sales_price" => $request->sales_price,
            "shipping_charges" => $request->shipping_charges,
            "hsncode" => $request->hsncode,
            "gst" => $request->gst,
            "country_of_origin" => $request->country_of_origin,
            "color" => $request->color,
            "manufacturer_detail" => $request->manufacturer_detail,
            "packer_detail" => $request->packer_detail,
            "net_quantity" => $request->net_quantity,
            "character" => $request->character,
            "material" => $request->material,
            "no_of_compartment" => $request->no_of_compartment,
            "brand" => $request->brand,
            "backpack_style" => $request->backpack_style,
            "bag_capacity" => $request->bag_capacity,
            "gender" => $request->gender,
            "pattern" => $request->pattern,
            "recommended_age" => $request->recommended_age,
            "importer_detail" => $request->importer_detail,
            "created_at" =>  date('Y-m-d H:i:s'),
            "cat_id" => $request->cat_id

        );



        $res = InventoryformsModel::insert($data);



        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('inventory_kids')->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    public function inventory_mensfashion(string $id)

    {
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();


        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();




        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }



        return view('inventory_men_fashion', array('size_list' => $sizelist, 'categoryid' => $categoryid, 'brand' => $brand, 'colour' => $colour, 'gst' => $gst, 'size' => $size, 'qtyunit' => $qtyunit));
    }

    public function add_inventory_mensfashion(Request $request)

    {
        $validatedData = $request->validate([

            'product_name' => 'required|unique:inventory_new,product_name,NULL,id,del_status,0',
            'barcode' => 'unique:inventory_new',
            'isbn' => 'unique:inventory_new',
        ]);

        $data = array(

            "net_weight" => $request->net_weight,
            "product_id" => $request->product_id,
            "product_name" => $request->product_name,
            "size" => $request->size,
            "barcode" => $request->barcode,
            "description" => $request->description,
            "mrp" => $request->mrp,
            "discount" => $request->discount,
            "discounted_price" => $request->discounted_price,
            "sales_price" => $request->sales_price,
            "shipping_charges" => $request->shipping_charges,
            "hsncode" => $request->hsncode,
            "gst" => $request->gst,
            "country_of_origin" => $request->country_of_origin,
            "size_chart" => $request->size_chart, //image
            "color" => $request->color,
            "fabric" => $request->fabric,
            "fit" => $request->fit,
            "net_quantity" => $request->net_quantity,
            "neck" => $request->neck,
            "pattern" => $request->pattern,
            "sleeve_length" => $request->sleeve_length,
            "manufacturer_detail" => $request->manufacturer_detail,
            "packer_detail" => $request->packer_detail,
            "brand" => $request->brand,
            "importer_detail" => $request->importer_detail,
            "created_at" =>  date('Y-m-d H:i:s'),
            "cat_id" => $request->cat_id

        );

        $res = InventoryformsModel::insert($data);
        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('inventory_women_fashion')->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    public function inventory_womenfashion(string $id)

    {
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();




        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }



        return view('inventory_women_fashion', array('size_list' => $sizelist, 'categoryid' => $categoryid, 'brand' => $brand, 'colour' => $colour, 'gst' => $gst, 'size' => $size, 'qtyunit' => $qtyunit));
    }

    public function add_inventory_womenfashion(Request $request)

    {
        $validatedData = $request->validate([

            'product_name' => 'required|unique:inventory_new,product_name,NULL,id,del_status,0',
            'barcode' => 'unique:inventory_new',
            'isbn' => 'unique:inventory_new',

        ]);

        $data = array(

            "net_weight" => $request->net_weight,
            "product_id" => $request->product_id,
            "product_name" => $request->product_name,
            "size" => $request->size,
            "barcode" => $request->barcode,
            "description" => $request->description,
            "mrp" => $request->mrp,
            "discount" => $request->discount,
            "discounted_price" => $request->discounted_price,
            "sales_price" => $request->sales_price,
            "shipping_charges" => $request->shipping_charges,
            "hsncode" => $request->hsncode,
            "gst" => $request->gst,
            "country_of_origin" => $request->country_of_origin,
            "size_chart" => $request->size_chart, //image
            "bottom_type" => $request->bottom_type,
            "bottomwear_color" => $request->bottomwear_color,
            "bottomwear_fabric" => $request->bottomwear_fabric,
            "color" => $request->color,
            "fabric" => $request->fabric,
            "fit" => $request->fit,
            "kurta_color" => $request->kurta_color,
            "kurta_fabric" => $request->kurta_fabric,
            "length" => $request->length,
            "net_quantity" => $request->net_quantity,
            "neck" => $request->neck,
            "set_type" => $request->set_type,
            "occasion" => $request->occasion,
            "ornamentation" => $request->ornamentation,
            "pattern" => $request->pattern,
            "pattern_type" => $request->pattern_type,
            "sleeve_length" => $request->sleeve_length,
            "sleeve_styling" => $request->sleeve_styling,
            "manufacturer_detail" => $request->manufacturer_detail,
            "packer_detail" => $request->packer_detail,
            "brand" => $request->brand,
            "importer_detail" => $request->importer_detail,
            "created_at" =>  date('Y-m-d H:i:s'),
            "cat_id" => $request->cat_id

        );

        $res = InventoryformsModel::insert($data);
        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('inventory_women_fashion')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    public function inventory_health(string $id)

    {
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();




        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }


        return view('inventory_health_and_wellnes', array('size_list' => $sizelist, 'categoryid' => $categoryid, 'brand' => $brand, 'colour' => $colour, 'gst' => $gst, 'size' => $size, 'qtyunit' => $qtyunit));
    }

    public function add_inventory_health(Request $request)

    {
        $validatedData = $request->validate([

            'product_name' => 'required|unique:inventory_new,product_name,NULL,id,del_status,0',
            'barcode' => 'unique:inventory_new',
            'isbn' => 'unique:inventory_new',

        ]);

        $data = array(

            "net_weight" => $request->net_weight,
            "product_id" => $request->product_id,
            "product_name" => $request->product_name,
            "size" => $request->size,
            "barcode" => $request->barcode,
            "description" => $request->description,
            "mrp" => $request->mrp,
            "discount" => $request->discount,
            "discounted_price" => $request->discounted_price,
            "sales_price" => $request->sales_price,
            "shipping_charges" => $request->shipping_charges,
            "hsncode" => $request->hsncode,
            "gst" => $request->gst,
            "country_of_origin" => $request->country_of_origin,

            "net_quantity" => $request->net_quantity,
            "sole_material" => $request->sole_material,
            "manufacturer_detail" => $request->manufacturer_detail,
            "packer_detail" => $request->packer_detail,
            "brand" => $request->brand,
            "importer_detail" => $request->importer_detail,
            "created_at" =>  date('Y-m-d H:i:s'),
            "cat_id" => $request->cat_id

        );

        $res = InventoryformsModel::insert($data);
        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('inventory_health_and_wellnes')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    public function inventory_mobiles(string $id)

    {
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();


        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();



        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }



        return view('inventory_mobiles_and_tablets', array('size_list' => $sizelist, 'categoryid' => $categoryid, 'brand' => $brand, 'colour' => $colour, 'gst' => $gst, 'size' => $size, 'qtyunit' => $qtyunit));
    }


    public function add_inventory_mobiles(Request $request)

    {
        $validatedData = $request->validate([

            'product_name' => 'required|unique:inventory_new,product_name,NULL,id,del_status,0',
            'barcode' => 'unique:inventory_new',
            'isbn' => 'unique:inventory_new',
        ]);

        $data = array(

            "net_weight" => $request->net_weight,
            "product_id" => $request->product_id,
            "product_name" => $request->product_name,
            "size" => $request->size,
            "barcode" => $request->barcode,
            "description" => $request->description,
            "mrp" => $request->mrp,
            "discount" => $request->discount,
            "discounted_price" => $request->discounted_price,
            "sales_price" => $request->sales_price,
            "shipping_charges" => $request->shipping_charges,
            "hsncode" => $request->hsncode,
            "gst" => $request->gst,
            "country_of_origin" => $request->country_of_origin,

            "color" => $request->color,
            "connectivity" => $request->connectivity,
            "operating_system" => $request->operating_system,
            "ram" => $request->ram,
            "warranty_service_type" => $request->warranty_service_type,
            "manufacturer_detail" => $request->manufacturer_detail,
            "packer_detail" => $request->packer_detail,
            "dual_camera" => $request->dual_camera,
            "expandable_storage" => $request->expandable_storage,
            "headphone_jack" => $request->headphone_jack,
            "internal_memory" => $request->internal_memory,
            "material" => $request->material,
            "no_of_primary_camera" => $request->no_of_primary_camera,
            "no_of_secondary_camera" => $request->no_of_secondary_camera,
            "importer_detail" => $request->importer_detail,
            "primary_camera" => $request->primary_camera,
            "screen_length_size" => $request->screen_length_size,
            "secondary_camera" => $request->secondary_camera,
            "sim" => $request->sim,
            "sim_type" => $request->sim_type,
            "created_at" =>  date('Y-m-d H:i:s'),
            "cat_id" => $request->cat_id

        );

        $res = InventoryformsModel::insert($data);
        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('inventory_mobiles')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    public function inventory_uniform(string $id)

    {
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();



        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }


        return view('inventory_uniform', array('size_list' => $sizelist, 'categoryid' => $categoryid, 'brand' => $brand, 'colour' => $colour, 'gst' => $gst, 'size' => $size, 'qtyunit' => $qtyunit));
    }

    public function add_inventory_uniform(Request $request)

    {
        $validatedData = $request->validate([

            'product_name' => 'required|unique:inventory_new,product_name,NULL,id,del_status,0',
            'barcode' => 'unique:inventory_new',
            'isbn' => 'unique:inventory_new',

        ]);

        $data = array(

            "net_weight" => $request->net_weight,
            "product_id" => $request->product_id,
            "product_name" => $request->product_name,
            "size" => $request->size,
            "barcode" => $request->barcode,
            "description" => $request->description,
            "mrp" => $request->mrp,
            "discount" => $request->discount,
            "discounted_price" => $request->discounted_price,
            "sales_price" => $request->sales_price,
            "shipping_charges" => $request->shipping_charges,
            "hsncode" => $request->hsncode,
            "size_chart" => $request->size_chart, //image
            "gst" => $request->gst,
            "country_of_origin" => $request->country_of_origin,
            "material" => $request->material,
            "manufacturer_detail" => $request->manufacturer_detail,
            "packer_detail" => $request->packer_detail,
            "net_quantity" => $request->net_quantity,
            "brand" => $request->brand,
            "importer_detail" => $request->importer_detail,
            "created_at" =>  date('Y-m-d H:i:s'),
            "cat_id" => $request->cat_id

        );



        $res = InventoryformsModel::insert($data);



        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('inventory_kids')->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    public function inventory_kitchen(string $id)

    {
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();



        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }



        return view('inventory_home_and_kitchen', array('size_list' => $sizelist, 'categoryid' => $categoryid, 'brand' => $brand, 'colour' => $colour, 'gst' => $gst, 'size' => $size, 'qtyunit' => $qtyunit));
    }

    public function add_inventory_kitchen(Request $request)

    {
        $validatedData = $request->validate([

            'product_name' => 'required|unique:inventory_new,product_name,NULL,id,del_status,0',
            'barcode' => 'unique:inventory_new',
            'isbn' => 'unique:inventory_new',

        ]);

        $data = array(

            "net_weight" => $request->net_weight,
            "product_id" => $request->product_id,
            "product_name" => $request->product_name,
            "size" => $request->size,
            "barcode" => $request->barcode,
            "description" => $request->description,
            "mrp" => $request->mrp,
            "discount" => $request->discount,
            "discounted_price" => $request->discounted_price,
            "sales_price" => $request->sales_price,
            "shipping_charges" => $request->shipping_charges,
            "hsncode" => $request->hsncode,
            "gst" => $request->gst,
            "country_of_origin" => $request->country_of_origin,
            "add_ons" => $request->add_ons,
            "body_material" => $request->body_material,
            "burner_material" => $request->burner_material,
            "no_of_burners" => $request->no_of_burners,
            "packaging_breadth" => $request->packaging_breadth,
            "packaging_height" => $request->packaging_height,
            "packaging_length" => $request->packaging_length,
            "packaging_unit" => $request->packaging_unit,
            "product_breadth" => $request->product_breadth,
            "product_height" => $request->product_height,
            "product_length" => $request->product_length,
            "product_unit" => $request->product_unit,
            "brand" => $request->brand,
            "manufacturer_detail" => $request->manufacturer_detail,
            "packer_detail" => $request->packer_detail,
            "importer_detail" => $request->importer_detail,
            "created_at" =>  date('Y-m-d H:i:s'),
            "cat_id" => $request->cat_id

        );

        $res = InventoryformsModel::insert($data);
        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('inventory_home_and_kitchen')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    public function inventory_musicalinstruments(string $id)

    {
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $qtyunit = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $size = managemastersizeModel::orderBy('id', 'DESC')->where('del_status', 0)->get();



        $array = array("del_status" => 0, "id" => $id);
        $invcategoryid = InventoryCatModel::where($array)->first();


        $array2 = array("del_status" => 0, "id" =>  $invcategoryid->cat_four);
        $categoryid = managesubcategorythreeModel::where($array2)->first();

        $allsize = explode(',', $categoryid['size']);
        $countsize = count($allsize);
        $sizelist = array();

        for ($i = 0; $i < $countsize; $i++) {
            $sizedata = managemastersizeModel::where('id', $allsize[$i])->first();
            array_push($sizelist, $sizedata);
        }



        return view('inventory_musical_instruments', array('size_list' => $sizelist, 'categoryid' => $categoryid, 'brand' => $brand, 'colour' => $colour, 'gst' => $gst, 'size' => $size, 'qtyunit' => $qtyunit));
    }

    public function add_inventory_musicalinstruments(Request $request)

    {
        $validatedData = $request->validate([

            'product_name' => 'required|unique:inventory_new,product_name,NULL,id,del_status,0',
            'barcode' => 'unique:inventory_new',
            'isbn' => 'unique:inventory_new',

        ]);

        $data = array(

            "net_weight" => $request->net_weight,
            "product_id" => $request->product_id,
            "product_name" => $request->product_name,
            "size" => $request->size,
            "barcode" => $request->barcode,
            "description" => $request->description,
            "mrp" => $request->mrp,
            "discount" => $request->discount,
            "discounted_price" => $request->discounted_price,
            "sales_price" => $request->sales_price,
            "shipping_charges" => $request->shipping_charges,
            "hsncode" => $request->hsncode,
            "gst" => $request->gst,
            "country_of_origin" => $request->country_of_origin,
            "color" => $request->color,
            "type" => $request->type,
            "manufacturer_detail" => $request->manufacturer_detail,
            "packer_detail" => $request->packer_detail,
            "importer_detail" => $request->importer_detail,
            "created_at" =>  date('Y-m-d H:i:s'),
            "cat_id" => $request->cat_id

        );

        $res = InventoryformsModel::insert($data);

        if ($res) {

            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {

            return redirect('inventory_musical_instruments')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    //delete inventory
    public function deleteform(Request $request)

    {

        $data = InventoryformsModel::where('id', Request('id'));

        $updData = array(

            'del_status' => 1

        );

        $res = $data->update($updData);

        if ($res) {

            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {

            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }



    //get_size_list
    public function get_size_list(Request $request)
    {
        $array = array('del_status' => 0, 'status' => 1, 'size_id' => $request->id);
        $data = managemastersizelistModel::orderBy('id', 'DESC')->where($array)->get();

        return json_encode($data);
    }



    public function showRegisterForm()
    {
        return view('registervendor');
    }


    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required|max:60',
            'email' => 'required|unique:vendor|max:255',
            'phone_no' => 'required|unique:vendor|max:15',
            'password' =>  'required|string|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return redirect('register')->withErrors($validator)->withInput();
        }

        $data = ManageuservendorModel::orderBy('id', 'DESC')->first();
        $uniqueid = "VEN-00" . $data['id'] + 1;

        $data = array(
            "unique_id" =>  $uniqueid,
            "username" => $request->username,
            "email" =>  $request->email,
            "password" =>  $request->password,
            "phone_no" =>  $request->phone_no,
            "state" =>  $request->state,
            "pincode" =>  $request->pincode,
            "address" =>  $request->address,
            "gst_no" =>  $request->gst_no,
            "status" =>  1
        );

        $res = ManageuservendorModel::insert($data);
        if ($res) {
            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {
            return redirect('register')->withErrors(['' => 'Somthing went wrong!']);
        }
    }
}
