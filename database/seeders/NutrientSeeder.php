<?php

namespace Database\Seeders;

use App\Models\Nutrient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NutrientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vitamins = [
            "Витамин А, РЭ",
            "бета Каротин",
            "Витамин В1, тиамин",
            "Витамин В2, рибофлавин",
            "Витамин В4, холин",
            "Витамин В5, пантотеновая",
            "Витамин В6, пиридоксин",
            "Витамин В9, фолаты",
            "Витамин В12, кобаламин",
            "Витамин C, аскорбиновая",
            "Витамин D, кальциферол",
            "Витамин Е, альфа токоферол, ТЭ",
            "Витамин Н, биотин",
            "Витамин К, филлохинон",
            "Витамин РР, НЭ",
        ];
        $minerals = [
            "Калий, K",
            "Кальций, Ca",
            "Кремний, Si",
            "Магний, Mg",
            "Натрий, Na",
            "Сера, S",
            "Фосфор, P",
            "Хлор, Cl",
            "Железо, Fe",
            "Йод, I",
            "Кобальт, Co",
            "Марганец, Mn",
            "Медь, Cu",
            "Молибден, Mo",
            "Селен, Se",
            "Фтор, F",
            "Хром, Cr",
            "Цинк, Zn",
        ];
        foreach ($vitamins as $v) {
            $nutrient = new Nutrient();
            $nutrient->name_ru = $v;
            $nutrient->name_en = $v;
            $nutrient->type = "vitamins";
            if (!$nutrient->save()) {
                echo "Нутриент \"{$v}\" не сохранен!\n";
            } else {
                echo "Нутриент \"{$v}\" сохранен!\n";
            }
        }
        foreach ($minerals as $m) {
            $nutrient = new Nutrient();
            $nutrient->name_ru = $m;
            $nutrient->name_en = $m;
            $nutrient->type = "minerals";
            if (!$nutrient->save()) {
                echo "Нутриент \"{$m}\" не сохранен!\n";
            } else {
                echo "Нутриент \"{$m}\" сохранен!\n";
            }
        }
    }
}
