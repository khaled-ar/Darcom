<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    protected $guarded = ['role'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'fcm'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'whatsapp_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function general_user() {
        return $this->hasOne(GeneralUser::class);
    }

    public function office() {
        return $this->hasOne(Office::class);
    }

    public function employee() {
        return $this->hasOne(Employee::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function posts_comparisons() {
        return $this->hasMany(PostComparison::class)->with('post');
    }

    public function paths() {
        return $this->hasMany(Path::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function subscription() {
        return $this->hasOne(Subscription::class)->where('status', 'active');
    }
}
