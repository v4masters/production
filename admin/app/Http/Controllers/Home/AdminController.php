<?php

namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Home;
use App\Models\SubAdmin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showFrom()
    {
        return view('subadmin_add');
    }

    public function store(Request $request)
    {
        $model = new SubAdmin();
        $model->name = request('name');
        $model->email = request('email');
        $model->username = request('username');
        $model->password = request('password');
        $model->contact = request('contact');
        $model->address = request('address');
        $model->status =1;
        $model->access_id =1;
        $res=SubAdmin::create($request->all());
        if($res)
        {
         return redirect()->back()->with('success', 'Submitted successfully.');
        }
        else
        {
        return redirect('add_sub_admin')->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    public function ViewForm()
    {
        $data=SubAdmin::orderBy('id', 'DESC')->get();
        return view('subadmin_view', ['pagedata' => $data]);
    }

    

}
