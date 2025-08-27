<?php
   
namespace App\Http\Controllers\Home;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Home;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;


use App\Models\ReviewModel;
use App\Models\OrderBatch;
use App\Models\managemastersizelistModel;
   
class ReviewController extends Controller
{
    
    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }
    
    
    
    //view_review
    public function product_review_view()
    { 
        $data=ReviewModel::where(['vendor_id'=>session('id')])->get();
        return view('product_review_view', ['reviews' => $data]);
    }
    
    //product_review_edit_view
    public function product_review_edit_view(Request $request, String $id)
    {
        $data=ReviewModel::where(['id'=>$id])->first();
        return view('product_review_edit', ['review_data' => $data]);
    }
    
    //product_review_edit
    public function product_review_edit(Request $request)
    {
        $review=ReviewModel::where(['id'=>$request->id]);
        
        $res = $review->update(['status'=>$request->status]);
        
         if ($res) {
            return redirect()->back()->with('success', 'Updated successfully.');
        } else {
            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }
    
}












