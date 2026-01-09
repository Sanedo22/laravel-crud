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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudents"
            aria-expanded="true" aria-controls="collapseStudents">
            <i class="fas fa-user-graduate"></i>
            <span>Students</span>
        </a>
        <div id="collapseStudents" class="collapse {{ request()->is('admin/students*') ? 'show' : '' }}" aria-labelledby="headingStudents" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('students-index') ? 'active' : '' }}" href="{{ route('students-index') }}">All Students</a>
                <a class="collapse-item {{ request()->routeIs('students-trashed') ? 'active' : '' }}" href="{{ route('students-trashed') }}">Deleted Students</a>
            </div>
        </div>
    </li>

    <!-- Teachers -->
    <li class="nav-item {{ request()->is('admin/teachers*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTeachers"
            aria-expanded="true" aria-controls="collapseTeachers">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Teachers</span>
        </a>
        <div id="collapseTeachers" class="collapse {{ request()->is('admin/teachers*') ? 'active' : '' }}" aria-labelledby="headingTeachers" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('teachers-index') ? 'active' : '' }}" href="{{ route('teachers-index') }}">All Teachers</a>
                <a class="collapse-item {{ request()->routeIs('teachers-trashed') ? 'active' : '' }}" href="{{ route('teachers-trashed') }}">Deleted Teachers</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

</ul>
