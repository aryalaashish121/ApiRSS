<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class ArticleController extends Controller
{
    public function store(ArticleStoreRequest $request)
    {
        $article = Article::create($request->validated());
        return response()->json($article, 200);
    }

    public function render(Request $request,$category_slug)
    {
        /* create new feed */
        \Log::info("Fetch article");
        $category =  Category::where('slug', $category_slug)->pluck('id')->first();
        if(!$category){
            return response()->json([
                "error"=>"Provided category doesnot exist."
            ]);
        }
        $posts = Cache::remember($category_slug, 600, function () use ($category,$request) {
            return Article::where('category_id', $category)
            ->orderBy('created_at','desc')
            ->get();
        });

        if(!$posts){
            return response()->json([
                "error"=>"No post avaiable."
            ]);
        }
        $feed = $this->createFeed($posts,$category_slug);
        return $feed->render('atom');
    }

    private function createFeed($posts,$category_slug){
        $feed = \App::make("feed");
        $this->setTitle($feed,Carbon::now());
        foreach ($posts as $post) {
            $feed->addItem([
                'title' => $post->title,
                'author' => $post->author,
                'link' => url('/api/'.$category_slug.'/'.$post->slug),
                'pubdate' => $post->created_at,
                'description' => $post->description,
                'content' => 'content'
            ]);
        }
        return $feed;
    }

    private function setTitle($feed, $date)
    {
        $feed->title = 'Kotuko Code challenge';
        $feed->description = 'Php server side application ';
        $feed->link = url('feed');
        $feed->setDateFormat('datetime');
        $feed->pubdate = $date;
        $feed->lang = 'en';
        $feed->setShortening(true);
        $feed->setTextLimit(100);
    }

    public function getArticle(Request $request){
        return $request->all();
    }
}
