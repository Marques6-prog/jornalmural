<!DOCTYPE html>
<html lang="pt-pt">

<?php include_once "topBase.php"; ?>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php
    include_once "components/header.php";
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php
      include_once "components/sidebar.php";
      ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="bo-page-head">
            <div>
              <h1>Visão geral</h1>
              <p>Olá, <?= htmlspecialchars($_SESSION["user"]["name"] ?? "Administrador") ?>. Aqui está o estado do seu jornal.</p>
            </div>
            <a href="<?= route("/create-post") ?>" class="btn btn-primary">
              <i class="mdi mdi-plus me-1"></i> Nova publicação
            </a>
          </div>

          <div class="bo-stat-grid">
            <div class="bo-stat">
              <div><small>Publicações</small><strong><?= (int)$total ?></strong></div>
              <div class="bo-stat__icon purple"><i class="mdi mdi-file-document-outline"></i></div>
            </div>
            <div class="bo-stat">
              <div><small>Visitantes únicos</small><strong><?= (int)$totalVisits ?></strong></div>
              <div class="bo-stat__icon green"><i class="mdi mdi-eye-outline"></i></div>
            </div>
            <div class="bo-stat">
              <div><small>Estado</small><strong>Online</strong></div>
              <div class="bo-stat__icon orange"><i class="mdi mdi-pulse"></i></div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Ações rápidas</h4>
                  <p class="text-muted">Continue a gerir o conteúdo da sua plataforma.</p>
                  <div class="d-flex flex-wrap gap-2">
                    <a href="<?= route("/create-post") ?>" class="btn btn-primary">Criar publicação</a>
                    <a href="<?= route("/create-post?kind=featured") ?>" class="btn btn-warning">
                      <i class="mdi mdi-star me-1" aria-hidden="true"></i>Adicionar notícia em destaque
                    </a>
                    <a href="<?= route("/create-post?kind=gallery") ?>" class="btn btn-info">
                      <i class="mdi mdi-image-plus me-1" aria-hidden="true"></i>Adicionar foto ou vídeo à galeria
                    </a>
                    <a href="<?= route("/list-post") ?>" class="btn btn-light">Ver publicações</a>
                    <a href="<?= route("/create-category") ?>" class="btn btn-light">Adicionar categoria</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <?php include_once "bottomBase.php" ?>
</body>

</html>