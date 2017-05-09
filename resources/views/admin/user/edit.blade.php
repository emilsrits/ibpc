@extends('layouts.admin')

@section('title')
Edit User
@endsection

@section('content')
    <div class="admin-page lg-100 md-100 sm-100">
        <div class="user-edit">
            <h3>#{{ $user->id . ' ' . $user->full_name }}</h3>
            <form id="edit-user-form" role="form" method="POST" action="{{ url('/admin/user/update', ['id' => $user->id]) }}">
                {{ csrf_field() }}
                <div class="manage-btn-group">
                    <div class="btn-manage-back">
                        <a href="{{ url('/admin/users') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
                    </div>
                    <button id="entity-delete" type="submit" name="submit" value="delete" formnovalidate>Delete</button>
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
                                <td><label for="name">Name</label></td>
                                <td><input type="text" name="name" value="{{ $user->name }}"></td>
                            </tr>
                            <tr class="entity-attribute">
                                <td><label for="surname">Surname</label></td>
                                <td><input type="text" name="surname" value="{{ $user->surname }}"></td>
                            </tr>
                            <tr class="entity-attribute">
                                <td><label for="email">Email</label></td>
                                <td><input type="email" name="email" value="{{ $user->email }}"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="user-content-section">
                    <div class="content-section-toggle">
                        <strong>Password<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                    </div>
                    <div class="content-container">
                        <table class="user-table">
                            <tbody>
                            <tr class="entity-attribute">
                                <td><label for="password">New Password</label></td>
                                <td><input type="password" name="password"></td>
                            </tr>
                            <tr class="entity-attribute">
                                <td><label for="auto_password">Generate Password?</label></td>
                                <td><input type="checkbox" name="auto_password"></td>
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
                            <tr class="entity-attribute">
                                @foreach($roles as $role)
                                    <td class="user-role">
                                        <input type="checkbox" name="{{ 'role[' . $role->id . '][id]' }}"
                                               {{ $user->hasRole($role->slug) ? 'checked' : '' }}
                                               value="{{ $role->id }}">
                                        <label for="{{ 'role[' . $role->id . '][id]' }}">{{ $role->name }}</label>
                                    </td>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection