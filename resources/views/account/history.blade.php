@extends('layouts.master')

@section('title')
Order History
@endsection

@section('content')
<div class="grid rlg-100 md-100 sm-100">
    <div id="user-account">
        <h4>My Account</h4>
        <div class="grid-uniform lg-100 md-100 sm-100">
            <div id="account-nav">
                <div class="account-orders grid-item lg-33 md-33 sm-33">
                    <a href="{{ url('/user/account') }}">
                        <i class="fa fa-shopping-basket" aria-hidden="true"></i> My Orders
                    </a>
                </div>
                <div class="account-order-history grid-item lg-33 md-33 sm-33">
                    <a class="active" href="{{ url('/user/history') }}">
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
            <h4>Order history</h4>
            @if(count($user->orders))
                <table class="user-orders">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Price</th>
                        <th>Delivery</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="col-sm">{{ $order->id }}</td>
                            <td class="no-wrap">{{ $order->getPriceCurrency('price') }}</td>
                            <td>{{ $order->delivery }}</td>
                            <td>{{ $order->status }}</td>
                            <td class="col-md no-wrap">{{ $order->created }}</td>
                            <td class="col-md no-wrap">{{ $order->updated }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>You have no previous orders</p>
            @endif
        </div>
    </div>
</div>
@endsection