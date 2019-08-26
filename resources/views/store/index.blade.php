@extends('layouts.store')

@section('title')
IBPC
@endsection

@section('content')
<div class="section">
    <div class="container">
        <div class="columns is-multiline">
            <div class="column is-12-mobile is-3-tablet is-2-widescreen">
                @include('store._partials.categories')
            </div>

            <div class="column is-12-mobile is-9-tablet is-10-widescreen">
                {{ $products->appends(Request::except('page'))->links() }}
                <div class="columns is-multiline">
                    @foreach($products as $product)
                        <div class="column is-12-mobile is-4-tablet is-3-desktop">
                            <catalog-product
                                :product="{{ json_encode($product) }}"
                                :product-prices="{
                                    current: '{{ money($product->price) }}',
                                    old: '{{ $product->old_price ? money($product->old_price) : null }}'
                                }"
                                :media="'{{ $product->image }}'"
                                :route="'{{ url('/p', ['code' => $product->code]) }}'"
                            >
                            </catalog-product>
                        </div>
                    @endforeach
                </div>
                @if($products->count() >= 8)
                    {{ $products->appends(Request::except('page'))->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 