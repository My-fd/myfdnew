<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('/assets/css/theme.min.css') }}">
    <script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
    <title>MyFd | @yield('title')</title>
</head>
<body>
<div id="db-wrapper">
    @yield('root')
</div>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-copy text-dark-success me-1">
                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
            </svg>
            <strong class="me-auto toast-title">...</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">...</div>
    </div>
</div>
<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('/assets/js/theme.min.js') }}"></script>
@yield('js')
<script>
$(document).ready(function() {
    $("[data-toggle=tooltip]").tooltip();
    $("[data-bs-toggle=popover]").popover();
});

</script>
</body>
</html>
