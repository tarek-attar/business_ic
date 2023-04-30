@extends('admin.master')

@section('title')
    {{ __('site.All Users') }}|{{ env('APP_NAME') }}
@endsection
{{-- @section('styles')
    <style>
        .actionButton a {
            max-width: 140px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection --}}

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">
            <a href="{{ route('admin.users.index') }}" style="text-decoration: none; color: black;">
                {{ __('site.All Users') }}
            </a>
        </h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success px-5 ">{{ __('site.Add New') }}</a>
    </div>
    @if (session('msg'))
        <div class="alert alert-{{ session('type') }}">
            {{ session('msg') }}
        </div>
    @endif
    <div class=" mb-4">
        <input type="text" id="searchByID" class="form-control" placeholder="{{ __('site.Search By ID') }}
        ">
    </div>

    <div id="ajax_search_result">
        <table class="table table-bordered table-hover table-striped">
            <tr class="bg-dark text-white">
                <th>ID</th>
                <th>{{ __('site.Name') }}
                </th>
                <th>{{ __('site.Email') }}
                </th>
                <th>{{ __('site.Phone Number') }}
                </th>
                <th>{{ __('site.Role') }}
                </th>
                <th>{{ __('site.Notic') }}
                </th>
                <th>{{ __('site.Actions') }}
                </th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }} </td>
                    <td>{{ $user->email }} </td>
                    <td>{{ $user->phone_number }} </td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->notic }}</td>
                    <td class="action">

                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info m-1">
                            <i class="fas fa-eye"> </i>
                        </a>
                        <a href="{{ route('admin.edituser', $user->id) }}" class="btn btn-sm btn-primary m-1"><i
                                class="fas fa-edit"></i></a>

                        @if ($action == 'true')
                            <a href="{{ route('admin.upgrade', $user->id) }}" class="btn btn-sm btn-warning m-1">
                                <i class="fas fa-arrow-circle-up"></i>
                            </a>
                            <form id="delete-form-{{ $user->id }}" class="d-inline"
                                action="{{ route('admin.user_delete', $user->id) }}" method="post">
                                @csrf
                                {{-- @method('delete') --}}
                                <button onclick="event.preventDefault(); showConfirmationDialog({{ $user->id }});"
                                    class="btn btn-sm btn-danger m-1"><i class="fas fa-times w-"></i></button>
                            </form>
                        @endif

                    </td>
                </tr>
            @endforeach
        </table>
        {{ $users->links() }}
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $(document).on('input', "#searchByID", function() {
                var searchByID = $(this).val();
                jQuery.ajax({
                    url: "{{ route('admin.ajax_search_ID') }}",
                    type: 'post',
                    dataType: 'html',
                    cache: false,
                    data: {
                        searchByID: searchByID,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(users) {
                        $("#ajax_search_result").html(users);
                    },
                    error: function() {}
                });
            });
        });
    </script>
    <script>
        function showConfirmationDialog(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            });
        }
    </script>
    <script>
        setTimeout(() => {
            $('.alert').fadeOut();
        }, 2000);
    </script>
@endsection
