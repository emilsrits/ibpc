@extends('layouts.master')

@section('title')
    Create Product
@endsection

@section('content')
    <div class="lg-100 md-100 sm-100">
        <div class="product-create">
            <form id="create-products-form" role="form" method="POST" action="{{ url('/admin/products/create/save') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="manage-btn-group">
                    <div class="btn-manage-back">
                        <a href="{{ url('/admin') }}">Back</a>
                    </div>
                    <button class="product-create-save" type="submit" name="submit">Save</button>
                </div>
                <div class="create-attribute product-create-category">
                    <label for="category">Category: </label>
                    <select name="category">
                        <option value="0"></option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="create-attribute product-create-image">
                    <label for="image">Image: </label>
                    <input type="file" name="image">
                </div>
                <div class="create-attribute product-create-code">
                    <label for="code">Code: </label>
                    <input type="text" name="code" required>
                </div>
                <div class="create-attribute product-create-title">
                    <label for="title">Title: </label>
                    <input type="text" name="title" required>
                </div>
                <div class="create-attribute product-create-description">
                    <label for="description">Description: </label>
                    <textarea name="description" cols="30" rows="10"></textarea>
                </div>
                <div class="create-attribute product-create-price">
                    <label for="price">Price: </label>
                    <input type="text" name="price" required pattern="^[0-9]*\.[0-9]{2}|[0-9]*$">
                </div>
                <div class="create-attribute product-create-stock">
                    <label for="stock">Stock: </label>
                    <input type="number" min="0" max="1000" name="stock" required>
                </div>
                <div class="create-attribute product-create-status">
                    <label for="status">Status: </label>
                    <select name="status" required>
                        <option value="0">Disabled</option>
                        <option value="1">Enabled</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
@endsection