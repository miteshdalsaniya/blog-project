<header class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-white px-3">
    <h1 class="h2">{{ Auth::user()->name ?? 'Dashboard' }}</h1>

    @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger" type="submit">Logout</button>
        </form>
    @endauth
</header>
