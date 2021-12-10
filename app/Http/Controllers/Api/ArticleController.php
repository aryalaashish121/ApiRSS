<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleStoreRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function store(ArticleStoreRequest $request){

        $article = Article::create($request->validated());
        return response()->json($article,200);
    }
}
