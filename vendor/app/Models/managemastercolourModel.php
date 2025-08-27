<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class managemastercolourModel extends Model

{

    

    use HasFactory;

    protected $table = 'master_colour';

    protected $fillable = [

        'id',

        'title',

        'status',

        'created_at',

        'del_status'

    ];

   

}