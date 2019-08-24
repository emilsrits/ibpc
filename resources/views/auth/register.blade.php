@extends('layouts.master')

@section('content')
<div class="container is-fluid">
    <div class="columns">
        <div class="column is-8 is-offset-2">
            <div id="authorization" class="panel">
                <p class="panel-heading">Register</p>

                <div class="panel-block">
                    <form class="form" role="form" method="POST" action="{{ url('/register') }}">
                        @csrf

                        <div class="field">
                            <label for="first_name" class="label">First Name</label>
                            <div class="control">
                                <input id="first-name" class="input" type="text" name="first_name" value="{{ old('first_name') }}" required>
                            </div>
                            @if($errors->has('first_name'))
                                <p class="help is-danger">{{ $errors->first('first_name') }}</p>
                            @endif
                        </div>

                        <div class="field">
                            <label for="last_name" class="label">Last Name</label>
                            <div class="control">
                                <input id="last-name" class="input" type="text" name="last_name" value="{{ old('last_name') }}" required>
                            </div>
                            @if($errors->has('last_name'))
                                <p class="help is-danger">{{ $errors->first('last_name') }}</p>
                            @endif
                        </div>

                        <div class="field">
                            <label for="email" class="label">Email</label>
                            <div class="control">
                                <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autofocus>
                            </div>
                            @if($errors->has('email'))
                                <p class="help is-danger">{{ $errors->first('email') }}</p>
                            @endif
                        </div>

                        <div class="field">
                            <label for="password" class="label">Password</label>
                            <div class="control">
                                <input id="password" class="input" type="password" name="password" required>
                            </div>
                            @if($errors->has('password'))
                                <p class="help is-danger">{{ $errors->first('password') }}</p>
                            @endif
                        </div>

                        <div class="field">
                            <label for="password_confirmation" class="label">Confirm Password</label>
                            <div class="control">
                                <input id="password-confirm" class="input" type="password" name="password_confirmation" required>
                            </div>
                            @if($errors->has('password_confirmation'))
                                <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                            @endif
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button button-action action-do" type="submit">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
