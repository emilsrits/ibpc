@extends('layouts.admin')

@section('title')
Catalog
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="product-catalog">
        <h3>Catalog</h3>
        <div class="manage-btn-group">
            <div class="btn-manage-back">
                <a href="{{ url('/admin') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
            </div>
            <div class="btn-manage-add">
                <a href="{{ url('/admin/product/create') }}">Add Product</a>
            </div>
        </div>
        <form id="catalog-form" role="form" method="POST" action="{{ url('/admin/catalog') }}">
            {{ csrf_field() }}
            <div class="catalog-action">
                <select id="mass-action" name="mass-action">
                    <option value="0"></option>
                    <option value="1">Enable</option>
                    <option value="2">Disable</option>
                    <option value="3">Delete</option>
                </select>
                <button id="mass-action-run" type="submit" name="submit"><i class="fa fa-play" aria-hidden="true"></i></button>
                <button id="filters-clear" type="button" name="clear"><i class="fa fa-refresh" aria-hidden="true"></i> Clear Filters</button>
            </div>
            {{ $products->appends(Request::except('page'))->links() }}
            <table id="catalog-table">
                <thead class="table-head">
                <tr>
                    <th class="col-xs">
                        <input id="mass-select" type="checkbox" name="mass-select" value="yes">
                    </th>
                    <th class="col-sm">Id</th>
                    <th>Title</th>
                    <th>Code</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th id="sort-created" class="col-md">
                        <button type="submit" name="created" value="{{ $request['created'] === 'desc' ? 'asc' : 'desc' }}">
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
                        <button type="submit" name="updated" value="{{ $request['updated'] === 'desc' ? 'asc' : 'desc' }}">
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
                    <td><input type="number" name="id" min="0" value="{{ $request['id'] ? $request['id'] : '' }}"></td>
                    <td><input type="text" name="title" value="{{ $request['title'] ? $request['title'] : '' }}"></td>
                    <td><input type="text" name="code" value="{{ $request['code'] ? $request['code'] : '' }}"></td>
                    <td colspan="2"></td>
                    <td>
                        <select name="status">
                            <option value="0"></option>
                            <option value="enabled" {{ $request['status'] === 'enabled' ? 'selected' : '' }}>
                                Enabled</option>
                            <option value="disabled" {{ $request['status'] === 'disabled' ? 'selected' : '' }}>
                                Disabled</option>
                        </select>
                    </td>
                    <td>
                        <select name="category">
                            <option value="0"></option>
                            @foreach($categories as $category)
                                @if(!$category->parent)
                                    <option value="{{ $category->id }}"
                                            {{ $request['category'] == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" name="createdAt" value="{{ $request['createdAt'] ? $request['createdAt'] : '' }}"></td>
                    <td><input type="text" name="updatedAt" value="{{ $request['updatedAt'] ? $request['updatedAt'] : '' }}"></td>
                    <td></td>
                </tr>
                <tbody class="table-body">
                @foreach($products as $product)
                    <tr>
                        <td>
                            <input class="entity-select" type="checkbox" name="catalog[{{ $product->id }}][id]" value="{{ $product->id }}">
                        </td>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->code }}</td>
                        <td class="no-wrap">{{ $product->getPriceCurrency('current') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->status ? 'Enabled' : 'Disabled' }}</td>
                        <td>{{ $product->categories->first()->title }}</td>
                        <td class="no-wrap">{{ $product->created_at }}</td>
                        <td class="no-wrap">{{ $product->updated_at }}</td>
                        <td>
                            <a href="{{ url('/admin/product/edit', ['id' => $product->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if($products->count() > 20)
                {{ $products->appends(Request::except('page'))->links() }}
            @endif
        </form>
    </div>
</div>
@endsection