@extends('admin.master')

@section('title')
    {{ __('site.Create Job') }} | {{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Create Job') }}</h1>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-success px-5 ">{{ __('site.All Jobs') }}</a>
    </div>
    @include('admin.errors')
    <form action="{{ route('admin.jobs.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="">{{ __('site.Title English') }}</label>
            <input type="text" name="title_en" inputmode="text" placeholder="{{ __('site.Title English') }}"
                class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Title Arabic') }}</label>
            <input type="text" name="title_ar" inputmode="text" placeholder="{{ __('site.Title Arabic') }}"
                class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Description English') }}</label>
            <textarea type="text" name="description_en" placeholder="{{ __('site.Description English') }}" class="form-control"
                rows="5"></textarea>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Description Arabic') }}</label>
            <textarea type="text" name="description_ar" placeholder="{{ __('site.Description Arabic') }}" class="form-control"
                rows="5"></textarea>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Price') }}</label>
            <input type="number" name="price_min" placeholder="{{ __('site.min price') }}" class="form-control"
                min="1">
            <br>
            <input type="number" name="price_max" placeholder="{{ __('site.max price') }}" class="form-control"
                min="1">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Category') }}</label>
            <select name="category_id" class="form-control">
                @foreach ($categories as $item)
                    <option value="{{ $item->id }}">{{ $item->name_en }} - {{ $item->name_ar }} </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Delivery Time') }}</label>
            <input type="date" name="delivery_time" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Notic') }}</label>
            <textarea type="text" name="notic" placeholder="{{ __('site.Notic') }}" class="form-control" rows="5"></textarea>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Files') }}</label>
            <input type="file" name="image[]" class="form-control" multiple>
        </div>
        {{--  يجب رفع الملفات مع بعضها وتكون علي صيغة مصفوفة اري نستخرجهم بلوب --}}
        <button class="btn btn-success px-5"><i class="fa fa-check" aria-hidden="true"></i>{{ __('site.Add') }}</button>
    </form>
@endsection
