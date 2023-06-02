@extends('admin.master')

@section('title')
    {{ __('site.Show Freelancer') }} | {{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Show Freelancer') }}</h1>
        <a href="{{ route('admin.freelancers.index') }}" class="btn btn-success px-5 ">{{ __('site.All Freelancers') }}</a>
    </div>
    @include('admin.errors')
    <div class="mb-3">
        <label for="">{{ __('site.Owner') }}</label>
        <input readonly type="text" name="user_id" value="{{ $freelancer->user->id }} - {{ $freelancer->user->name }}"
            class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Phone Number') }}</label>
        <input readonly type="text" name="phone_number" value="{{ $freelancer->user->phone_number }}"
            class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Email') }}</label>
        <input readonly type="text" name="email" value="{{ $freelancer->user->email }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Service') }}</label>
        @foreach ($freelanser_services as $services)
            <input readonly type="text" name="service"
                value="{{ $services->category->name_ar }} - {{ $services->category->name_en }}" class="form-control">
        @endforeach
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Address') }}</label>
        <input readonly type="text" name="address" value="{{ $freelancer->address }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Notic') }}</label>
        <textarea readonly name="notic" class="form-control" id="" rows="5">{{ $freelancer->user->notic }}</textarea>
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Status') }}</label>
        <input readonly type="text" name="status" class="form-control"
            @switch($freelancer->status)
                        @case('active')
                        value={{ __('site.active') }}
                        style="color: green"
                        @break
                        @case('unactive')
                        value={{ __('site.unactive') }}
                        style="color: red"
                        @break
                        @default
                    @endswitch>
    </div>

    <div class="mb-3">
        <label for="">{{ __('site.Image') }} :</label>
        @php
            $count = 0;
        @endphp
        @foreach ($images as $F_img)
            @php
                $count++;
            @endphp
            <img width="80" src="{{ asset('uploads/' . $F_img->image) }}" alt=" file Image">
        @endforeach
        @if ($count == 0)
            <h6 style="color: red"> There is no files for this Freelancer</h6>
        @endif
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Updated At') }}</label>
        <input readonly type="text" name="updated_at" value="{{ $freelancer->updated_at }}" class="form-control">
    </div>
@endsection
