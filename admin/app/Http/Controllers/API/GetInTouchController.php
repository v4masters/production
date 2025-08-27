<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\API\GetInTouchModel;
use App\Models\API\CatTwo;
use App\Models\API\CatThree;
use App\Models\API\CatFour;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
   
class GetInTouchController extends BaseController
{
    /* allcategory */
    public function getIntouch(Request $request): JsonResponse
    {
      
      $data=[
            'username'=>$request->username,
            'email'=>$request->email,
           
        ];
             
        $user = GetInTouchModel::create($data);
        if($user)
            return $this->sendResponse(1, null, "We'll Contact You Soon!");
        else 
               return $this->sendResponse(0, null, "Something Went Wrong!");
    }
}