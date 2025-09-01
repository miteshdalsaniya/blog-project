@include('layouts.app')

<body>
    <div class="d-flex">
        @include('admin.include.sidebar')

        <main class="col-md-10 ms-sm-auto px-md-2">
            @include('admin.include.header')

            <div class="pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Users</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

          <table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                       @if(auth()->user()->role == 1)

                    <select class="form-select role-dropdown" data-id="{{ $user->id }}">
                        <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>User</option>
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                    </select>

                    @else
                        {{ $user->role == 1 ? 'Admin' : 'User' }}
                    @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
            <div class="mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).on('change', '.role-dropdown', function() {
    let userId = $(this).data('id');
    let newRole = $(this).val();
    let select = $(this);

    if(!confirm('Are you sure you want to change this role?')) {
        select.val(select.find('option[selected]').val());
        return;
    }

    $.ajax({
        url: "{{ route('admin.users.RoleUpdate') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            user_id: userId,
            role: newRole
        },
        success: function(res) {
            if(res.status === 'success') {
                alert('Role updated successfully!');
            } else {
                alert(res.message);
            }
        }
    });
});
</script>

</body>
</html>
