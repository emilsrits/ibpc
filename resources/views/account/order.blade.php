@extends('layouts.master')

@section('title')
Order
@endsection

@section('content')
    <div class="grid rlg-100 md-100 sm-100">
        <div id="user-account">
            <h4>View Order</h4>
            <div class="grid-uniform lg-100 md-100 sm-100">
                <div id="account-nav">
                    <div class="account-orders grid-item lg-33 md-33 sm-33">
                        <a href="{{ url('/user/account') }}">
                            <i class="fa fa-shopping-basket" aria-hidden="true"></i> My Orders
                        </a>
                    </div>
                    <div class="account-order-history grid-item lg-33 md-33 sm-33">
                        <a href="{{ url('/user/history') }}">
                            <i class="fa fa-history" aria-hidden="true"></i> Order History
                        </a>
                    </div>
                    <div class="account-settings grid-item lg-33 md-33 sm-33">
                        <a href="{{ url('/user/edit') }}">
                            <i class="fa fa-address-card" aria-hidden="true"></i> Update Account
                        </a>
                    </div>
                </div>
            </div>
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
                        <td>Order Cost:</td>
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