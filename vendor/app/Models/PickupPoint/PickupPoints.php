<?php

namespace App\Models\PickupPoint;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class PickupPoints extends Model

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
        'pickup_point_name',
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



