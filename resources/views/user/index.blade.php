<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">My Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    @if(Auth::user()->role == 1)
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    @endif
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Logout</button>
                        </form>
                    </li>
                @endauth

                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    @if (Route::has('register'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1 class="mb-4">All Blog Posts</h1>
    <div class="row">
        @foreach($posts as $post)
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                @if($post->post_img)
                    <img src="{{ asset('uploads/posts/' . $post->post_img) }}" 
                         class="card-img-top" 
                         alt="{{ $post->title }}" 
                         style="height: 200px; width: 100%; object-fit: cover;">
                @endif

                <div class="card-body">
                    <h5 class="card-title">Title : <strong>{{ $post->title }}</strong></h5>
                    <p class="text-muted mb-1">By <strong>{{ $post->user->name ?? 'Unknown' }}</strong></p>

                    <h6 class="mt-3">Comments:</h6>
                    @forelse($post->comments as $comment)
                        <p class="mb-1">
                            <strong>{{ $comment->user->name ?? 'Guest' }}:</strong> 
                            {{ $comment->comment }}
                        </p>
                    @empty
                        <p class="text-muted">No comments yet.</p>
                    @endforelse

                    @auth
                        <button class="btn btn-info btn-sm mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#commentForm{{ $post->id }}">
                            Add Comment
                        </button>

                        <div class="collapse mt-2" id="commentForm{{ $post->id }}">
                            <form method="POST" action="{{ route('user.blog.comment', $post->id) }}">
                                @csrf
                                <div class="mb-2">
                                    <textarea name="comment" class="form-control" placeholder="Write a comment..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                            </form>
                        </div>
                    @endauth

                    @guest
                        <div class="alert alert-warning mt-3">
                            Please login first to comment. 
                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary ms-2">Login</a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100;">
    @if(session('success'))
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="successToast">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="errorToast">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>

<footer class="bg-dark text-white text-center py-3 mt-4">
    &copy; {{ date('Y') }} My Blog. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        const toastElList = [].slice.call(document.querySelectorAll('.toast'));
        toastElList.forEach(function (toastEl) {
            const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
            toast.show();
        });
    });
</script>
</body>
</html>
