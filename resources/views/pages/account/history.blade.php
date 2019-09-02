@extends('layouts.store')

@section('title')
Order History
@endsection

@section('content')
<div class="section">
    <div class="container">
        <div id="user-account" class="box">
            @include('pages.account._partials.navigation')
            
            @if(count($orders))
                @include('pages.account._partials.orders_table', ['orders' => $orders])
            @else
                <p>You have no previous orders</p>
            @endif
        </div>
    </div>
</div>
@endsection