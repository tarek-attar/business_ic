@extends('admin.master')

@section('title')
    {{ __('site.Create User') }}|{{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Create User') }}
        </h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-success px-5 ">{{ __('site.All Users') }}
        </a>
    </div>
    @include('admin.errors')
    <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="">{{ __('site.Name') }}
            </label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Email') }}
            </label>
            <input type="text" name="email" class="form-control">
        </div>
        <div>
            <label for="phone">{{ __('site.Phone Number') }} (059 000 1111)</label><br>
            <input type="tel" id="phone" name="phone_number" required>
        </div>
        <div class="mb-3"><br>
            <label for="">{{ __('site.Password') }} (8 char at least)
            </label>
            <input type="text" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Notic') }}</label>
            <textarea name="notic" id="" cols="30" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="">{{ __('site.Role') }}
            </label>
            <input readonly type="text" name="role" value="user" class="form-control">
        </div>
        <button class="btn btn-success px-5"><i class="fa fa-check" aria-hidden="true"></i> {{ __('site.Add') }}</button>
    </form>
@endsection

@section('scripts')
    <script>
        const phoneInput = document.getElementById("phone");

        // Add an event listener to validate the phone number
        phoneInput.addEventListener("input", function() {
            const phonePattern = /^[0-9]{3}[0-9]{3}[0-9]{4}$/;
            const isValid = phonePattern.test(phoneInput.value);
            if (!isValid) {
                phoneInput.setCustomValidity("Please enter a valid phone number (e.g. 123-456-7890)");
            } else {
                phoneInput.setCustomValidity("");
            }
        });
    </script>
@endsection
