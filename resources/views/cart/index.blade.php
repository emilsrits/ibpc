@extends('layouts.master')

@section('title')
Shopping Cart
@endsection

@section('content')
@if(Session::has('cart'))
<div class="lg-100 md-100 sm-100">
    @include('partials.widgets.checkout_progress', ['page' => 1])
    <form id="shopping-cart-form" role="form" method="POST" action="{{ url('/cart/update') }}">
        {{ csrf_field() }}
        <fieldset>
            <table id="shopping-cart-table">
                <thead class="table-head">
                    <tr>
                        <th></th>
                        <th class="hidden-xs">Product</th>
                        <th><span class="visible-xs">Product</span></th>
                        <th>Quantity</th>
                        <th class="hidden-xs">Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    @foreach($products as $product)
                        @if($product['item']['id'])
                        <tr>
                            <td><a href="{{ url('/cart/remove', ['id' => $product['item']['id']]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                            <td class="cart-item-image hidden-xs">
                                <a href="{{ url('/store', ['code' => $product['item']['code']]) }}">
                                    <img src="{{ asset($product['item']['image']) }}" alt="{{ $product['item']['code'] }}">
                                </a>
                            </td>
                            <td>
                                <a href="{{ url('/store', ['code' => $product['item']['code']]) }}">
                                    {{ $product['item']['title'] }}
                                </a>
                            </td>
                            <td>
                                <input id="qty" type="number" name="cart[{{ $product['item']['id'] }}][qty]" min="1" max="1000"
                                       value="{{ $product['qty'] }}" title="qty" pattern="[0-9]*">
                            </td>
                            <td class="cart-item-price hidden-xs no-wrap">
                                {{ $cart->getItemPrice($product['item']['id'], 1) }}
                            </td>
                            <td class="no-wrap">
                                {{ $cart->getItemTotalPrice($product['item']['id'], 1) }}
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </fieldset>
        <div class="cart-update cf">
            <button class="btn btn-cart-update" type="submit" name="submit">Update Cart</button>
        </div>
        <div class="cart-checkout cf">
            <div class="cart-total">
                <strong>Total: {{ $cart->getPriceCurrency('total') }}</strong>
            </div>
            <button class="btn btn-checkout" type="button" title="Checkout" onclick="window.location='{{ url('/checkout') }}'">Checkout</button>
        </div>
    </form>
</div>
@else
<div class="lg-100">
    <div class="cart-empty">
        <h2>Cart is empty</h2>
        <a class="btn" href="{{ url('/') }}">Back To Shop</a>
    </div>
</div>
@endif
@endsection