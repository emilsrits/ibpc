@extends('layouts.master')

@section('title')
Order History
@endsection

@section('content')
<div class="grid rlg-100 md-100 sm-100">
    <div id="user-account" class="cf">
        @include('partials.account.navigation')
        <div id="account-panel" class="grid-item lg-10 md-100 sm-100">
            <h4>Order history</h4>
            @if(count($orders))
                {{ $orders->appends(Request::except('page'))->links() }}
                <div class="table-items of-x">
                    <table class="user-orders">
                        <thead>
                        <tr>
                            <th class="col-sm">Id</th>
                            <th>Price</th>
                            <th>Delivery</th>
                            <th>Status</th>
                            <th class="col-md">Created</th>
                            <th class="col-md">Updated</th>
                            <th class="col-xs"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td class="no-wrap">{{ $order->getPriceCurrency('price') }}</td>
                                <td>{{ $order->delivery }}</td>
                                <td>{{ $order->status }}</td>
                                <td class="no-wrap">{{ $order->created }}</td>
                                <td class="no-wrap">{{ $order->updated }}</td>
                                <td>
                                    <a href="{{ url('/user/order', ['id' => $order->id]) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if($orders->count() >= 20)
                    {{ $orders->appends(Request::except('page'))->links() }}
                @endif
            @else
                <p>You have no previous orders</p>
            @endif
        </div>
    </div>
</div>
@endsection