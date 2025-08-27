<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class VendorPickupLocation extends Model

{

    use HasFactory;

    protected $table = 'vendor_pickup_location';
    
    protected $fillable = [
        'id',
        'unique_id',
        'vendor_id',
        'vendor_name',
        'street_building',
        'locality',
        'city_town_vill',
        'dist',
        'state',
        'pincode',
        'country',
        'status',
        'del_status'
    ];



}



