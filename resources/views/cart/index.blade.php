@extends('layouts.master')

@section('title')
Shopping Cart
@endsection

@section('content')
<div class="section">
    <div class="container">
        <div class="columns is-multiline">
            <div class="column is-12-mobile is-3-tablet is-2-widescreen">
                @include('partials.store.categories')
            </div>

            <div class="column is-12-mobile is-9-tablet is-10-widescreen">
                <checkout-cart
                    :cart-total-price="'{{ $cart ? money($cart->totalPrice) : null }}'"
                    :routes="{
                        action: '{{ url('/cart/update') }}',
                        checkout: '{{ url('/checkout') }}'
                    }"
                >
                    <template v-slot:form-method>
                        {{ method_field('PATCH') }}
                    </template>

                    @if(Session::has('cart'))
                        <template v-slot:cart-items="{removeProductFromCart}">
                            @foreach($products as $product)
                                @if($product['item']['id'])
                                <tr>
                                    <td class="has-text-centered">
                                        <button class="cart-item-remove button-clean" type="button" value="{{ $product['item']['id'] }}" @click="removeProductFromCart">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                    <td class="cart-item-media is-hidden-mobile">
                                        <a href="{{ url('/p', ['code' => $product['item']['code']]) }}">
                                            <img class="image" src="{{ asset($product['item']['image']) }}" alt="{{ $product['item']['code'] }}">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('/p', ['code' => $product['item']['code']]) }}">
                                            {{ $product['item']['title'] }}
                                        </a>
                                    </td>
                                    <td>
                                        <input id="qty" type="number" name="cart[{{ $product['item']['id'] }}][qty]" min="1" max="1000"
                                            value="{{ $product['qty'] }}" title="qty" pattern="[0-9]*">
                                    </td>
                                    <td class="cart-item-price is-hidden-mobile">
                                        @money($cart->getItemPrice($product['item']['id']))
                                    </td>
                                    <td>
                                        @money($cart->getItemTotalPrice($product['item']['id']))
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </template>
                    @endif
                </checkout-cart>
            </div>
        </div>
    </div>
</div>
@endsection