@extends('layouts.store')

@section('title')
Order Successful
@endsection

@section('content')
<div class="section">
    <div class="container">
        @include('pages.checkout._partials.checkout_progress', ['step' => 5])
        <div id="checkout-success" class="box">
            <div class="order-success-message">
                <h4>Order created!</h4>
                <ul>
                    <li>Email with an invoice attachment will be sent to you shortly</li>
                    <li>You can check your order progress under <a href="{{ url('/user/account') }}">My Orders</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection