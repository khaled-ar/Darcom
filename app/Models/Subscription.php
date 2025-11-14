<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = ['paid', 'status'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['date'];

    public function getDateAttribute() {
        return $this->updated_at->format('Y-m-d');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function package() {
        return $this->belongsTo(Package::class);
    }
}
