@extends('layouts.store')

@section('content')
<div class="container is-fluid">
    <div class="columns">
        <div class="column is-8 is-offset-2">
            <div id="authorization" class="panel">
                <p class="panel-heading">{{ __('Verify Your Email Address') }}</p>

                <div class="panel-block">
                    @if(session('resent'))
                        <h2 class="is-size-5">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </h2>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
