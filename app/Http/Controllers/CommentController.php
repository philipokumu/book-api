<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\CommentCollection;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($book_id)
    {
        $comments = Comment::where('book_id',$book_id)->orderBy('id','desc')->get();

        return new CommentCollection($comments);
    }

    public function store($book_id)
    {
        $data = request()->validate([
            'text' => 'required|max:500',
            'ip_address' => '',
        ]);

        $comment = Comment::create(array_merge($data,['book_id'=>$book_id]));

        return new CommentResource($comment);
    }

    public function destroy($book_id, Comment $comment)
    {
        $comment->delete();

        return response([],204);
    }
}
