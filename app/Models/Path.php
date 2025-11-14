<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'images',
        'videos',
        'columns'
    ];
}
