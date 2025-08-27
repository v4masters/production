<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GetInTouchModel extends Model
{
    
    use HasFactory;
    protected $table = 'get_in_touch';
    protected $fillable = [
        'id',
        'email',
        'username',
        'status',
        'del_status',
        'created_at',
        'updated_at',
    ];

}


