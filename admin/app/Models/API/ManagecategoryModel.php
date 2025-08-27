<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagecategoryModel extends Model
{
    
    use HasFactory;
    protected $table = 'master_category';
    protected $fillable = [
        'id',
        'name',
        'des',
        'market_fee',
        'img_icon',
        'folder',
        'img',
        'status',
        'created_at',
        'del_status'
    ];

}
