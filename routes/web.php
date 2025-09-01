<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\PreventBackHistory;

use Illuminate\Support\Facades\Route;


Route::get('/', [UserController::class, 'index'])->name('home');

Route::get('/dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // route admin group all admin process route //

    Route::controller(AdminController::class)->group(function () {
        Route::get('/users', 'users')->name('admin.users');
        Route::get('/users/{id}', 'showUser')->name('users.show');        
        Route::delete('/users/{id}', 'deleteUser')->name('users.destroy');
        Route::get('/posts', 'posts')->name('admin.posts');
        Route::get('/addpost', 'addpost')->name('addpost');
        Route::post('storepost', 'storepost')->name('post.store');
        Route::get('/admin/posts/edit/{id}', 'editPost')->name('posts.edit');
        Route::put('/admin/posts/update/{id}', 'updatePost')->name('posts.update');
        Route::delete('/admin/posts/delete/{id}', 'deletePost')->name('posts.delete');
        Route::get('/admin/posts/comments', 'allPostsWithComments')->name('admin.posts.comments');
        Route::delete('/comments/{id}',  'deleteComment')->name('comments.delete');
        Route::post('/post/check-title', 'checkTitle')->name('post.checkTitle');
        Route::post('/admin/users/toggle-role', 'RoleUpdate') ->name('admin.users.RoleUpdate');
        


    });

      Route::controller(UserController::class)->group(function () {
       Route::post('/blog/{post}/comment','comment')->name('user.blog.comment');
        
    });
});

require __DIR__.'/auth.php';
