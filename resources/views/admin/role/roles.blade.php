@extends('layouts.admin')

@section('title')
Roles
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="users-roles">
        <h3>Roles List</h3>
        <div class="manage-btn-group">
            <div class="btn-manage-back">
                <a href="{{ url('/admin') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
            </div>
        </div>
        <table id="roles-table">
            <thead class="table-head">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody class="table-body">
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->slug }}</td>
                    <td>{{ $role->description }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection