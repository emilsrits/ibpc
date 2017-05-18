@extends('layouts.email')

@section('styles')
    <style>
        #email {
            font-family: OpenSans-Regular, sans-serif;
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
            </tbody>
        </table>
        <p>Order will be accepter once you have paid the bill, please, indicate order number #{{ $order->id }}</p>
        <p>When order will be ready to be received we will inform you and send an e-mail and SMS</p>
    </div>
@endsection