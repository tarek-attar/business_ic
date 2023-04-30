@extends('admin.master')

@section('title')
    {{ __('site.Show Category') }} | {{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Show Category') }}</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-success px-5 ">{{ __('site.All Categories') }}</a>
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.English Name') }}</label>
        <input readonly type="text" name="name_en" value="{{ $category->name_en }}"
            placeholder="{{ __('site.Title English') }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Arabic Name') }}</label>
        <input readonly type="text" name="name_ar" value="{{ $category->name_ar }}"
            placeholder="{{ __('site.Title English') }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Notic') }}</label>
        <textarea readonly type="text" name="notic" placeholder="{{ __('site.Notic') }}" class="form-control"
            rows="5">{{ $category->notic }}</textarea>
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Created At') }}</label>
        <input readonly type="text" name="created_at" value="{{ $category->created_at }}"
            placeholder="{{ __('site.Title English') }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Updated At') }}</label>
        <input readonly type="text" name="updated_at" value="{{ $category->updated_at }}"
            placeholder="{{ __('site.Title English') }}" class="form-control">
    </div>
@endsection
