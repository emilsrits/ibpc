@extends('layouts.master')

@section('content')
<div class="container is-fluid">
    <div class="columns">
        <div class="column is-8 is-offset-2">
            <div id="authorization" class="panel">
                <p class="panel-heading">Reset Password</p>

                <div class="panel-block">
                    <form class="form" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="field">
                            <label for="email" class="label">Email</label>
                            <div class="control">
                                <input id="email" class="input" type="email" name="email" value="{{ $email or old('email') }}" required autofocus>
                            </div>
                            @if ($errors->has('email'))
                                <p class="help is-danger">{{ $errors->first('email') }}</p>
                            @endif
                        </div>

                        <div class="field">
                            <label for="password" class="label">Password</label>
                            <div class="control">
                                <input id="password" class="input" type="password" name="password" required>
                            </div>
                            @if ($errors->has('password'))
                                <p class="help is-danger">{{ $errors->first('password') }}</p>
                            @endif
                        </div>

                        <div class="field">
                            <label for="password_confirmation" class="label">Confirm Password</label>
                            <div class="control">
                                <input id="password-confirm" class="input" type="password" name="password_confirmation" required>
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                            @endif
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-link button-action" type="submit">Reset Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
