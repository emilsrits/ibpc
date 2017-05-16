<div class="checkout-progress">
    <ul class="cf">
        <li class="{{ $page >= 1 ? 'current' : ''}}">
            <a href="{{ url('/cart') }}">
                <span class="hidden-lg hidden-md hidden-sm">1</span><span class="hidden-xs">Cart</span>
            </a>
        </li>
        <li class="{{ $page >= 2 ? 'current' : ''}}">
            <a href="{{ url('/checkout') }}">
                <span class="hidden-lg hidden-md hidden-sm">2</span><span class="hidden-xs">Shipping Information</span>
            </a>
        </li>
        <li class="{{ $page >= 3 ? 'current' : ''}}">
            <a href="{{ url('/checkout/delivery') }}">
                <span class="hidden-lg hidden-md hidden-sm">3</span><span class="hidden-xs">Delivery</span>
            </a>
        </li>
        <li class="{{ $page >= 4 ? 'current' : ''}}">
            <a href="{{ url('/checkout/confirmation') }}">
                <span class="hidden-lg hidden-md hidden-sm">4</span><span class="hidden-xs">Confirmation</span>
            </a>
        </li>
        <li class="{{ $page >= 5 ? 'current' : ''}}">
            <a href="{{ url('/checkout/success') }}">
                <span class="hidden-lg hidden-md hidden-sm">5</span><span class="hidden-xs">Success</span>
            </a>
        </li>
    </ul>
</div>