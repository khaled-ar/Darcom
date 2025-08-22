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
        'updated_at'
    ];

    public function work_times() {
        return $this->hasMany(WorkTime::class);
    }

    public function social_links() {
        return $this->hasMany(SocialLink::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function($office) {
            if(request()->hasFile('logo')) {
                DB::transaction(function() use ($office) {
                    $logo = Files::moveFile(request('logo'), "Logos");
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
