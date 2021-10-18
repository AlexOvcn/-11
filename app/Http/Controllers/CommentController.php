<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        Comment::create([
            'user_id' => $request->user_id,
            'album_id' => $request->album_id,
            'confirmed' => $request->confirmed,
            'comment' => $request->comment
        ]);
    }
}
