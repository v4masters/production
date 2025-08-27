<?php

namespace App\Models\API;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'users';
    protected $fillable = ['id',
        'name',
        'unique_id',
        'user_type',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_no',
        'dob',
        'school_code',
        'country',
        'state',
        'distt',
        'city',
        'address',
        'landmark',
        'pincode',
        'email_verified_at',
        'status',
        'del_status',
        'remember_token',
        'created_at',
        'updated_at'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}



