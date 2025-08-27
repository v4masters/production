<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class OrderBatchModel extends Model

{

    use HasFactory;

    protected $table = 'order_under_batch';

    protected $fillable = ['id','batch_no','batch_id','vendor_id','total_order','print_status','comment','status','created_at','updated_at'];

								

}

