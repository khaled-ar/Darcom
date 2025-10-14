<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'icon'
    ];

    protected $appends = [
        'icon_url',
    ];

    public function getIconUrlAttribute()
    {
        return $this->icon ? asset("Images/Icons") . '/' . $this->icon : null;
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }
}
