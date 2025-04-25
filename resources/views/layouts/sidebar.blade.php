<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="./index.html" class="brand-link">
      <!--begin::Brand Image-->
      <img
        src="/assets/img/AdminLTELogo.png"
        alt="AdminLTE Logo"
        class="brand-image opacity-75 shadow" />
      <!--end::Brand Image-->
      <!--begin::Brand Text-->
      <span class="brand-text fw-light">AdminLTE 4</span>
      <!--end::Brand Text-->
    </a>
    <!--end::Brand Link-->
  </div>
  <!--end::Sidebar Brand-->
  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false">
        <li class="nav-item">
          <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/concerts" class="nav-link {{ request()->is('concerts*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-music-note"></i>
            <p>Konser</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/users" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-people"></i>
            <p>User</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/tickets" class="nav-link {{ request()->is('tickets*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-ticket"></i>
            <p>Ticket</p>
          </a>
        </li>

      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>