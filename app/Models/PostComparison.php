<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComparison extends Model
{
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $guarded = [];

    public function post() {
        return $this->belongsTo(Post::class)->select([
            'id',
            'columns->price as price',
            'columns->currency as currency',
            'columns->property_size as property_size',
            'columns->lon as lon',
            'columns->lat as lat',
        ]);
    }
}
