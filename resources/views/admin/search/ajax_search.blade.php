{{-- <table class="table table-bordered table-hover table-striped">
    <tr class="bg-dark text-white">
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Password</th>
        <th>Actions</th>
    </tr>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }} </td>
            <td>{{ $user->email }} </td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->password }}</td>
            <td>
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info m-1">
                    <i class="fas fa-eye"> </i>
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning m-1">
                    <i class="fas fa-arrow-circle-up"></i>
                </a>
            </td>
        </tr>
    @endforeach
</table> --}}
<table class="table table-bordered table-hover table-striped">
    <tr class="bg-dark text-white">
        <th>ID</th>
        <th>{{ __('site.Name') }}
        </th>
        <th>{{ __('site.Email') }}
        </th>
        <th>{{ __('site.Role') }}
        </th>
        <th>{{ __('site.Password') }}
        </th>
        <th>{{ __('site.Actions') }}
        </th>
    </tr>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }} </td>
            <td>{{ $user->email }} </td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->password }}</td>
            <td>
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info m-1">
                    <i class="fas fa-eye"> </i>
                </a>
                <a href="{{ route('admin.upgrade', $user->id) }}" class="btn btn-sm btn-warning m-1">
                    <i class="fas fa-arrow-circle-up"></i>
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary m-1"><i
                        class="fas fa-edit"></i></a>
                <form id="delete-form-{{ $user->id }}" class="d-inline"
                    action="{{ route('admin.users.destroy', $user->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button onclick="event.preventDefault(); showConfirmationDialog({{ $user->id }});"
                        class="btn btn-sm btn-danger m-1"><i class="fas fa-times w-"></i></button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
<br>
