<header>
    <nav id="nav-top" class="navbar navbar-default">
        <div class="container-inner">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('media/logo.png') }}" alt="IBPC">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <ul id="product-search" class="nav navbar-nav">
                       <li class="product-search-container">
                           <form id="product-search-form" role="form" method="GET" action="{{ url('/search/') }}">
                               <input id="search" type="search" name="q">
                               <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                           </form>
                       </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="{{ url('/cart') }}">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="navbar-cart-items">
                                    @if (Session::has('cart'))
                                        ({{ count(session('cart')->items) }})
                                        @money(session('cart')->totalPrice)
                                    @else
                                        0
                                    @endif
                                </span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                @if (Auth::guest())
                                    User
                                @else
                                    {{ Auth::user()->first_name }}
                                @endif
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @if(Auth::check())
                                    <li><a href="{{ url('/user/account') }}">Account</a></li>
                                    @if(Auth::user()->hasRole('admin'))
                                        <li><a href="{{ url('/admin') }}">Admin Panel</a></li>
                                    @endif
                                    <li role="separator" class="divider"></li>
                                @endif
                                @if (Auth::guest())
                                    <li><a href="{{ url('/login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign In</a></li>
                                    <li><a href="{{ url('/register') }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Register</a></li>
                                @else
                                    <li>
                                        <a id="sign-out" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out" aria-hidden="true"></i> Sign Out
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

@include('partials.widgets.flash_message')