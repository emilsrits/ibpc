@extends('layouts.master')

@section('title')
    Create Product
@endsection

@section('content')
    <div class="admin-page lg-100 md-100 sm-100">
        <div class="product-create">
            <h3>New Product</h3>
            <form id="create-products-form" role="form" method="POST" action="{{ url('/admin/products/create/save') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="manage-btn-group">
                    <div class="btn-manage-back">
                        <a href="{{ url('/admin/catalog') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
                    </div>
                    <button class="product-create-save" type="submit" name="submit">Save</button>
                </div>
                <div class="product-content-section">
                    <div class="product-content-section-toggle">
                        <strong>General<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                    </div>
                    <div class="product-create-container product-general-attributes">
                        <table class="product-create-table">
                            <tbody>
                            <tr class="create-attribute product-create-category">
                                <td><label for="category">Category</label></td>
                                <td>
                                    <select id="category-select" name="category" required>
                                        <option value="0"></option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    {{ $request->old('category') == $category->id || json_decode($request['category']) == $category->id
                                                    ? 'selected'
                                                    : '' }}>
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr class="create-attribute product-create-image">
                                <td><label for="image">Image</label></td>
                                <td><input type="file" name="image" accept="image/gif, image/jpeg, image/png"></td>
                            </tr>
                            <tr class="create-attribute product-create-code">
                                <td><label for="code">Code</label></td>
                                <td><input type="text" name="code" required value="{{ $request->old('code') ? $request->old('code') : '' }}"></td>
                            </tr>
                            <tr class="create-attribute product-create-title">
                                <td><label for="title">Title</label></td>
                                <td><input type="text" name="title" required value="{{ $request->old('title') ? $request->old('title') : '' }}"></td>
                            </tr>
                            <tr class="create-attribute product-create-description">
                                <td><label for="description">Description</label></td>
                                <td><textarea name="description" cols="20" rows="10">{{ $request->old('description') ? $request->old('description') : '' }}</textarea></td>
                            </tr>
                            <tr class="create-attribute product-create-price">
                                <td><label for="price">Price</label></td>
                                <td><input type="text" name="price" required value="{{ $request->old('price') ? $request->old('price') : '' }}" pattern="^[0-9]*\.[0-9]{2}|[0-9]*$"></td>
                            </tr>
                            <tr class="create-attribute product-create-stock">
                                <td><label for="stock">Stock</label></td>
                                <td><input type="number" min="0" max="1000" name="stock" required value="{{ $request->old('stock') ? $request->old('stock') : '' }}"></td>
                            </tr>
                            <tr class="create-attribute product-create-status">
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
                @if($specifications)
                    @if($specifications->specifications->first())
                        <div class="product-content-section">
                            <div class="product-content-section-toggle">
                                <strong>Specifications<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                            </div>
                            <div class="product-create-container product-specification-attributes">
                                <table class="product-create-table">
                                    @foreach($specifications->specifications as $category => $specifications)
                                        @if($specifications->attributes->first())
                                            <tr class="product-create-specification">
                                                <td colspan="2">{{ $specifications->name }}</td>
                                            </tr>
                                        @endif
                                        @foreach($specifications->attributes as $attribute)
                                            <tr class="create-attribute">
                                                <td><label for="{{ 'attr[' . $specifications->id . '][' . $attribute->id . ']' }}">{{ $attribute->name }}</label></td>
                                                <td><input type="text" name="{{ 'attr[' . $specifications->id . '][' . $attribute->id . ']' }}"></td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @endif
                @endif
            </form>
        </div>
    </div>
@endsection