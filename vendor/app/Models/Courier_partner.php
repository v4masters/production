<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class Courier_partner extends Model

{

    use HasFactory;

    protected $table = 'admin_courier_partner';
    
    protected $fillable = [
        'id','title', 'url', 'channel_id','courier_partner', 'username', 'password',
        'token', 'access_key', 'secret_key', 'status', 'del_status'
    ];



}



