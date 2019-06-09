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
        <form id="orders-form" role="form" method="POST" action="{{ url('/admin/orders') }}">
            {{ csrf_field() }}
            <div class="orders-action">
                <select id="mass-action" name="mass-action">
                    <option value="0"></option>
                    @foreach(config('constants.order_status') as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                <button id="mass-action-run" type="submit" name="submit"><i class="fa fa-play" aria-hidden="true"></i></button>
                <button id="filters-clear" type="button" name="clear"><i class="fa fa-refresh" aria-hidden="true"></i> Clear Filters</button>
            </div>
            {{ $orders->appends(Request::except('page'))->links() }}
            <table id="orders-table">
                <thead class="table-head">
                <tr>
                    <th class="col-xs">
                        <input id="mass-select" type="checkbox" name="mass-select" value="yes">
                    </th>
                    <th class="col-sm">Id</th>
                    <th>User</th>
                    <th>Price</th>
                    <th class="col-md">Status</th>
                    <th id="sort-created" class="col-md">
                        <button type="submit" name="created" value="{{ $request['created'] === 'desc' ? 'asc' : 'desc' }}">
                            Created at
                            @if($request['created'] === 'asc')
                                <i class="fa fa-sort-asc" aria-hidden="true"></i>
                            @elseif($request['created'] === 'desc')
                                <i class="fa fa-sort-desc" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-sort" aria-hidden="true"></i>
                            @endif
                        </button>
                    </th>
                    <th id="sort-updated" class="col-md">
                        <button type="submit" name="updated" value="{{ $request['updated'] === 'desc' ? 'asc' : 'desc' }}">
                            Updated at
                            @if($request['updated'] === 'asc')
                                <i class="fa fa-sort-asc" aria-hidden="true"></i>
                            @elseif($request['updated'] === 'desc')
                                <i class="fa fa-sort-desc" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-sort" aria-hidden="true"></i>
                            @endif
                        </button>
                    </th>
                    <th class="col-xs"></th>
                </tr>
                </thead>
                <tr id="table-search">
                    <td></td>
                    <td><input type="number" name="id" min="0" value="{{ $request['id'] ? $request['id'] : '' }}"></td>
                    <td><input type="text" name="user" value="{{ $request['user'] ? $request['user'] : '' }}"></td>
                    <td></td>
                    <td>
                        <select name="status">
                            <option value=""></option>
                            @foreach(config('constants.order_status') as $key => $value)
                                <option value="{{ $key }}" {{ $request['status'] === $value ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" name="createdAt" value="{{ $request['createdAt'] ? $request['createdAt'] : '' }}"></td>
                    <td><input type="text" name="updatedAt" value="{{ $request['updatedAt'] ? $request['updatedAt'] : '' }}"></td>
                    <td></td>
                </tr>
                <tbody class="table-body">
                @foreach($orders as $order)
                    <tr>
                        <td>
                            @if(!in_array($order->status, config('constants.order_status_finished')))
                                <input class="entity-select" type="checkbox"
                                       name="orders[{{ $order->id }}][id]" value="{{ $order->id }}">
                            @endif
                        </td>
                        <td>{{ $order->id }}</td>
                        <td class="no-wrap">{{ $order->user->full_name }}</td>
                        <td class="no-wrap">{{ $order->getPriceCurrency('price') }}</td>
                        <td>{{ $order->status }}</td>
                        <td class="no-wrap">{{ $order->created_at }}</td>
                        <td class="no-wrap">{{ $order->updated_at }}</td>
                        <td>
                            <a href="{{ url('/admin/order/edit', ['id' => $order->id]) }}">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if($orders->count() >= 20)
                {{ $orders->appends(Request::except('page'))->links() }}
            @endif
        </form>
    </div>
</div>
@endsection