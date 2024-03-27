<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{ Route('home') }}">
                    <i class="fa fa-balance-scale"></i>
                    <h2 class="brand-text mb-0">Budget Fee</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                    <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                        data-ticon="icon-disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>

    {{-- !DIBACA BAIK BAIK --}}
    {{-- !PUTRI MINTA SETELAH LOGIN LANGSUNG KE MENU CHECKSHEET TIDAK PERLU ADA HOMEPAGE. --}}
    {{-- !9 SEPTEMBER 2022 --}}
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {{-- *DIATAS JGN DI COMMENT, BIAR BISA DI TOGGLE HIDE SIDEBAR. --}}

            {{-- !SIDEBAR MENU HEADER --}}
            <li class=" navigation-header">
                <span data-i18n="Menu">
                    Menu
                </span>
                <i data-feather="more-horizontal"></i>
            </li>

            {{-- !SIDEBAR MENU BUDGER --}}
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="list" class="feather icon-list"></i>
                    <span class="menu-title text-truncate" data-i18n="Budget">Budget</span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Request()->segment(2) == 'list-budget' ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('budget.list') }}">
                            <i data-feather="corner-down-right" class="feather icon-corner-down-right"></i>
                            <span class="menu-item text-truncate" data-i18n="List Budget">List Budget</span>
                        </a>
                    </li>
                    <li class="{{ Request()->segment(2) == 'archive' ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('budget.archive-list') }}">
                            <i data-feather="corner-down-right" class="feather icon-corner-down-right"></i>
                            <span class="menu-item text-truncate" data-i18n="Archive">Archive</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- !SIDEBAR MENU REALIZATION --}}
            <li class=" nav-item {{ Request()->segment(1) == 'realization' ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('realization.index') }}">
                    <i data-feather="bar-chart-2" class="feather icon-bar-chart-2"></i>
                    <span class="menu-title text-truncate" data-i18n="Realization">Realization</span>
                </a>
            </li>

            {{-- !SIDEBAR MENU REPORT --}}
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="file-text" class="feather icon-file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Report">Report</span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Request()->segment(2) == 'report-budget' ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('report.budget') }}">
                            <i data-feather="corner-down-right" class="feather icon-corner-down-right"></i>
                            <span class="menu-item text-truncate" data-i18n="Report Budget">Report Budget</span>
                        </a>
                    </li>
                    <li class="{{ Request()->segment(2) == 'report-realization' ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('report.realization') }}">
                            <i data-feather="corner-down-right" class="feather icon-corner-down-right"></i>
                            <span class="menu-item text-truncate" data-i18n="Report Realization">Report
                                Realization</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- !SIDEBAR MENU HEADER --}}
            <li class=" navigation-header">
                <span data-i18n="Setting">
                    Setting
                </span>
                <i data-feather="more-horizontal"></i>
            </li>

            {{-- !SIDEBAR MENU REALIZATION --}}
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('setting.budget-group.index') }}">
                    <i data-feather="compass" class="feather icon-compass"></i>
                    <span class="menu-title text-truncate" data-i18n="Budget Group">Budget Group</span>
                </a>
            </li>

            {{-- !SIDEBAR MENU REALIZATION --}}
            @if( auth()->user()->getUserGroup->getGroup->GroupCode != config('GroupCodeApplication.USER_RMFEE') )
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('setting.user.index') }}">
                    <i data-feather="users" class="feather icon-users"></i>
                    <span class="menu-title text-truncate" data-i18n="User">User</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>
