<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\API\Users;
use App\Models\API\SchoolModel;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
   
class MySchoolController extends BaseController
{
    // -------------------------------My School Information-----------------------------//
    
    //getSchools
    public function getSchools(Request $request): JsonResponse
    {
        $schools = SchoolModel::select('school_code','school_name','state','distt', 'folder', 'school_banner')->where(['del_status'=>0, 'status'=>1])->orderBy('id','desc')->get();
        
        return $this->sendResponse(1, $schools, 'Success');
    }
    
    //get School information
    public function getSchoolInfo(Request $request): JsonResponse
    {
        $school = SchoolModel::where(['school_code'=> $request->school_code, 'del_status'=>0])->first();
        
        if (!$school) {
            return $this->sendResponse(0, null,'No School Found');
        }
        else
        {
            return $this->sendResponse(1, $school, 'Success');
        }
    }
}