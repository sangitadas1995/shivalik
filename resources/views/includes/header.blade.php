<header class="header">
  <a id="btn-collapse" class="header-bar" href="#">
    <!-- <i class="ri-bar-chart-horizontal-line"></i> -->
  </a>
  <a id="btn-toggle" href="#" class="sidebar-toggler break-point-lg">
    <i class="ri-bar-chart-horizontal-line"></i>
  </a>
  <div class="dropdown navbar-nav-right profile-img-text">
    <a class="dropdown-toggle align-items-center" class="btn btn-secondary dropdown-toggle" type="button"
      id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      <span class="d-flex">
        <span><img class="img-xs rounded-circle" src="{{ asset('images/face15.jpg') }}" alt="" /></span>
        <span class="profile-text ms-2">
          <b>Welcome to<br /></b> Admin</span>
      </span>
    </a>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li><a class="dropdown-item" href="#">Action</a></li>
      <li><a class="dropdown-item" href="#">Another action</a></li>
      <li>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <a class="dropdown-item" href="#" onclick="event.preventDefault();
                this.closest('form').submit();">Logout</a>
        </form>
      </li>
    </ul>
  </div>
</header>
<div class="page-breadcrumb">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#"><i class="ri-home-4-line"></i></a>
      </li>
      <li class="breadcrumb-item">
        <a href="#" class="d-flex align-items-center">Welcome Back, Admin</a>
      </li>
    </ol>
  </nav>
</div>