<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishlistModel extends Model
{
    
    use HasFactory;
    protected $table = 'wishlist';
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'session_type',
        'status',
        'del_status',
        'created_at',
        'updated_at',
    ];

}


