<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class test_ship_rocket extends Model
{
    use HasFactory;
    protected $table = 'test_ship_rocket';
    protected $fillable = [
        'id',	
       	'name',
       	'created_at',
        'updated_at',
    ];

}