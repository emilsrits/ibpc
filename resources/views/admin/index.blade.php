@extends('layouts.master')

@section('title')
Admin Panel
@endsection

@section('content')
<div class="lg-100 md-100 sm-100">
    <div class="manage-section manage-catalog">
        <h4>Catalog</h4>
        <div class="manage-tab products-catalog">
            <a href="{{ url('/admin/catalog') }}"><i class="fa fa-book" aria-hidden="true"></i>Product Catalog</a>
        </div>
        <div class="manage-tab products-categories">
            <a href="{{ url('/admin/categories') }}"><i class="fa fa-tag" aria-hidden="true"></i>Categories</a>
        </div>
        <div class="manage-tab products-attributes">
            <a href="{{ url('/admin/specifications') }}"><i class="fa fa-list" aria-hidden="true"></i>Attributes</a>
        </div>
    </div>
    <div class="manage-section manage-users">
        <h4>Users</h4>
        <div class="manage-tab users-create">
            <a href="{{ url('/admin/users/create') }}"><i class="fa fa-plus" aria-hidden="true"></i>Create Users</a>
        </div>
        <div class="manage-tab users-edit">
            <a href="{{ url('/admin/users/edit') }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit Users</a>
        </div>
    </div>
</div>
@endsection