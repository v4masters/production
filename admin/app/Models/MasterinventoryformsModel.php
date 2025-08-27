<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class MasterinventoryformsModel extends Model

{

    

    use HasFactory;

    protected $table = 'master_inventory_form';

    protected $fillable = [

        'id',

        'route_name',

        'title',

        'status',

        'created_at',

        'del_status'

    ];

   

}