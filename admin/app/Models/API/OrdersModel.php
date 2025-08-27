<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class OrdersModel extends Model

{

    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
	    'id',	
        'invoice_number',
        'pp_id',
        'user_type',	
        'user_id',
        'vendor_id',
        'class',	
        'order_total',
        'grand_total',
        'mode_of_payment',	
        'shipping_charge',	
        'discount',	
        'payment_status',	
        'order_status',	
        'bill_status',	
        'order_date',	
        'order_month',	
        'order_year',	
        'order_time',	
        'print_status',	
        'custom_set_status',
        'delivery_status',	
        'order_weight',	
        'status',	
        'del_satus',	
        'created_at',	
        'updated_at',
    ];


}

