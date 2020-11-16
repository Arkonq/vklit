<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Models\User;


class NewsController extends Controller
{
    public function submit(NewsRequest $req) {
        $news = new News;
        $news->name = auth()->user()->name;
        $news->message = $req->input('message');
        $news->image = $req->input('image');

        $news->save();

        return redirect()->route('news')->with('success','News published successfully');
    }

    public function all() {
        $news = new News;
        return view('feed', ['data' => $news->all()->sortByDesc('created_at') ]);
    }
}
