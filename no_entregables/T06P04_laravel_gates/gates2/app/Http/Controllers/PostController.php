<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Get the authenticated user
        $user = Auth::user();

        // Fetch only posts that belong to the authorized user
        $posts = $user->posts()->with('user')->latest()->get();

        // Authorize the action for each post using the gate
        foreach ($posts as $post) {
            Gate::authorize('show-user-post', $post);
        }

        return view('form.index', [
            'posts' => $posts,
        ]);
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
    public function store(PostUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Create a new post and fill it with the validated data
        $post = new Post($validated);

        $post->commentable = $request->input('commentable') ? true : false;
        $post->expirable = $request->input('expirable') ? true : false;

        // Associate the post with the authenticated user
        $request->user()->posts()->save($post);

        return redirect(route('posts.index'));
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
    public function edit(Post $post): View
    {
        $this->authorize('update', $post);

        return view('form.edit', [
            'post' => $post,
        ]);
    }
}
