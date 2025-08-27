<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatOne extends Model
{
    
    use HasFactory;
    protected $table = 'master_category';
    protected $fillable = [
        'id',
        'name',
        'des',
        'market_fee',
        'img_icon',
        'img',
        'folder',
        'status',
        'created_at',
        'del_status'
    ];

}
