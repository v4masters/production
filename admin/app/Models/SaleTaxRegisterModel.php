<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleTaxRegisterModel extends Model

{

    use HasFactory;

    protected $table = 'sale_tax_register';

    protected $fillable = [
	   					
    'id',
    'batch_id',
    'vendor_id',
    'order_id',
    'user_id',
    'bill_no',
    'bill_id',
    'total_amount',
    'total_discount',
    'shipping_charge',
    'gst_type',
    'gst_0',
    'gst_5',
    'gst_12',
    'gst_18',
    'gst_28',
    'vendor_state_code',
    'user_state_code',
    'status',
    'del_status',
    'created_at',
    'updated_at',
    'deliver_on',
    'bill_date',
    'bill_status',
    'payout_date',
    'delivery_status',
    'payout_status',
    ];


}

