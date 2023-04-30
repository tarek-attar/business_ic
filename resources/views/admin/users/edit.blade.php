@extends('admin.master')

@section('title')
    {{ __('site.Edit User') }}|{{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Edit User') }}
        </h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-success px-5 ">{{ __('site.All Users') }}
        </a>
    </div>
    @include('admin.errors')
    <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="">{{ __('site.Name') }}
            </label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Email') }}
            </label>
            <input type="text" name="email" value="{{ $user->email }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Phone Number') }} (059 000 1111)
            </label>
            <input type="text" name="phone_number" value="{{ $user->phone_number }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Password') }} (8 char at least)
            </label>
            <input readonly type="text" name="password" value="{{ $user->password }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Notic') }}</label>
            <textarea name="notic" id="" cols="30" class="form-control">{{ $user->notic }}</textarea>
        </div>

        @if ($user->role != 'freelancer')
            <h4 style="color: red"> If you want to Upgrade user to Freelancer complet thess data :</h4>
            <div {{-- class="form-inline" --}}>
                <h5>Do you want to upgrade user to freelancer: </h5>
                <label>
                    <input type="radio" name="yesno" value="yes">
                    Yes
                </label>
                <label>
                    <input type="radio" name="yesno" value="no">
                    No
                </label>
            </div>
            <div class="mb-3">
                <label for="">{{ __('site.User ID') }}
                </label>
                <input readonly type="text" name="user_id" value="{{ $user->id }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="">{{ __('site.Address') }}</label><br>
                <input type="text" name="address" placeholder="{{ __('site.Address') }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="">{{ __('site.Status') }}</label>
                <select name="status" class="form-control">
                    <option value="active">Active</option>
                    <option value="unactive">UnActive</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="">{{ __('site.Service') }}</label>
                <select name="category_id" class="form-control">
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name_en }} - {{ $item->name_ar }} </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="">{{ __('site.Id Images') }}</label>
                <input type="file" name="image[]" class="form-control" multiple>
            </div>
        @endif

        <input readonly hidden type="text" name="type" value="edit" class="form-control">
        <button class="btn btn-success px-5"><i class="fa fa-check" aria-hidden="true"></i> {{ __('site.Edit') }}</button>
    </form>
@endsection
