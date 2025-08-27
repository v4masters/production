<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryVenImgModel extends Model
{
    
    use HasFactory;
    protected $table = 'inventory_images_vendor';
    protected $fillable = [
        'id',
        'vendor_id',
       	'item_id',
       	'image',
       	'size_id',
       	'alt',
       	'folder',
        'updated_at',
        'dp_status',
        'status',
        'created_at',
        'del_status'
    ];

}
