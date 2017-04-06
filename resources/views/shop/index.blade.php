@extends('layouts.master')

@section('title')
    IBPC
@endsection

@section('content')
    <div class="grid clearfix">
        @include('partials.sidebar')
        <div class="grid-item large-85">
            <div class="grid-uniform">
                @foreach($products as $product)
                    <div class="grid-item large-25 medium-33 small-50">
                        <div class="product-grid">
                            <div class="product-image">
                                <a href="{{ url('/product', ['id' => $product->id]) }}">
                                    <img src="{{ $product->image_path }}" alt="{{ $product->code }}" class="img-responsive">
                                </a>
                            </div>
                            <p class="product-link text-center">
                                <a href="{{ url('/product', ['id' => $product->id]) }}">{{ $product->title }}</a>
                            </p>
                            <p class="product-price-old"><s>{{ $product->old_price }}</s></p>
                            <p class="product-price">{{ $product->current_price }}</p>
                            <a href="{{ url('/cart/add', ['id' => $product->id]) }}" class="btn btn-cart-add" role="button">ADD TO CART</a>
                        </div>
                    </div>
                @endforeach
            </div> <!-- grid-uniform -->
        </div> <!-- grid-item large-eight-tenths -->
    </div> <!-- grid -->
@endsection 