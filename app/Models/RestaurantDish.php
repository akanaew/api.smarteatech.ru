<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantDish extends Model
{
    public function getNameAttribute()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    public function getDescriptionAttribute()
    {
        return $this->{'description_' . app()->getLocale()};
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo('App\Models\RestaurantDishCategory', 'category_id', 'id');
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo('App\Models\Upload', 'image_id', 'id')->withDefault(function ($upload) {
            $upload->path = __DIR__ . '/uploads/defaults/placeholder.png';
        });
    }

    protected $appends = ['name', 'description'];
    protected $hidden = ['name_ru', 'name_en', 'description_ru', 'description_en', 'category_id', 'image_id', 'created_at', 'updated_at'];
}
