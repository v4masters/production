<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class managemasterqtyModel extends Model

{

    

    use HasFactory;

    protected $table = 'master_qty_unit';

    protected $fillable = [

        'id',

        'title',

        'unit_chart',
        'folder',

        'status',

        'created_at',

        'del_status'

    ];

   

}