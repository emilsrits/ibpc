<header>
    <header-navbar 
        :user="{{ json_encode(Auth::user()) }}"
        @if (Session::has('cart'))
        :cart="{
            items: {{ json_encode(session('cart')->items) }},
            price: '{{ money(session('cart')->totalPrice) }}'
        }"
        @else
        :cart="null"
        @endif
        :routes="{
            home: '{{ url('/') }}',
            search: '{{ url('/search/') }}',
            cart: '{{ url('/cart') }}',
            account: '{{ url('/user/account') }}',
            login: '{{ url('/login') }}',
            register: '{{ url('/register') }}',
            logout: '{{ url('/logout') }}'
        }"
        :media="{
            logo: '{{ asset('media/logo.png') }}'
        }"
    >
    </header-navbar>
</header>

@include('partials.widgets.flash_message')