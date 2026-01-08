<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <span class="fw-bold text-dark">Admin Dashboard</span>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->name }}
                </span>
                <img class="img-profile rounded-circle"
                     src="{{ asset('admin/img/undraw_profile.svg') }}">
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>

    </ul>

</nav>
