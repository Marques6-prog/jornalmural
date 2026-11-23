<!DOCTYPE html>
<html lang="en">

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
          <div class="row">

            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Formulário de categorias</h4>
                  <p class="card-description">
                    Informe os dados no formulário
                  </p>

                  <?php
                  if (isset($_GET["status"]) && isset($_GET["msg"])) {
                  ?>
                    <div class="alert alert-<?= $_GET["status"] ?>">
                      <span> <?= $_GET["msg"] ?> </span>
                    </div>
                  <?php } ?>

                  <form method="post" action="<?= route("/category/create") ?>" class="forms-sample">
                    <div class="form-group d-flex flex-column">
                      <label for="exampleInputName1">Nome</label>
                      <input type="text" name="name" class="form-control form-control-md" id="exampleInputEmail1" placeholder="Name" maxlength="80" minlength="3" />
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Cadastrar</button>
                  </form>
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
  </div>
  <?php include_once "bottomBase.php" ?>
</body>

</html>