<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class managemastergstModel extends Model
{
    
    use HasFactory;
    protected $table = 'master_taxes';
    protected $fillable = [
        'id',
        'title',
        'status',
        'created_at',
        'del_status'
    ];
   
}