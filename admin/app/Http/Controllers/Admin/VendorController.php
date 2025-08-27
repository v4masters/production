<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorModel; // Adjust if needed
use Illuminate\Support\Facades\Session;

class VendorController extends Controller
{
    /**
     * Allow admin to login as vendor (simulate vendor login).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $vendor_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAsVendor(Request $request, $vendor_id)
    {
        // Find vendor by unique_id
        $vendor = VendorModel::where('unique_id', $vendor_id)->first();

        if (!$vendor) {
            return redirect()->back()->with('error', 'Vendor not found.');
        }

        // Store vendor details in session (simulate login)
        $request->session()->put('username', $vendor->username);
        $request->session()->put('email', $vendor->email);
        $request->session()->put('profile_img', $vendor->profile_img);
        $request->session()->put('id', $vendor->unique_id);
        $request->session()->put('website_img', $vendor->website_img);

        // Regenerate the session ID for security
        $request->session()->regenerate();

       return redirect('/vendor/home')->with('success', 'Logged in as vendor successfully.');

    }
}
