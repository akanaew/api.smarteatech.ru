<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => '/categories'], function () use ($router) {
    $router->get('/', 'CategoriesController@indexAction');
});

$router->group(['prefix' => '/restaurants'], function () use ($router) {
    $router->get('/', 'RestaurantsController@indexAction');
    $router->get('/{restaurantId}', 'RestaurantsController@getRestaurantAction');
    $router->get('/{restaurantId}/categories', 'RestaurantsController@getRestaurantCategoriesAction');
    $router->get('/{restaurantId}/dishes', 'RestaurantsController@getRestaurantDishesAction');
    $router->get('/{restaurantId}/dishes/{dishId}', 'RestaurantsController@getRestaurantDishAction');
});

$router->group(['prefix' => '/ingredients'], function () use ($router) {
    $router->get('/', 'IngredientsController@getByName');
});
