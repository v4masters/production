<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class managesubcategorytwoModel extends Model

{

    use HasFactory;

    protected $table = 'master_category_sub_two';

    protected $fillable = [

        'id',

        'cat_id',

        'sub_cat_id',

        'title',

        'status',

        'created_at',

        'del_status'

    ];



}



