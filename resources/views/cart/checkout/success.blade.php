@extends('layouts.master')

@section('title')
Order Successful
@endsection

@section('content')
<div class="checkout-success lg-100 md-100 sm-100">
    @include('partials.widgets.checkout_progress', ['page' => 5])
    <div class="order-success-message">
        <h4>Order created!</h4>
        <ul>
            <li>Email with an invoice attachment will be sent to you shortly</li>
            <li>You can check your order progress under <a href="{{ url('/user/account') }}">My Orders</a></li>
        </ul>
    </div>
</div>
@endsection