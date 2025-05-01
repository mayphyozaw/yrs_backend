<aside class="main-sidebar elevation-4 sidebar-dark-teal">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link tw-text-base">
        <img src="{{ asset('image/logo.png') }}" alt="{{ config('app.name') }} Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link @yield('dashboard-page-active') tw-text-sm justify-start">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard

                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link @yield('user-page-active') tw-text-sm justify-start"> 
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('wallet.index') }}" class="nav-link @yield('wallet-page-active') tw-text-sm justify-start"> 
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Wallet 

                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('wallet-transaction.index') }}" class="nav-link @yield('wallet-transaction-page-active') tw-text-sm justify-start"> 
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Wallet Transaction

                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('top-up-history.index') }}" class="nav-link @yield('top-up-history-page-active') tw-text-sm justify-start"> 
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Top Up History

                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('station.index') }}" class="nav-link @yield('station-page-active') tw-text-sm justify-start"> 
                        <i class="nav-icon fas fa-subway"></i>
                        <p>
                            Station
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('route.index') }}" class="nav-link @yield('route-page-active') tw-text-sm justify-start"> 
                        <i class="nav-icon fas fa-route"></i>
                        <p>
                            Route
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('ticket-pricing.index') }}" class="nav-link @yield('ticket-pricing-page-active') tw-text-sm justify-start"> 
                        <i class="nav-icon fas fa-tag"></i>
                        <p>
                            Ticket Pricing
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('ticket.index') }}" class="nav-link @yield('ticket-page-active') tw-text-sm justify-start"> 
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                            Ticket
                        </p>
                    </a>
                </li>

                

                <li class="nav-item">
                    <a href="{{ route('ticket-inspector.index') }}" class="nav-link @yield('ticket-inspector-page-active') tw-text-sm justify-start"> 
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Ticket Inspector

                        </p>
                    </a>
                </li>
               
                <li class="nav-item">
                    <a href="{{ route('admin-user.index') }}" class="nav-link @yield('admin-user-page-active') tw-text-sm justify-start">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Admin User

                        </p>
                    </a>
                </li>   

            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
