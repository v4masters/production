<?php

namespace App\Models;

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
        'folder',
        'img_icon',
        'status',
        'created_at',
        'del_status'
    ];

}