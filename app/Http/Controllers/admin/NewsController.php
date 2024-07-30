<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Option;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::join('users', 'news.user_id', '=', 'users.id')
                ->select('news.*', 'users.name as user_name')
                ->where('news.user_id', auth()->user()->id)
                ->get();
        return view('admin.news.index', ['news' => $news]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'news_body' => 'required'
        ]);

        if(isset($request->nid) && !empty($request->nid)){

            $news = News::find($request->nid);
            $news->news_body = $request->news_body;
            $news->save();

            return redirect()->route('admin.news.index')->with('success', 'News is updated successfully');

        }else{

            $news = new News();
            $news->user_id = auth()->user()->id;
            $news->news_body = $request->news_body;
            $news->save();

            return back()->with('success', 'News is saved successfully');

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $news1 = News::find($id);
        $news = News::join('users', 'news.user_id', '=', 'users.id')
                ->select('news.*', 'users.name as user_name')
                ->where('news.user_id', auth()->user()->id)
                ->get();
        $newssettings = Option::where('key', 'newsbg')->where('key', 'newscolor')->first();
        return view('admin.news.index', ['news1' => $news1, 'news' => $news, 'newssettings' => $newssettings]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::find($id);
        $news->delete();

        return back()->with('success', 'News is deleted successfully');
    }

    /**
     * Update the specified resource settings from storage.
     */
    public function settings(Request $request){
        Option::where('key', 'newsbg')->update(array('value' => $request->bgcolor));
        Option::where('key', 'newscolor')->update(array('value' => $request->color));
        Option::where('key', 'maintenance_mode')->update(array('value' => $request->maintenance_mode));
        $option = Option::where('key', 'newsdirection')->first();
        $option->value = (isset($request->newsdirection) == "on") ? true : false;
        $option->save();
        return back()->with('success', 'News settings are updated successfully');
    }
}
