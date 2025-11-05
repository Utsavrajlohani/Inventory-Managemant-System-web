<style>
    /* Navigation dark mode styles */
    body.dark-mode .navbar {
        background: linear-gradient(to right, #1a1a1a, #2d2d2d) !important;
        border-bottom: 1px solid #3d3d3d;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    body.dark-mode .navbar-brand,
    body.dark-mode .nav-link {
        color: #ffffff !important;
    }
    body.dark-mode .nav-link:hover {
        color: #63b3ed !important;
    }
    body.dark-mode .navbar-toggler {
        border-color: #3d3d3d;
        color: #ffffff;
    }
    body.dark-mode .navbar-toggler-icon {
        filter: invert(1);
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: linear-gradient(45deg, #1a237e, #0d47a1);">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
        <i class="fas fa-boxes me-2"></i>
        <span style="font-weight: 600;">Inventory Management</span>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item px-1">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-home fa-fw"></i> <span>Home</span>
            </a>
        </li>
        <li class="nav-item px-1">
            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                <i class="fas fa-box fa-fw"></i> <span>Products</span>
            </a>
        </li>
        <li class="nav-item px-1">
            <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                <i class="fas fa-truck fa-fw"></i> <span>Suppliers</span>
            </a>
        </li>
        <li class="nav-item px-1">
            <a class="nav-link {{ request()->routeIs('sales.index') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                <i class="fas fa-shopping-cart fa-fw"></i> <span>Sales</span>
            </a>
        </li>
        <li class="nav-item px-1">
            <a class="nav-link {{ request()->routeIs('sales.report') || request()->routeIs('sales.report.period') ? 'active' : '' }}" href="{{ route('sales.report') }}">
                <i class="fas fa-chart-line fa-fw"></i> <span>Sales Reports</span>
            </a>
        </li>
      </ul>
      <ul class="navbar-nav align-items-center">
        <li class="nav-item">
          <button class="btn btn-outline-light btn-sm rounded-pill px-3" id="themeToggle">
            <i class="fas fa-sun" id="themeIcon"></i>
            <span class="ms-1" id="themeText">Light Mode</span>
          </button>
        </li>
        <li class="nav-item ms-3">
          <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3" style="background: linear-gradient(45deg, #dc3545, #c82333); border: none;">
              <i class="fas fa-sign-out-alt"></i> Logout
            </button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
