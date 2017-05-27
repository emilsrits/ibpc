@extends('layouts.master')

@section('title')
Checkout Confirmation
@endsection

@section('content')
<div class="checkout-confirm lg-100 md-100 sm-100">
    @include('partials.widgets.checkout_progress', ['page' => 4])
    <form id="checkout-confirm-form" role="form" method="POST" action="{{ url('/checkout/confirm') }}">
        {{ csrf_field() }}
        <div class="checkout-cart grid-item lg-100 md-100 sm-100">
            <table class="checkout-cart-items">
                @foreach($cart->items as $item)
                    @if($item['item']['id'])
                    <tr class="checkout-cart-item">
                        <td>{{ $item['item']['title'] }}</td>
                        <td class="no-wrap">{{ $cart->getItemTotalPrice($item['item']['id'], 1) }}</td>
                    </tr>
                    @endif
                @endforeach
                <tr class="checkout-cart-item">
                    @if(Session::has('delivery'))
                        @if($cart->delivery)
                            <td>{{ 'Delivery to ' . $cart->delivery['code'] }}</td>
                            <td>{{ $cart->getPriceCurrency('delivery') }}</td>
                        @endif
                    @endif
                </tr>
                <tr>
                    <td colspan="2">Total incl. VAT: {{ $cart->getPriceCurrency('with_delivery') }}</td>
                </tr>
            </table>
            <button id="order-submit" class="btn btn-checkout" type="submit" title="Checkout">Order</button>
        </div>
    </form>
</div>
@endsection