<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientsController extends Controller
{
    public function getByName(Request $request)
    {
        $ingredients =
            Ingredient::where([
                ['name_'.app()->getLocale(), 'ILIKE', '%' . $request->get('name') . '%']
            ])->get();
        return response()->json($ingredients);
    }
}
