@extends('admin.master')

@section('title')
    {{ __('site.Show Payment') }}|{{ env('APP_NAME') }}
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.Show Payment') }}
        </h1>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-success px-5 ">{{ __('site.All Payments') }}
        </a>
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Sender') }}
        </label>
        <input readonly type="text" name="receiver_id" value="{{ $payment->sender_id }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Receiver') }}
        </label>
        <input readonly type="text" name="receiver_id" value="{{ $payment->receiver_id }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Job') }}
        </label>
        <input readonly type="text" name="job_id" value="{{ $payment->job_id }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Amount') }}
        </label>
        <input readonly type="text" name="chat_name" value="{{ $payment->amount }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Company ratio') }}
        </label>
        <input readonly type="text" name="chat_name" value="{{ $payment->company_ratio }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Amount after discount') }}
        </label>
        <input readonly type="text" name="chat_name" value="{{ $payment->amount_after_discount }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Created At') }}
        </label>
        <input readonly type="text" name="created_at" value="{{ $payment->created_at }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">{{ __('site.Updated At') }}
        </label>
        <input readonly type="text" name="updated_at" value="{{ $payment->updated_at }}" class="form-control">
    </div>
@endsection
