@extends('layouts.admin')

@section('title')
Edit User
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">#{{ $user->id . ' ' . $user->full_name }}</h1>

            <form id="entity-edit-form" role="form" method="POST" action="{{ url('/admin/user/update', ['id' => $user->id]) }}">
                @method('PATCH')
                @csrf

                <entity-manage
                    :routes="{
                        back: '{{ url('/admin/users') }}'
                    }"
                >
                </entity-manage>

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">Account</h2>
                    </div>

                    <div class="column is-9">
                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field is-narrow">
                                    <label class="label is-small" for="first_name">First Name</label>
                                    <div class="control">
                                        <input class="input" type="text" name="first_name" value="{{ old('first_name') ?? $user->first_name }}">
                                    </div>
                                </div>

                                <div class="field is-narrow">
                                    <label class="label is-small" for="last_name">Last Name</label>
                                    <div class="control">
                                        <input class="input" type="text" name="last_name" value="{{ old('last_name') ?? $user->last_name }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    <label class="label is-small" for="email">Email</label>
                                    <div class="control">
                                        <input class="input" type="text" name="email" value="{{ old('email') ?? $user->email }}">
                                    </div>
                                </div>

                                <div class="field is-narrow">
                                    <label class="label is-small" for="phone">Phone</label>
                                    <div class="control">
                                        <input class="input" type="text" name="phone" value="{{ old('phone') ?? $user->phone }}">
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
                        <div class="field">
                            <label class="label is-small" for="address">Street Address</label>
                            <div class="control">
                                <input class="input" type="text" name="address" value="{{ old('address') ?? $user->address }}">
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field is-narrow">
                                    <label class="label is-small" for="country">Country</label>
                                    <div class="control">
                                        <div class="select">
                                            {!! Form::select('country', config('constants.countries'), old('country') ?? optional($user)->country) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label is-small" for="city">City</label>
                                    <div class="control">
                                        <input class="input" type="text" name="city" value="{{ old('city') ?? $user->city }}">
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label is-small" for="postcode">ZIP / Postal Code</label>
                                    <div class="control">
                                        <input class="input" type="text" name="postcode" value="{{ old('postcode') ?? $user->postcode }}">
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
                        <div class="field">
                            <label class="label is-small" for="password">New Password</label>
                            <div class="control">
                                <input class="input" type="password" name="password" value="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">Roles</h2>
                    </div>

                    <div class="column is-9">
                        @foreach($roles as $role)
                            <div class="field">
                                <input
                                    id="{{ 'role[' . $role->id . '][id]' }}"
                                    class="switch is-small"
                                    type="checkbox"
                                    name="{{ 'role[' . $role->id . '][id]' }}"
                                    value="{{ $role->id }}"
                                    {{ $user->hasRole($role->slug) ? 'checked' : '' }}>

                                <label for="{{ 'role[' . $role->id . '][id]' }}">{{ $role->slug }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection