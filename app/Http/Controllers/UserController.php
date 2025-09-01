<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class UserController extends Controller

{
        public function index()

        {
            $posts = Post::with(['user', 'comments.user'])
                        ->latest()
                        ->get();

            return view('user.index', compact('posts'));
        }

        // user posts comment insert logic //

        public function comment(Request $request, $postId)
        
        {
            $request->validate([
                'comment' => 'required|string|max:1000',
            ]);

            $post = Post::findOrFail($postId);

            Comment::create([
                'post_id' => $post->id,
                'user_id' => Auth::id(),
                'comment' => $request->comment,
            ]);

            return redirect()->back()->with('success', 'Comment added successfully!');
        }

}
