<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class managemasterorganisationModel extends Model
{
    
    use HasFactory;
    protected $table = 'master_orgnisation';
    protected $fillable = [
     'id',
	'name',
	'email',
	'phone',
	'address',
	'city',
	'state',
	'country',	
	'zip_code',
	'whatsapp_number',	
	'password',
	'status',
	'created_at',
	'del_status'
    ];
   
}


