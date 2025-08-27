<?php



namespace App\Models\API;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class managesubcategorythreeModel extends Model

{

    

    use HasFactory;

    protected $table = 'master_category_sub_three';

    protected $fillable = [

        'id',

        'cat_id',

        'sub_cat_id',

        'sub_cat_id_two',

        'title',

        'size',

        'form_id',

        'status',

        'created_at',

        'del_status'

    ];



}



