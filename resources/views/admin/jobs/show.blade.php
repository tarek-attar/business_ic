@extends('admin.master')

@section('title')
    {{ __('site.Show Job') }} | {{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Show Job') }}</h1>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-success px-5 ">{{ __('site.All Jobs') }}</a>
    </div>
    @include('admin.errors')
    <div class="mb-3">
        <label for="">{{ __('site.Owner') }}</label>
        <input readonly type="text" name="user_id" value="{{ $job->user->id }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Title English') }}</label>
        <input readonly type="text" name="title_en" value="{{ $job->title_en }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Title Arabic') }}</label>
        <input readonly type="text" name="title_ar" value="{{ $job->title_ar }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Description English') }}</label>
        <textarea readonly type="text" name="description_en" class="form-control" rows="5">{{ $job->description_en }} </textarea>
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Description Arabic') }}</label>
        <textarea readonly type="text" name="description_ar" class="form-control" rows="5">{{ $job->description_ar }} </textarea>
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Price') }}</label>
        <input readonly type="text" name="price_min" value="{{ $job->price_min }}" class="form-control">
        <br>
        <input readonly type="text" name="price_max" value="{{ $job->price_max }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Category') }}</label>
        <input readonly type="text" name="category_id"
            value="{{ $job->category->name_en }} - {{ $job->category->name_ar }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Delivery Time') }}</label>
        <input readonly type="text" name="delivery_time" value="{{ $job->delivery_time }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">Connection Token</label>
        <input readonly type="text" name="connection_token" value="{{ $job->connection_token }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Status') }}</label>
        <input readonly type="text" name="status" class="form-control"
            @switch($job->status)
                        @case(0)
                        value={{ __('site.Open') }}
                        style="color: green"
                        @break
                        @case(1)
                        value={{ __('site.Close') }}
                        style="color: red"
                        @break
                        @default
                    @endswitch>
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.notic') }}</label>
        <textarea readonly type="text" name="notic" class="form-control" rows="5">{{ $job->notic }} </textarea>
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Files') }} :</label>
        @php
            $count = 0;
        @endphp
        @foreach ($images as $F_img)
            @php
                $count++;
            @endphp
            <img width="80" src="{{ asset('uploads/' . $F_img->file_name) }}" alt=" file Image">
        @endforeach
        @if ($count == 0)
            <h6 style="color: red"> There is no files for this Job</h6>
        @endif
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Updated At') }}</label>
        <input readonly type="text" name="updated_at" value="{{ $job->updated_at }}" class="form-control">
    </div>
@endsection
