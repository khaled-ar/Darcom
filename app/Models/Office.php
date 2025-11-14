<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Files;
use Illuminate\Support\Facades\DB;

class Office extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'logo'
    ];

    protected $appends = [
        'logo_url',
    ];

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset("Images/Logos") . '/' . $this->logo : null;
    }

    public function work_times() {
        return $this->hasMany(WorkTime::class);
    }

    public function social_links() {
        return $this->hasMany(SocialLink::class);
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public function ratings() {
        return $this->hasMany(Rating::class);
    }

    public function verifications() {
        return $this->hasMany(Verification::class);
    }

    public function user() {
        return $this->belongsTo(User::class)->select([
            'id', '2FA'
        ]);
    }

    protected static function booted()
    {
        static::retrieved(function ($office) {
                $ratings = $office->ratings();
                $count = $ratings->count();
                $rate = $count > 0 ? number_format($ratings->sum('value') / $count, 1) : "0.0";
                $rate = $rate > 5 ? "5.0" : $rate;
                $rate = $rate < 0.5 ? "0.0" : $rate;
                if ($count >= 1000) {
                    $units = ['', 'K', 'M', 'B', 'T'];
                    $pow = floor(($count ? log($count) : 0) / log(1000));
                    $pow = min($pow, count($units) - 1);
                    $count /= pow(1000, $pow);
                    $count = round($count, 1) . ' ' . $units[$pow];
                }
                $office->setAttribute('rate', $rate . '|' . $count);
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function($office) {
            if(request()->hasFile('logo')) {
                DB::transaction(function() use ($office) {
                    $logo = Files::moveFile(request('logo'), "Images/Logos");
                    $office->update(['logo' => $logo]);
                    $office->social_links()->create([
                        'whatsapp_link' => request('whatsapp_link'),
                        'facebook_link' => request('facebook_link'),
                        'twitter_link' => request('twitter_link'),
                        'instagram_link' => request('instagram_link'),
                        'telegram_link' => request('telegram_link'),
                    ]);
                    $work_times = request('work_times');
                    if($work_times) {
                        foreach($work_times as $work_time) {
                            $data = explode(',', $work_time);
                            $office->work_times()->create([
                                'day' => $data[0],
                                'start' => $data[1],
                                'end' => $data[2],
                            ]);
                        }
                    }
                    $office->save();
                });
            }
        });
    }

}
