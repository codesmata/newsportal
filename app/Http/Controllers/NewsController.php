<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewsRequest;
use App\News;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
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
        return view('news.single', ['news' => $news]);
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
