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
                @csrf
                @include('partials.checkout.cart_items', ['cart' => $cart])
                <div class="has-text-right">
                    <button id="order-submit" class="button is-link button-action" type="submit" title="Checkout">Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection