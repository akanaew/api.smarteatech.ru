<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Restaurant;
use App\Models\RestaurantDish;
use App\Models\RestaurantDishCategory;
use App\Models\Upload;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Shuchkin\SimpleXLSX;

class RestaurantSeeder extends Seeder
{
    public function grab_image($url, $saveto)
    {
        $file = file_get_contents($url);
        $savefile = fopen($saveto, 'w');
        fwrite($savefile, $file);
        fclose($savefile);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurants = [];
        $categories = [];
        $filepath_restaurants_logo = '/uploads/restaurants/logo/';
        $filepath_restaurants_dishes = '/uploads/restaurants/dishes/';
        $restaurants_filepath = 'C:\Users\angry\Desktop\Рестораны.xlsx';
        $xlsx = SimpleXLSX::parse($restaurants_filepath);
        foreach ($xlsx->rows() as $key => $row) {
            if ($key !== 0) {
                $category = Category::where('name_ru', $row[2])->first();
                $filename_origin = $row[5];
                $filename = sha1(date('YmdHis') . rand(0, 1000) . time()) . '.' . pathinfo($filename_origin, PATHINFO_EXTENSION);

                $this->grab_image($row[5], __DIR__ . '/../../public' . $filepath_restaurants_logo . $filename);

                $upload = new Upload();
                $upload->path = $filepath_restaurants_logo . $filename;
                $upload->save();

                $restaurants[$key]['name_ru'] = $row[0];
                $restaurants[$key]['name_en'] = $row[1];
                $restaurants[$key]['category_id'] = $category->id;
                $restaurants[$key]['description_en'] = $row[3];
                $restaurants[$key]['description_ru'] = $row[4];
                $restaurants[$key]['logo_id'] = $upload->id;
                $restaurants[$key]['site'] = $row[6];
                $restaurants[$key]['phone'] = $row[7];
                $restaurants[$key]['vk'] = $row[8];
                $restaurants[$key]['facebook'] = $row[9];
                $restaurants[$key]['dishes'] = [];

                $restaurantsDishesFile = SimpleXLSX::parse($row[10]);
                foreach ($restaurantsDishesFile->rows() as $k => $value) {
                    if ($k !== 0) {
                        if ($value[1] === "") {
                            $categories[$key][] = "Без категории";
                        } else {
                            $categories[$key][] = trim($value[1]);
                        }


                        $image = new Upload();
                        $image->path = $value[3];
                        $image->save();

                        $restaurants[$key]['dishes'][$k] = [
                            'name_en' => $value[0],
                            'name_ru' => $value[0],
                            'description_en' => $value[2],
                            'description_ru' => $value[2],
                            'image_id' => $image->id,
                            'calories' => (float)$value[5],
                            'proteins' => (float)$value[6],
                            'fats' => (float)$value[7],
                            'carbohydrates' => (float)$value[8],
                            'weight' => $value[9],
                            'gluten_free' => $value[10] === '+',
                            'vegetarians' => $value[11] === '+',
                            'hot' => $value[12] === '+',
                        ];

                    }
                }
            }
        }

        foreach ($restaurants as $key => $item) {
            $restaurant = new Restaurant();
            $restaurant->name_en = $item['name_en'];
            $restaurant->name_ru = $item['name_ru'];
            $restaurant->description_en = $item['description_en'];
            $restaurant->description_ru = $item['description_ru'];
            $restaurant->logo_id = $item['logo_id'];
            $restaurant->category_id = $item['category_id'];
            $restaurant->site = $item['site'];
            $restaurant->phone = $item['phone'];
            $restaurant->vk = $item['vk'];
            $restaurant->facebook = $item['facebook'];
            $restaurant->save();

            $cat_id = null;

            foreach (array_unique($categories[$key]) as $c) {
                $dc = new RestaurantDishCategory();
                $dc->restaurant_id = $restaurant->id;
                $dc->name_en = $c;
                $dc->name_ru = $c;
                $dc->save();
                $cat_id = $dc->id;
            }

            foreach ($item['dishes'] as $i) {
                $dish = new RestaurantDish();
                $dish->restaurant_id = $restaurant->id;
                $dish->name_en = $i['name_en'];
                $dish->name_ru = $i['name_ru'];
                $dish->description_en = $i['description_en'];
                $dish->description_ru = $i['description_ru'];
                $dish->image_id = $i['image_id'];
                $dish->category_id = $cat_id;
                $dish->calories = $i['calories'];
                $dish->proteins = $i['proteins'];
                $dish->fats = $i['fats'];
                $dish->carbohydrates = $i['carbohydrates'];
                $dish->weight = $i['weight'];
                $dish->gluten_free = $i['gluten_free'];
                $dish->vegetarians = $i['vegetarians'];
                $dish->hot = $i['hot'];
                $dish->save();
            }
        }
    }
}
