<header class="header" id="header">
  <a id="btn-collapse" class="header-bar" href="#">
    <!-- <i class="ri-bar-chart-horizontal-line"></i> -->
  </a>
  <a id="btn-toggle" class="sidebar-toggler break-point-lg">
    <i class="ri-bar-chart-horizontal-line"></i>
  </a>
  <button id="sidebar-toggler-small" class="d-none d-lg-block sidebar-toggler-small break-point-lg"
    onclick="onSidebarSmallTogglerClick(event)">
    <i class="ri-bar-chart-horizontal-line"></i>
  </button>
  <div class="dropdown navbar-nav-right profile-img-text">
    <a class="dropdown-toggle align-items-center" class="btn btn-secondary dropdown-toggle" type="button"
      id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      <span class="d-flex">
        <span><img class="img-xs rounded-circle" src="{{ asset('images/face15.jpg') }}" alt="" /></span>
        <span class="profile-text ms-2">
          {{-- <b>Welcome to<br /></b>
          <?php //echo Helper::userDetails(session('user_auto_id'));?>
        </span> --}}
        <b>Welcome to<br /></b> {{ auth('web')->user()->name }}</span>
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
        <a href="#" class="d-flex align-items-center">Welcome Back,
          <?php echo Helper::userDetails(session('user_auto_id'));?>
        </a>
      </li>
    </ol>
  </nav>
</div>