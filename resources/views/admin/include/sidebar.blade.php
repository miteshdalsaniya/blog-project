<nav class="col-md-2 d-none d-md-block bg-dark text-white sidebar position-sticky" style="height: 100vh; top: 0; overflow-y: auto;">
    <div class="position-sticky">
        <h4 class="text-center py-3">Admin Panel</h4>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-primary' : '' }}" href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white {{ request()->routeIs('admin.users') ? 'active bg-primary' : '' }}" href="{{ route('admin.users') }}">
                    Users
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white {{ request()->routeIs('admin.posts') ? 'active bg-primary' : '' }}" href="{{ route('admin.posts') }}">
                    Posts
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white {{ request()->routeIs('admin.posts.comments') ? 'active bg-primary' : '' }}" href="{{ route('admin.posts.comments') }}">
                    Comments
                </a>
            </li>
        </ul>
    </div>
</nav>
