<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Files;

class GeneralUser extends Model
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
        return asset("Images/Profiles") . '/' . $this->image;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function($general_user) {
            if(request('image') && request('image') !== $general_user->getOriginal('image')) {
                // Delete old image if it exists
                $old = $general_user->getOriginal('image');
                if ($old) {
                    Files::deleteFile(public_path("Images/Profiles/{$old}"));
                }

                // Move and set new image
                $image = Files::moveFile(request('image'), 'Images/Profiles');
                $general_user->image = $image;
            }
        });
    }

}
