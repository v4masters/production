<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class managemastersizelistModel extends Model
{
    
    use HasFactory;
    protected $table = 'size_list';
    protected $fillable = [
        'id',
        'title',
        'size_id',
        'status',
        'del_status'
    ];
   
}