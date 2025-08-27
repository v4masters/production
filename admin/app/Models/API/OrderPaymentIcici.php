<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPaymentIcici extends Model
{
    
    use HasFactory;
    protected $table = 'order_payment_icici';
    protected $fillable = [
        'id',
        'uid',
        'response_code',
        'unique_ref_number',
        'service_tax_amount',
        'processing_fee_amount',
        'total_amount',
        'transaction_amount',
        'transaction_date',
        'interchange_value',
        'tdr',
        'payment_mode',
        'submerchantid',
        'order_id',
        'rs',
        'tps',
        'mandatory_fields',
        'optional_fields',
        'rsv',
        'del_status',
        'updated_at',
        'status',
        'created_at',
    ];

}
