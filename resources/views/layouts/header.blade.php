<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
    <div style="width: 50%;">
        <ol class="breadcrumb">
            @if( isset($Segments) && count($Segments) > 0 )
                @php
                    $i = 0;
                    $SegmentCount = count($Segments);
                @endphp
                <li class="breadcrumb-item">
                    <b class="text-primary">
                        Home
                    </b>
                </li>
                @foreach ($Segments as $key => $val)
                    <li class="breadcrumb-item">
                        <b class="text-primary">
                            {{ $val }}
                        </b>
                    </li>
                @endforeach
            @endif
        </ol>
    </div>

    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto">
                            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                                <i class="ficon feather icon-menu"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name text-bold-600">
                                    {{ Auth()->check() ? Auth()->user()->Name : 'test' }}
                                </span>
                                <span class="user-status">
                                    {{ Auth()->check() ? Auth()->user()->getDept->DeptName : 'test' }}
                                    /
                                    {{ Auth()->check() ? Auth()->user()->getBranch->BranchName : 'test' }}
                                </span>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url('/logout') }}">
                                <i class="feather icon-power"></i> 
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>