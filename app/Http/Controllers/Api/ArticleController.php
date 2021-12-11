<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleStoreRequest;
use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class ArticleController extends Controller
{
    public function store(ArticleStoreRequest $request)
    {
        $article = Article::create($request->validated());
        return response()->json($article, 200);
    }

    public function render($category_slug)
    {

        /* create new feed */
        $feed = \App::make("feed");

        $category =  Category::where('slug', $category_slug)->pluck('id');
        $posts = Cache::remember($category, 600, function () use ($category) {
            return Article::where('category_id', $category)->get();
        });

        $this->setTitle($feed, $posts[0]->created_at);
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
        // }
        return $feed->render('atom');
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

    public function getArticle(){
        
    }
}
