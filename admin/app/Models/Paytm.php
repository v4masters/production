<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class Paytm extends Model

{

    use HasFactory;

    protected $table = 'order_payment';

    protected $fillable = [
	'id',
	'user_id',
	'name',
	'mobile',
	'email',
	'status',
	'amount',
	'order_id',
	'pay_mode',
	'band_txn_id',
	'check_sum_hash',
	'transaction_amount',
	'transaction_id',
	'transaction_date',
	'transaction_status',
	'created_at',
	'updated_at'
    ];




	
	
	
	
	
	
	
	
	
	
	
	
	

}

