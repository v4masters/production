<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class managemastersizeModel extends Model
{
    
    use HasFactory;
    protected $table = 'sizes';
    protected $fillable = [
        'id',
        'title',
        'chart',
        'folder',
        'status',
        'created_at',
        'del_status'
    ];
   
}