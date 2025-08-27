<?php

namespace App\Models\API;

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
'site_background_img',	
'website_img',	
'profile_img',	
'folder',	
'username',	
'password',	
'email',	
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
'created_at',	
'updated_at',	
'del_status',
    ];



}



