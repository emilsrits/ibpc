@extends('layouts.master')

@section('title')
{{ $product->code }}
@endsection

@section('content')
<div class="grid cf">
    <div class="lg-100">
        <div id="product-view" class="cf">
            <div id="product-details" class="lg-65 md-65 sm-100">
                @if($product->media->first())
                    <div id="product-media-gallery">
                        @foreach($product->getImages(5) as $image)
                            <div class="product-media-item">
                                <img src="{{ $image->path }}" alt="{{ $image->id }}">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div id="product-media">
                        <img class="img-responsive" src="{{ $product->image }}" alt="{{ $product->code }}">
                    </div>
                @endif
                <table class="product-specifications">
                    <tbody>
                    @if($specifications)
                        @foreach($specifications->specifications as $category => $specifications)
                            @if($specifications->attributes->first())
                                <tr class="category">
                                    @foreach($product->attributes as $attribute)
                                        @if($attribute->specification->id === $specifications->id)
                                            <td>{{ $specifications->name }}</td>
                                            @break
                                        @endif
                                    @endforeach
                                </tr>
                                @foreach($specifications->attributes as $attribute => $value)
                                    @if($product->getAttributeById($value->id))
                                        <tr class="specification">
                                            <td class="attribute">{{ $value->name }}</td>
                                            <td class="value">{{ $product->getAttributeById($value->id) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                    @if($product->description)
                        <tr class="category">
                            <td>Additional Information</td>
                        </tr>
                        <tr class="specification">
                            <td class="attribute">Description</td>
                            <td class="value">{{ $product->description }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div id="product-buy" class="lg-35 md-35 sm-100">
                <h2>{{ $product->title }}</h2>
                <p class="product-code">{{ $product->code }}</p>
                <p class="product-price-old"><s>{{ $product->getPriceCurrency('old') }}</s></p>
                <p class="product-price-current">{{ $product->getPriceCurrency('current') }}</p>
                @if($product->status)
                    @if($product->stock > 5)
                        <div class="stock-status in-stock">
                            <div class="stock-icon"><i class="fa fa-circle" aria-hidden="true"></i></div>
                            <div class="stock-text">In Stock</div>
                        </div>
                    @else
                        <div class="stock-status low-stock">
                            <div class="stock-icon"><i class="fa fa-circle" aria-hidden="true"></i></div>
                            <div class="stock-text">Low Stock</div>
                        </div>
                    @endif
                @else
                    <div class="stock-status out-of-stock">
                        <div class="stock-icon"><i class="fa fa-circle" aria-hidden="true"></i></div>
                        <div class="stock-text">Out of Stock</div>
                    </div>
                @endif
                <div class="form-container">
                    <form id="add-to-cart-form" class="cf" role="form" method="POST" action="{{ url('/cart/add', ['id' => $product->id]) }}">
                        {{ csrf_field() }}
                        <label for="qty">Qty: </label>
                        <input id="qty" type="number" name="qty" min="1" max="1000" value="1" title="qty" pattern="[0-9]*">
                        <button class="btn btn-cart-add" type="submit" name="submit">Add To Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection