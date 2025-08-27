<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class managesubcategoryModel extends Model
{
    
    use HasFactory;
    protected $table = 'master_category_sub';
    protected $fillable = [
        'id',
        'cat_id',
        'des',
        'name',
        'market_fee',
        'img',
        'img_icon',
        'folder',
        'status',
        'created_at',
        'del_status'
    ];

}