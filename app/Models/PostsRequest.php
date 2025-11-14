<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostsRequest extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
