<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="{{ asset('/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
</head>
<body>

<header class="header">
    <div class="container header__nav" id="navbarNav">
        <a href="{{ route('web.home') }}" class="header-logo">
            <img class="header-logo-img" src="./img/logo.svg">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <nav>   
            <ul class="list-reset navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('web.home') }}">{{ __('Home') }}</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('web.messages.index') }}">{{ __('Messages') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('web.user.account') }}">{{ __('Profile') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('web.logout') }}">{{ __('Logout') }}</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-add" href="{{ route('web.listings.create') }}">{{ __('Create Ad') }}</a>
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
        </nav>
    </div>
</header>




<div class="content">
    @yield('content')
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container footer__block">
        <div class="footer__box">
            <div class="footer__social">
                <ul class="list-reset footer__social__list">
                    <li class="footer__social__list__vk">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="40" height="40" x="0" y="0" viewBox="0 0 532.337 532.337" style="enable-background:new 0 0 40 40" xml:space="preserve" class=""><g><path d="M471.998 241.286c7.57-9.786 13.58-17.638 18.018-23.562 31.965-42.498 45.82-69.646 41.574-81.482l-1.666-2.772c-1.107-1.665-3.977-3.194-8.592-4.578-4.621-1.383-10.533-1.604-17.736-.691l-79.822.563a22.728 22.728 0 0 0-5.545.128c-1.848.281-3.047.563-3.605.832-.557.282-1.016.508-1.383.692l-1.107.832c-.924.551-1.939 1.524-3.047 2.914-1.109 1.389-2.039 2.999-2.773 4.853-8.684 22.356-18.568 43.146-29.656 62.363-6.838 11.457-13.123 21.396-18.844 29.792-5.729 8.415-10.533 14.603-14.414 18.568-3.879 3.972-7.393 7.166-10.531 9.56-3.146 2.411-5.545 3.421-7.203 3.054a138.055 138.055 0 0 1-4.713-1.114c-2.588-1.658-4.67-3.917-6.236-6.787-1.572-2.857-2.631-6.463-3.189-10.808-.551-4.339-.881-8.084-.967-11.23-.098-3.139-.049-7.57.141-13.305.184-5.729.275-9.602.275-11.64 0-7.014.141-14.639.418-22.864.275-8.219.508-14.737.691-19.542.184-4.798.275-9.884.275-15.245 0-5.349-.324-9.56-.975-12.613a44.18 44.18 0 0 0-2.906-8.868c-1.297-2.858-3.189-5.08-5.686-6.646-2.496-1.573-5.588-2.815-9.283-3.746-9.799-2.222-22.271-3.409-37.418-3.604-34.37-.355-56.451 1.86-66.243 6.658-3.88 2.038-7.393 4.804-10.532 8.317-3.329 4.07-3.788 6.291-1.383 6.646 11.089 1.665 18.936 5.643 23.556 11.922l1.665 3.323c1.291 2.411 2.583 6.659 3.88 12.754 1.292 6.096 2.124 12.84 2.497 20.233.924 13.488.924 25.031 0 34.646-.924 9.614-1.799 17.093-2.631 22.442-.833 5.361-2.081 9.7-3.74 13.023-1.665 3.335-2.772 5.367-3.329 6.107-.557.734-1.016 1.199-1.383 1.384a20.804 20.804 0 0 1-7.484 1.383c-2.589 0-5.729-1.298-9.425-3.887-3.697-2.576-7.534-6.138-11.5-10.667-3.978-4.522-8.452-10.856-13.446-18.99-4.988-8.121-10.166-17.736-15.521-28.819l-4.431-8.042c-2.772-5.165-6.561-12.699-11.365-22.583s-9.058-19.443-12.748-28.69c-1.481-3.874-3.697-6.83-6.652-8.868l-1.383-.832c-.924-.735-2.405-1.524-4.437-2.351a29.865 29.865 0 0 0-6.377-1.805l-75.943.551c-7.76 0-13.023 1.763-15.795 5.275l-1.108 1.659c-.56.93-.835 2.411-.835 4.437 0 2.038.557 4.529 1.665 7.479 11.089 26.059 23.146 51.188 36.169 75.386 13.03 24.211 24.346 43.709 33.954 58.489 9.608 14.792 19.4 28.733 29.382 41.854 9.982 13.121 16.585 21.523 19.816 25.214 3.231 3.703 5.771 6.476 7.62 8.317l6.928 6.658c4.431 4.432 10.949 9.743 19.542 15.937 8.592 6.193 18.103 12.289 28.55 18.287 10.435 6.01 22.589 10.899 36.444 14.694 13.856 3.794 27.344 5.317 40.465 4.571h31.874c6.469-.551 11.363-2.576 14.688-6.096l1.107-1.383c.734-1.102 1.432-2.815 2.08-5.123.643-2.307.975-4.853.975-7.619-.191-7.943.416-15.116 1.799-21.481 1.383-6.377 2.955-11.175 4.713-14.418 1.756-3.226 3.738-5.955 5.959-8.177 2.217-2.222 3.783-3.55 4.713-4.015.924-.453 1.666-.777 2.217-.973 4.43-1.476 9.65-.043 15.66 4.296 6.004 4.352 11.641 9.7 16.91 16.077 5.262 6.377 11.59 13.531 18.984 21.481 7.387 7.943 13.855 13.855 19.4 17.735l5.545 3.336c3.695 2.209 8.494 4.241 14.412 6.096 5.912 1.842 11.09 2.307 15.52 1.383l70.955-1.114c7.02 0 12.473-1.15 16.354-3.464 3.879-2.295 6.188-4.853 6.928-7.619.734-2.772.783-5.899.141-9.419-.648-3.507-1.297-5.955-1.939-7.338-.648-1.383-1.25-2.546-1.807-3.464-9.24-16.628-26.885-37.051-52.938-61.255l-.557-.551-.275-.281-.275-.27h-.278c-11.83-11.273-19.309-18.85-22.449-22.736-5.727-7.38-7.025-14.865-3.879-22.441 2.203-5.745 10.514-17.85 24.926-36.333z" data-original="#000000" opacity="1" class=""></path></g></svg>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="footer__logo">
            </div>

            <div class="footer__nav">
                <ul class="list-reset footer__nav__list">
                    <li class="footer__nav__feedback">
                        <a href="#">
                            <span>{{ __('Feedback') }}</span>
                        </a>
                    </li>

                    <li class="footer__nav__feedback">
                        <a href="#">
                            <span>{{ __('User Agreement') }}</span>
                        </a>
                    </li>
                </ul>

            
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
