<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryImgModel extends Model
{
    
    use HasFactory;
    protected $table = 'inventory_images';
    protected $fillable = [
        'id',
       	'item_id',
       	'image',
       	'size_id',
       	'alt',
       	'folder',
       	'dp_status',
        'updated_at',
        'status',
        'created_at',
        'del_status'
    ];

}
