<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PincodeListModel extends Model
{
    
    use HasFactory;
    protected $table = 'pincode_list';
    protected $fillable = [
        'id',
        'pincode',
    ];

}


