<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class managemasterbrandModel extends Model

{

    

    use HasFactory;

    protected $table = 'master_brand';

    protected $fillable = [

        'id',
        'brand_logo',
        'folder',
        'title',

        'status',

        'created_at',

        'del_status'

    ];

    

}