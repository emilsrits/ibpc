@extends('layouts.admin')

@section('title')
Users
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="users-list">
        <h3>User List</h3>
        <div class="manage-btn-group">
            <div class="btn-manage-back">
                <a href="{{ url('/admin') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
            </div>
        </div>
        <form id="users-form" role="form" method="POST" action="{{ url('/admin/users/action') }}">
            {{ csrf_field() }}
            <div class="users-action">
                <select id="mass-action" name="mass-action">
                    <option value="0"></option>
                    <option value="1">Disable</option>
                    <option value="2">Enable</option>
                    <option value="3">Delete</option>
                </select>
                <button id="mass-action-run" type="submit" name="submit"><i class="fa fa-play" aria-hidden="true"></i></button>
            </div>
            {{ $users->appends(Request::except('page'))->links() }}
            <table id="users-table">
                <thead class="table-head">
                <tr>
                    <th>
                        <input id="mass-select" type="checkbox" name="mass-select" value="yes">
                    </th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="table-body">
                @foreach($users as $user)
                    <tr>
                        <td>
                            <input class="entity-select" type="checkbox"
                                   name="specifications[{{ $user->id }}][id]" value="{{ $user->id }}">
                        </td>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name . ' ' . $user->surname }}</td>
                        <td>{{ $user->roles->first()->name }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>
                            <a href="{{ url('/admin/user/edit', ['id' => $user->id]) }}">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if($users->count() > 20)
                {{ $users->appends(Request::except('page'))->links() }}
            @endif
        </form>
    </div>
</div>
@endsection