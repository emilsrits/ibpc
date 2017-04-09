@extends('layouts.master')

@section('title')
    IBPC
@endsection

@section('content')
    <div class="grid clearfix">
        <div class="grid-item lg-100 md-100 sm-100">
            {{ $products->appends(Request::except('page'))->links() }}
            <div class="grid-uniform clearfix">
                @foreach($products as $product)
                    <div class="grid-item lg-25 md-33 sm-50">
                        <div class="product-grid">
                            <div class="product-image">
                                <a href="{{ url('/product', ['id' => $product->id]) }}">
                                    <img class="img-responsive" src="{{ $product->image_path }}" alt="{{ $product->code }}">
                                </a>
                            </div>
                            <p class="product-link text-center">
                                <a href="{{ url('/product', ['id' => $product->id]) }}">{{ $product->title }}</a>
                            </p>
                            <p class="product-price-old"><s>{{ $product->old_price }}</s></p>
                            <p class="product-price">{{ $product->current_price }}</p>
                            <a class="btn btn-cart-add" href="{{ url('/cart/add', ['id' => $product->id]) }}" role="button">ADD TO CART</a>
                        </div>
                    </div>
                @endforeach
            </div> <!-- grid-uniform -->
            @if($products->count() >= 8)
                {{ $products->appends(Request::except('page'))->links() }}
            @endif
        </div> <!-- grid-item lg-eight-tenths -->
    </div> <!-- grid -->
@endsection 