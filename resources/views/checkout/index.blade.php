@extends('layouts.store')

@section('title')
Checkout
@endsection

@section('content')
<div class="section">
    <div class="container">
        @include('checkout._partials.checkout_progress', ['step' => 2])
        <div class="box">
            <div id="checkout-address">
                <p>{{ $user->fullname }}</p>
                <p>{{ $user->email }}</p>
                @if($user->phone)
                    <p>{{ $user->phone }}</p>
                @endif
                @if(!$user->canMakeOrder())
                    <div class="has-text-right">
                        <h4>Please fill in missing shipping address information</h4>
                        <a class="checkout-edit" href="{{ url('/user/edit') }}">Edit my account information</a>
                    </div>
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
                @include('checkout._partials.cart_items', ['cart' => $cart])
                <div class="has-text-right">
                    <a class="button button-action action-add" href="{{ url('/checkout/delivery') }}">
                        <i class="fa fa-arrow-right" aria-hidden="true">&nbsp;</i>
                        Continue
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection