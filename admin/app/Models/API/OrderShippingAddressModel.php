<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class OrderShippingAddressModel extends Model

{
    use HasFactory;

    protected $table = 'order_shipping_address';

    protected $fillable = [
	    'id',	
        'user_id',	
        'invoice_number',
        'address_type',
        'name',	
        'phone_no',	
        'school_code',
        'school_name',
        'alternate_phone',	
        'village',	
        'address',	
        'post_office',	
        'pincode',	
        'city',	
        'state',	
        'district',	
        'status',	
        'del_status',	
        'created_at',	
        'updated_at',	
    ];
}



