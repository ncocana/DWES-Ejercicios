<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request): ArticleCollection
    {
        // Return all items
        // $articles = Article::all();

        // Sort by order
        $sortField = $request->input('sort');
        
        // $sortDirection = 'asc';
        // if (Str::of($sortField)->startsWith('-')) {
        //     $sortDirection = 'desc';
        // }
        $sortDirection = Str::of($sortField)->startsWith('-') ? 'desc' : 'asc';
        $sortField = ltrim($sortField, '-');

        $articles = Article::orderBy($sortField, $sortDirection)->get();

        return ArticleCollection::make($articles);
    }

    public function show(Article $article): ArticleResource
    {
        return ArticleResource::make($article);
    }

    public function store(ArticleRequest $request): ArticleResource
    {
        // dd($request->all());
        // dd($request->input('data.attributes'));

        $request->validated();

        $article = Article::create([
            'title' => $request->input('data.attributes.title'),
            'slug' => $request->input('data.attributes.slug'),
            'content' => $request->input('data.attributes.content'),
        ]);

        return ArticleResource::make($article);
    }

    public function update(Article $article, ArticleRequest $request)
    {
        $request->validated();

        $article->update([
            'title' => $request->input('data.attributes.title'),
            'slug' => $request->input('data.attributes.slug'),
            'content' => $request->input('data.attributes.content'),
        ]);

        return ArticleResource::make($article);
    }

    public function destroy(Article $article): Response
    {
        $article->delete();
        return response()->noContent();
    }
}
