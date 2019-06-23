@extends('layouts.master')

@section('title')
Account Settings
@endsection

@section('content')
<div class="grid rlg-100 md-100 sm-100">
    <div id="user-account" class="cf">
        @include('partials.account.navigation')
        <div id="account-panel" class="grid-item lg-10 md-100 sm-100">
            <h4>Account settings</h4>
            <form id="account--edit-form" role="form" method="POST" enctype="multipart/form-data" action="{{ url('/user/update', ['id' => $user->id]) }}">
                {{ csrf_field() }}
                <div class="account-content-section">
                    <div class="content-section-toggle">
                        <strong>Contact information<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                    </div>
                    <div class="content-container">
                        <div class="form-group">
                            <label for="name">First Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="surname">Last Name</label>
                            <input type="text" name="surname" class="form-control" value="{{ $user->surname }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                        </div>
                    </div>
                </div>
                <div class="account-content-section">
                    <div class="content-section-toggle">
                        <strong>Password<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                    </div>
                    <div class="content-container user-account-password-section">
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" name="password" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">New Password Again</label>
                            <input type="password" name="password_confirmation" class="form-control" value="">
                        </div>
                    </div>
                </div>
                <div class="account-content-section">
                    <div class="content-section-toggle">
                        <strong>Address<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                    </div>
                    <div class="content-container">
                        <div class="form-group">
                            <label for="country">Country</label>
                            @include('partials.widgets.countries', ['default' => $user->country])
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" name="city" class="form-control" value="{{ $user->city }}">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                        </div>
                        <div class="form-group">
                            <label for="postcode">Postcode</label>
                            <input type="text" name="postcode" class="form-control" value="{{ $user->postcode }}">
                        </div>
                    </div>
                </div>
                <div id="account-update-confirm">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" name="current_password" class="form-control" value="" required>
                    </div>
                    <button id="account-update-submit" class="btn" type="submit" name="submit" value="save">Save Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.user-account-password-section').hide();
    });
</script>
@endsection