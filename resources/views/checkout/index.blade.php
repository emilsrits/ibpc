@extends('layouts.master')

@section('title')
Checkout
@endsection

@section('content')
<div class="section">
    <div class="container">
        @include('partials.checkout.checkout_progress', ['step' => 2])
        <div class="box">
            <div id="checkout-address">
                <p>{{ $user->fullname }}</p>
                <p>{{ $user->email }}</p>
                @if($user->phone)
                    <p>{{ $user->phone }}</p>
                @endif
                @if(!$user->canMakeOrder())
                    <h4>Please fill in missing shipping address information</h4>
                    <a href="{{ url('/user/edit') }}">Edit my account information</a>
                @else
                    <h4>Shipping Address</h4>
                    <p>{{ countryFromCode($user->country) }}</p>
                    <p>{{ $user->city }}</p>
                    <p>{{ $user->address }}</p>
                    <p>{{ $user->postcode }}</p>
                    <div class="has-text-right">
                        <a class="checkout-edit" href="{{ url('/user/edit') }}">Edit my account information</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="box">
            <div id="checkout-cart">
                @include('partials.checkout.cart_items', ['cart' => $cart])
                <div class="has-text-right">
                    <a class="button is-link button-action" href="{{ url('/checkout/delivery') }}">
                        <i class="fa fa-arrow-right" aria-hidden="true">&nbsp;</i>
                        Continue
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection