<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAdmin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    protected $fillable = [
        'id',
        'ci_session_id',
        'unique_id',
        'name',	
        'email'	,
        'username',	
        'password',	
        'contact',	
        'address'	,
        'profile_pic',
        'folder',
        'status',
        'del_status',
        'access_id',
        'type',
        'created_at',
        'updated_at',
    ];


}

