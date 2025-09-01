@include('layouts.app')

<body>
    
    <div class="d-flex">
        @include('admin.include.sidebar')

        <main class="col-md-10 ms-sm-auto px-md-2">
            @include('admin.include.header')

            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manage Posts</h1>
                <a href="{{ route('addpost') }}" class="btn btn-success">Add New Post</a>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Author</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>{{ $loop->iteration + ($posts->currentPage() - 1) * $posts->perPage() }}</td>
                                <td>{{ $post->user->name ?? 'Admin' }}</td>
                                <td>{{ $post->title }}</td>
                                <td>
                                    <img src="{{ asset('uploads/posts/' . $post->post_img) }}" alt="Post Image" width="80">
                                </td>
                                <td>{{ $post->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('posts.delete', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No posts found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $posts->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function () {
            let alertBox = document.getElementById('success-alert');
            if (alertBox) {
                alertBox.style.transition = "opacity 0.5s ease";
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 500);
            }
        }, 3000);
    </script>
</body>
</html>
