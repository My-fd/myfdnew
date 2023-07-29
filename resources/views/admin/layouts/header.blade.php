<div class="header @@classList">
    <nav class="navbar-classic navbar navbar-expand-lg">
        <a id="nav-toggle" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-menu nav-icon me-2 icon-xs">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </a>

        <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
            <li class="dropdown ms-2">
                <a class="rounded-circle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md avatar-indicators avatar-online">
                        <img alt="avatar" src="/images/manager.png" class="rounded-circle">
                    </div>
                </a>
                @if(!\Illuminate\Support\Facades\Auth::guest())
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                        <div class="px-4 pb-0 pt-2">
                            <div class="lh-1 ">
                                <h5 class="mb-1">{{ \Illuminate\Support\Facades\Auth::user()->getFullName() }}</h5>
                            </div>
                            <div class=" dropdown-divider mt-3 mb-2"></div>
                        </div>
                        <ul class="list-unstyled">
                            <li>
                                <form action="/logout" method="get">
                                    @csrf
                                    <button class="dropdown-item" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round"
                                             class="feather feather-power me-2 icon-xxs dropdown-item-icon">
                                            <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                                            <line x1="12" y1="2" x2="12" y2="12"></line>
                                        </svg>
                                        Выйти
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endif
            </li>
        </ul>
    </nav>
</div>
