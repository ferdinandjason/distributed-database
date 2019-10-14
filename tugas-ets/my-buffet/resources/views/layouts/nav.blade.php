<div class="container">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">

        @if( strpos(url()->current(), 'login') == false && strpos(url()->current(), 'register') == false )
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <b>My</b>Buffet
                </a>

                <button type='button' class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="glyphicon glyphicon-user" style="color: #5e5e5e;"></span>
                </button>
            </div>

            @guest
                <ul class="nav navbar-nav navbar-right collapse navbar-collapse">
                    <li><a href="{{ url('/login') }}">Sign In</a></li>
                    <li><a href="{{ url('/register') }}">Sign Up</a></li>
                </ul>
            @else
                <ul class="nav navbar-nav navbar-right collapse navbar-collapse">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->nama }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('user.profile')}}">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>My Profile
                            </a></li>
                            <li><a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>Log Out
                            </a></li>
                        </ul>
                    </li>
                </ul>
            @endguest
        @else
            <div class="navbar-header">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <b>My</b>Buffet
                    </a>
            </div>
        @endif

        </div>
    </nav>
</div>