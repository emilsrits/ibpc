@extends('layouts.store')

@section('title')
Order #{{ $order->id }}
@endsection

@section('content')
<div class="section">
    <div class="container">
        <div id="user-account" class="box">
            @include('pages.account._partials.navigation')
            
            <table class="table is-bordered">
                <caption>Order #{{ $order->id }}</caption>
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
                        <td>@money($order->delivery_cost)</td>
                    </tr>
                @endif
                <tr>
                    <td>Total cost incl. VAT:</td>
                    <td>@money($order->price)</td>
                </tr>
            </table>
            <div class="scrollable-x">
                <table id="user-order" class="table is-fullwidth">
                    <thead>
                    <tr>
                        <th class="is-hidden-mobile"></th>
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
                            <td class="order-item-media is-hidden-mobile">
                                <img class="image" src="{{ $product->image }}" alt="{{ $product->code }}">
                            </td>
                            <td class="no-wrap">{{ $product->title }}</td>
                            <td class="no-wrap">{{ $product->code }}</td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td>@money($product->getOrderPriceById($order->id, $product->id))</td>
                            <td>@money($product->getOrderTotalPriceById($order->id, $product->id))</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection