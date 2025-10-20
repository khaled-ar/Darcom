<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'images',
        'videos',
        'columns'
    ];

    protected $appends = [
        'images_urls',
        'videos_urls',
        'columns_values',
        'in_favorite'
    ];

    public function scopeCategory($query)
    {
        return request('category_id') ? $query->whereCategoryId(request('category_id')) : $query;
    }

    public function scopeFilters($query)
    {
        $filterableColumns = array_keys(json_decode($this->columns, true) ?? []);

        foreach ($filterableColumns as $column) {
            if (request()->has($column) && request($column) !== null) {
                $value = request($column);

                if (is_array($value)) {
                    if (isset($value['min']) || isset($value['max'])) {
                        // Range filter
                        if (isset($value['min']) && $value['min'] !== '') {
                            $min = $value['min'];
                            $query->where("columns->{$column}", '>=', $min);
                        }
                        if (isset($value['max']) && $value['max'] !== '') {
                            $max = $value['max'];
                            $query->where("columns->{$column}", '<=', $max);
                        }
                    }

                } else {
                    // Single value
                    $query->where("columns->{$column}", $value);
                }
            }
        }

        return $query;
    }

    public function getInFavoriteAttribute()
    {
        return in_array($this->id, request()->user()->favorites()->pluck('post_id')->toArray());
    }

    public function getColumnsValuesAttribute()
    {
        return json_decode($this->columns);
    }

    public function getImagesUrlsAttribute()
    {
        return $this->images ? collect(explode(",", $this->images))->map(function ($image) {
            return asset('Images/Posts') . '/' . $image;
        }) : null;
    }

    public function getVideosUrlsAttribute()
    {
        return $this->videos ? collect(explode(",", $this->videos))->map(function ($video) {
            return asset('Videos/Posts') . '/' . $video;
        }) : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class)->with(['employee', 'general_user']);
    }
}
