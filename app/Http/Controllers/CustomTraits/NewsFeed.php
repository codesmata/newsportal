<?php

namespace App\Http\Controllers\CustomTraits;
use App\News;
use Illuminate\Support\Facades\URL;

trait NewsFeed
{

    public function generateNewsFeed()
    {
        $feed = app("feed");
        
        $feed->setCache(60, 'laravelFeedKey');
        
        if (!$feed->isCached()) {
            $news = News::orderBy('created_at', 'desc')->take(20)->get();
            
            $feed->title = 'News Feed';
            $feed->description = 'News Feed for RSS';
            $feed->link = url('feed');
            $feed->setDateFormat('datetime');
            $feed->lang = 'en';
            $feed->setShortening(true);
            $feed->setTextLimit(100);

            foreach ($news as $newsArticle) {
                $feed->add(
                    $newsArticle->title,
                    $newsArticle->user->name,
                    URL::to('/news'.$newsArticle->id),
                    $newsArticle->created,
                    $newsArticle->body);
            }
        }

        return $feed->render('atom');
    }
}
