<table class="checkout-cart-items table is-fullwidth">
    <thead>
        <th></th>
        <th>Code</th>
        <th>Quantity</th>
        <th class="has-text-right">Subtotal</th>
    </thead>
    <tbody>
        @foreach($cart->items as $item)
            @if($item['item']['id'])
            <tr>
                <td>{{ $item['item']['title'] }}</td>
                <td>{{ $item['item']['code'] }}</td>
                <td>{{ $cart->getItemQuantity($item['item']['id']) }}</td>
                <td class="has-text-right">@money($cart->getItemTotalPrice($item['item']['id']))</td>
            </tr>
            @endif
        @endforeach

        @if(Session::has('delivery'))
            @if($cart->delivery)
            <tr>
                <td>{{ 'Delivery to ' . $cart->delivery_code }}</td>
                <td class="has-text-right" colspan="3">@money($cart->delivery_cost)</td>
            </tr>
            @endif
        @endif

        @if($cart->getVat())
            <tr>
                <td>VAT</td>
                <td class="has-text-right" colspan="3">@money($cart->vat)</td>
            </tr>
        @endif
        <tr>
            <td class="has-text-right has-text-weight-bold" colspan="4">Total incl. VAT: @money($cart->getTotalPriceWithVat())</td>
        </tr>
    </tbody>
</table>