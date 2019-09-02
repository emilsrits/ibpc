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
                <a href="{{ url('/admin') }}">Dashboard</a>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link item-link" href="{{ url('/admin/catalog') }}">Catalog</a>

                <div class="navbar-dropdown">
                    <div class="navbar-item">
                        <a href="{{ url('/admin/categories') }}">Categories</a>
                    </div>

                    <div class="navbar-item">
                        <a href="{{ url('/admin/specifications') }}">Properties</a>
                    </div>
                </div>
            </div>

            <div class="navbar-item">
                <a href="{{ url('/admin/orders') }}">Orders</a>
            </div>

            <div class="navbar-item">
                <a href="{{ url('/admin/users') }}">Users</a>
            </div>
        </template>
    </header-navbar>
</header>

@include('_partials.widgets.flash_message')