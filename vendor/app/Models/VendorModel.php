<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class VendorModel extends Model

{

    use HasFactory;

    protected $table = 'vendor';

    protected $fillable = [
        'id',	
        'unique_id',	
        'website_vendor_url',	
        'website_img',	
        'site_background_img',
        'profile_img',	
        'folder',	
        'username',	
        'password',	
        'email',
        'e_email',
        'e_pass',
        'e_status',
        'phone_no',	
        'gst_no',	
        'country',	
        'state',	
        'state_code',	
        'distt',	
        'city',	
        'landmark',	
        'pincode',	
        'address',	
        'address2',	
        'status',	
        'update_pp_order_status',
        'created_at',	
        'updated_at',	
        'del_status',
    ];
}

