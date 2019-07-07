@extends('layouts.admin')

@section('title')
Create Product
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="product-create">
        <h3>New Product</h3>
        <form id="create-products-form" role="form" method="POST" action="{{ url('/admin/product/create/save') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="manage-btn-group">
                <div class="btn-manage-back">
                    <a href="{{ url('/admin/catalog') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
                </div>
                <button class="entity-save" type="submit" name="submit">Save</button>
            </div>
            <div class="product-content-section">
                <div class="content-section-toggle">
                    <strong>General<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                </div>
                <div class="content-container">
                    <table class="product-table">
                        <tbody>
                        <tr class="entity-attribute">
                            <td><label for="category">Category</label></td>
                            <td>
                                <select id="category-select" name="category" required>
                                    <option value="0"></option>
                                    @foreach($categories as $parent)
                                        <option value="{{ $parent->id }}"
                                                {{ $request->old('category') == $parent->id || json_decode($request['category']) == $parent->id
                                                ? 'selected'
                                                : '' }}>
                                            {{ $parent->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr class="entity-attribute product-media">
                            <td><label for="media">Media</label></td>
                            <td>
                                <div id="product-media-preview"></div>
                                <input id="product-media-upload" type="file" name="media[]" accept="image/gif, image/jpeg, image/png" multiple="multiple">
                            </td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="code">Code</label></td>
                            <td><input type="text" name="code" required value="{{ $request->old('code') ? $request->old('code') : '' }}"></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="title">Title</label></td>
                            <td><input type="text" name="title" required value="{{ $request->old('title') ? $request->old('title') : '' }}"></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="description">Description</label></td>
                            <td><textarea name="description" cols="20" rows="10">{{ $request->old('description') ? $request->old('description') : '' }}</textarea></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="price">Price</label></td>
                            <td><input type="text" name="price" required value="{{ $request->old('price') ? $request->old('price') : '' }}" pattern="^[0-9]*\.[0-9]{2}|[0-9]*$"></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="stock">Stock</label></td>
                            <td><input type="number" min="0" max="1000" name="stock" required value="{{ $request->old('stock') ? $request->old('stock') : '' }}"></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="status">Status</label></td>
                            <td>
                                <select name="status" required>
                                    <option value="0" {{ $request->old('status') == 0 ? 'selected' : '' }}>Disabled</option>
                                    <option value="1" {{ $request->old('status') == 1 ? 'selected' : '' }}>Enabled</option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="specifications" class="product-content-section">
                @include('partials.admin.product.specifications')
            </div>
        </form>
    </div>
</div>
@endsection