<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories =  Category::orderBy('created_at','desc')->get(['name','created_at']);
        return response()->json($categories,200);
    }

    public function store(CategoryRequest $request)
    {
        $category =  Category::create($request->validated());
        if ($category) {
            return response()->json($category, 201);
        }
    }
}
