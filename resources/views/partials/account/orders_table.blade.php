{{ $orders->appends(Request::except('page'))->links() }}
<div class="scrollable-x">
    <table class="table is-fullwidth is-hoverable">
        <thead>
        <tr>
            <th>Id</th>
            <th>Price</th>
            <th>Delivery</th>
            <th>Status</th>
            <th>Created</th>
            <th>Updated</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>@money($order->price)</td>
                <td>{{ $order->delivery }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created }}</td>
                <td>{{ $order->updated }}</td>
                <td>
                    <a class="link-action" href="{{ url('/user/order', ['id' => $order->id]) }}">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if($orders->count() >= 20)
    {{ $orders->appends(Request::except('page'))->links() }}
@endif