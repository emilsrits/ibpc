@extends('layouts.master')

@section('title')
Categories
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="product-categories">
        <h3>Categories</h3>
        <div class="manage-btn-group">
            <div class="btn-manage-back">
                <a href="{{ url('/admin') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
            </div>
            <div class="btn-manage-add">
                <a href="{{ url('/admin/category/create') }}">Add Category</a>
            </div>
        </div>
        <form id="categories-form" role="form" method="POST" action="{{ url('/admin/categories/action') }}">
            {{ csrf_field() }}
            <div class="categories-action">
                <select id="mass-action" name="mass-action">
                    <option value="0"></option>
                    <option value="1">Enable</option>
                    <option value="2">Disable</option>
                    <option value="3">Delete</option>
                </select>
                <button id="mass-action-run" type="submit" name="submit"><i class="fa fa-play" aria-hidden="true"></i></button>
            </div>
            {{ $categories->appends(Request::except('page'))->links() }}
            <table id="categories-table">
                <thead class="table-head">
                <tr>
                    <th>
                        <input id="mass-select" type="checkbox" name="mass-select" value="yes">
                    </th>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Parent</th>
                    <th>Parent Id</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="table-body">
                @foreach($categories as $category)
                    <tr>
                        <td>
                            <input class="entity-select" type="checkbox" name="categories[{{ $category->id }}][id]" value="{{ $category->id }}">
                        </td>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->parent }}</td>
                        <td>{{ $category->parent_id }}</td>
                        <td>
                            @if($category->status)
                                Enabled
                            @else
                                Disabled
                            @endif
                        </td>
                        <td>{{ $category->created_at }}</td>
                        <td>{{ $category->updated_at }}</td>
                        <td>
                            <a href="{{ url('/admin/category/edit', ['id' => $category->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if($categories->count() > 20)
                {{ $categories->appends(Request::except('page'))->links() }}
            @endif
        </form>
    </div>
</div>
@endsection