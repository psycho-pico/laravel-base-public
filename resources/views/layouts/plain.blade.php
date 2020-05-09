<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Psychopico2') }}</title>

        <link href="{{ asset('plain/plain.min.css') }}" rel="stylesheet">

        <script src="{{ asset('js/app.min.js') }}"></script>
    </head>
    <body class="d-flex flex-column h-100 {{ (date('H') > 6 && date('H') < 18 ? '' : 'dark') }}">
    {{-- <body class="d-flex flex-column h-100 darks"> --}}
        <header>
          <!-- Fixed navbar -->
          <nav class="navbar navbar-expand-md navbar-dark">
            <a class="navbar-brand" href="{{ route('/') }}">
                <img src="{{ asset('img/mzm white.png') }}">
                <span class="title">{{ config('app.name', 'Psychopico2') }}</span>
            </a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
              <ul class="navbar-nav mr-auto">
              </ul>
              <ul class="navbar-nav">
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endauth
                @endif
              </ul>
            </div>
          </nav>
        </header>

        <!-- Begin page content -->
        <main role="main" class="flex-shrink-0">
            @yield('content')
        </main>

        <footer class="footer">
            <span class="text-muted">Copyright &copy; yph 2020</span>
        </footer>

        @yield('footer')
    </body>
</html>
