<?php

namespace Tests\Unit\Authentication;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\User;
use App\News;

class NewsControllerTest extends TestCase
{

    use DatabaseMigrations;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class, 'verifiedUser')->create();
    }

    public function testGetUserNews()
    {
        $this->actingAs($this->user)
            ->get('/user-news')
            ->assertViewIs('news.user-news');
    }

    public function testStore()
    {
        $newsArticle = [
            'title' => '',
            'body' => '',
            'photo' => 'default.jpg'
        ];

        $this->user
            ->news()
            ->create($newsArticle);

        $this->assertDatabaseHas(
            'news',
            array_merge(['user_id' => $this->user->id], $newsArticle)
        );
    }

    public function testDestroy()
    {
        $newsArticle = [
            'title' => '',
            'body' => '',
            'photo' => 'default.jpg'
        ];

        $news = $this->user
            ->news()
            ->create($newsArticle);

        News::where('id', $news->id)->delete();

        $this->assertNull(News::find($news->id));
    }

    public function testShow()
    {
        $newsArticle = [
            'title' => '',
            'body' => '',
            'photo' => 'default.jpg'
        ];

        $news = $this->user
            ->news()
            ->create($newsArticle);

        $this->get('/news/'.$news->id)
            ->assertViewIs('news.single')
            ->assertViewHas('news');
    }
}
