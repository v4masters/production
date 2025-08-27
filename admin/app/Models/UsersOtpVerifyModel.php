<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersOtpVerifyModel extends Model
{
    
    use HasFactory;
    protected $table = 'users_otp_verify';
    protected $fillable = [
        'id',
        'user_id',
        'user_type',
        'otp',
        'otp_type',
        'sent_at',
        'status',
        'del_status',
        'created_at',
        'updated_at'
    ];

}