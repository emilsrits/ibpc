@extends('layouts.master')

@section('title')
    Create Product
@endsection

@section('content')
    <div class="lg-100 md-100 sm-100">
        <div class="product-create">
            <h3>New Product</h3>
            <form id="create-products-form" role="form" method="POST" action="{{ url('/admin/products/create/save') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="manage-btn-group">
                    <div class="btn-manage-back">
                        <a href="{{ url('/admin') }}">Back</a>
                    </div>
                    <button class="product-create-save" type="submit" name="submit">Save</button>
                </div>
                <table class="product-create-table">
                    <tbody>
                        <tr class="create-attribute product-create-category">
                            <td><label for="category">Category: </label></td>
                            <td>
                                <select name="category" required>
                                    <option value="0"></option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr class="create-attribute product-create-image">
                            <td><label for="image">Image: </label></td>
                            <td><input type="file" name="image" accept="image/gif, image/jpeg, image/png"></td>
                        </tr>
                        <tr class="create-attribute product-create-code">
                            <td><label for="code">Code: </label></td>
                            <td><input type="text" name="code" required></td>
                        </tr>
                        <tr class="create-attribute product-create-title">
                            <td><label for="title">Title: </label></td>
                            <td><input type="text" name="title" required></td>
                        </tr>
                        <tr class="create-attribute product-create-description">
                            <td><label for="description">Description: </label></td>
                            <td><textarea name="description" cols="20" rows="10"></textarea></td>
                        </tr>
                        <tr class="create-attribute product-create-price">
                            <td><label for="price">Price: </label></td>
                            <td><input type="text" name="price" required pattern="^[0-9]*\.[0-9]{2}|[0-9]*$"></td>
                        </tr>
                        <tr class="create-attribute product-create-stock">
                            <td><label for="stock">Stock: </label></td>
                            <td><input type="number" min="0" max="1000" name="stock" required></td>
                        </tr>
                        <tr class="create-attribute product-create-status">
                            <td><label for="status">Status: </label></td>
                            <td>
                                <select name="status" required>
                                    <option value="0">Disabled</option>
                                    <option value="1">Enabled</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection