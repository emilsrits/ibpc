@extends('layouts.pdf')

@section('styles')
    <style>
        #invoice {
            font-family: OpenSans-Regular, sans-serif;
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
            font-size: 11px;
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
    <img src="{{ asset('/images/logo.png') }}" alt="logo">
    <h4>Invoice #{{ $order->id }}</h4>
    <p>{{ \Carbon\Carbon::now()->toDateString() }}</p>
    <hr>
    <table>
        <tbody>
        <tr class="invoice-header">
            <td>Recipient:</td>
            <td>IBPC</td>
        </tr>
        <tr>
            <td>VAT identification number:</td>
            <td>LV40013214068</td>
        </tr>
        <tr>
            <td>Registration number:</td>
            <td>20003515031</td>
        </tr>
        <tr>
            <td>Address:</td>
            <td>Riga, Brivibas gatve 229, LV-1050</td>
        </tr>
        <tr>
            <td>Bank:</td>
            <td>A/S Swedbank</td>
        </tr>
        <tr>
            <td>Bank code:</td>
            <td>HABALV22</td>
        </tr>
        <tr>
            <td>Account:</td>
            <td>LV41HABA0123456789012</td>
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
                <td style="white-space: nowrap">{{ $product->getOrderPriceById($order->id, $product->id) }}</td>
                <td style="white-space: nowrap">{{ $product->getOrderTotalPriceById($order->id, $product->id) }}</td>
            </tr>
        @endforeach
        @if($order->delivery_cost)
            <tr>
                <td colspan="3">Delivery cost:</td>
                <td>{{ $order->delivery_price }}</td>
            </tr>
        @endif
        <tr>
            <td colspan="3">Total:</td>
            <td>{{ $order->total_price }}</td>
        </tr>
        </tbody>
    </table>
    <p class="invoice-important">When submitting payment, please, indicate invoice number.</p>
    <p class="invoice-validity">The invoice was made electronically and is valid without a signature</p>
</div>
@endsection