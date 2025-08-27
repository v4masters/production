<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class StateModel extends Model

{

    use HasFactory;

    protected $table = 'state_code';

    protected $fillable = [
       
           'id',	
           'state_code',	
           'state',

    ];
}
