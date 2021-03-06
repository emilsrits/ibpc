@extends('layouts.pdf')

@section('styles')
    <style>
        #invoice {
            font-family: DejaVu Sans, sans-serif;
        }
        #invoice h4 {
            text-transform: uppercase;
        }
        #invoice .invoice-header {
            font-weight: bold;
        }
        #invoice hr {
            margin: 10px 0;
        }
        #invoice table {
            margin: 10px 0 20px;
            border-collapse: collapse;
        }
        #invoice table thead, #invoice table tbody {
            font-size: 12px;
        }
        #invoice table thead tr th, #invoice table tbody tr td {
            padding: 5px 15px;
        }
        #invoice table tbody tr td:first-of-type {
            width: 220px;
        }
        #invoice .invoice-important {
            color: #FF0000;
            font-size: 10px;
        }
        #invoice .invoice-validity {
            margin-top: 15px;
            font-size: 10px;
        }
        #invoice-products {
            width: 100%;
        }
        #invoice-products th, #invoice-products td {
            border: 1px solid #000;
        }
    </style>
@endsection

@section('content')
<div id="invoice">
    <h2>{{ config('constants.app.name') }}</h2>
    <h4>Invoice #{{ $order->id }}</h4>
    <p>{{ \Carbon\Carbon::now()->toDateString() }}</p>
    <hr>
    <table>
        <tbody>
        <tr class="invoice-header">
            <td>Recipient:</td>
            <td>{{ config('constants.recipient.name') }}</td>
        </tr>
        
        <tr>
            <td>Identification number:</td>
            <td>{{ config('constants.recipient.id') }}</td>
        </tr>

        <tr>
            <td>Registration number:</td>
            <td>{{ config('constants.recipient.reg') }}</td>
        </tr>

        <tr>
            <td>Address:</td>
            <td>{{ config('constants.recipient.address') }}</td>
        </tr>

        <tr>
            <td>Bank:</td>
            <td>{{ config('constants.recipient.bank') }}</td>
        </tr>

        <tr>
            <td>Bank code:</td>
            <td>{{ config('constants.recipient.code') }}</td>
        </tr>

        <tr>
            <td>Account:</td>
            <td>{{ config('constants.recipient.account') }}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <table>
        <tbody>
        <tr class="invoice-header">
            <td>Payer:</td>
            <td>{{ $user->fullname }}</td>
        </tr>

        @if($order->delivery === 'address')
            <tr>
                <td>Delivery address:</td>
                <td>{{ $user->fulladdress }}</td>
            </tr>
        @endif
        </tbody>
    </table>
    <hr>
    <table id="invoice-products">
        <thead>
            <tr>
                <th>Title</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->products as $product)
                <tr>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td style="white-space: nowrap">@moneyraw($product->getOrderPriceById($order->id, $product->id))</td>
                    <td style="white-space: nowrap">@moneyraw($product->getOrderTotalPriceById($order->id, $product->id))</td>
                </tr>
            @endforeach

            @if($order->delivery_cost)
                <tr>
                    <td colspan="3">Delivery cost:</td>
                    <td>@moneyraw($order->delivery_cost)</td>
                </tr>
            @endif

            <tr>
                <td colspan="3">Total, {{ config('constants.currency') }}:</td>
                <td>@moneyraw($order->price)</td>
            </tr>
        </tbody>
    </table>
    <p class="invoice-important">When submitting payment, please, indicate invoice number.</p>
    <p class="invoice-validity">The invoice was made electronically and is valid without a signature</p>
</div>
@endsection