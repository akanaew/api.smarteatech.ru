<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantGlobalCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Американская кухня' => 'Americancuisine cuisine',
            'Канадская кухня' => 'Canadiancuisine cuisine',
            'Английская кухня' => 'Englishcuisine cuisine',
            'Шотландская кухня' => 'Scottishcuisine cuisine',
            'Австралийская кухня' => 'Australiancuisine cuisine',
            'Абхазская кухня' => 'Abkhaziancuisine cuisine',
            'Азербайджанская кухня' => 'Azerbaijanicuisine cuisine',
            'Турецкая кухня' => 'Turkishcuisine cuisine',
            'Армянская кухня' => 'Armeniancuisine cuisine',
            'Грузинская кухня' => 'Georgiancuisine cuisine',
            'Кавказская кухня' => 'Caucasiancuisine cuisine',
            'Татарская и Башкирская кухня' => 'Tatar and Bashkircuisine cuisine',
            'Балканская кухня' => 'Balkancuisine cuisine',
            'Болгарская кухня' => 'Bulgariancuisine cuisine',
            'Русская кухня' => 'Russiancuisine cuisine',
            'Белорусская кухня' => 'Belarusiancuisine cuisine',
            'Украинская кухня' => 'Ukrainiancuisine cuisine',
            'Гуцульская кухня' => 'Hutsulskayacuisine cuisine',
            'Польская кухня' => 'Polishcuisine cuisine',
            'Бельгийская кухня' => 'Belgiancuisine cuisine',
            'Восточная и арабская кухня' => 'Oriental and Arabiccuisine cuisine',
            'Египетская кухня' => 'Egyptiancuisine cuisine',
            'Ливанская кухня' => 'Lebanesecuisine cuisine',
            'Иранская кухня' => 'Iraniancuisine cuisine',
            'Узбекская кухня' => 'Uzbekcuisine cuisine',
            'Индийская кухня' => 'Indiancuisine cuisine',
            'Тайская кухня' => 'Thaicuisine cuisine',
            'Азиатская кухня' => 'Asiancuisine cuisine',
            'Китайская кухня' => 'Chinesecuisine cuisine',
            'Японская кухня' => 'Japanesecuisine cuisine',
            'Вьетнамская кухня' => 'Vietnamesecuisine cuisine',
            'Корейская кухня' => 'Koreancuisine cuisine',
            'Гавайская кухня' => 'Hawaiiancuisine cuisine',
            'Индейская кухня' => 'Indiancuisine cuisine',
            'Колумбийская кухня' => 'Columbiancuisine cuisine',
            'Мексиканская кухня' => 'Mexicancuisine cuisine',
            'Европейская кухня' => 'Europeancuisine cuisine',
            'Итальянская кухня' => 'Italiancuisine cuisine',
            'Испанская кухня' => 'Spanishcuisine cuisine',
            'Немецкая кухня' => 'Germancuisine cuisine',
            'Французская кухня' => 'Frenchcuisine cuisine',
            'Латышская кухня' => 'Latviancuisine cuisine',
            'Чешская и Словацкая кухня' => 'Czech and Slovakcuisine cuisine',
            'Греческая кухня' => 'Greekcuisine cuisine',
            'Еврейская кухня' => 'Jewishcuisine cuisine',
            'Фаст-фуд' => 'Fast food',
            'Кофейня' => 'Coffee house',
        ];

        foreach ($categories as $key => $item) {
            $category = new Category();
            $category->type = 'restaurants';
            $category->name_en = $item;
            $category->name_ru = $key;
            $category->save();
        }
    }
}
