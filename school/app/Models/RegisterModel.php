<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterModel extends Model
{
    
    use HasFactory;
    protected $table = 'school';
    protected $fillable = [
        'id',	
'unique_id',	
'admin_name',	
'admin_email',	
'admin_phone',	
'admin_address',	
'school_name',	
'school_email',	
'school_phone',	
'school_address',
'landline_no',
'country',	
'state',	
'distt',	
'city',
'tehsil',	
'village',	
'post_office',	
'zipcode',
'address',	
'landmark',	
'school_code',	
'admin_profile',	
'school_banner',	
'folder',
'username',	
'password',	
'status',	
'del_status',	
'created_at'
    ];
   
}


	

	