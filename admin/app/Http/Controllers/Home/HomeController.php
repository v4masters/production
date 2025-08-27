<?php

namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Home;
use App\Models\manageAccess;

class HomeController extends Controller
{
    public function showForm()
    {
        $data=manageAccess::orderBy('id', 'DESC')->where('del_status',0)->get();
        return view('access_manage', ['pagedata' => $data]);
    }

    public function add_data(Request $request)
    {
        $model = new manageAccess();
        $model->feature = request('feature');
        $model->controller = request('controller');
        $res=manageAccess::create($request->all());
        if($res)
        {
         return redirect()->back()->with('success', 'Submitted successfully.');
        }
        else
        {
        return redirect('manage_access')->withErrors(['' => 'Somthing went wrong!']);
        }
    }
    public function edit(string $id)
    {
        $data['pagedata']=manageAccess::where('id', $id)->first();
        return view('access_admin_edit',  $data);
    }
    
    public function update(Request $request)
    {
        $id=request('id');
        $access = manageAccess::findOrFail($id);

        // Validate the input data
        $validatedData = $request->validate([
            'feature' => 'required',
            'controller' => 'required',
        ]);

        // Update the data
       $res= $access->update($validatedData);
       if($res)
        {
         return redirect()->back()->with('success', 'Updated successfully.');
        }
        else
        {
        return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }
// public function destroy(string $id)
    // {
    //     $data = manageAccess::findOrFail($id);
    //     $data->delete();
    //     return redirect()->route('products')->with('success', 'product deleted successfully');
    // }
}