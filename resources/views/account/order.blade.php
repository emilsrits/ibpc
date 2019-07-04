@extends('layouts.master')

@section('title')
Order
@endsection

@section('content')
<div class="grid rlg-100 md-100 sm-100">
    <div id="user-account" class="cf">
        @include('partials.account.navigation')
        <div id="account-panel" class="grid-item lg-10 md-100 sm-100">
            <h4>Order #{{ $order->id }}</h4>
            <table class="order-sumup">
                <tr>
                    <td>Order Date:</td>
                    <td>{{ $order->created }}</td>
                </tr>
                <tr>
                    <td>Order Status:</td>
                    <td>{{ $order->status }}</td>
                </tr>
                <tr>
                    <td>Items Ordered:</td>
                    <td>{{ count($order->products) }}</td>
                </tr>
                @if($order->delivery_cost)
                    <tr>
                        <td>Delivery cost:</td>
                        <td>{{ $order->getPriceCurrency('delivery') }}</td>
                    </tr>
                @endif
                <tr>
                    <td>Total cost incl. VAT:</td>
                    <td>{{ $order->getPriceCurrency('price') }}</td>
                </tr>
            </table>
            <div class="table-items of-x">
                <table class="user-orders order-view">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Code</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->products as $product)
                        <tr>
                            <td><img class="img-responsive" src="{{ $product->image }}" alt="{{ $product->code }}"></td>
                            <td class="no-wrap">{{ $product->title }}</td>
                            <td class="no-wrap">{{ $product->code }}</td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td class="no-wrap">{{ $product->getOrderPriceById($order->id, $product->id, 1) }}</td>
                            <td class="no-wrap">{{ $product->getOrderTotalPriceById($order->id, $product->id, 1) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection