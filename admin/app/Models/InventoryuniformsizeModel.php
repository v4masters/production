<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryuniformsizeModel extends Model
{

    use HasFactory;
    protected $table = 'inv_uni_size';
    protected $fillable = [
        'id',
        'item_id',
        'size',
        'weight',
        'price_per_size',
        'uni_barcode',
        'uni_hsncode',
        'uni_gst',
        'uni_qty',
        'status',
        'created_at',
        'del_status',

    ];
}
