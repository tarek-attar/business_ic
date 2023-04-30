@extends('admin.master')

@section('title')
    {{ __('site.Show Chat') }} | {{ env('APP_NAME') }}
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Show Chat') }}</h1>
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
    <div class="mb-3">
        <label for="">{{ __('site.Note') }}</label>
        <textarea readonly name="note" id="" cols="30" class="form-control">{{ $chat->notic }}</textarea>
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Created At') }}</label>
        <input readonly type="text" name="created_at" value="{{ $chat->created_at }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Updated At') }}</label>
        <input readonly type="text" name="updated_at" value="{{ $chat->updated_at }}" class="form-control">
    </div>
@endsection
