@extends('layouts.admin')

@section('title')
Roles
@endsection

@section('content')
    <div class="admin-page lg-100 md-100 sm-100">
        <div class="users-roles">
            <h3>Role List</h3>
            <div class="manage-btn-group">
                <div class="btn-manage-back">
                    <a href="{{ url('/admin') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
                </div>
                <div class="btn-manage-add">
                    <a href="{{ url('/admin/role/create') }}">Add Role</a>
                </div>
            </div>
            <form id="roles-form" role="form" method="POST" action="{{ url('/admin/roles/action') }}">
                {{ csrf_field() }}
                <div class="roles-action">
                    <select id="mass-action" name="mass-action">
                        <option value="0"></option>
                        <option value="1">Delete</option>
                    </select>
                    <button id="mass-action-run" type="submit" name="submit"><i class="fa fa-play" aria-hidden="true"></i></button>
                </div>
                <table id="roles-table">
                    <thead class="table-head">
                    <tr>
                        <th>
                            <input id="mass-select" type="checkbox" name="mass-select" value="yes">
                        </th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-body">
                    @foreach($roles as $role)
                        <tr>
                            <td>
                                <input class="entity-select" type="checkbox"
                                       name="roles[{{ $role->id }}][id]" value="{{ $role->id }}">
                            </td>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->slug }}</td>
                            <td>{{ $role->description }}</td>
                            <td>
                                <a href="{{ url('/admin/user/edit', ['id' => $role->id]) }}">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection