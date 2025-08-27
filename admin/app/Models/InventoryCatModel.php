<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryCatModel extends Model
{
    
    use HasFactory;
    protected $table = 'inventory_cat';
    protected $fillable = [
        'id',
        'cat_one',
        'cat_two',
        'cat_three',
        'cat_four',

        'updated_at',
        'status',
        'created_at',
        'del_status'
    ];

}
