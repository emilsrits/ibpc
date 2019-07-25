@extends('layouts.admin')

@section('title')
Edit Product
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="product-edit">
        <h3>#{{ $product->id . ' ' . $product->title }}</h3>
        <form id="edit-products-form" role="form" method="POST" action="{{ url('/admin/product/update', ['id' => $product->id]) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="manage-btn-group">
                <div class="btn-manage-back">
                    <a href="{{ url('/admin/catalog') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
                </div>
                <button id="entity-delete" type="submit" name="submit" value="delete" formnovalidate>Delete</button>
                <button class="entity-save" type="submit" name="submit" value="save">Save</button>
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
                            <td><span>{{ $product->category_title }}</span></td>
                        </tr>
                        <tr class="entity-attribute product-media">
                            <td><label for="media">Media</label></td>
                            <td>
                                <div id="product-media-preview">
                                    @if($product->media->first())
                                        @foreach($product->media as $media)
                                            <div class="media-item">
                                                <img class="img-responsive" src="{{ $media->path }}" alt="{{ $product->code }}">
                                                <button class="btn btn-label product-media-remove" data-id="{{ $media->id }}" data-product_id="{{ $product->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <input id="product-media-upload" type="file" name="media[]" accept="image/gif, image/jpeg, image/png" multiple="multiple">
                            </td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="code">Code</label></td>
                            <td>
                                <input type="text" name="code" required value="{{ old('code') ? old('code') : $product->code }}">
                            </td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="title">Title</label></td>
                            <td>
                                <input type="text" name="title" required value="{{ old('title') ? old('title') : $product->title }}">
                            </td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="description">Description</label></td>
                            <td>
                                <textarea name="description" cols="20" rows="10">{{ old('description') ? old('description') : $product->description }}</textarea>
                            </td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="price">Price</label></td>
                            <td>
                                <input type="text" name="price" required pattern="^[0-9]*\.[0-9]{2}|[0-9]*$" 
                                    value="{{ old('price') ? old('price') : formatMoneyByDecimal($product->price) }}">
                            </td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="stock">Stock</label></td>
                            <td>
                                <input type="number" min="0" max="1000" name="stock" required 
                                    value="{{ old('stock') ? old('stock') : $product->stock }}">
                            </td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="status">Status</label></td>
                            <td>
                                <select name="status" required>
                                    <option value="0" {{ old('status') == 0 || $product->status == 0 ? 'selected' : '' }}>Disabled</option>
                                    <option value="1" {{ old('status') == 1 || $product->status == 1 ? 'selected' : '' }}>Enabled</option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if($category)
                @if($category->first()->specifications->first())
                    <div class="product-content-section">
                        <div class="content-section-toggle">
                            <strong>Specifications<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                        </div>
                        <div class="content-container">
                            <table class="product-table">
                                <tbody>
                                @foreach($category->first()->specifications as $key => $specification)
                                    @if($specification->properties->first())
                                        <tr class="entity-specification">
                                            <td colspan="2">{{ $specification->name }}</td>
                                        </tr>
                                    @endif
                                    @foreach($specification->properties as $property)
                                        <tr class="entity-attribute">
                                            <td><label for="{{ 'attr[' . $specification->id . '][' . $property->id . ']' }}">{{ $property->name }}</label></td>
                                            <td>
                                                <input type="text" name="{{ 'attr[' . $specification->id . '][' . $property->id . ']' }}"
                                                    value="{{ is_array(old('attr.'.$specification->id)) 
                                                        ? old('attr.'.$specification->id.'.'.$property->id.'') 
                                                        : $product->getPropertyById($property->id) }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endif
        </form>
    </div>
</div>
@endsection