@extends('admin.master')

@section('title')
    {{ __('site.Show User') }}|{{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Show User') }}
        </h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-success px-5 ">{{ __('site.All Users') }}
        </a>
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Name') }}
        </label>
        <input readonly type="text" name="name" value="{{ $user->name }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Email') }}
        </label>
        <input readonly type="text" name="email" value="{{ $user->email }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Role') }}
        </label>
        <input readonly type="text" name="role" value="{{ $user->role }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Password') }}
        </label>
        <input readonly type="text" name="password" value="{{ $user->password }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Notic') }}</label>
        <textarea readonly name="notic" id="" cols="30" class="form-control">{{ $user->notic }}</textarea>
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Created At') }}
        </label>
        <input readonly type="text" name="created_at" value="{{ $user->created_at }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Updated At') }}
        </label>
        <input readonly type="text" name="updated_at" value="{{ $user->updated_at }}" class="form-control">
    </div>
@endsection
