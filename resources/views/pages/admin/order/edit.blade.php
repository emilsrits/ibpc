@extends('layouts.admin')

@section('title')
Edit Order
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">#{{ $order->id }}</h1>

            <form id="entity-edit-form" role="form" method="POST" action="{{ url('/admin/order/update', ['id' => $order->id]) }}">
                @method('PATCH')
                @csrf

                <entity-manage
                    :can-save="{{ json_encode($closed ? false : true) }}"
                    :routes="{
                        back: '{{ url('/admin/orders') }}'
                    }"
                >
                </entity-manage>

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">General</h2>
                    </div>

                    <div class="column is-9">
                        <div class="field is-distinct">
                            <label class="label is-small">User</label>
                            <div class="control">
                                <span>{{ $order->user->full_name }}</span>
                            </div>
                        </div>

                        <div class="field is-distinct">
                            <label class="label is-small">Current Status</label>
                            <div class="control">
                                <span>{{ $order->status }}</span>
                            </div>
                        </div>

                        <div class="field is-distinct">
                            <label class="label is-small">Created</label>
                            <div class="control">
                                <span>{{ $order->created_at }}</span>
                            </div>
                        </div>

                        <div class="field is-distinct">
                            <label class="label is-small">Updated</label>
                            <div class="control">
                                <span>{{ $order->updated_at }}</span>
                            </div>
                        </div>

                        <div class="field is-distinct">
                            <label class="label is-small">Delivery Cost</label>
                            <div class="control">
                                <span>@money($order->delivery_cost)</span>
                            </div>
                        </div>

                        <div class="field is-distinct">
                            <label class="label is-small">Total cost incl. VAT:</label>
                            <div class="control">
                                <span>@money($order->price)</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!$closed)
                    <div class="columns">
                        <div class="column is-3">
                            <h2 class="is-size-5">Order Status</h2>
                        </div>

                        <div class="column is-9">
                            <div class="control">
                                @foreach(config('constants.order_status') as $key => $value)
                                    <div class="field">
                                        <label class="radio">
                                            <input type="radio" name="status" value="{{ $value  }}" {{ $order->status === $value ? 'checked' : '' }}>
                                            {{ ucfirst($value) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">Order Items</h2>
                    </div>

                    <div class="column is-9 scrollable-x">
                        <table class="table is-fullwidth">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Code</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td class="no-wrap">{{ $product->title }}</td>
                                        <td class="no-wrap">{{ $product->code }}</td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td class="no-wrap">@money($product->getOrderPriceById($order->id, $product->id))</td>
                                        <td class="no-wrap">@money($product->getOrderTotalPriceById($order->id, $product->id))</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

            <div class="columns">
                <div class="column is-3">
                    <h2 class="is-size-5">Invoice</h2>
                </div>

                <div class="column is-9">
                    <form id="send-invoice-form" role="form" method="POST" action="{{ url('/admin/order/invoice', ['id' => $order->id]) }}">
                        @csrf

                        <button class="button button-action action-do" type="submit" name="submit" value="invoice">Resend Invoice</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection