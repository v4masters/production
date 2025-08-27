<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class VendorBankDetailModel extends Model

{

    use HasFactory;

    protected $table = 'vendor_bank';

    protected $fillable = [
       'id',	
'vendor_id',	
'acc_holder_name',	
'acc_number',	
'bank_name',	
'bank_branch',	
'ifsc_code',	
'bank_state',	
'bank_district',	
'bank_address',	
'created_at',	
'updated_at',	
'status',	
'del_status',	

    ];
}

