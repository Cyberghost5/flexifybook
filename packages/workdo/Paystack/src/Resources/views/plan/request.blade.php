@extends('layouts.auth')

@section('page-title')
    {{ __('Paystack') }}
@endsection

@section('language-bar')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>{{ __('Paystack Payment') }}</h2>
                    <p>{{ __('Redirecting you to Paystack for payment...') }}</p>
                    <div class="spinner-border" role="status">
                        <span class="sr-only">{{ __('Loading...') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Redirect to Paystack payment page
        window.location.href = '{{ $paystack_session->url }}';
    </script>
@endsection