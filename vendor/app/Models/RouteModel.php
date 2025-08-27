<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteModel extends Model
{
    use HasFactory;
    protected $table = 'route';
    protected $fillable = [
    	'id',
    	'unique_id',
    	'vendor_id',
    	'source',
    	'google_source',
    	'goole_destination',
    	'source_latitude',
    	'source_longitude',
    	'destination',
    	'destination_latitude',
    	'destination_longitude',
    	'comment',
    	'status',
    	'del_status',
    	'created_at',
    	'updated_at',
    ];

}
