<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-center">
        <span class="brand-text font-weight-semibold">{{ config('app.name') }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link dashboard">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('items.index') }}" class="nav-link items">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>Items</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link chat">
                        <i class="nav-icon fas fa-comment-dots"></i>
                        <p>Chat <span class="right badge badge-danger">1</span></p>
                    </a>
                </li>
                @if (Auth::user()->hasRole('admin'))
                    <li class="nav-item">
                        <a href="#" class="nav-link users">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link setting">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Setting</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
