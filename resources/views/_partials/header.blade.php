<header>
    <header-navbar 
        :user="{{ json_encode(Auth::user()) }}"
        :media="{
            logo: '{{ asset('media/logo.png') }}'
        }"
        :routes="{
            home: '{{ url('/') }}',
            account: '{{ url('/user/account') }}',
            login: '{{ url('/login') }}',
            register: '{{ url('/register') }}',
            logout: '{{ url('/logout') }}'
        }"
    >
        <template v-slot:navbar-start>
            <div class="navbar-item">
                <form class="search-form" role="form" method="GET" action="{{ url('/search/') }}">
                    <div class="search-container">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        <input id="search" type="search" name="q">
                    </div>
                </form>
            </div>
        </template>

        <template v-slot:navbar-end>
            <div class="navbar-item">
                <header-navbar-cart
                    @if (Session::has('cart'))
                    :cart="{
                        itemCount: {{ json_encode(count(session('cart')->items)) }},
                        price: '{{ money(session('cart')->totalPrice) }}'
                    }"
                    @else
                    :cart="null"
                    @endif
                    route="{{ url('/cart') }}"
                >
                </header-navbar-cart>
                </div>
        </template>
    </header-navbar>
</header>