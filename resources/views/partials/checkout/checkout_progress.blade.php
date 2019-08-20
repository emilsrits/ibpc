<ul class="checkout-steps">
    <li class="steps-segment {{ $step >= 1 ? 'passed' : ''}}">
        <span class="steps-marker">
            <span class="icon">
                <i class="fa fa-shopping-cart"></i>
            </span>
        </span>
        <div class="steps-content is-hidden-mobile">
            <p class="heading">Shopping Cart</p>
        </div>
    </li>

    <li class="steps-segment {{ $step >= 2 ? 'passed' : ''}}">
        <span class="steps-marker">
            <span class="icon">
                <i class="fa fa-address-card"></i>
            </span>
        </span>
        <div class="steps-content is-hidden-mobile">
            <p class="heading">Shipping Information</p>
        </div>
    </li>

    <li class="steps-segment {{ $step >= 3 ? 'passed' : ''}}">
        <span class="steps-marker">
            <span class="icon">
                <i class="fa fa-truck"></i>
            </span>
        </span>
        <div class="steps-content is-hidden-mobile">
            <p class="heading">Delivery method</p>
        </div>
    </li>

    <li class="steps-segment {{ $step >= 4 ? 'passed' : ''}}">
        <span class="steps-marker">
            <span class="icon">
                <i class="fa fa-credit-card"></i>
            </span>
        </span>
        <div class="steps-content is-hidden-mobile">
            <p class="heading">Confirmation</p>
        </div>
    </li>

    <li class="steps-segment {{ $step >= 5 ? 'passed' : ''}}">
        <span class="steps-marker">
            <span class="icon">
                <i class="fa fa-check-circle-o"></i>
            </span>
        </span>
        <div class="steps-content is-hidden-mobile">
            <p class="heading">Success</p>
        </div>
    </li>
</ul>