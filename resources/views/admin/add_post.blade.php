@include('layouts.app')

<body>
<div class="container-fluid">
    <div class="row">
        
        @include('admin.include.sidebar')

        <main class="col-md-10 ms-sm-auto px-md-2">
            
            @include('admin.include.header')

            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Post</h1>
                <a href="{{ route('admin.posts') }}" class="btn btn-secondary mb-3">Back to Posts</a>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Add New Post</h2>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                           <form id="addPostForm" action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Post Title</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Enter post title">
                                <span class="text-danger" id="titleError"></span>
                            </div>

                            <div class="mb-3">
                                <label for="post_img" class="form-label">Post Image</label>
                                <input type="file" id="post_img" name="post_img" class="form-control">
                                <span class="text-danger" id="imgError"></span>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea id="content" name="content" rows="5" class="form-control" placeholder="Write your post content here"></textarea>
                                <span class="text-danger" id="contentError"></span>
                            </div>

                            <button type="submit" class="btn btn-primary" id="submitBtn">Add Post</button>
                        </form>

                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>


<script>
$('#submitBtn').on('click', function(e) {
    e.preventDefault(); 

    $('#titleError').text('');
    $('#imgError').text('');
    $('#contentError').text('');

    let title = $('#title').val().trim();
    let postImg = $('#post_img').val().trim();
    let content = $('#content').val().trim();
    let valid = true;

    if (!title) {
        $('#titleError').text('Please enter a post title.');
        valid = false;
    }

    if (!postImg) {
        $('#imgError').text('Please select a post image.');
        valid = false;
    }

    if (!content) {
        $('#contentError').text('Please enter post content.');
        valid = false;
    }

    if (!valid) return;

    $.ajax({
        url: "{{ route('post.checkTitle') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            title: title
        },
        success: function(res) {
            if (res.status === 'exists') {
                $('#titleError').text(res.message);
            } else {
                $('#addPostForm')[0].submit();
            }
        }
    });
});
</script>

</body>
</html>
