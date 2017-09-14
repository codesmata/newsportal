<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CustomTraits\NewsFeed;
use App\Http\Requests\CreateNewsRequest;
use App\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class NewsController extends Controller
{
    use NewsFeed;

    public function __construct()
    {
        $this->middleware('auth', ['only' => [
            'store',
            'destroy',
            'getUserNews',
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::paginate(10);
        return view('news.all', ['news' => $news]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNewsRequest $request)
    {

        $photo = ($request['photo']) ? $this->processImage($request->file('photo')) : '';
        $user = Auth::user();
        $user
            ->news()
            ->create(array_merge(['photo' => $photo], $request->except(['photo'])));
        return redirect('user-news');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::find($id);

        if ($news) {
            return view('news.single', ['news' => $news]);
        }
        return view('error.404');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        News::where('id', $id)->delete();
        return redirect('user-news');
    }

    /**
     * Get News for this user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUserNews()
    {
        $news = Auth::user()->news()->paginate(10);
        return view('news.user-news', ['news' => $news]);
    }

    public function getPhoto($photo)
    {
        return ($photo) ? Storage::get('test-images/'.$photo) : '';
    }

    public function processImage($image)
    {
        $imageName = time().'.'.$image->getClientOriginalExtension();

        $localStorage = \Storage::disk('local');
        $filePath = '/test-images/' . $imageName;
        $localStorage->put($filePath, file_get_contents($image), 'public');

        return $imageName;
    }
}
