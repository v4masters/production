<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class managemastersettypeModel extends Model
{

    use HasFactory;
    protected $table = 'master_set_type';
    protected $fillable = [
        'id',
        'title',
        'status',
        'created_at',
        'del_status'
    ];
}
