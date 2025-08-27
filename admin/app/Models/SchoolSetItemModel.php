<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSetItemModel extends Model
{

    use HasFactory;
    protected $table = 'school_set_item';
    protected $fillable = [
      'id',	
      'set_id',	
      'school_id',	
      'item_id',	
      'item_qty',		
      'status',	
      'del_status',	
      'created_at',	
      'updated_at'

    ];
    

}
