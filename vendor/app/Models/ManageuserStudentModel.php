<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ManageuserStudentModel extends Model

{

    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'unique_id',
        'user_type',
        'name',
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
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
        'status',
        'folder',
        'profile',
        'del_status',
        'remember_token',
        'created_at',

    ];
}
