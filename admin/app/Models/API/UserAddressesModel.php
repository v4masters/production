<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddressesModel extends Model
{
    use HasFactory;
        protected $table = 'user_addresses';
        protected $primaryKey = 'id';
        
        protected $fillable = [
            'id',
            'user_id',
            'school_code',
            'address_type',
            'default_address',
            'name',
            'phone_no',
            'alternate_phone',
            'village',
            'city',
            'state',
            'district',
            'post_office',
            'pincode',
            'address',
            'status',
            'created_at',
            'updated_at',
            'del_status'
        ];

        public $timestamps = false;
                                                           
    }