@extends('layouts.master')

@section('title')
Active Orders
@endsection

@section('content')
<div class="section">
    <div class="container">
        <div id="user-account" class="box">
            @include('partials.account.navigation')
            
            @if(count($orders))
                @include('partials.account.orders_table', ['orders' => $orders])
            @else
                <p>You have no active orders</p>
            @endif
        </div>
    </div>
</div>
@endsection 