<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Psychopico2') }}</title>

        <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/roboto.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap-sticky-footer-navbar.min.css') }}" rel="stylesheet">

    </head>
    <body class="d-flex flex-column h-100">
        <header>
          <!-- Fixed navbar -->
          <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
            <a class="navbar-brand" href="{{ route('/') }}">{{ config('app.name', 'Psychopico2') }}</a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/about') }}">About</a>
                </li>
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
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endauth
                @endif
              </ul>
            </div>
          </nav>
        </header>

        <!-- Begin page content -->
        <main role="main" class="flex-shrink-0">
          <div class="container">
              @yield('content')
          </div>
        </main>

        <footer class="footer mt-auto py-3">
          <div class="container">
            <span class="text-muted">Copyright &copy; yph 2020</span>
          </div>
        </footer>

        <script src="{{ asset('js/app.min.js') }}"></script>
    </body>
</html>
