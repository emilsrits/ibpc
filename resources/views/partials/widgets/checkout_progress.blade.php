<div class="checkout-progress">
    <ul class="cf">
        <li class="{{ $page >= 1 ? 'current' : ''}}">
            <span class="hidden-lg hidden-md hidden-sm">1</span><span class="hidden-xs">Cart</span>
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </li>
        <li class="{{ $page >= 2 ? 'current' : ''}}">
            <span class="hidden-lg hidden-md hidden-sm">2</span><span class="hidden-xs">Shipping Information</span>
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </li>
        <li class="{{ $page >= 3 ? 'current' : ''}}">
            <span class="hidden-lg hidden-md hidden-sm">3</span><span class="hidden-xs">Delivery</span>
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </li>
        <li class="{{ $page >= 4 ? 'current' : ''}}">
            <span class="hidden-lg hidden-md hidden-sm">4</span><span class="hidden-xs">Confirmation</span>
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </li>
        <li class="{{ $page >= 5 ? 'current' : ''}}">
            <span class="hidden-lg hidden-md hidden-sm">5</span><span class="hidden-xs">Success</span>
            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
        </li>
    </ul>
</div>