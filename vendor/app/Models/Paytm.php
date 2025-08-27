
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paytm extends Model
{
    
    use HasFactory;
    protected $table = 'paytm';

    protected $fillable = ['id','name','mobile','email','status','fee','order_id','transaction_id','created_at','updated_at'];
         //status = 0, failed, 
         //status = 1, success, 
         //status = 2, processing 
         
      

}