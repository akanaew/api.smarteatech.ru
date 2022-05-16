<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantDishCategory extends Model
{
    public function getNameAttribute()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    protected $appends = ['name'];
    protected $hidden = ['name_ru', 'name_en', 'restaurant_id', 'created_at', 'updated_at'];
}
