<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function indexAction(Request $request)
    {
        if ($request->has('type') && $request->has('no_paginate')) {
            return Category::where(['type' => $request->get('type')])->get();
        }

        if ($request->has('type')) {
            return Category::where(['type' => $request->get('type')])->paginate(20);
        }

        if ($request->has('no_paginate')) {
            return Category::all();
        }

        return Category::paginate(20);
    }
}
