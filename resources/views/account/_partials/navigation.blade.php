<div class="tabs is-centered is-boxed is-medium">
    <ul>
        <li class="@if(Route::is('account.index')) is-active @endif">
            <a href="{{ URL::route('account.index') }}">
                <span class="icon is-small"><i class="fa fa-shopping-basket"></i></span>
                <span class="is-hidden-mobile">Active Orders</span>
            </a>
        </li>

        <li class="@if(Route::is('account.showHistory')) is-active @endif">
            <a href="{{ URL::route('account.showHistory') }}">
                <span class="icon is-small"><i class="fa fa-history"></i></span>
                <span class="is-hidden-mobile">Order History</span>
            </a>
        </li>

        <li class="@if(Route::is('account.edit')) is-active @endif">
            <a href="{{ URL::route('account.edit') }}">
                <span class="icon is-small"><i class="fa fa-address-card"></i></span>
                <span class="is-hidden-mobile">Edit Account</span>
            </a>
        </li>
    </ul>
</div>