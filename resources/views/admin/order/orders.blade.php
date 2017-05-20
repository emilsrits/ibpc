@extends('layouts.admin')

@section('title')
Orders
@endsection

@section('content')
    <div class="admin-page lg-100 md-100 sm-100">
        <div class="orders-list">
            <h3>Orders</h3>
            <div class="manage-btn-group">
                <div class="btn-manage-back">
                    <a href="{{ url('/admin') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
                </div>
            </div>
            <form id="orders-form" role="form" method="POST" action="{{ url('/admin/orders/action') }}">
                {{ csrf_field() }}
                <div class="orders-action">
                    <select id="mass-action" name="mass-action">
                        <option value="0"></option>
                        <option value="1">Delete</option>
                    </select>
                    <button id="mass-action-run" type="submit" name="submit"><i class="fa fa-play" aria-hidden="true"></i></button>
                </div>
                {{ $orders->appends(Request::except('page'))->links() }}
                <table id="orders-table">
                    <thead class="table-head">
                    <tr>
                        <th>
                            <input id="mass-select" type="checkbox" name="mass-select" value="yes">
                        </th>
                        <th>Id</th>
                        <th>User</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-body">
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <input class="entity-select" type="checkbox"
                                       name="orders[{{ $order->id }}][id]" value="{{ $order->id }}">
                            </td>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->full_name }}</td>
                            <td class="has-currency">{{ $order->getPriceCurrency('total') }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->updated_at }}</td>
                            <td>
                                <a href="{{ url('/admin/order/edit', ['id' => $order->id]) }}">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($orders->count() > 20)
                    {{ $orders->appends(Request::except('page'))->links() }}
                @endif
            </form>
        </div>
    </div>
@endsection