<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_dishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->foreign('restaurant_id')->references('id')->on('restaurants');
            $table->string('name_en');
            $table->string('name_ru');
            $table->text('description_en');
            $table->text('description_ru');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('restaurant_dish_categories');
            $table->unsignedBigInteger('image_id');
            $table->foreign('image_id')->references('id')->on('uploads');
            $table->float('calories')->default(0.0);
            $table->float('proteins')->default(0.0);
            $table->float('fats')->default(0.0);
            $table->float('carbohydrates')->default(0.0);
            $table->string('weight');
            $table->boolean('gluten_free')->default(false);
            $table->boolean('vegetarians')->default(false);
            $table->boolean('hot')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_dishes');
    }
};
