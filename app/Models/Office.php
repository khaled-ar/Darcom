<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Files;

class Office extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($office) {
            if(request()->hasFile('logo')) {
                $logo = Files::moveFile(request('logo'), "Logos");
                $office->update(['logo' => $logo]);
                $office->save();
            }
        });
    }

}
