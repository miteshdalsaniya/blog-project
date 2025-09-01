<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class AdminController extends Controller
{

    // show all dashboard data //

    public function dashboard()
    
    {
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $totalComments = Comment::count();

        return view('admin.dashboard', compact('totalUsers', 'totalPosts', 'totalComments'));
    }
    
    // show all users logic //

    public function users()

    {
        $users = User::orderBy('id', 'desc')->paginate(5); 
        return view('admin.manage_users', compact('users'));
    }

    //  show all posts logic //

    public function posts()

    {

    $posts = Post::with('user')->orderBy('id', 'desc')->paginate(5); 
    return view('admin.manage_posts', compact('posts'));
    
    }

    // delete posts logic //

    public function destroy($id)

    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
   
    //  add posts page redirect logic //

    public function addpost()

    {
        return view('admin.add_post'); 
    }

    // posts data store in database logic //

    public function storePost(Request $request)

    {
        $request->validate([
            'title' => 'required|string|max:255',
            'post_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'content' => 'required|string',
        ]);

        $imageName = null;

        if ($request->hasFile('post_img')) {
            $image = $request->file('post_img');

            $destinationPath = public_path('uploads/posts');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $imageName);
        }

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'post_img' => $imageName,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.posts')->with('success', 'Post added successfully!');
    }

    //  posts delete logic //

    public function deletePost($id)

    {
        $post = Post::findOrFail($id);

        $imagePath = public_path('uploads/posts/' . $post->post_img);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $post->delete();

        return redirect()->route('admin.posts')->with('success', 'Post deleted successfully!');
    }
 
    // edit page redirect and edit data fecha logic //

    public function editPost($id)

    {
        $post = Post::findOrFail($id);
        return view('admin.edit_post', compact('post'));
    }

    //  posts update logic //

   public function updatePost(Request $request, $id)

    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $id,
            'post_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'content' => 'required|string',
        ]);

        if ($request->hasFile('post_img')) {
            $imageName = time() . '_' . $request->file('post_img')->getClientOriginalName();
            $request->file('post_img')->move(public_path('uploads/posts'), $imageName);
            $post->post_img = $imageName;
        }

        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        return redirect()->route('admin.posts')->with('success', 'Post updated successfully!');
    }

    // show all posts with comment logic //

    public function allPostsWithComments()

    {
        $comments = Comment::with(['user', 'post', 'post.user'])->latest()->paginate(5); 

        return view('admin.all_comments', compact('comments'));
        
    }

    // one title is a one time insert chek logic //

    public function checkTitle(Request $request)

    {
        $title = $request->title;

        $exists = \DB::table('posts')->where('title', $title)->exists();

        if ($exists) {
            return response()->json(['status' => 'exists', 'message' => 'This title already exists.']);
        } else {
            return response()->json(['status' => 'available']);
        }
    }

    //  chnage role code //

    public function RoleUpdate(Request $request)

    {
        $user = User::findOrFail($request->user_id);

        if(auth()->user()->role != 1 || auth()->user()->id == $user->id){
            return response()->json(['status' => 'error', 'message' => 'Unauthorized action']);
        }

        $user->role = $request->role;
        $user->save();

        return response()->json(['status' => 'success']);
    }


}
