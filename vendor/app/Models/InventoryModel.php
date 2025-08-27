<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryModel extends Model
{
    
    use HasFactory;
    protected $table = 'inventory';
    protected $fillable = [
   	'id',
	'cat_id',
	'cover_photo',
	'itemcode',
	'barcode',
	'hsncode',
	'itemname',
	'set_category',
	'set_type',
	'medium',
	'description',
	'tags',
	'company_name',
	'edition',
	'class',
	'stream',
	'inventory_type',
	'avail_qty',
	'unit_price',
	'item_weight',
	'gst',
	'discount',
	'updated_at',
	'uploaded_by',
	'uploader_id',
	'size_chart',
    'cover_photo_2',
    'cover_photo_3',
    'cover_photo_4',
    'qty',
	'status',
	'item_type',
	'vendor_status',
	'uniform',	
	'created_at',	
	'del_status',
    ];

}


	

