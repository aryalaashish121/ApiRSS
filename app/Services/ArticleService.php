<?php
namespace App\Services;

use Carbon\Carbon;

class ArticleService {
    
    public function createFeed($posts,$category_slug){
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

}