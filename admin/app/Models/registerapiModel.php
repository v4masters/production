<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registerapiModel extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
        'unique_id',
        'user_type',
        'first_name',
        'last_name',
        'email',
        'phone_no',
        'password',
        'dob',
        'school_code',
        'folder',
        'profile',
        'country',
        'state',
        'distt',
        'city',
        'address',
        'landmark',
        'pincode',
        'created_at',
        'del_status'
    ];
   													
}
