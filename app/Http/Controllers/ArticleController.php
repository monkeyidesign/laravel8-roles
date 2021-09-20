<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('user')->get();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$organizationId = auth()->user()->organization_id ? auth()->user()->organization_id : auth()->id();
//        Article::create($request->all() +
//            [
//                'user_id' => $organizationId,
//                'published_at' => Gate::allows('publish-articles')
//                && $request->input('published') ? now() : null
//            ]
//        );
        Article::create($request->all() +
            [
                'user_id' => auth()->user()->id,
                //'published_at' => (auth()->user()->is_admin || auth()->user()->is_publisher) && $request->input('published') ? now() : null,
                'published_at' => Gate::allows('publish-articles') && $request->input('published') ? now() : null
            ]
        );
        return redirect()->route('articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        //$this->authorize('edit-article', $article);
        $categories = Category::all();

        return view('articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $data = $request->all();
        if (Gate::allows('publish-articles')) {
//        if (auth()->user()->is_admin || auth()->user()->is_publisher) {
            $data['published_at'] = $request->input('published') ? now() : null;
        }
        $article->update($data);

        return redirect()->route('articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('update', $article);

        $article->delete();

        return redirect()->route('articles.index');
    }
}
