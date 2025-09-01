@include('layouts.app')

<body>
<div class="d-flex">
    @include('admin.include.sidebar')

    <main class="col-md-10 ms-sm-auto px-md-2">
        
        @include('admin.include.header')

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <p class="card-text">Total Users: {{ $totalUsers }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Posts</h5>
                        <p class="card-text">Total Posts: {{ $totalPosts }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Comments</h5>
                        <p class="card-text">Total Comments: {{ $totalComments }}</p>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>
</body>
</html>
