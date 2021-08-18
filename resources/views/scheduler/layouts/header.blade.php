        <header id="header">
            <button id="mobileMenuBtn"></button>

            <h1 class="text-white  pull-left">Scheduler</h1>
            {{-- <span class="logo pull-left">
                <img src="{{ asset('assets/images/logo_light.png') }}" alt="admin panel" height="35" class="margin-top-6" />
            </span> --}}

            <nav>
                <ul class="nav pull-right">
                    <li class="dropdown pull-left">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img class="user-avatar" alt="" src="{{ asset('assets/images/default.png') }}" height="34" />
                            <span class="user-name">
                                <span class="hidden-xs">
                                    {{ Auth::user()->fullname }} <i class="fa fa-angle-down"></i>
                                </span>
                            </span>
                        </a>
                        <ul class="dropdown-menu hold-on-click">
                            <li>
                                <a href="javascript:void()" onclick="document.getElementById('logout-form').submit()"><i class="fa fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none">
                    @csrf
                </form>
            </nav>
        </header>
