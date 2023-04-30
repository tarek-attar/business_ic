@extends('admin.master')

@section('title')
    {{ __('site.All Admins') }}|{{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.All Admins') }}
        </h1>
    </div>
    <table class="table table-bordered table-hover table-striped">
        <tr class="bg-dark text-white">
            <th>ID</th>
            <th>{{ __('site.User ID') }}
            <th>{{ __('site.Name') }}
            </th>
            <th>{{ __('site.Email') }}
            </th>
            <th>{{ __('site.Role') }}
            </th>
            <th>{{ __('site.Password') }}
            </th>
            <th>{{ __('site.Notic') }}
            </th>
        </tr>
        {{--  @foreach ($admins as $admin)
            <tr>
                <td>{{ $admin->id }}</td>
                <td>{{ $admin->name }} </td>
                <td>{{ $admin->email }} </td>
                <td>{{ $admin->role }}</td>
                <td>{{ $admin->password }}</td>
            </tr>
        @endforeach --}}
        @php
            $count = 1;
        @endphp
        @foreach ($admins as $admin)
            <tr>
                <td>{{ $count++ }}</td>
                <td>{{ $admin->id }}</td>
                <td>{{ $admin->name }} </td>
                <td>{{ $admin->email }} </td>
                <td>{{ $admin->role }}</td>
                <td>{{ $admin->password }}</td>
                <td>{{ $admin->notic }}</td>
            </tr>
        @endforeach
    </table>
@endsection
