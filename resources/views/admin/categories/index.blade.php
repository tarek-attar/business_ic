@extends('admin.master')

@section('title')
    {{ __('site.All Categories') }} | {{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.All Categories') }}</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success px-5 ">{{ __('site.Add New') }}</a>
    </div>
    @if (session('msg'))
        <div class="alert alert-{{ session('type') }}">
            {{ session('msg') }}
        </div>
    @endif
    <table class="table table-bordered table-hover table-striped ">
        <tr class="bg-dark text-white">
            <th>{{ __('site.ID') }}</th>
            <th>{{ __('site.English Name') }}</th>
            <th>{{ __('site.Arabic Name') }}</th>
            <th>{{ __('site.Notic') }}</th>
            <th>{{ __('site.Created At') }}</th>
            <th>{{ __('site.Updated At') }}</th>
            <th>{{ __('site.Actions') }}</th>
        </tr>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name_en }}</td>
                <td>{{ $category->name_ar }}</td>
                <td>{{ $category->notic }}</td>
                <td>{{ $category->created_at }}</td>
                <td>{{ $category->updated_at }}</td>
                <td>
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary"><i
                            class="fas fa-edit"></i></a>
                    <form id="delete-form-{{ $category->id }}" class="d-inline"
                        action="{{ route('admin.categories.destroy', $category->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button onclick="event.preventDefault(); showConfirmationDialog({{ $category->id }});"
                            class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                    </form>
                    <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-sm btn-info m-1"><i
                            class="fas fa-eye"></i></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $categories->links() }}
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{--
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        توضع بهذا الشكل عند تشغيل الموقع رسميا
    --}}
    <script>
        function showConfirmationDialog(categoryId) {
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
                    document.getElementById('delete-form-' + categoryId).submit();
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
