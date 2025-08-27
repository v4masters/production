<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class OrderTrackingModel extends Model

{

    use HasFactory;

    protected $table = 'order_tracking';

    protected $fillable = [
	    'id',	
        'invoice_number',	
        'product_id',
        'set_id',
        'item_id',
        'item_type',
        'qty',
        'created_by',
        'vendor_id',	
        'tracking_status',	
        'shipper_name',	
        'courier_number',	
        'shipper_address',
        'shipping_partner',
        'updated_on',	
        'courier_no_status',	
        'route_id',	
        'status',	
        'active_status',
        'del_status',	
        'created_at',	
        'updated_at',	
    ];



}



