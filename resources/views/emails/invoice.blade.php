@extends('layouts.email')

@section('styles')
    <style>
        #email {
            font-family: 'Roboto', sans-serif;
        }
        #email p {
            font-size: 12px;
            font-weight: normal;
        }
        #email hr {
            margin: 10px 0;
            color: #CC4040;
        }
        #email table {
            margin: 10px 0 20px;
            border-collapse: collapse;
        }
        #email table tbody {
            font-size: 12px;
        }
        #email table tbody tr td {
            padding: 5px 15px;
        }
        #email table tbody tr td:first-of-type {
            width: 220px;
        }
        #email .invoice-header{
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div id="email">
        <img src="{{ asset('/images/logo.png') }}" alt="logo">
        <h4>Hello, {{ $user->full_name }}!</h4>
        <p>We have sent you invoice for your order, see bill in attachment</p>
        <hr>
        <table>
            <tbody>
            <tr class="invoice-header">
                <td>Order number:</td>
                <td>{{ $order->id }}</td>
            </tr>
            <tr>
                <td>Order date:</td>
                <td>{{ \Carbon\Carbon::now()->toDateString() }}</td>
            </tr>
            <tr>
                <td>Payment method:</td>
                <td>Transfer</td>
            </tr>
            <tr>
                <td>Order status:</td>
                <td>{{ $order->status }}</td>
            </tr>
            <tr>
                <td>Items ordered:</td>
                <td>{{ count($order->products) }}</td>
            </tr>
            <tr>
                <td>Order total cost, incl VAT:</td>
                <td>{{ $order->getPriceCurrency('price') }}</td>
            </tr>
            </tbody>
        </table>
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
        <p>Order will be accepted once you have paid the bill, please, indicate order number #{{ $order->id }}</p>
        <p>When order will be ready to be received we will inform you and send an e-mail and SMS</p>
    </div>
@endsection