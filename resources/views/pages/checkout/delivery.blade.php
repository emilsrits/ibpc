@extends('layouts.store')

@section('title')
Checkout Delivery
@endsection

@section('content')
<div class="section">
    <div class="container">
        @include('pages.checkout._partials.checkout_progress', ['step' => 3])
        <div id="checkout-delivery" class="box">
            <form id="checkout-delivery-form" class="form" role="form" method="POST" action="{{ url('/checkout/confirmation') }}">
                @csrf
                <div class="level">
                    <div class="level-left">
                        <div class="level-item">
                            <img class="image" src="{{ asset('/media/delivery-storage.png') }}" alt="storage">

                            <div class="field">
                                <div class="select">
                                    <select name="delivery">
                                        <option value="storage" {{ Session::get('delivery') === 'storage' ? 'selected' : '' }}>
                                            Storage @money(config('constants.delivery_cost.storage'))
                                        </option>
                                        <option value="address" {{ Session::get('delivery') === 'address' ? 'selected' : '' }}>
                                            Address @money(config('constants.delivery_cost.address'))
                                        </option>
                                    </select>
                                </div>
                                <p class="help">Choose your delivery method</p>
                            </div>
                        </div>

                        <div class="level-item">
                            <ul class="delivery-info">
                                <li>Storage: receive order at storage for no cost.</li>
                                <li>Address: receive order at your shipping address for additional cost.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="level-right">
                        <div class="level-item">
                            <button class="button button-action action-add" type="submit" title="Checkout">
                                <i class="fa fa-arrow-right" aria-hidden="true">&nbsp;</i>
                                Continue
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection