<header id="admin-header">
    <nav id="nav-top" class="navbar navbar-default">
        <div class="container-inner">
            <div class="container-fluid">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="IBPC">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side of Navbar -->
                    <ul class="nav navbar-nav admin-sections">
                        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li><a href="{{ url('/admin/catalog') }}">Catalog</a></li>
                        <li><a href="{{ url('/admin/settings') }}">Configuration</a></li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/admin/profile') }}">Profile</a></li>
                                <li><a href="{{ url('/admin') }}">Admin Panel</a></li>
                                <li role="separator" class="divider"></li>
                                <!-- Authentication Links -->
                                <li>
                                    <a href="{{ url('/user/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out" aria-hidden="true"></i> Sign Out
                                    </a>
                                </li>
                                <form id="logout-form" action="{{ url('/user/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </div>
    </nav>
</header>

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('message-' . $msg))
            <div class="message message-{{ $msg }}">
                <div class="message-text">{{ Session::get('message-' . $msg) }}</div>
                <div class="message-close">
                    <a href="#" data-dismiss="message" aria-label="message-close"><i class="fa fa-times" aria-hidden="true"></i></a>
                </div>
            </div>
        @endif
    @endforeach
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>