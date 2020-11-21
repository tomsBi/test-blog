<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    //test
    public function index()
    {
        return view('articles.index', [
            'articles' => Article::all()
        ]);
    }

    public function create()
    {
        return view('articles.create');
    }

    //test
    public function store(Request $request)
    {
        $article = (new Article)->fill($request->all());
        $article->user()->associate(auth()->user());
        $article->save();

        return redirect()->route('articles.index');
    }
    //test
    public function show(Article $article)
    {
        return view('articles.show', [
            'article' => $article
        ]);
    }
    //test
    public function edit(Article $article)
    {
        return view('articles.edit', [
            'article' => $article
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $article->update($request->all());

        return redirect()->route('articles.edit', $article);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index');
    }
}
