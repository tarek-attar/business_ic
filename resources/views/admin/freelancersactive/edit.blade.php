@extends('admin.master')

@section('title')
    {{ __('site.Edit Freelancer Active') }} | {{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Edit Freelancer Active') }}</h1>
        <a href="{{ route('admin.freelancersactive.index') }}"
            class="btn btn-success px-5 ">{{ __('site.All Freelancers Avtive') }}</a>
    </div>
    @include('admin.errors')
    <form action="{{ route('admin.freelancersactive.update', $freelancer->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="">{{ __('site.Name') }}</label>
            <input type="text" name="name" value="{{ $freelancer->user->name }}" inputmode="text" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Phone Number') }}</label><br>
            <input type="tel" name="phone_number" value="{{ $freelancer->user->phone_number }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Email') }}</label><br>
            <input type="text" name="email" value="{{ $freelancer->user->email }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Service') }}</label>
            <select name="category_id" class="form-control">
                @foreach ($categories as $item)
                    <option {{ $freelancer->category_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                        {{ $item->name_en }} - {{ $item->name_ar }} </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Address') }}</label><br>
            <input type="text" name="address" value="{{ $freelancer->address }}" placeholder="{{ __('site.Address') }}"
                class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Notic') }}</label>
            <textarea type="text" name="notic" placeholder="{{ __('site.Notic') }}" class="form-control" rows="5"> {{ $freelancer->user->notic }}</textarea>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Status') }}</label>
            <select name="status" class="form-control">
                <option {{ $freelancer->status == 'active' ? 'selected' : '' }} value="active">Active</option>
                <option {{ $freelancer->status == 'unactive' ? 'selected' : '' }} value="unactive">UnActive</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Image') }}</label>
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
                    <img width="80" src="{{ asset('uploads/' . $F_img->image) }}" alt="image" name="existFile">
                    <input type="checkbox" name="deleteFile[]" value="{{ $F_img->id }}">{{ 'Delete' }}
                </div>
            @endforeach
            @if ($count == 0)
                <h6 style="color: red"> There is no files for this Job</h6>
            @endif
            <br><br>
        </div>


        <div class="mb-3">
        </div>
        {{--  يجب رفع الملفات مع بعضها وتكون علي صيغة مصفوفة اري نستخرجهم بلوب --}}
        <button class="btn btn-success px-5"><i class="fa fa-check" aria-hidden="true"></i>{{ __('site.Edit') }}</button>
    </form>
@endsection
