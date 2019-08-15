@extends('layouts.master')

@section('content')
<div class="container is-fluid">
    <div class="columns">
        <div class="column is-8 is-offset-2">
            <div id="authorization" class="panel">
                <p class="panel-heading">Login</p>

                <div class="panel-block">
                    <form class="form" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="field">
                            <label for="email" class="label">Email</label>
                            <div class="control">
                                <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autofocus>
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
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" name="remember">&nbsp;Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-link" type="submit">
                                    Login
                                </button>
                            </div>
                            <div class="control">
                                <a class="password-reset" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                            <div class="control has-text-right">
                                <a class="button is-link" href="{{ url('/register') }}">
                                    Register
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
