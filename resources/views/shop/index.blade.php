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
                            <div class="product-image">
                                <a href="{{ url('/product', ['id' => $product->id, 'code' => $product->code]) }}">
                                    <img class="img-responsive" src="{{ $product->image_path }}" alt="{{ $product->code }}">
                                </a>
                            </div>
                            <p class="product-link text-center">
                                <a href="{{ url('/product', ['id' => $product->id, 'code' => $product->code]) }}">{{ $product->title }}</a>
                            </p>
                            @if($product->stock > 5)
                                <div class="stock-status in-stock">
                                    <div class="stock-text">In Stock</div>
                                </div>
                            @else
                                <div class="stock-status low-stock">
                                    <div class="stock-text">Low Stock</div>
                                </div>
                            @endif
                            <div class="product-price">
                                @if($product->old_price)
                                    <div class="product-price-old">{{ $product->old_price }}</div>
                                @endif
                                <div class="product-price-current">{{ $product->current_price }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div> <!-- grid-uniform -->
            @if($products->count() >= 8)
                {{ $products->appends(Request::except('page'))->links() }}
            @endif
        </div>
    </div> <!-- grid -->
@endsection 