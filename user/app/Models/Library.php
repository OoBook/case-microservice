<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Library extends Model
{

    protected $connection = "mysql_library";

    protected $fillable = [
        'id',
        'name',
        'city'
    ];

}
