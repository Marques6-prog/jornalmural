<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="navbar-brand-wrapper d-flex justify-content-center">
    <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100 px-3">
      <a class="navbar-brand brand-logo text-white" href="<?= route("/dashboard") ?>">
        <i class="mdi mdi-newspaper-variant-outline me-2"></i>Trans-Marques(8) 
      </a>
      <button class="navbar-toggler align-self-center d-lg-none" type="button" aria-label="Abrir menu">
        <i class="mdi mdi-menu text-white"></i>
      </button>
    </div>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end px-4">
    <span class="text-muted d-none d-md-inline me-auto">Painel administrativo</span>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown" id="profileDropdown">
          <img src="<?= imageRepository($_SESSION["user"]["image"] ?? null) ?>" alt="Perfil" style="width:38px;height:38px;object-fit:cover;border-radius:10px;margin-right:10px" />
          <span class="nav-profile-name font-weight-bold"><?= htmlspecialchars($_SESSION["user"]["name"] ?? "Administrador") ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown">
          <a class="dropdown-item" href="<?= route("/admin/logout") ?>">
            <i class="mdi mdi-logout text-danger me-2"></i> Terminar sessão
          </a>
        </div>
      </li>
    </ul>
  </div>
</nav>