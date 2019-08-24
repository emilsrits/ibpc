@extends('layouts.master')

@section('title')
Order History
@endsection

@section('content')
<div class="section">
    <div class="container">
        <div id="user-account" class="box">
            @include('account._partials.navigation')
            
            @if(count($orders))
                @include('account._partials.orders_table', ['orders' => $orders])
            @else
                <p>You have no previous orders</p>
            @endif
        </div>
    </div>
</div>
@endsection