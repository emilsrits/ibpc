@extends('layouts.master')

@section('title')
    Shopping Cart
@endsection

@section('content')
    @if(Session::has('cart'))
        <div class="large-100">
            <form role="form" method="POST" action="{{ url('/checkout') }}">
                {{ csrf_field() }}
                <fieldset>
                    <table id="shopping-cart-table">
                        <thead class="table-headers">
                            <tr>
                                <th></th>
                                <th class="hidden-xs">Product</th>
                                <th><span class="visible-xs">Product</span></th>
                                <th class="hidden-xs">Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($products as $product)
                                <tr>
                                    <td><a href="#"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                    <td class="product-image hidden-xs">
                                        <a href="{{ url($product['item']['code']) }}">
                                            <img src="{{ asset($product['item']['image_path']) }}" alt="{{ $product['item']['code'] }}">
                                        </a>
                                    </td>
                                    <td>{{ $product['item']['title'] }}</td>
                                    <td class="hidden-xs">{{ $product['price'] }}</td>
                                    <td>{{ $product['qty'] }}</td>
                                    <td>{{ $product['price'] * $product['qty'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </fieldset>
            </form>
        </div>
    @else
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <h2 style="margin: auto; text-align: center;">Cart is empty.</h2>
            </div>
        </div>
    @endif

        {{--<div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <ul class="list-group">
                    @foreach($products as $product)
                        <li class="list-group-item">
                            <span class="badge">{{ $product['qty'] }}</span>
                            <strong>{{ $product['item']['title'] }}</strong>
                            <span class="label label-success">{{ $product['price'] }}</span>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Reduce by 1</a></li>
                                    <li><a href="#">Reduce All</a></li>
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div> <!--  /.row -->
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <strong>Total: {{ $totalPrice }}</strong>
            </div>
        </div> <!--  /.row -->
        <hr>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <button type="button" class="btn btn-success">Checkout</button>
            </div>
        </div> <!--  /.row -->
    @else
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <h2 style="margin: auto; text-align: center;">Cart is empty.</h2>
            </div>
        </div> <!--  /.row -->
    @endif--}}
@endsection 