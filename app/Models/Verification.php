<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Files;

class Verification extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id_image',
        'license_image',
        'commercial_register_image',
    ];

    protected $appends = [
        'id_image_url',
        'license_image_url',
        'commercial_register_image_url'
    ];

    public function getIdImageUrlAttribute()
    {
        return $this->id_image ? asset("Images/Verifications") . '/' . $this->id_image : null;
    }

    public function getLicenseImageUrlAttribute()
    {
        return $this->license_image ? asset("Images/Verifications") . '/' . $this->license_image : null;
    }

    public function getCommercialRegisterImageUrlAttribute()
    {
        return $this->commercial_register_image ? asset("Images/Verifications") . '/' . $this->commercial_register_image : null;
    }

    public function office() {
        return $this->belongsTo(Office::class)->select([
            'id', 'name', 'admin_name', 'phone_number', 'logo'
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function($office) {
            $id_image = Files::moveFile(request('id_image'), "Images/Verifications");
            $license_image = Files::moveFile(request('license_image'), "Images/Verifications");
            $commercial_register_image = Files::moveFile(request('commercial_register_image'), "Images/Verifications");
            $office->update([
                'id_image' => $id_image,
                'license_image' => $license_image,
                'commercial_register_image' => $commercial_register_image,
            ]);
            $office->save();
        });
    }
}
