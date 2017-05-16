@extends('layouts.master')

@section('title')
Order Successful
@endsection

@section('content')
<div class="checkout-delivery lg-100 md-100 sm-100">
    @include('partials.widgets.checkout_progress', ['page' => 5])
    <h4>Order created</h4>
</div>
@endsection