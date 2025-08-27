<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aws_img_url_model extends Model
{
    
    use HasFactory;
    protected $table = 'aws_img_url_model';
    protected $fillable = [
        'id',
        'url',
        'updated_at',
        'status',
        'created_at',
        'del_status'
    ];

}
