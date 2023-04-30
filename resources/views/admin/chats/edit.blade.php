@extends('admin.master')

@section('title')
    {{ __('site.Edit Chat') }} | {{ env('APP_NAME') }}
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Edit Chat') }}</h1>
        <a href="{{ route('admin.chats.index') }}" class="btn btn-success px-5 ">{{ __('site.All Chats') }}</a>
    </div>

    <div class="mb-3">
        <label for="">{{ __('site.Room Id') }}</label>
        <input readonly type="text" name="room_id" value="{{ $chat->chat_room_id }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Chat Name') }}</label>
        <input readonly type="text" name="chat_name" value="{{ $chat->room->name }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Sender') }}</label>
        <input readonly type="text" name="sender" value="ID: {{ $chat->user->id }} - {{ $chat->user->name }}"
            class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Message') }}</label>
        <textarea readonly name="message" id="" cols="30" class="form-control">{{ $chat->message }}</textarea>
    </div>
    <form action="{{ route('admin.chats.update', $chat->id) }}" method="post">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="">{{ __('site.Notic') }}</label>
            <textarea name="notic" id="" cols="30" class="form-control">{{ $chat->notic }}</textarea>
        </div>
        <button class="btn btn-success px-5 mb-5"><i class="fa fa-check" aria-hidden="true"></i>
            {{ __('site.Update') }}</button>
    </form>
@endsection
