@extends('layouts.master')

@section('title')
IBPC
@endsection

@section('content')
<div class="grid cf">
    <div class="grid-item lg-100 md-100 sm-100">
        {{ $products->appends(Request::except('page'))->links() }}
        <div class="grid-uniform cf">
            @foreach($products as $product)
                <div class="grid-item lg-25 md-33 sm-50">
                    <div class="product-grid">
                        <div class="product-media">
                            <a href="{{ url('/p', ['code' => $product->code]) }}">
                                <img class="img-responsive" src="{{ $product->image }}" alt="{{ $product->code }}">
                            </a>
                        </div>
                        <p class="product-link text-center">
                            <a href="{{ url('/p', ['code' => $product->code]) }}">{{ $product->title }}</a>
                        </p>
                        @if($product->stock > 5)
                            <div class="stock-status in-stock">
                                <div class="stock-text">In Stock</div>
                            </div>
                        @else
                            <div class="stock-status low-stock">
                                <div class="stock-text">{{ $product->stock }} In Stock</div>
                            </div>
                        @endif
                        <div class="product-price">
                            @if($product->old_price)
                                <div class="product-price-old">@money($product->old_price)</div>
                            @endif
                            <div class="product-price-current">@money($product->price)</div>
                        </div>
                        <div class="product-add-to-cart cf">
                            <button class="btn product-quick-add" type="button" value="{{ $product->id }}">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if($products->count() >= 8)
            {{ $products->appends(Request::except('page'))->links() }}
        @endif
    </div>
</div>
@endsection 