<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function getNameAttribute()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    protected $appends = ['name'];
    protected $hidden = ['name_en', 'name_ru', 'type', 'created_at', 'updated_at'];
}
