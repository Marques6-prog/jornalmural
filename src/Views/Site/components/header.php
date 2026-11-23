<!-- Topbar Start -->
 <div class="container-fluid d-none d-lg-block">
     <div class="row align-items-center justify-content-between bg-white py-3 px-lg-5">
         <div class="col-lg-5">
             <a href="<?= route("/") ?>" class="navbar-brand p-0">
                 <h1 class="m-0 display-4 text-uppercase text-primary">Trans<span class="text-secondary font-weight-normal">Marques(8)</span></h1>
             </a>
         </div>
         <div class="col-lg-7 d-flex justify-content-end align-items-center">
             <a class="public-top-contact mr-4 text-secondary" href="tel:+244937645564"><i class="fa fa-phone-alt mr-2 text-primary"></i>+244 937 645 564</a>
             <a class="public-top-contact mr-4 text-secondary" href="mailto:transmarques23@hotmail.com"><i class="far fa-envelope mr-2 text-primary"></i>Email</a>
             <a class="btn btn-primary px-4 py-2 font-weight-bold" href="<?= route("/submission") ?>">Reservar viagem</a>
         </div>
     </div>
 </div>
 <!-- Topbar End -->

 <!-- Navbar Start -->
 <div class="container-fluid p-0">
     <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 px-lg-5">
         <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse"
             aria-controls="navbarCollapse" aria-expanded="false" aria-label="Abrir ou fechar o menu">
             <span class="navbar-toggler-icon"></span>
         </button>
         <a class="navbar-brand d-lg-none text-white" href="<?= route("/") ?>">Trans Marques(8)</a>
         <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
             <div class="navbar-nav mr-auto py-0">
                 <a href="<?= route("/") ?>" class="nav-item nav-link <?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/jornalmural/' ? 'active' : '' ?>">Início</a>
                 <div class="nav-item dropdown">
                     <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Categorias</a>
                     <div class="dropdown-menu rounded-0 m-0">
                         <?php if (empty($categories)) { ?>
                            <span class="dropdown-item-text text-muted">Sem categorias disponíveis</span>
                         <?php } ?>
                         <?php foreach (($categories ?? []) as $value) { ?>
                            <a href="<?= route("/categories/{$value['id']}") ?>" class="dropdown-item"><?= $value["name"] ?></a>
                        <?php } ?>                         
                     </div>
                 </div>
                 <a href="<?= route("/aboutus") ?>" class="nav-item nav-link <?= strpos($_SERVER['REQUEST_URI'], '/aboutus') !== false ? 'active' : '' ?>">Quem Somos</a>
                 <a href="<?= route("/submission") ?>" class="nav-item nav-link <?= strpos($_SERVER['REQUEST_URI'], '/submission') !== false ? 'active' : '' ?>">Agendamento</a>
                 <a href="<?= route("/contacts") ?>" class="nav-item nav-link <?= strpos($_SERVER['REQUEST_URI'], '/contacts') !== false ? 'active' : '' ?>">Contactos</a>
             </div>
             <form
                method="get"
                action="<?= route("/search")?>"
                class="input-group ml-auto site-search">
                 <label class="sr-only" for="site-search">Pesquisar publicações</label>
                 <input
                    type="search"
                    name="search"
                    id="site-search"
                    value="<?= htmlspecialchars((string)($search ?? ""), ENT_QUOTES, "UTF-8") ?>"
                    class="form-control border-0"
                    placeholder="Procurar"
                    maxlength="120"
                    aria-label="Pesquisar publicações">
                 <div class="input-group-append">
                     <button type="submit" class="input-group-text bg-primary text-dark border-0 px-3" aria-label="Pesquisar">
                         <i class="fa fa-search" aria-hidden="true"></i>
                     </button>
                 </div>
            </form>
         </div>
     </nav>
 </div>
 <!-- Navbar End -->