@extends('admin.master')

@section('title')
    {{ __('site.Edit Job') }} | {{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Edit Job') }}</h1>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-success px-5 ">{{ __('site.All Jobs') }}</a>
    </div>
    @include('admin.errors')
    <form action="{{ route('admin.jobs.update', $job->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="">{{ __('site.Owner ID') }}</label>
            <input type="number" name="user_id" value="{{ $job->user->id }}" placeholder="Owner ID" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Title English') }}</label>
            <input type="text" name="title_en" value="{{ $job->title_en }}" placeholder="{{ __('site.Title English') }}"
                class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Title Arabic') }}</label>
            <input type="text" name="title_ar" value="{{ $job->title_ar }}" placeholder="{{ __('site.Title Arabic') }}"
                class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Description English') }}</label>
            <textarea type="text" name="description_en" placeholder="{{ __('site.Description English') }}" class="form-control"
                rows="5">{{ $job->description_en }} </textarea>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Description Arabic') }}</label>
            <textarea type="text" name="description_ar" placeholder="{{ __('site.Description Arabic') }}" class="form-control"
                rows="5">{{ $job->description_ar }} </textarea>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Price') }}</label>
            <input type="number" name="price_min" value="{{ $job->price_min }}" placeholder="{{ __('site.Price') }}"
                class="form-control">
            <br>
            <input type="number" name="price_max" value="{{ $job->price_max }}" placeholder="{{ __('site.Price') }}"
                class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Categories') }}</label>
            <select name="category_id" class="form-control">
                @foreach ($categories as $item)
                    <option {{ $job->category_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                        {{ $item->name_en }} - {{ $item->name_ar }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Delivery Time') }}</label>
            <input type="date" name="delivery_time" value="{{ $job->delivery_time }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Notic') }}</label>
            <textarea type="text" name="notic" placeholder="{{ __('site.Description English') }}" class="form-control"
                rows="5">{{ $job->notic }} </textarea>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Status') }}</label>
            <select name="status" class="form-control">
                <option {{ $job->status == 0 ? 'selected' : '' }} value="0">{{ __('site.Open') }}</option>
                <option {{ $job->status == 1 ? 'selected' : '' }} value="1">{{ __('site.Close') }}</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Files') }}</label>
            <input type="file" name="image[]" class="form-control" multiple>
            <br>
            @php
                $count = 0;
            @endphp
            @foreach ($images as $F_img)
                @php
                    $count++;
                    //$theFileName = $F_img->id;
                @endphp
                <div>
                    <img width="80" src="{{ asset('uploads/' . $F_img->file_name) }}" alt="" name="existFile">
                    <input type="checkbox" name="deleteFile[]" value="{{ $F_img->id }}">{{ ' Delete' }}
                </div>
            @endforeach
            @if ($count == 0)
                <h6 style="color: red"> There is no files for this Job</h6>
            @endif
            <br><br>

        </div>

        <button class="btn btn-success px-5 mb-5"><i class="fa fa-check" aria-hidden="true"></i>
            {{ __('site.Update') }}</button>
    </form>
@endsection
