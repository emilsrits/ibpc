@extends('layouts.master')

@section('content')
<div class="container is-fluid">
    <div class="columns">
        <div class="column is-8 is-offset-2">
            <div id="authorization" class="panel">
                <p class="panel-heading">Reset Password</p>

                <div class="panel-block">
                    @if (session('status'))
                        <p class="alert alert-success">{{ session('status') }}</p>
                    @endif

                    <form class="form" role="form" method="POST" action="{{ url('/password/email') }}">
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

                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-link button-action" type="submit">Send Password Reset Link</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
