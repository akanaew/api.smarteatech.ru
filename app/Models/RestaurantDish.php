<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantDish extends Model
{
    public function getWeightResultAttribute() {
        if (str_contains($this->weight, '/')) {
            if (str_contains($this->weight, 'шт.')) {
                $weightArray = explode('/', $this->weight);
                $weightCount = '';
                $weightTmp = 0;
                foreach ($weightArray as $item) {
                    if (str_contains($item, ' шт.')) {
                        $weightCount = $item;
                    } else {
                        $weightTmp += (int) preg_replace("/[^,.0-9]/", '', $item);
                    }
                }
                return $weightCount . '/' .$weightTmp . ' г';
            }

            $weightArray = explode('/', $this->weight);
            $weightTmp = 0;
            foreach ($weightArray as $item) {
                $weightTmp += (int) $item;
            }

            return $weightTmp . ' г';
        }

        return $this->weight;
    }

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

    protected $appends = ['name', 'weight_result', 'description'];
    protected $hidden = ['name_ru', 'name_en', 'description_ru', 'description_en', 'category_id', 'image_id', 'created_at', 'updated_at'];
}
