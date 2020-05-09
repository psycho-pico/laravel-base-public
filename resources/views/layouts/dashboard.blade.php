<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="yohanes pajero">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Psychopico2') }} - @yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/roboto.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin-src/css/admin.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-src/css/dashboard.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-src/css/dashboard-dark.min.css') }}" rel="stylesheet">

    @yield('header')

</head>
@php
if (Auth::user()->getPreference && !is_null(Auth::user()->getPreference->dark_mode)) {
    if (Auth::user()->getPreference->dark_mode == 1) {
        $dark = true;
    }
    else {
        $dark = false;
    }
}
else {
    if (date('H') > 6 && date('H') < 18) {
        $dark = false;
    }
    else {
        $dark = true;
    }

}
@endphp
<body class="{{$dark ? 'dark' : ''}}" id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @php
            $sidebar_toggled = Auth::user()->getPreference->sidebar_toggled ?? false;
            $sidebar_item_collapsed = (Auth::user()->getPreference->sidebar_item_collapsed ?? false) ? '1' : '0';
            $sidebar_item_collapsed_index = Auth::user()->getPreference->sidebar_item_collapsed_index ?? '';
        @endphp
        <input type="hidden" name="sidebar_item_collapsed" value="{{$sidebar_item_collapsed}}">
        <input type="hidden" name="sidebar_item_collapsed_index" value="{{$sidebar_item_collapsed_index}}">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion {{$sidebar_toggled ? 'toggled' : ''}}" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center mb-2" href="{{ route('/') }}">
                <div class="sidebar-brand-icon">
                    <img style="width: 55px; height: auto;" src="{{ asset('img/mzm white.png') }}">
                </div>
                <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Psychopico2') }}</div>
            </a>
            <div class="sidebar-menus-wrapper">
                <div class="sidebar-menus">

                    <!-- Divider -->
                    {{-- <hr class="sidebar-divider my-0"> --}}

                    <!-- Nav Item - Dashboard -->
                    <li class="nav-item{{Str::contains(Route::currentRouteName(), 'dashboard') ? ' active' : ''}}">
                        <a class="nav-link-searchable nav-link collapsed" href="{{ route('dashboard') }}">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>Dashboard</span></a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">


                    @can('content-view')
                    <div class="sidebar-heading">
                        Content
                    </div>

                    @php
                    $websitesUrl = [
                        "pages"
                    ];
                    @endphp

                    <li class="nav-item{{Str::contains(Route::currentRouteName(), $websitesUrl) ? ' active' : ''}}">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#websitesGroup" aria-expanded="true" aria-controls="websitesGroup">
                            <i class="fas fa-globe-asia"></i>
                            <span>Websites</span>
                        </a>
                        <div id="websitesGroup" class="collapse sidebar-menu-collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="nav-link-searchable collapse-item{{Str::contains(Route::currentRouteName(), 'pages') ? ' active' : ''}}" href="{{ route('pages.index') }}"><span>Pages</span></a>
                            </div>
                        </div>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">
                    @endcan


                    @can('ref-view')
                    <div class="sidebar-heading">
                        Reference
                    </div>

                    <!-- Divider -->
                    <hr class="sidebar-divider">
                    @endcan


                    @can('config-view')
                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Config
                    </div>

                    @php
                    $credentialsUrl = [
                        "users"
                        ,"roles"
                        ,"permission"
                    ];
                    @endphp

                    <li class="nav-item{{Str::contains(Route::currentRouteName(), $credentialsUrl) ? ' active' : ''}}">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#credentialsGroup" aria-expanded="true" aria-controls="credentialsGroup">
                            <i class="fas fa-users"></i>
                            <span>Credentials</span>
                        </a>
                        <div id="credentialsGroup" class="collapse sidebar-menu-collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="nav-link-searchable collapse-item{{Str::contains(Route::currentRouteName(), 'users') ? ' active' : ''}}" href="{{ route('users.index') }}"><span>User</span></a>
                                <a class="nav-link-searchable collapse-item{{Str::contains(Route::currentRouteName(), 'roles') ? ' active' : ''}}" href="{{ route('roles.index') }}"><span>Role</span></a>
                                <a class="nav-link-searchable collapse-item{{Str::contains(Route::currentRouteName(), 'permissions') ? ' active' : ''}}" href="{{ route('permissions.index') }}"><span>Permission</span></a>
                            </div>
                        </div>
                    </li>

                    @php
                    $applicationsUrl = [
                        "paginations"
                    ];
                    @endphp

                    <li class="nav-item{{Str::contains(Route::currentRouteName(), $applicationsUrl) ? ' active' : ''}}">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#applicationsGroup" aria-expanded="true" aria-controls="applicationsGroup">
                            <i class="fas fa-desktop"></i>
                            <span>Applicatoins</span>
                        </a>
                        <div id="applicationsGroup" class="collapse sidebar-menu-collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="nav-link-searchable collapse-item{{Str::contains(Route::currentRouteName(), 'paginations') ? ' active' : ''}}" href="{{ route('paginations.index') }}"><span>Pagination</span></a>
                            </div>
                        </div>
                    </li>


                    <!-- Divider -->
                    <hr class="sidebar-divider">
                    @endcan


                    @can('core-setting-view')
                    <div class="sidebar-heading">
                        Core Settings
                    </div>
                    @endcan


                    <li class="nav-item">
                        <a class="nav-link-searchable nav-link collapsed" href="{{ route('dashboard') }}">
                            <i class="fas fa-cloud"></i>
                            <span>Cloud</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-searchable nav-link collapsed" href="{{ route('dashboard') }}">
                            <i class="fas fa-database"></i>
                            <span>Database</span></a>
                    </li>


                </div>
            </div>
            <div class="text-center d-none d-md-inline">
                <button class="border-0 sidebar-toggler w-100 py-2 mb-0 bg-transparent" style="height: unset !important;" id="sidebarToggle"></button>
            </div>

        </ul>

        <div id="content-wrapper" class="main-content d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 sidebar-toggler">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form method="GET" action="" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small navbar-search-input" placeholder="{{__('Search module')}}" aria-label="Search" aria-describedby="basic-addon2" tabindex="1" onclick="$(this).select();">
                            <div class="input-group-append">
                                <button class="navbar-search-button btn btn-primary" type="submit"><i class="fas fa-search fa-sm"></i></button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none blurring-effect-on-popup search-dropdown-mobile-wrapper">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in dropdown-search-main" aria-labelledby="searchDropdown">
                                <form method="GET" action="" class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small navbar-search-input navbar-search-input-mobile" placeholder="{{__('Search module')}}" aria-label="Search" aria-describedby="basic-addon2" onclick="$(this).select();">
                                        <div class="input-group-append">
                                            <button class="navbar-search-button btn btn-primary" type="submit"><i class="fas fa-search fa-sm"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow blurring-effect-on-popup">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> {{Auth::user()->username }}</span>
                                <img class="img-profile rounded-circle bg-light" src="{{ asset('img/yo.jpg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profiles.index') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item preference-url" href="{{ route('preferences.index') }}">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Preferece
                                </a>
                                <a class="dropdown-item dark-mode-toggler {{$dark ? 'dark-active' : ''}}" href="#!">
                                    <i class="fas fa-adjust fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Dark Mode <span class="badge badge-secondary ml-1 badge-dark">{{$dark ? 'on' : 'off'}}</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-700">@yield('title')</h1>
                    <div class="mb-5 small d-flex breadcrumb-wrapper horizontal-scroll">
                        @for($i = 0; $i <= count(Request::segments()); $i++)
                                @if (true)
                                    @if (is_numeric(Request::segment(count(Request::segments()) - 1)) && $i == (count(Request::segments()) - 1))
                                    @else
                                        <span class="{{$i >= count(Request::segments()) ? 'text-gray-700 font-weight-bold' : 'text-gray-600' }}">
                                            @if (is_numeric(Request::segment(count(Request::segments()))) && $i == count(Request::segments()))
                                                {{__('Show')}}
                                            @else
                                                {{  preg_replace('/([a-z])([A-Z])/s','$1 $2', ucwords(Request::segment($i)))}}
                                            @endif
                                        </span>
                                    @endif

                                    @if($i < count(Request::segments()) & $i > 0)
                                        @if (is_numeric(Request::segment(count(Request::segments()))) && ($i + 1) == count(Request::segments()))
                                            {!!'<i class="fa fa-angle-right mx-2 text-gray-400"></i>'!!}
                                        @elseif (is_numeric(Request::segment(count(Request::segments()) - 1)) && $i == (count(Request::segments()) - 1))
                                        @else

                                            {!!'<i class="fa fa-angle-right mx-2 text-gray-400"></i>'!!}
                                        @endif
                                    @endif
                                @endif
                        @endfor
                    </div>
                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; yph 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('sb-admin-src/js/sb-admin-2.js') }}"></script> --}}
    <script src="{{ asset('js/jquery.mousewheel.min.js') }}"></script>

    <script src="{{ asset('js/bootstrap3-typeahead.min.js') }}"></script>
    {{-- <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/jquery.typeahead.min.js') }}"></script> --}}


    @yield('footer')

    <script src="{{ asset('admin-src/js/admin-base.js') }}"></script>
    <script src="{{ asset('admin-src/js/admin-func.js') }}"></script>

</body>

</html>
