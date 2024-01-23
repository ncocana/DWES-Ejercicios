<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiPostController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post): JsonResponse
    {
        // $this->authorize('update', $post);
        // dd('Reached update method');

        $validated = $request->validated();

        $post->commentable = $request->input('commentable') ? true : false;
        $post->expirable = $request->input('expirable') ? true : false;

        $post->update($validated);

        return response()->json([
            'data' => $post,
            'message' => 'Post has been updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): JsonResponse
    {
        // $this->authorize('delete', $post);
 
        $post->delete();
 
        return response()->json([
            'message' => 'Post has been deleted'
        ]);
    }
}
