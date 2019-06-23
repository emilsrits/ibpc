<h4>My Account</h4>
<div class="grid-uniform lg-100 md-100 sm-100">
    <div id="account-nav">
        <div class="account-orders grid-item lg-33 md-33 sm-33">
            <a class="@if(Route::is('account.index')) active @endif" href="{{ URL::route('account.index') }}">
                <i class="fa fa-shopping-basket" aria-hidden="true"></i> Active Orders
            </a>
        </div>
        <div class="account-order-history grid-item lg-33 md-33 sm-33">
            <a class="@if(Route::is('account.showHistory')) active @endif" href="{{ URL::route('account.showHistory') }}">
                <i class="fa fa-history" aria-hidden="true"></i> Order History
            </a>
        </div>
        <div class="account-settings grid-item lg-33 md-33 sm-33">
            <a class="@if(Route::is('account.edit')) active @endif" href="{{ URL::route('account.edit') }}">
                <i class="fa fa-address-card" aria-hidden="true"></i> Update Account
            </a>
        </div>
    </div>
</div>