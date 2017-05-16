@extends('layouts.master')

@section('title')
Checkout Delivery
@endsection

@section('content')
<div class="checkout-delivery lg-100 md-100 sm-100">
    @include('partials.widgets.checkout_progress', ['page' => 3])
    <div class="center-block lg-60 md-60 sm-100">
        <form id="checkout-delivery-form" role="form" method="POST" action="{{ url('/checkout/confirmation') }}">
            {{ csrf_field() }}
            <div class="checkout-delivery-storage grid-item lg-50 md-50 sm-100">
                <h4>Receive at storage</h4>
                <img src="{{ asset('/images/delivery-storage.png') }}" alt="storage">
                <p>0.00 €</p>
                <input type="checkbox" name="delivery" value="storage" {{ Session::get('delivery') === 'storage' ? 'checked' : '' }}>
            </div>
            <div class="checkout-delivery-address grid-item lg-50 md-50 sm-100">
                <h4>Receive at your address</h4>
                <img src="{{ asset('/images/delivery-address.png') }}" alt="address">
                <p>2.99 €</p>
                <input type="checkbox" name="delivery" value="address" {{ Session::get('delivery') === 'address' ? 'checked' : '' }}>
            </div>
            <button class="btn btn-checkout" type="submit" title="Checkout">Continue</button>
        </form>
    </div>
</div>
@endsection