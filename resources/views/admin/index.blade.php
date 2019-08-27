@extends('layouts.admin')

@section('title')
Admin Panel
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <div class="manage-section">
                <h4>Recent Orders</h4>

                @if(!$orders->isEmpty())
                    <div class="scrollable-x">
                        <table class="table is-hoverable">
                            <thead>
                                <th>Id</th>
                                <th>User</th>
                                <th>Cost</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td class="no-wrap">{{ $order->user->full_name }}</td>
                                        <td class="no-wrap">@money($order->price)</td>
                                        <td>{{ $order->status }}</td>
                                        <td class="no-wrap">{{ $order->created_at }}</td>
                                        <td>
                                            <a class="link-action" href="{{ url('/admin/order/edit', ['id' => $order->id]) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No orders</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection