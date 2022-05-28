<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantDish;
use App\Models\RestaurantDishCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestaurantsController extends Controller
{
    public function indexAction(Request $request): JsonResponse
    {
        if ($request->has('category_id')) {
            return response()->json(Restaurant::with(['logo', 'category'])->where('category_id', $request->get('category_id'))->with('category')->paginate(40));
        }

        return response()->json(Restaurant::with(['logo', 'category'])->paginate(40));
    }

    public function getRestaurantAction(Request $request, $restaurantId)
    {
        return response()->json(Restaurant::with(['logo', 'category'])->find($restaurantId));
    }

    public function getRestaurantCategoriesAction(Request $request, $restaurantId): JsonResponse
    {
        return response()->json(RestaurantDishCategory::where('restaurant_id', $restaurantId)->get());
    }

    public function getRestaurantDishesAction(Request $request, $restaurantId): JsonResponse {
        if ($request->has('category_id')) {
            return response()->json(RestaurantDish::with(['category', 'image'])->where([
                ['restaurant_id', $restaurantId],
                ['category_id', $request->get('category_id')],
            ])
                ->orderBy("name_" . app()->getLocale())
                ->paginate(40));
        }

        return response()->json(RestaurantDish::with(['category', 'image'])
            ->where('restaurant_id', $restaurantId)
            ->orderBy("name_" . app()->getLocale())
            ->paginate(40));
    }

    public function getRestaurantDishAction(Request $request, $restaurantId, $dishId): JsonResponse {
        return response()->json(RestaurantDish::with(['category', 'image'])->where([
            ['restaurant_id', $restaurantId],
            ['id', $dishId],
        ])
            ->orderByDesc("calories")
            ->orderByDesc("proteins")
            ->orderByDesc("fats")
            ->orderByDesc("carbohydrates")
            ->first());
    }
}
