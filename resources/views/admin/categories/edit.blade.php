@extends('admin.master')

@section('title')
    {{ __('site.Edit Category') }} | {{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Edit Category') }}</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-success px-5 ">{{ __('site.All Categories') }}</a>
    </div>
    @include('admin.errors')
    <form action="{{ route('admin.categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="">{{ __('site.English Name') }}</label>
            <input type="text" name="name_en" value="{{ $category->name_en }}" placeholder="{{ __('site.English Name') }}"
                class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Arabic Name') }}</label>
            <input type="text" name="name_ar" value="{{ $category->name_ar }}"
                placeholder="{{ __('site.Arabic Name') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Notic') }}</label>
            <textarea type="text" name="notic" placeholder="{{ __('site.Notic') }}" class="form-control" rows="5">{{ $category->notic }}</textarea>
        </div>
        <button class="btn btn-success px-5 mb-5"><i class="fa fa-check" aria-hidden="true"></i>
            {{ __('site.Add') }}</button>
    </form>
@endsection
