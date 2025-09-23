<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Files;

class Employee extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'image'
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset("Images/Profiles") . '/' . $this->image : null;
    }

    public function office() {
        return $this->belongsTo(Office::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::created(function($employee) {
            if(request()->hasFile('image')) {
                $image = Files::moveFile(request('image'), "Images/Profiles");
                $employee->update(['image' => $image]);
                $employee->save();
            }
        });
    }
}
