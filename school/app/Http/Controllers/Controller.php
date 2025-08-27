<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    
  public function add_image(Request $request)
  {

   
    $file = $request->file('image');
    $name = time() . $file->getClientOriginalName();
    $filePath = 'brand/' . $name;
    $re=Storage::disk('s3')->put($filePath, file_get_contents($file));
    print_r($re);



    }

}
