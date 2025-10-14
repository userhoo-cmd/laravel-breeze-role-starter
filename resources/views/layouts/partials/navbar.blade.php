<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="{{ route('dashboard') }}" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">{{ __('dashboard.title') }}</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Language Switcher -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-globe"></i> {{ strtoupper(app()->getLocale()) }}
            </a>
            <div id="switchLang" class="dropdown-menu dropdown-menu-right">
                @if(\Illuminate\Support\Facades\Route::has('lang.switch'))
                    <a href="{{ route('lang.switch', ['lang' => 'en']) }}" class="dropdown-item">English</a>
                    <a href="{{ route('lang.switch', ['lang' => 'es']) }}" class="dropdown-item">Español</a>
                @else
                    <span class="dropdown-item text-muted">Language switching not available</span>
                @endif
            </div>
        </li>

        <!-- User Account Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user-circle"></i> {{ auth()->user()->getFullname() }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                @if(\Illuminate\Support\Facades\Route::has('settings.index'))
                    <a href="{{ route('settings.index') }}" class="dropdown-item">
                        <i class="nav-icon fas fa-cogs mr-2"></i> {{ __('settings.title') }}
                    </a>
                    <div class="dropdown-divider"></div>
                @endif

                <a href="#" class="dropdown-item"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> {{ __('common.Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
