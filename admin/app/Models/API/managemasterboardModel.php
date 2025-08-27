<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class managemasterboardModel extends Model
{
    
    use HasFactory;
    protected $table = 'master_board';
    protected $fillable = [
        'id',
        'title',
        'status',
        'created_at',
        'del_status'
    ];
   
}