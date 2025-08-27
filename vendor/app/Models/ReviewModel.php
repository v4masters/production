<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewModel extends Model
{
    use HasFactory;
    protected $table = 'review';
    protected $fillable = [
        'id',	
        'product_id',	
        'user_id',	
        'vendor_id',	
        'item_type',	
        'review_comment',	
        'image',	
        'on_date',	
        'status',	
        'del_status',	
        'created_at',	
        'updated_at',	
    ];

}