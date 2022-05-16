<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    public function getNameAttribute()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    protected $appends = ['name'];
    protected $hidden = ['name_en', 'name_ru', 'created_at', 'updated_at'];
}
