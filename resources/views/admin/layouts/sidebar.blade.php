<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="sidebar-brand-text mx-2">Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Students -->
    <li class="nav-item {{ request()->is('admin/students*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('students-index') }}">
            <i class="fas fa-user-graduate"></i>
            <span>Students</span>
        </a>
    </li>

    <!-- Teachers -->
    <li class="nav-item {{ request()->is('admin/teachers*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('teachers-index') }}">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Teachers</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

</ul>
