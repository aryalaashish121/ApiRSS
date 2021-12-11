<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['checkUrlLowerCase'])->group(function(){
    //create category
    Route::post('/category/create',[CategoryController::class,'store']);
    Route::get('/allcategories',[CategoryController::class,'index']);


    Route::post('/create-article',[ArticleController::class,'store']);
    Route::get('/{category}',[ArticleController::class,'render']);
    Route::get('/{category}/{article}',[ArticleController::class,'getArticle']);

   
});
