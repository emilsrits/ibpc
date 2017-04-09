@extends('layouts.master')

@section('title')
    {{ $product->code }}
@endsection

@section('content')
    <div class="grid clearfix">
        <div class="lg-100">
            <div id="product-view" class="clearfix">
                <div id="product-details" class="lg-65 md-65 sm-100">
                    <div class="product-image">
                        <img class="img-responsive" src="{{ $product->image_path }}" alt="{{ $product->code }}">
                    </div>
                    <table class="product-specifications">
                        <tbody>
                        @foreach($specifications as $name => $attributes)
                            <tr class="category">
                                <td>{{ $name }}</td>
                            </tr>
                            @foreach($attributes as $attribute => $value)
                                <tr class="specification">
                                    <td class="attribute">{{ $attribute }}</td>
                                    <td class="value">{{ $value }}</td>
                                </tr>
                            @endforeach
                        @endforeach
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
                    <p class="product-price-old"><s>{{ $product->old_price }}</s></p>
                    <p class="product-price">{{ $product->current_price }}</p>
                    <div class="form-container">
                        <form id="add-to-cart-form" class="clearfix" role="form" method="POST" action="{{ url('/cart/checkout') }}">
                            {{ csrf_field() }}
                            <label for="qty">Qty: </label>
                            <input id="qty" class="product-qty" type="text" name="qty" maxlength="3" value="1" title="qty" pattern="[0-9]*">
                            <a class="btn btn-cart-add" href="{{ url('/cart/add', ['id' => $product->id]) }}" role="button">ADD TO CART</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection