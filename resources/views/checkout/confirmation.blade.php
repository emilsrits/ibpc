@extends('layouts.master')

@section('title')
Checkout Confirmation
@endsection

@section('content')
<div class="section">
    <div class="container">
        @include('partials.checkout.checkout_progress', ['step' => 4])
        <div id="checkout-confirm" class="box">
            <form id="checkout-confirm-form" role="form" method="POST" action="{{ url('/checkout/confirm') }}">
                {{ csrf_field() }}
                <div class="checkout-cart grid-item lg-100 md-100 sm-100">
                    <table class="checkout-cart-items table is-fullwidth">
                        @foreach($cart->items as $item)
                            @if($item['item']['id'])
                            <tr class="checkout-cart-item">
                                <td>{{ $item['item']['title'] }}</td>
                                <td class="has-text-right">@money($cart->getItemTotalPrice($item['item']['id']))</td>
                            </tr>
                            @endif
                        @endforeach
                        <tr class="checkout-cart-item">
                            @if(Session::has('delivery'))
                                @if($cart->delivery)
                                    <td>{{ 'Delivery to ' . $cart->delivery_code }}</td>
                                    <td class="has-text-right">@money($cart->delivery_cost)</td>
                                @endif
                            @endif
                        </tr>
                        @if($cart->getVat())
                            <tr class="checkout-cart-item">
                                <td>VAT</td>
                                <td class="has-text-right">@money($cart->vat)</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="has-text-right has-text-weight-bold" colspan="2">Total incl. VAT: @money($cart->getTotalPriceWithVat())</td>
                        </tr>
                    </table>
                    <div class="has-text-right">
                        <button id="order-submit" class="button is-link button-action" type="submit" title="Checkout">Order</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection