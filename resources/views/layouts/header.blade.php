<nav class="app-header navbar navbar-expand bg-body">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Start Navbar Links-->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i>
        </a>
      </li>
      <li class="nav-item d-none d-md-block"><a href="/" class="nav-link">Home</a></li>
      <li class="nav-item d-none d-md-block"><a href="{{ route('tickets.redeem.form') }}" class="nav-link">Redeem</a></li>
    </ul>
    <ul class="navbar-nav ms-auto">
      
      <!--begin::Fullscreen Toggle-->
      <li class="nav-item">
        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
          <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
          <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
        </a>
      </li>
      <!--end::Fullscreen Toggle-->
      <!--begin::User Menu Dropdown-->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img
            src="/assets/img/user2-160x160.jpg"
            class="user-image rounded-circle shadow"
            alt="User Image"
          />
          <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <!--begin::User Image-->
          <li class="user-header text-bg-primary">
            <img
              src="/assets/img/user2-160x160.jpg"
              class="rounded-circle shadow"
              alt="User Image"
            />
            <p>
              {{ Auth::user()->name }} - {{ Auth::user()->role }}
              <small>Member since Nov. 2023</small>
            </p>
          </li>
          <!--end::User Image-->
         
          <!--begin::Menu Footer-->
          <li class="user-footer">
            <form method="POST" action="{{ route('logout') }}" class="d-inline float-end">
              @csrf
              <button type="submit" class="btn btn-default btn-flat">Sign out</button>
            </form>
          </li>
          <!--end::Menu Footer-->
        </ul>
      </li>
      <!--end::User Menu Dropdown-->
    </ul>
    <!--end::End Navbar Links-->
  </div>
  <!--end::Container-->
</nav>
