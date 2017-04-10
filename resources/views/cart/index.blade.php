@extends('layouts.master')

@section('title')
    Shopping Cart
@endsection

@section('content')
    @if(Session::has('cart'))
        <div class="lg-100">
            <form id="shopping-cart-form" role="form" method="POST" action="{{ url('/cart/update') }}">
                {{ csrf_field() }}
                <fieldset>
                    <table id="shopping-cart-table">
                        <thead class="table-headers">
                            <tr>
                                <th></th>
                                <th class="hidden-xs">Product</th>
                                <th><span class="visible-xs">Product</span></th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($products as $product)
                                <tr>
                                    <td><a href="{{ url('/cart/remove', ['id' => $product['item']['id']]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                    <td class="product-image hidden-xs">
                                        <a href="{{ url('/product', ['id' => $product['item']['id']]) }}">
                                            <img src="{{ asset($product['item']['image_path']) }}" alt="{{ $product['item']['code'] }}">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('/product', ['id' => $product['item']['id']]) }}">
                                            {{ $product['item']['title'] }}
                                        </a>
                                    </td>
                                    <td>
                                        <input id="qty" type="text" name="qty" maxlength="3" value="{{ $product['qty'] }}" title="qty" pattern="[0-9]*">
                                    </td>
                                    <td>
                                        {{ $cart->getItemTotalPrice($product['item']['id']) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </fieldset>
            </form>
        </div>
    @else
        <div class="lg-100">
            <div class="cart-empty">
                <h2>Cart is empty</h2>
                <a class="btn" href="{{ url('/') }}">Back To Shop</a>
            </div>
        </div>
    @endif
@endsection