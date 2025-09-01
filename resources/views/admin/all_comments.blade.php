@include('layouts.app')

<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        @include('admin.include.sidebar')

        <main class="col-md-10 ms-sm-auto px-md-2">
            {{-- Header --}}
            @include('admin.include.header')

            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">All Comments</h1>
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
                            <th>No</th>
                            <th>Post Title</th>
                            <th>Author</th>
                            <th>User</th>
                            <th>Comment</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                            <tr>
                                <td>{{ $loop->iteration + ($comments->currentPage() - 1) * $comments->perPage() }}</td>
                                <td>{{ $comment->post->title ?? 'Deleted Post' }}</td>
                                <td>{{ $comment->post->user->name ?? 'Admin' }}</td>
                                <td>{{ $comment->user->name ?? 'Unknown' }}</td>
                                <td>{{ $comment->comment }}</td>
                                <td>{{ $comment->created_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('comments.delete', $comment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this comment?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No comments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination Links --}}
                <div class="mt-3">
                    {{ $comments->links('pagination::bootstrap-5') }}
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
