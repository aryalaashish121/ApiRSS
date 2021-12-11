<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Services\ArticleService;
use App\Traits\ResponseHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class ArticleController extends Controller
{
    use ResponseHelper;
    public function store(ArticleStoreRequest $request)
    {
        $article = Article::create($request->validated());
        return $this->respondCreated($article, "New article created.");
    }

    public function render(Request $request,$category_slug, ArticleService $articleService)
    {

        /* create new feed */
        \Log::info("Fetch article");
        $category =  Category::where('slug', $category_slug)->pluck('id')->first();
        
        if(!$category){
           return $this->respondBadRequest("Category not found!");
        }

        $posts = Cache::remember($category_slug, 600, function () use ($category,$request) {
             $articles = Article::where('category_id', $category)
            ->orderBy('created_at','desc');

            if (!empty($request->is_live)) {
                $status = 0;
                if ($request->is_live == 'true') {
                    $status = 1;
                } else {
                    $status = 0;
                }
                $articles->where(['is_live' => $status]);
            }
            if($request->per_page){
              return  $articles->paginate($request->per_page);
            }
            return $articles->get();
        });

        if(!$posts){
           return $this->respondBadRequest("No post avaiable.");
        }
        $feed = $articleService->createFeed($posts,$category_slug);
        return $feed->render('atom');
    }
  
    public function getArticle($category,$article){
        return new ArticleResource(Article::where('slug',$article)->first());
    }
}
