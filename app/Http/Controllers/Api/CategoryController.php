<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ResponseHelper;
    public function index()
    {
        $categories =  Category::orderBy('created_at', 'desc')->get(['name', 'created_at']);
        return $this->respondSuccess($categories);
    }

    public function store(CategoryRequest $request)
    {
        $category =  Category::create($request->validated());
        if ($category) {
            return $this->respondCreated($category, "New Category created.");
        }
    }
}
