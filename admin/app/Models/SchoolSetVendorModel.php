<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSetVendorModel extends Model
{

    use HasFactory;
    protected $table = 'school_set_vendor';
    protected $fillable = [
       
      'id',	
      'school_id',	
      'vendor_id',
      'item_id',
      'item_discount',
      'item_qty',
      'set_id',
      'org',	
      'board',	
      'grade',	
      'set_class',	
      'set_category',
      'shipping_charges',
      'shipping_chr_type',
      'set_type',	
      'status',	
      'market_place_fee',
      'del_status',	
      'created_at',	
      'updated_at'

    ];
}
	
	
