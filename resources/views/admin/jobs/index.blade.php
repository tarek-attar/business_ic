@extends('admin.master')

@section('title')
    {{ __('site.All Jobs') }}|{{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.All Jobs') }}</h1>
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-success px-5 ">{{ __('site.Add New') }}</a>
    </div>
    @if (session('msg'))
        <div class="alert alert-{{ session('type') }}">
            {{ session('msg') }}
        </div>
    @endif
    <table class="table table-bordered table-hover table-striped">
        <tr class="bg-dark text-white">
            <th>{{ __('site.ID') }}</th>
            <th>{{ __('site.Owner') }}</th>
            <th>{{ __('site.Title English') }}</th>
            <th>{{ __('site.Title Arabic') }}</th>
            <th>{{ __('site.Price') }}</th>
            <th>{{ __('site.Categories English') }} </th>
            <th>{{ __('site.Categories Arabic') }}</th>
            <th>{{ __('site.Delivery Time') }}</th>
            <th>{{ __('site.Status') }}</th>
            <th>{{ __('site.Notic') }}</th>
            <th>{{ __('site.Actions') }}</th>
        </tr>
        @foreach ($jobs as $job)
            <tr>
                <td>{{ $job->id }}</td>
                <td>ID:{{ $job->user_id }} <br> N: {{ $job->user->name }}</td>
                <td>{{ $job->title_en }}</td>
                <td>{{ $job->title_ar }}</td>
                <td>{{ $job->price_min }} - {{ $job->price_max }}</td>
                <td>{{ $job->category->name_en }}</td>
                <td>{{ $job->category->name_ar }}</td>
                <td>{{ $job->delivery_time }}</td>
                <td>
                    @switch($job->status)
                        @case(0)
                            <label style="background-color: green; color: white;padding: 5px;">{{ __('site.Open') }}</label>
                        @break

                        @case(1)
                            <label style="background-color: red; color: white;padding: 5px;">{{ __('site.Close') }}</label>
                        @break

                        @default
                    @endswitch
                </td>
                <td>{{ $job->notic }}</td>
                <td class="action">
                    <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-sm btn-primary m-1"><i
                            class="fas fa-edit"></i></a>
                    <form id="delete-form-{{ $job->id }}" class="d-inline"
                        action="{{ route('admin.jobs.destroy', $job->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button onclick="event.preventDefault(); showConfirmationDialog({{ $job->id }});"
                            class="btn btn-sm btn-danger m-1"><i class="fas fa-times w-"></i></button>
                    </form>
                    <a href="{{ route('admin.jobs.show', $job->id) }}" class="btn btn-sm btn-info m-1"><i
                            class="fas fa-eye"></i></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $jobs->links() }}
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{--
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        توضع بهذا الشكل عند تشغيل الموقع رسميا
    --}}
    <script>
        function showConfirmationDialog(jobId) {
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
                    document.getElementById('delete-form-' + jobId).submit();
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
