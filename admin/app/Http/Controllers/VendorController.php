<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;      // For signed URLs
use App\Models\VendorModel;                   // Your Vendor model (adjust namespace if needed)

class VendorController extends Controller
{
    /**
     * Allow admin to login as vendor via signed URL.
     *
     * @param  string $vendor_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAsVendor($vendor_id)
    {
        // Find vendor by unique_id (adjust field if needed)
        $vendor = VendorModel::where('unique_id', $vendor_id)->first();

        if (!$vendor) {
            return redirect()->back()->with('error', 'Vendor not found.');
        }

        // Generate a signed URL valid for 10 minutes that routes to vendor login with token
        $url = URL::temporarySignedRoute(
            'vendor.login_with_token',       // route name (must be defined in vendor routes)
            now()->addMinutes(10),
            ['vendor' => $vendor->id]
        );

        // Redirect admin to that URL, which logs in vendor and opens vendor dashboard
        return redirect($url);
    }
}
