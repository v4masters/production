<?php

namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Home;
use App\Models\manageAccess;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    
    
     
	//get_new_order
    function get_new_order()
    { 
        $where=array('orders.order_status'=>2,'orders.payment_status'=>2,'order_payment.status'=>1,'orders.status'=>1);
        $data= DB::table('orders')
            ->leftJoin('order_payment', 'order_payment.order_id', '=', 'orders.invoice_number')
            ->select('orders.id')
            ->where($where)
            ->whereDate('order_payment.transaction_date', Carbon::today()->toDateString())
            ->where('orders.vendor_id','like','%'.session('id').'%')
            ->count();
            
            

        return $data;
    }
    
    //home
    public function home()
    {
        $data=['new_order'=>$this->get_new_order()];
        
        return view('index', ['pagedata' => $data]);
    }
    
    
    
    
    
    
    
    
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
    
    public function index(Request $request)
{
    if ($request->session()->get('user_type') === 'vendor') {
        return view('vendor.home');
    }

    return view('admin.home');
}

}