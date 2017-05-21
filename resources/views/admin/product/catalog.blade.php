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
                    <th class="col-md">Created at</th>
                    <th class="col-md">Updated at</th>
                    <th class="col-xs"></th>
                </tr>
                </thead>
                <tbody class="table-body">
                @foreach($products as $product)
                    <tr>
                        <td>
                            <input class="entity-select" type="checkbox" name="catalog[{{ $product->id }}][id]" value="{{ $product->id }}">
                        </td>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->getPriceCurrency('current') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if($product->status)
                                Enabled
                            @else
                                Disabled
                            @endif
                        </td>
                        <td>{{ $product->created_at }}</td>
                        <td>{{ $product->updated_at }}</td>
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