@extends('layouts.store')

@section('title')
Account Settings
@endsection

@section('content')
<div class="section">
    <div class="container">
        <div id="user-account" class="box">
            @include('pages.account._partials.navigation')

            <form id="account--edit-form" role="form" method="POST" enctype="multipart/form-data" action="{{ url('/user/update', ['id' => $user->id]) }}">
                @method('PATCH')
                @csrf

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">Account</h2>
                    </div>

                    <div class="column is-9">
                        <div class="field is-horizontal">
                            <div class="field-body">
                                {{-- First Name Field --}}
                                <div class="field is-narrow">
                                    <label class="label is-small" for="first_name">First Name</label>
                                    <div class="control">
                                        <input class="input" type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}">
                                    </div>
                                </div>

                                {{-- Last Name Field --}}
                                <div class="field is-narrow">
                                    <label class="label is-small" for="last_name">Last Name</label>
                                    <div class="control">
                                        <input class="input" type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-body">
                                {{-- Email Field --}}
                                <div class="field">
                                    <label class="label is-small" for="email">Email</label>
                                    <div class="control">
                                        <input class="input" type="text" name="email" value="{{ old('email', $user->email) }}">
                                    </div>
                                </div>

                                {{-- Phone Field --}}
                                <div class="field is-narrow">
                                    <label class="label is-small" for="phone">Phone</label>
                                    <div class="control">
                                        <input class="input" type="text" name="phone" value="{{ old('phone', $user->phone) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">Address</h2>
                    </div>

                    <div class="column is-9">
                        {{-- Street Address Field --}}
                        <div class="field">
                            <label class="label is-small" for="address">Street Address</label>
                            <div class="control">
                                <input class="input" type="text" name="address" value="{{ old('address', $user->address) }}">
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-body">
                                {{-- Country Field --}}
                                <div class="field is-narrow">
                                    <label class="label is-small" for="country">Country</label>
                                    <div class="control">
                                        <div class="select">
                                            {!! Form::select('country', config('constants.countries'), old('country', optional($user)->country)) !!}
                                        </div>
                                    </div>
                                </div>

                                {{-- City Field --}}
                                <div class="field">
                                    <label class="label is-small" for="city">City</label>
                                    <div class="control">
                                        <input class="input" type="text" name="city" value="{{ old('city', $user->city) }}">
                                    </div>
                                </div>

                                {{-- Postal Code Field --}}
                                <div class="field">
                                    <label class="label is-small" for="postcode">ZIP / Postal Code</label>
                                    <div class="control">
                                        <input class="input" type="text" name="postcode" value="{{ old('postcode', $user->postcode) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">Password</h2>
                    </div>

                    <div class="column is-9">
                        <div class="field is-horizontal">
                            <div class="field-body">
                                {{-- New Password Field --}}
                                <div class="field">
                                    <label class="label is-small" for="password">New Password</label>
                                    <div class="control">
                                        <input class="input" type="password" name="password" value="">
                                    </div>
                                </div>

                                {{-- New Password Confirmation Field --}}
                                <div class="field">
                                    <label class="label is-small" for="password_confirmation">New Password Again</label>
                                    <div class="control">
                                        <input class="input" type="password" name="password_confirmation" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="account-update-confirm" class="form-section">
                    {{-- Current Password Field --}}
                    <div class="field">
                        <label class="label is-small" for="current_password">Current Password</label>
                        <div class="control">
                            <input class="input" type="password" name="current_password" value="" required>
                        </div>
                    </div>

                    <div class="has-text-right">
                        <button id="account-update-submit" class="button button-action action-do" type="submit" name="submit" value="save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection