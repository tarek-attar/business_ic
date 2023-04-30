@extends('admin.master')

@section('title')
    {{ __('site.All Freelancers Request') }}|{{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.All Freelancers Request') }}</h1>
        {{--  <a href="{{ route('admin.freelancers.create') }}" class="btn btn-success px-5 ">{{ __('site.Add New') }}</a> --}}
    </div>
    @if (session('msg'))
        <div class="alert alert-{{ session('type') }}">
            {{ session('msg') }}
        </div>
    @endif
    <table class="table table-bordered table-hover table-striped">
        <tr class="bg-dark text-white">
            <th>{{ __('site.ID') }}</th>
            <th>{{ __('site.User ID') }}</th>
            <th>{{ __('site.Name') }}</th>
            <th>{{ __('site.Phone Number') }}</th>
            <th>{{ __('site.Email') }}</th>
            <th>{{ __('site.Service') }}</th>
            <th>{{ __('site.Address') }}</th>
            <th>{{ __('site.Notic') }}</th>
            <th>{{ __('site.Status') }}</th>
            <th>{{ __('site.Actions') }}</th>
        </tr>
        @php
            $count = 1;
        @endphp
        @foreach ($freelancers as $freelancer)
            <tr>
                <td>{{ $freelancer->id }}</td>
                <td>{{ $freelancer->user_id }}</td>
                <td>{{ $freelancer->user->name }}</td>
                <td>{{ $freelancer->user->phone_number }}</td>
                <td>{{ $freelancer->user->email }}</td>
                <td>{{ $freelancer->category->name_ar }}-{{ $freelancer->category->name_en }}</td>
                <td>{{ $freelancer->address }}</td>
                <td>{{ $freelancer->user->notic }}</td>
                <td>
                    @switch($freelancer->status)
                        @case('active')
                            <label style="background-color: green; color: white;padding: 5px;">{{ __('site.active') }}</label>
                        @break

                        @case('unactive')
                            <label style="background-color: red; color: white;padding: 5px;">{{ __('site.unactive') }}</label>
                        @break

                        @case('')
                            <label style="background-color: red; color: white;padding: 5px;">{{ __('site.unactive') }}</label>
                        @break

                        @default
                    @endswitch
                </td>
                <td class="action">
                    <a href="{{ route('admin.freelancers.edit', $freelancer->id) }}" class="btn btn-sm btn-primary m-1"><i
                            class="fas fa-edit"></i></a>
                    <form id="delete-form-{{ $freelancer->id }}" class="d-inline"
                        action="{{ route('admin.freelancers.destroy', $freelancer->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button onclick="event.preventDefault(); showConfirmationDialog({{ $freelancer->id }});"
                            class="btn btn-sm btn-danger m-1"><i class="fas fa-times w-"></i></button>
                    </form>
                    <a href="{{ route('admin.freelancers.show', $freelancer->id) }}" class="btn btn-sm btn-info m-1"><i
                            class="fas fa-eye"></i></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{-- {{ $freelancers->links() }} --}}
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{--
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        توضع بهذا الشكل عند تشغيل الموقع رسميا
    --}}
    <script>
        function showConfirmationDialog(freelancerID) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will nott be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + freelancerID).submit();
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
