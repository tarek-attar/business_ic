@extends('admin.master')

@section('title')
    {{ __('site.Upgrade User') }}|{{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Upgrade User') }}
        </h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-success px-5 ">{{ __('site.All Users') }}
        </a>
    </div>
    @include('admin.errors')
    <form action="{{ route('admin.users.update', $user->id) }}" method="post">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="">{{ __('site.ID') }}
            </label>
            <input readonly type="text" name="name" value="{{ $user->id }}" class="form-control">
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
            <select name="role" class="form-control">
                <option {{ $user->role == 'superadmin' ? 'selected' : '' }} value="superadmin">Super Admin</option>
                <option {{ $user->role == 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                <option {{ $user->role == 'freelancer' ? 'selected' : '' }} value="freelancer">Freelancer</option>
                <option {{ $user->role == 'user' ? 'selected' : '' }} value="user">User</option>
            </select>
        </div>
        <input readonly hidden type="text" name="type" value="upgrade" class="form-control">
        <button class="btn btn-success px-5"> <i class="fa fa-check"></i> {{ __('site.Upgrade') }}
        </button>
    </form>
@endsection
