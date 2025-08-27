<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class VendorDocumentModel extends Model

{

    use HasFactory;

    protected $table = 'vendor_document';

    protected $fillable = [
     'id',
	'vendor_id',	
	'adhar_card',
	'pan_card',
	'gst_number',	
	'shop_act_number',
	'cancelled_cheque',
	'folder',
	'status',	
	'created_at',
	'updated_at',
	'del_status',		

    ];
}

	
