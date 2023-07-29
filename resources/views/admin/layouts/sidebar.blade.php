<nav class="flex-wrap navbar-vertical navbar">
    <div class="flex-fill slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 90%;">
        <div class="flex-fill nav-scroller" style="overflow: hidden; width: auto; height: 90%;">
            <div class="p-2" style="height: 76px;">
                <a class="navbar-brand" href="{{ route('admin.index') }}">
                    <img src="{{ asset('images/dabster.svg') }}" alt="">
                    @if(env('IS_CANARY', false))
                        <span class="text-warning fw-bold">α</span>
                    @endif
                </a>
            </div>
            <ul class="navbar-nav flex-column" id="sideNavbar">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.managers.list') }}">
                        Менеджеры
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.demands.list') }}">
                        Запросы на регистрацию
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.slugs.list') }}">
                        Черный список поддоменов
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.releaseNotes') }}">
                        Обновления
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.alphaTesters') }}">
                        Альфа тестеры
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.teams.list') }}">
                        Команды
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.tariffs.list') }}">
                        Тарифы
                    </a>
                </li>
                <li class="nav-item">
                    <div class="navbar-heading">Служебное</div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.autodoc') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-clipboard nav-icon icon-xs me-2">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        </svg>
                        Документация
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.globals.list') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-clipboard nav-icon icon-xs me-2">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12,3 C 8,3 8,21 12,21 C 16,21 16,3 12,3"/>
                            <path d="M3,12 C 3,8 21,8 21,12 C 21,16 3,16 3,12"/>
                        </svg>
                        Глобальные настройки
                    </a>
                </li>
            </ul>
        </div>
        <div class="slimScrollBar"
             style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 949px;"></div>
        <div class="slimScrollRail"
             style="width: 7px; height: 100%; position: absolute; top: 0; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
    </div>
</nav>
