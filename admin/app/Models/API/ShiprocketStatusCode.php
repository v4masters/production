<?php
namespace App\Models\API;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiprocketStatusCode extends Model
{
    use HasFactory;
    protected $table = 'shiprocket_status_code';
    protected $fillable = [
        'id',	
       	'status_code',
       	'des',
       	'status',
       	'del_status',
       	'created_at',
        'updated_at',
    ];

}