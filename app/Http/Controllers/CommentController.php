<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $validatedData = $request->validated();
        Comment::create($validatedData);
        return response()
            ->json(['message'=>'Your comment was successfully posted']);


    }

    public function update(CommentRequest $request)
    {
        $validatedData = $request->validated();
        $comment = Comment::find($request->comment_id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->update($validatedData);
        return response()->json(['message' => 'Post updated successfully']);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(null, 204);
    }
}
