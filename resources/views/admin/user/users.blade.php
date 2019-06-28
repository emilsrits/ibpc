@extends('layouts.admin')

@section('title')
Users
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="users-list">
        <h3>Users List</h3>
        <div class="manage-btn-group">
            <div class="btn-manage-back">
                <a href="{{ url('/admin') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
            </div>
        </div>
        <form id="users-form" role="form" method="POST" action="{{ url('/admin/users') }}">
            {{ csrf_field() }}
            <div class="users-action">
                <select id="mass-action" name="mass-action">
                    <option value="0"></option>
                    <option value="1">Enable</option>
                    <option value="2">Disable</option>
                </select>
                <button id="mass-action-run" type="submit" name="submit"><i class="fa fa-play" aria-hidden="true"></i></button>
                <button id="filters-clear" type="button" name="clear"><i class="fa fa-refresh" aria-hidden="true"></i> Clear Filters</button>
            </div>
            {{ $users->appends(Request::except('page'))->links() }}
            <table id="users-table">
                <thead class="table-head">
                <tr>
                    <th class="col-xs">
                        <input id="mass-select" type="checkbox" name="mass-select" value="yes">
                    </th>
                    <th class="col-sm">Id</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th id="sort-created" class="col-md">
                        <button class="btn-sort" type="submit" name="created" value="{{ sortEntry($request['created']) }}">
                            Created at
                            @if($request['created'] === 'asc')
                                <i class="fa fa-sort-asc" aria-hidden="true"></i>
                            @elseif($request['created'] === 'desc')
                                <i class="fa fa-sort-desc" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-sort" aria-hidden="true"></i>
                            @endif
                        </button>
                    </th>
                    <th id="sort-updated" class="col-md">
                        <button class="btn-sort" type="submit" name="updated" value="{{ sortEntry($request['updated']) }}">
                            Updated at
                            @if($request['updated'] === 'asc')
                                <i class="fa fa-sort-asc" aria-hidden="true"></i>
                            @elseif($request['updated'] === 'desc')
                                <i class="fa fa-sort-desc" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-sort" aria-hidden="true"></i>
                            @endif
                        </button>
                    </th>
                    <th class="col-xs"></th>
                </tr>
                </thead>
                <tr id="table-search">
                    <td></td>
                    <td><input type="number" name="id" min="1" value="{{ $request['id'] ? $request['id'] : '' }}"></td>
                    <td><input type="text" name="user" value="{{ $request['user'] ? $request['user'] : '' }}"></td>
                    <td>
                        <select name="role">
                            <option value=""></option>
                            @foreach(config('constants.user_roles') as $key => $value)
                                <option value="{{ $key }}" {{ $request['role'] === $value ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="status">
                            <option value=""></option>
                            <option value="1" {{ $request['status'] === '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $request['status'] === '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </td>
                    <td><input type="text" name="createdAt" value="{{ $request['createdAt'] ? $request['createdAt'] : '' }}"></td>
                    <td><input type="text" name="updatedAt" value="{{ $request['updatedAt'] ? $request['updatedAt'] : '' }}"></td>
                    <td></td>
                </tr>
                <tbody class="table-body">
                @foreach($users as $user)
                    <tr>
                        <td>
                            <input class="entity-select" type="checkbox"
                                   name="users[{{ $user->id }}][id]" value="{{ $user->id }}">
                        </td>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->roles->min()->name }}</td>
                        <td>{{ $user->status ? 'Active' : 'Disabled' }}</td>
                        <td class="no-wrap">{{ $user->created_at }}</td>
                        <td class="no-wrap">{{ $user->updated_at }}</td>
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