@extends('layouts.admin')

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
        <form id="categories-form" role="form" method="POST" action="{{ url('/admin/categories') }}">
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
                    <th class="col-xs">
                        <input id="mass-select" type="checkbox" name="mass-select" value="yes">
                    </th>
                    <th class="col-sm">Id</th>
                    <th>Title</th>
                    <th>Top Category</th>
                    <th>Parent ID</th>
                    <th>Status</th>
                    <th class="col-md">Created at</th>
                    <th class="col-md">Updated at</th>
                    <th class="col-xs"></th>
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
                        <td>
                            @if($category->parent)
                                Yes
                            @else
                                No
                            @endif
                        </td>
                        <td>{{ $category->parent_id }}</td>
                        <td>
                            @if($category->status)
                                Enabled
                            @else
                                Disabled
                            @endif
                        </td>
                        <td class="no-wrap">{{ $category->created_at }}</td>
                        <td class="no-wrap">{{ $category->updated_at }}</td>
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