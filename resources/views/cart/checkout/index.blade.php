@extends('layouts.master')

@section('title')
Checkout
@endsection

@section('content')
<div class="lg-100 md-100 sm-100">
    @include('partials.widgets.checkout_progress', ['page' => 2])
    <div class="checkout-address grid-item lg-40 md-100 sm-100">
        <p>{{ $user->fullname }}</p>
        <p>{{ $user->email }}</p>
        @if($user->phone)
            <p>{{ $user->phone }}</p>
        @endif
        @if(!$user->country || !$user->city || !$user->address || !$user->postcode)
            <h4>Please fill in missing shipping address information</h4>
            <a href="{{ url('/user/profile') }}">Edit my account information</a>
        @else
            <h4>Shipping Address</h4>
            <p>{{ $user->country }}</p>
            <p>{{ $user->city }}</p>
            <p>{{ $user->address }}</p>
            <p>{{ $user->postcode }}</p>
            <a class="checkout-edit" href="{{ url('/user/profile') }}">Edit my account information</a>
        @endif
    </div>
    <div class="checkout-cart grid-item lg-60 md-100 sm-100">
        <table class="checkout-cart-items">
            @foreach($cart->items as $item)
                @if($item['item']['id'])
                <tr class="checkout-cart-item">
                    <td>{{ $item['item']['title'] }}</td>
                    <td>{{ $cart->getItemTotalPrice($item['item']['id'], 1) }}</td>
                </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="2">Total incl. VAT: {{ $cart->getPriceCurrency('total') }}</td>
            </tr>
        </table>
        <button class="btn btn-checkout" type="button" title="Checkout" onclick="window.location='{{ url('/checkout/delivery') }}'">Continue</button>
    </div>
</div>
@endsection