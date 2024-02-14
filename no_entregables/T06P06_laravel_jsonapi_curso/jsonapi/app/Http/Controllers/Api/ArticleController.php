<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveArticleRequest;
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

        // Sort by order - Multiple fields
        $articles = Article::query();

        if ($request->filled('sort')) {

            // Sort by order - Single field
            // $sortField = $request->input('sort');
            
            // $sortDirection = 'asc';
            // if (Str::of($sortField)->startsWith('-')) {
            //     $sortDirection = 'desc';
            // }
    
            // $articles = Article::orderBy($sortField, $sortDirection)->get();
            // return ArticleCollection::make($articles);

            $sortFields = explode(',', $request->input('sort'));
            $allowedSorts = ['title', 'content'];
    
            foreach ($sortFields as $sortField) {
                $sortDirection = Str::of($sortField)->startsWith('-') ? 'desc' : 'asc';
                $sortField = ltrim($sortField, '-');
                
                abort_unless(in_array($sortField, $allowedSorts), 400);
    
                $articles->orderBy($sortField, $sortDirection);
            }
        }

        return ArticleCollection::make($articles->get());
    }

    public function show(Article $article): ArticleResource
    {
        return ArticleResource::make($article);
    }

    public function store(SaveArticleRequest $request): ArticleResource
    {
        // dd($request->all());
        // dd($request->input('data.attributes'));

        $article = Article::create($request->validated());

        return ArticleResource::make($article);
    }

    public function update(Article $article, SaveArticleRequest $request)
    {
        $article->update($request->validated());

        return ArticleResource::make($article);
    }

    public function destroy(Article $article): Response
    {
        $article->delete();
        return response()->noContent();
    }
}
