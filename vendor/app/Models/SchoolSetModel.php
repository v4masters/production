<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSetModel extends Model
{

    use HasFactory;
    protected $table = 'school_set';
    protected $fillable = [
       
      'id',	
      'school_id',
       'vendor_id',
       'vendor_status',
      'set_id',
      'org',	
      'board',	
      'grade',	
      'set_class',	
      'set_category',	
      'set_type',	
      'item_qty',
      'item_id',
      'status',	
      'del_status',	
      'created_at',	
      'updated_at'

    ];
}
