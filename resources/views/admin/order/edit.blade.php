@extends('layouts.admin')

@section('title')
Edit Order
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="order-edit">
        <h3>#{{ $order->id }}</h3>  
        <form id="edit-order-form" role="form" method="POST" action="{{ url('/admin/order/update', ['id' => $order->id]) }}">
            {{ csrf_field() }}
            <div class="manage-btn-group">
                <div class="btn-manage-back">
                    <a href="{{ url('/admin/orders') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
                </div>
                <button class="entity-save {{ $closed ? 'hidden' : '' }}" type="submit" name="submit" value="save">Save</button>
            </div>
            <div class="order-content-section">
                <div class="content-container">
                    <table class="order-table">
                        <tbody>
                        <tr class="entity-attribute">
                            <td><label for="user">User</label></td>
                            <td><span>{{ $order->user->full_name }}</span></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="status">Current status</label></td>
                            <td><span>{{ $order->status }}</span></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="created">Created</label></td>
                            <td><span>{{ $order->created_at }}</span></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="updated">Updated</label></td>
                            <td><span>{{ $order->updated_at }}</span></td>
                        </tr>
                        @if($order->delivery_cost > 0)
                            <tr class="entity-attribute">
                                <td><label for="delivery">Delivery cost</label></td>
                                <td><span>{{ $order->getPriceCurrency('delivery') }}</span></td>
                            </tr>
                        @endif
                        <tr class="entity-attribute">
                            <td><label for="cost">Total cost</label></td>
                            <td><span>{{ $order->getPriceCurrency('price') }}</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if(!$closed)
                <div class="order-content-section">
                    <div class="content-section-toggle">
                        <strong>Order Status<i class="fa fa-angle-down" aria-hidden="true"></i></strong>
                    </div>
                    <div class="content-container" style="display: none;">
                        <table class="order-table">
                            <tbody>
                            <tr class="entity-attribute">
                                <td><label for="status">Status</label></td>
                                <td>
                                    @foreach(config('constants.order_status') as $key => $value)
                                        <label class="radio-block">
                                            <input type="radio" name="status" value="{{ $value  }}"
                                                    {{ $order->status === $value ? 'checked' : '' }}> {{ $value }}
                                        </label>
                                    @endforeach
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="order-content-section">
                <div class="content-section-toggle">
                    <strong>Order Items<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                </div>
                <div class="content-container of-x">
                    <table id="orders-table">
                        <thead class="table-head">
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Code</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                        </thead>
                        <tbody class="table-body">
                        @foreach($order->products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->pivot->quantity }}</td>
                                <td class="no-wrap">{{ $product->getPriceCurrency('order', $order->id, $product->id) }}</td>
                                <td class="no-wrap">{{ $product->getPriceCurrency('order_total', $order->id, $product->id) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>

        <form id="send-invoice-form" role="form" method="POST" action="{{ url('/admin/order/update', ['id' => $order->id]) }}">
            {{ csrf_field() }}
            <div class="manage-btn-group">
                <button class="entity-save" type="submit" name="submit" value="invoice">Resend Invoice</button>
            </div>
        </form>
    </div>
</div>
@endsection