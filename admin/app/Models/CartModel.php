<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    
    use HasFactory;
    protected $table = 'cart';
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'vendor_id',
        'item_type',
        'set_id',
        'set_type',
        'set_status',
        'session_type',
        'qty',
        'size',
        'status',
        'del_status',
        'created_at',
        'updated_at',
    ];

}


