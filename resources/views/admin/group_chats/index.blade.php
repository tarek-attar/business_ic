@extends('admin.master')

@section('title')
    {{ __('site.All Group Chats') }}|{{ env('APP_NAME') }}
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.All Group Chats') }}
        </h1>

    </div>
    <table class="table table-bordered table-hover table-striped">
        <tr class="bg-dark text-white">
            <th>ID</th>
            <th>{{ __('site.Sender') }}
            </th>
            <th>{{ __('site.Message') }}
            </th>
            <th>{{ __('site.Notic') }}
            </th>
            <th>{{ __('site.Actions') }}
            </th>
        </tr>
        @foreach ($group_chats as $chat)
            <tr>
                <td>{{ $chat->id }}</td>
                <td>Id:{{ $chat->user_id }} <br> N: {{ $chat->user->name }}</td>
                <td>{{ $chat->message }}</td>
                <td>{{ $chat->notic }}</td>
                <td>
                    <a href="{{ route('admin.group_chats.show', $chat->id) }}" class="btn btn-sm btn-info m-1"><i
                            class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.group_chats.edit', $chat->id) }}" class="btn btn-sm btn-primary m-1"><i
                            class="fas fa-edit"></i></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $group_chats->links() }}
@endsection
