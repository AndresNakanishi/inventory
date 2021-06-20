<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $this->Url->build(["controller" => "Users", "action" => "dashboard"]) ?>">
        <div class="sidebar-brand-icon">
          <i class="fas fa-dog"></i>
        </div>
        <div class="sidebar-brand-text mx-3">CuchaCucha<sup>V1</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <?php if($userProfileCode === 'EMP'): ?>
        <a class="nav-link" href="<?= $this->Url->build(["controller" => "Users", "action" => "dashboard"]) ?>">
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span>
        </a>
        <?php elseif($userProfileCode === 'SOCIO'): ?>
        <a class="nav-link" href="<?= $this->Url->build(["controller" => "Users", "action" => "dashboardPartners"]) ?>">
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span>
        </a>
        <?php elseif($userProfileCode === 'ADMIN'): ?>
        <a class="nav-link" href="<?= $this->Url->build(["controller" => "Users", "action" => "dashboardAdmin"]) ?>">
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span>
        </a>
        <?php endif; ?>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Sistema
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item">
    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Pages</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Login Screens:</h6>
        <a class="collapse-item" href="login.html">Login</a>
        <a class="collapse-item" href="register.html">Register</a>
        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
        <div class="collapse-divider"></div>
        <h6 class="collapse-header">Other Pages:</h6>
        <a class="collapse-item" href="404.html">404 Page</a>
        <a class="collapse-item" href="blank.html">Blank Page</a>
        </div>
    </div>
    </li> -->

    <!-- Nav Item - Ventas -->

    <?php if($userProfileCode === 'EMP'): ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= $this->Url->build(["controller" => "Sales", "action" => "salesToday"]) ?>">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Ventas</span>
        </a>
    </li>
    <?php endif; ?>

    <?php if($userProfileCode === 'SOCIO' || $userProfileCode === 'ADMIN'): ?>
      <!-- Nav Item - Ventas -->
      <li class="nav-item">
          <a class="nav-link" href="<?= $this->Url->build(["controller" => "Sales", "action" => "index"]) ?>">
              <i class="fas fa-fw fa-calendar"></i>
              <span>Ventas</span>
          </a>
      </li>
    <?php endif; ?>

    <?php if($userProfileCode === 'SOCIO' || $userProfileCode === 'ADMIN' ): ?>

    <!-- Nav Item - Usuarios -->
    <li class="nav-item">
        <a class="nav-link" href="<?= $this->Url->build(["controller" => "Users", "action" => "reports"]) ?>">
            <i class="fas fa-file-alt"></i>
            <span>Reportes</span>
        </a>
    </li>

    <!-- Nav Item - Usuarios -->
    <li class="nav-item">
        <a class="nav-link" href="<?= $this->Url->build(["controller" => "Users", "action" => "index"]) ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Usuarios</span>
        </a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Configuración</span>
      </a>
      <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Configuración:</h6>
          <a class="collapse-item" href="<?= $this->Url->build(["controller" => "Categories", "action" => "index"]) ?>">Categorías</a>
          <a class="collapse-item" href="<?= $this->Url->build(["controller" => "Brands", "action" => "index"]) ?>">Marcas</a>
          <a class="collapse-item" href="<?= $this->Url->build(["controller" => "Products", "action" => "index"]) ?>">Productos</a>
          <a class="collapse-item" href="<?= $this->Url->build(["controller" => "SecondaryProducts", "action" => "index"]) ?>">Stock y Precios</a>
          <?php if($userProfileCode === 'ADMIN' ): ?>
            <a class="collapse-item" href="<?= $this->Url->build(["controller" => "Profiles", "action" => "index"]) ?>">Perfiles</a>
            <a class="collapse-item" href="<?= $this->Url->build(["controller" => "Branches", "action" => "index"]) ?>">Sucursales</a>
          <?php endif; ?>
        </div>
      </div>
    </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
