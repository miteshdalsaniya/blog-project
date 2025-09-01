@include('layouts.app')

<body>
<div class="d-flex">
    @include('admin.include.sidebar')

    <main class="col-md-10 ms-sm-auto px-md-2">
        @include('admin.include.header')

        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Post</h1>
            <a href="{{ route('admin.posts') }}" class="btn btn-secondary mb-3">Back to Posts</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="editPostForm" action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title) }}" >
                <span id="titleError" class="text-danger"></span>
            </div>

            <div class="mb-3">
                <label for="post_img" class="form-label">Post Image</label>
                <input type="file" name="post_img" id="post_img" class="form-control">
                @if($post->post_img)
                    <p class="mt-2">Current Image:</p>
                    <img src="{{ asset('uploads/posts/' . $post->post_img) }}" alt="Post Image" width="150">
                @endif
                <span id="imgError" class="text-danger"></span>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" class="form-control" rows="5">{{ old('content', $post->content) }}</textarea>
                <span id="contentError" class="text-danger"></span>
            </div>

            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#editPostForm').on('submit', function(e) {
    e.preventDefault(); 

    $('#titleError').text('');
    $('#contentError').text('');
    $('#imgError').text('');

    let title = $('#title').val().trim();
    let content = $('#content').val().trim();
    let image = $('#post_img').val();
    let valid = true;

    if (!title) {
        $('#titleError').text('Please enter a post title.');
        valid = false;
    }

    if (!content) {
        $('#contentError').text('Please enter post content.');
        valid = false;
    }

    if (image) {
        let allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.svg)$/i;
        if (!allowedExtensions.exec(image)) {
            $('#imgError').text('Invalid image type. Allowed: jpg, jpeg, png, gif, svg.');
            valid = false;
        }
    }

    if (!valid) return;

    this.submit();
});
</script>
</body>
</html>
