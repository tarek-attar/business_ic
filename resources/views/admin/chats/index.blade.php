@extends('admin.master')

@section('title')
    {{ __('site.All Chats') }} | {{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.All Chats') }}</h1>
    </div>
    @if (session('msg'))
        <div class="alert alert-{{ session('type') }}">
            {{ session('msg') }}
        </div>
    @endif
    <table class="table table-bordered table-hover table-striped">
        <tr class="bg-dark text-white">
            <th>ID</th>
            <th>{{ __('site.Room Id') }}</th>
            <th>{{ __('site.Chat Name') }}</th>
            <th>{{ __('site.Sender') }}</th>
            <th>{{ __('site.Message') }}</th>
            <th>{{ __('site.Notic') }}</th>
            <th>{{ __('site.Actions') }}</th>
        </tr>
        {{-- @while ($chats->room->type == 'public') --}}
        {{-- @if ($chats->id == 4) --}}
        @foreach ($chats as $chat)
            {{-- @php
                $user1 = $chat->room->user1;
                $user2 = $chat->room->user2;

                if ($chat->user_id == $user1) {
                    $firstUser = $user1;
                } else {
                    $firstUser = $user2;
                }
                if ($chat->user_id == $user2) {
                    $secondUser = $user2;
                } else {
                    $secondUser = $user1;
                }
            @endphp --}}
            <tr>
                <td>{{ $chat->id }}</td>
                <td>{{ $chat->chat_room_id }}</td>
                <td>{{ $chat->room->name }} </td>
                <td>ID: {{ $chat->user->id }} - {{ $chat->user->name }}</td>
                <td>{{ $chat->message }}</td>
                <td>{{ $chat->notic }}</td>
                <td>
                    <a href="{{ route('admin.chats.edit', $chat->id) }}" class="btn btn-sm btn-primary m-1"><i
                            class="fas fa-edit"></i></a>
                    <a href="{{ route('admin.chats.show', $chat->id) }}" class="btn btn-sm btn-info m-1"><i
                            class="fas fa-eye"></i></a>
                </td>
            </tr>
        @endforeach
        {{-- @endwhile --}}
        {{-- @endif --}}
    </table>
    {{ $chats->links() }}
@endsection
