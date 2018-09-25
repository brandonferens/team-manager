<nav>
    <div class="container flex justify-between">
        <a class="flex items-center" href="{{ route('teams.index') }}">
            <i class="fas fa-futbol text-3xl mr-2"></i>

            <span class="font-bold text-xl">Team Manager 2.0</span>
        </a>

        @auth
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form class="hidden" id="logout-form" action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
            </form>
        @else
            <a href="{{ route('login') }}">
                Login
            </a>
        @endauth
    </div>
</nav>
