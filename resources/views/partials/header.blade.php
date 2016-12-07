<header>
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
                  {{ config('app.name', 'IBPC') }}
               </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
               <!-- Left Side Of Navbar -->
               <ul class="nav navbar-nav">
                  <li><a href="{{ url('/') }}">Products</a></li>
                  <li><a href="#">Services</a></li>
                  <li><a href="#">About</a></li>
               </ul>

               <!-- Right Side Of Navbar -->
               <ul class="nav navbar-nav navbar-right">
                  <li><a href="{{ url('shop/cart') }}"><i class="fa fa-shopping-cart" aria-hidden="true"><span> {{ Session::has('cart') ? Session::get('cart')->totalQuantity : '0' }}</span></i> items</a></li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        @if (Auth::guest())
                            User 
                        @else
                           {{ Auth::user()->name }}
                        @endif
                        <span class="caret"></span>
                     </a>
                     <ul class="dropdown-menu">
                        @if(Auth::check())
                           <li><a href="{{ url('/profile') }}">Profile</a></li>
                           <li><a href="#">Settings</a></li>
                           <li><a href="#">Manage</a></li>
                           <li role="separator" class="divider"></li>
                        @endif
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                           <li><a href="{{ url('/login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign In</a></li>
                           <li><a href="{{ url('/register') }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> Register</a></li>
                        @else
                           <li><a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i> Sign Out</a></li>
                           <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                              {{ csrf_field() }}
                           </form>
                        @endif
                     </ul>
                  </li>
               </ul>
            </div><!-- /.navbar-collapse -->
         </div><!-- /.container-fluid -->
      </div>
   </nav>
</header>