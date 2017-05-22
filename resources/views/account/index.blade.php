@extends('layouts.master')

@section('title')
My Account
@endsection

@section('content')
<div class="grid rlg-100 md-100 sm-100">
    <div id="user-account">
        <h4>My Account</h4>
        <div class="grid-uniform lg-100 md-100 sm-100">
            <div id="account-nav">
                <div class="account-settings grid-item lg-33 md-33 sm-33">
                    <a href="{{ url('/user/edit') }}">
                        <i class="fa fa-address-card" aria-hidden="true"></i> Update Account
                    </a>
                </div>
                <div class="account-orders grid-item lg-33 md-33 sm-33">
                    <a class="active" href="{{ url('/user/account') }}">
                        <i class="fa fa-shopping-basket" aria-hidden="true"></i> My Orders
                    </a>
                </div>
                <div class="account-order-history grid-item lg-33 md-33 sm-33">
                    <a href="{{ url('/user/order/history') }}">
                        <i class="fa fa-history" aria-hidden="true"></i> Order History
                    </a>
                </div>
            </div>
        </div>
        <div id="account-panel" class="grid-item lg-80 md-85 sm-85">

        </div>
    </div>
</div>
@endsection 