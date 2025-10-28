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
        $filters = include base_path('/app/Data/filters.php');
        $filterableColumns = array_merge($filters['common'], $filters['extra'], ['listing_date']);

        // Create a whitelist of allowed columns
        $allowedColumns = array_flip($filterableColumns);

        foreach (request()->all() as $param => $value) {
            // Validate the parameter is allowed
            if (!isset($allowedColumns[$param]) || $value === null) {
                continue;
            }

            $column = $param; // Now validated

            // Check if this is a range filter (array with min/max keys)
            if (is_array($value) && $this->isRangeFilter($value)) {
                $this->applyRangeFilter($query, $column, $value);
            } else if (!is_array($value)) {
                // Handle single value with proper type handling
                $normalizedValue = $this->normalizeValue($value);

                // Only apply LIKE filter if value is not null after normalization
                if ($normalizedValue !== null) {
                    $this->applyCaseInsensitiveLike($query, $column, $normalizedValue);
                }
            }
            // Ignore other array types
        }

        return $query;
    }

    protected function isRangeFilter($value)
    {
        return isset($value['min']) || isset($value['max']);
    }

    protected function applyCaseInsensitiveLike($query, $column, $value)
    {
        // Use a simpler approach with JSON extraction and case conversion
        $query->where(function($q) use ($column, $value) {
            $q->whereRaw("LOWER(JSON_EXTRACT(columns, '$.\"{$column}\"')) LIKE ?", ['%' . strtolower($value) . '%'])
            ->orWhereRaw("LOWER(JSON_EXTRACT(columns, '$.{$column}')) LIKE ?", ['%' . strtolower($value) . '%']);
        });
    }

    protected function applyRangeFilter($query, $column, $value)
    {
        // Process range filter
        if (isset($value['min']) && $value['min'] !== '') {
            $minValue = $this->normalizeValue($value['min']);
            if ($minValue !== null) {
                $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(columns, ?)) >= ?', ["$.{$column}", $minValue]);
            }
        }

        if (isset($value['max']) && $value['max'] !== '') {
            $maxValue = $this->normalizeValue($value['max']);
            if ($maxValue !== null) {
                $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(columns, ?)) <= ?', ["$.{$column}", $maxValue]);
            }
        }
    }

    protected function normalizeValue($value)
    {
        // Convert empty strings to null
        if ($value === '' || $value === null) {
            return null;
        }

        // Trim whitespace for string values
        if (is_string($value)) {
            $value = trim($value);
            if ($value === '') {
                return null;
            }
        }

        // Convert numeric strings to numbers for range filters
        if (is_numeric($value)) {
            return $value + 0; // Converts to int or float
        }

        return $value;
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
