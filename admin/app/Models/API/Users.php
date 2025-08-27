<?php

namespace App\Models\API;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'id',	
        'unique_id',	
        'user_type',	
        'name',	
        'first_name',	
        'last_name',	
        'fathers_name',
        'email',	
        'email_verified_at',	
        'password',	
        'phone_no',	
        'dob',	
        'school_code',	
        'classno',	
        'country',	
        'state',	
        'district',	
        'city',	
        'post_office',	
        'village',	
        'address',	
        'landmark',	
        'pincode',	
        'folder',
        'cod_status',
        'profile',
        'status',	
        'del_status',	
        'remember_token',	
        'created_at',	
        'updated_at',
        'userfrom',
        'lmstoken',
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
