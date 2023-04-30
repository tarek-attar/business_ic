@extends('admin.master')

@section('title')
    {{ __('site.All Payments') }}|{{ env('APP_NAME') }}
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 m-0 text-gray-800">{{ __('site.All Payments') }}
        </h1>
    </div>
    <table class="table table-bordered table-hover table-striped">
        <tr class="bg-dark text-white">
            <th>ID</th>
            <th>{{ __('site.Sender') }}
            </th>
            <th>{{ __('site.Receiver') }}
            </th>
            <th>{{ __('site.Job') }}
            </th>
            <th>{{ __('site.Amount') }}
            </th>
            <th>{{ __('site.Company ratio') }}
            </th>
            <th>{{ __('site.Amount after discount') }}
            </th>
            <th>{{ __('site.Actions') }}
            </th>
        </tr>
        @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>Id:{{ $payment->sender_id }} <br> N: {{ $payment->sender->name }}</td>
                <td>Id:{{ $payment->receiver_id }} <br> N:{{ $payment->receiver->name }} </td>
                <td>Id:{{ $payment->job_id }} <br> EN: {{ $payment->job->title_en }} <br>AR:
                    {{ $payment->job->title_ar }}
                </td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->company_ratio }}</td>
                <td>{{ $payment->amount_after_discount }}</td>
                <td>
                    <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-info m-1"><i
                            class="fas fa-eye"></i></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $payments->links() }}
@endsection
