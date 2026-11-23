<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item">
      <a class="nav-link" href="<?= route("/dashboard") ?>">
        <i class="mdi mdi-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="mdi mdi-file-document-box-outline menu-icon"></i>
        <span class="menu-title">Posts</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="<?= route("/create-post") ?>">Criar</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= route("/list-post") ?>">Lista</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Categorias</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic1">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="<?= route("/create-category") ?>">Criar</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?= route("/list-category") ?>">Lista</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="<?= route("/recicle") ?>">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Lixeira</span>        
      </a>     
    </li>

    <li class="nav-item">
      <a class="nav-link" href="<?= route("/list-bookings") ?>">
        <i class="mdi mdi-calendar-check menu-icon"></i>
        <span class="menu-title">Agendamentos</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="<?= route("/list-contacts") ?>">
        <i class="mdi mdi-email-outline menu-icon"></i>
        <span class="menu-title">Mensagens</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="<?= route("/newsletter") ?>">
        <i class="mdi mdi-email-newsletter menu-icon"></i>
        <span class="menu-title">Newsletter</span>
      </a>
    </li>
  </ul>
</nav>