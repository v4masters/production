<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    
    use HasFactory;
    protected $table = 'testtokenlist';
    protected $fillable = [
        'id',
        'email',
        'phone_no',
        'token',
    ];

}


