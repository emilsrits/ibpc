@extends('layouts.master')

@section('title')
{{ $product->code }}
@endsection

@section('content')
<div class="grid cf">
    <div class="lg-100">
        <div id="product-view" class="cf">
            <div id="product-details" class="lg-65 md-65 sm-100">
                <div id="product-media-gallery">
                    <div class="product-media-item">
                        <img class="img-responsive" src="{{ $product->image }}" alt="{{ $product->code }}">
                    </div>
                    @if(count($product->media) > 1)
                        <div class="product-media-thumbs">
                            @foreach($product->getImages(5, 1) as $image)
                                <div class="product-media-item">
                                    <img src="{{ $image->path }}" alt="{{ $image->id }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <table class="product-specifications">
                    <tbody>
                    @if($product->properties->first())
                        @foreach($product->groupPropertiesBySpecification() as $specification => $properties)
                            <tr class="category">
                                <td>{{ $specification }}</td>
                            </tr>
                            @foreach($properties as $key => $property)
                                <tr class="specification">
                                    <td class="property">{{ $property['name'] }}</td>
                                    <td class="value">{{ $property['value'] }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                    @if($product->description)
                        <tr class="category">
                            <td>Additional Information</td>
                        </tr>
                        <tr class="specification">
                            <td class="property">Description</td>
                            <td class="value">{{ $product->description }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div id="product-buy" class="lg-35 md-35 sm-100">
                <h2>{{ $product->title }}</h2>
                <p class="product-code">{{ $product->code }}</p>
                @if($product->old_price)
                    <p class="product-price-old"><s>@money($product->old_price)</s></p>
                @endif
                <p class="product-price-current">@money($product->price)</p>
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