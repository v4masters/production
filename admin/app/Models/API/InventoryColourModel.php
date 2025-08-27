<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryColourModel extends Model
{
    
    use HasFactory;
    protected $table = 'inventory_colours';
    protected $fillable = [
        'id',
       	'item_id',
       	'colour_title',
       	'qty',
        'updated_at',
        'status',
        'created_at',
        'del_status'
    ];

}
