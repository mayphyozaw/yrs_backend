<aside class="main-sidebar elevation-4 sidebar-dark-teal">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link tw-text-base">
        <img src="{{ asset('image/logo.png') }}" alt="{{ config('app.name') }} Logo"
            class="brand-image img-circle elevation-3 tw-ml-0" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin-user.index') }}" class="nav-link @yield('admin-user-page-active')">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Admin User

                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link @yield('user-page-active')"> 
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User

                        </p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
