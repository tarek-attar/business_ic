@extends('admin.master')

@section('title')
    {{ __('site.Upgrade to Freelancer') }} | {{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Create Freelancer') }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-success px-5 ">{{ __('site.All Users') }}</a>
    </div>
    @include('admin.errors')
    <form action="{{ route('admin.freelancers.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        {{-- @method('put') --}}
        <div class="mb-3">
            <label for="">{{ __('site.Name') }}</label>
            <input type="text" name="name" inputmode="text" placeholder="{{ __('site.Name') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Phone Number') }}</label><br>
            <input type="tel" name="phone_number" placeholder="{{ __('site.Phone Number') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Email') }}</label><br>
            <input type="text" name="email" placeholder="{{ __('site.Email') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Address') }}</label><br>
            <input type="text" name="address" placeholder="{{ __('site.Address') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Notic') }}</label>
            <textarea type="text" name="notic" placeholder="{{ __('site.Notic') }}" class="form-control" rows="5"></textarea>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Status') }}</label>
            <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="unactive">UnActive</option>
            </select>
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
            <label for="">{{ __('site.Id Images') }}</label>
            <input type="file" name="id_image[]" class="form-control" multiple>
        </div>
        {{--  يجب رفع الملفات مع بعضها وتكون علي صيغة مصفوفة اري نستخرجهم بلوب --}}
        <button class="btn btn-success px-5"><i class="fa fa-check" aria-hidden="true"></i>{{ __('site.Add') }}</button>
    </form>
@endsection
