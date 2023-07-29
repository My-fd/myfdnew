<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('web.home') }}">My-Fd</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('web.home') }}">{{ __('Home') }}</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.listings.createAd') }}">{{ __('Create Ad') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.messages.index') }}">{{ __('Messages') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.user.account') }}">{{ __('Profile') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.logout') }}">{{ __('Logout') }}</a>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.register') }}">{{ __('Register') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.login') }}">{{ __('Login') }}</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<!-- Footer -->
<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <span class="text-muted">{{ __('Place sticky footer content here.') }}</span>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
