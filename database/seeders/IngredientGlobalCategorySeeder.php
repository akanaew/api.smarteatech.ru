<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PHPHtmlParser\Dom;

class IngredientGlobalCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dom = new Dom();
        $root = $dom->loadFromUrl('http://health-diet.ru/table_calorie/');
        $container = $root->find(".mzr-block-content > .uk-grid.uk-grid-medium")[0];
        foreach ($container->find('a.mzr-tc-group-item-href') as $link) {
            $category_name = $link->innerText;
            if ($category_name !== 'Фаст-фуд') {
                $category = new Category();
                $category->name_en = $category_name;
                $category->name_ru = $category_name;
                $category->type = 'ingredients';
                if (!$category->save()) {
                    echo "Категория \"{$category_name}\" не сохранена!\n";
                } else {
                    echo "Категория \"{$category_name}\" сохранена!\n";
                }
            }
        }
    }
}
