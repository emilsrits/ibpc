@extends('layouts.admin')

@section('title')
Edit User
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="user-edit">
        <h3>#{{ $user->id . ' ' . $user->full_name }}</h3>
        <form id="edit-user-form" role="form" method="POST" action="{{ url('/admin/user/update', ['id' => $user->id]) }}">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <div class="manage-btn-group">
                <div class="btn-manage-back">
                    <a href="{{ url('/admin/users') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
                </div>
                <button class="entity-save" type="submit" name="submit" value="save">Save</button>
            </div>
            <div class="user-content-section">
                <div class="content-section-toggle">
                    <strong>General<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                </div>
                <div class="content-container">
                    <table class="user-table">
                        <tbody>
                        <tr class="entity-attribute">
                            <td><label for="first_name">First Name</label></td>
                            <td><input type="text" name="first_name" value="{{ old('first_name') ? old('first_name') : $user->first_name }}"></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="last_name">Last Name</label></td>
                            <td><input type="text" name="last_name" value="{{ old('last_name') ? old('last_name') : $user->last_name }}"></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="email">Email</label></td>
                            <td><input type="email" name="email" value="{{ old('email') ? old('email') : $user->email }}"></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="phone">Phone</label></td>
                            <td><input type="text" name="phone" value="{{ old('phone') ? old('phone') : $user->phone }}"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="user-content-section">
                <div class="content-section-toggle">
                    <strong>Password<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                </div>
                <div class="content-container user-password-section">
                    <table class="user-table">
                        <tbody>
                        <tr class="entity-attribute">
                            <td><label for="password">New Password</label></td>
                            <td><input type="password" name="password"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="user-content-section">
                <div class="content-section-toggle">
                    <strong>Address<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                </div>
                <div class="content-container">
                    <table class="user-table">
                        <tbody>
                        <tr class="entity-attribute">
                            <td><label for="country">Country</label></td>
                            <td>
                                @include('partials.widgets.countries', ['default' => $user->country])
                            </td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="city">City</label></td>
                            <td><input type="text" name="city" value="{{ old('city') ? old('city') : $user->city }}"></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="address">Address</label></td>
                            <td><input type="text" name="address" value="{{ old('address') ? old('address') : $user->address }}"></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="postcode">Post Code</label></td>
                            <td><input type="text" name="postcode" value="{{ old('postcode') ? old('postcode') : $user->postcode }}"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="user-content-section">
                <div class="content-section-toggle">
                    <strong>User Roles<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                </div>
                <div class="content-container">
                    <table class="user-table">
                        <tbody>
                            @foreach($roles as $role)
                                <tr class="entity-attribute">
                                    <td class="user-role">
                                        <label>
                                            <input type="checkbox" name="{{ 'role[' . $role->id . '][id]' }}"
                                                value="{{ $role->id }}"
                                                {{ $user->hasRole($role->slug) ? 'checked' : '' }}>
                                            {{ $role->slug }}
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
       $('.user-password-section').hide();
    });
</script>
@endsection