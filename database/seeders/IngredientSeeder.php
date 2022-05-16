<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\IngredientNutrient;
use App\Models\Nutrient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PHPHtmlParser\Dom;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $minerals = [
            'Калий, K',
            'Кальций, Ca',
            'Кремний, Si',
            'Магний, Mg',
            'Натрий, Na',
            'Сера, S',
            'Фосфор, P',
            'Хлор, Cl',
            'Железо, Fe',
            'Йод, I',
            'Кобальт, Co',
            'Марганец, Mn',
            'Медь, Cu',
            'Молибден, Mo',
            'Селен, Se',
            'Фтор, F',
            'Хром, Cr',
            'Цинк, Zn',
        ];
        $vitamins = [
            'Витамин А, РЭ',
            'бета Каротин',
            'Витамин В1, тиамин',
            'Витамин В2, рибофлавин',
            'Витамин В4, холин',
            'Витамин В5, пантотеновая',
            'Витамин В6, пиридоксин',
            'Витамин В9, фолаты',
            'Витамин В12, кобаламин',
            'Витамин C, аскорбиновая',
            'Витамин D, кальциферол',
            'Витамин Е, альфа токоферол, ТЭ',
            'Витамин Н, биотин',
            'Витамин К, филлохинон',
            'Витамин РР, НЭ',
        ];

        $dom = new Dom();
        $rootPage = $dom->loadFromUrl('http://health-diet.ru/table_calorie/');
        foreach ($rootPage->find('.uk-grid.uk-grid-medium')[0]->find('.mzr-tc-group-item-href') as $link) {
            if ($link->innerText !== 'Фаст-фуд') {
                $category = Category::where([['name_ru', $link->innerText], ['type', 'ingredients']])->first();
                $categoryPage = $dom->loadFromUrl('http://health-diet.ru' . $link->href);
                foreach ($categoryPage->find('.uk-table.mzr-tc-group-table.uk-table-hover.uk-table-striped.uk-table-condensed')[0]->find('a') as $ingredientLink) {
                    $name = $ingredientLink->innerText;
                    $ingredientPage = $dom->loadFromUrl('http://health-diet.ru' . $ingredientLink->href);
                    $elTable = $ingredientPage->find('.el-table')[0];
                    $calories = (float)$elTable->find('tr')[1]->find('td')[2]->innerText;
                    $proteins = (float)$elTable->find('tr')[2]->find('td')[2]->innerText;
                    $fats = (float)$elTable->find('tr')[3]->find('td')[2]->innerText;
                    $carbohydrates = (float)$elTable->find('tr')[4]->find('td')[2]->innerText;
                    $dietary_fiber = (float)$elTable->find('tr')[5]->find('td')[2]->innerText;
                    $water = (float)$elTable->find('tr')[6]->find('td')[2]->innerText;
                    $nutrientTable = $ingredientPage->find('.mzr-table.mzr-table-border.mzr-tc-chemical-table')[0];
                    $ingredient = new Ingredient();
                    $ingredient->name_ru = $name;
                    $ingredient->name_en = $name;
                    $ingredient->category_id = $category->id;
                    $ingredient->calories = $calories;
                    $ingredient->proteins = $proteins;
                    $ingredient->fats = $fats;
                    $ingredient->carbohydrates = $carbohydrates;
                    $ingredient->dietary_fiber = $dietary_fiber;
                    $ingredient->water = $water;
                    if ($ingredient->save()) {
                        echo $ingredient->id . ") " . $ingredient->name_en . "| Success save! \r\n";
                        foreach ($nutrientTable->find('tr') as $key => $row) {
                            if (in_array($row->find('td')[0]->innerText, $vitamins)) {
                                $vitamin = Nutrient::where('name_ru', $row->find('td')[0]->innerText)->first();
                                $ingredientVitamin = new IngredientNutrient();
                                $ingredientVitamin->ingredient_id = $ingredient->id;
                                $ingredientVitamin->nutrient_id = $vitamin->id;
                                $ingredientVitamin->amount = (float)$row->find('td')[1]->innerText;
                                if ($ingredientVitamin->save()) {
                                    echo $ingredient->id . ") " . $ingredient->name_en . "| Success vitamin save! \r\n";
                                } else {
                                    echo $ingredient->name_en . "| Error vitamin save! \r\n";
                                }
                            };
                            if (in_array($row->find('td')[0]->innerText, $minerals)) {
                                $mineral = Nutrient::where('name_ru', $row->find('td')[0]->innerText)->first();
                                $ingredientMineral = new IngredientNutrient();
                                $ingredientMineral->ingredient_id = $ingredient->id;
                                $ingredientMineral->nutrient_id = $mineral->id;
                                $ingredientMineral->amount = (float)$row->find('td')[1]->innerText;
                                if ($ingredientMineral->save()) {
                                    echo $ingredient->id . ") " . $ingredient->name_en . "| Success mineral save! \r\n";
                                } else {
                                    echo $ingredient->name_en . "| Error mineral save! \r\n";
                                }
                            };
                        }
                    } else {
                        echo $category->name_en . "| Error save! \r\n";
                    }
                }
            }
        }
    }
}
