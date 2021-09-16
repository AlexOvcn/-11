<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function showAllNews()
    {

        return view('layouts.allNews', [
            'allNews' => News::all()
        ]);
    }

    public function showNews($id)
    {

        return view('layouts.news', [
            'news' => News::find($id)
        ]);
    }

    public function addNews()
    {
        return view('layouts.addNews');
    }

    public function creatingNews(Request $request)
    {
        // $news = new News();
        // $news->summary = $request->summary;
        // $news->short_description = $request->short_description;
        // $news->full_text = $request->full_text;
        // $news->save();

        // ..ИЛИ..
        News::create([
            'summary' => $request->summary,
            'short_description' => $request->short_description,
            'full_text' => $request->full_text
        ]); // при таком способе необходимо прописывать в Model все поля которые используем здесь

        return redirect()->route('layouts.allNews');

        // return back();  // возвращает на один уровень ниже
    }

}
