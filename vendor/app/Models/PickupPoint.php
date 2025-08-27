<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class PickupPoint extends Model

{

    use HasFactory;

    protected $table = 'pickup_points';

    protected $fillable = [
	   'uid', 
        'name',
        'email',
        'password',
        'addhar_card',
        'pan_card',
        'profile_pic',
        'address',
        'google_location',
        'contact_number',
        'opening_time',
        'closing_time',
        'notes',
        'images',
        'folder',
        'status',
        'del_status',
        'created_at',
        'updated_at'	
    ];



}



