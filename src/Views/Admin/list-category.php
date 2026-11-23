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

            <div class="col-lg-12">
              <form 
                action="<?= route("/list-category") ?>" 
                method="get"
                >
                <div class="form-group">
                  <label for="exampleInputName1">Pesquisar por post</label>
                  <div class="bo-search">
                    <i class="mdi mdi-magnify"></i>
                    <input 
                      type="text" 
                      class="form-control" 
                      name="search"  
                      value="<?= htmlspecialchars($search) ?>" 
                      id="exampleInputName1" 
                      placeholder="Pesquisar categorias"
                    />
                  </div>
                </div>
              </form>
            </div>

            <?php
            if (isset($_GET["status"]) && isset($_GET["msg"])) {
            ?>
              <div class="alert alert-<?= $_GET["status"] ?>">
                <span> <?= $_GET["msg"] ?> </span>
              </div>
            <?php } ?>

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Lista de posts</h4>

                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                            Categoria
                          </th>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($categories as $value) {
                        ?>
                          <tr>
                            <td>
                              <?= $value["name"] ?>
                            </td>
                            <td style="display: flex; justify-content: flex-end;">
                              <div>
                                <a href="<?= route("/category/{$value['id']}/edit") ?>">Edit</a>
                                <a 
                                  onclick="return confirm('Deseja eliminar essa categoria?');" 
                                  href="<?= route("/category/{$value['id']}/delete") ?>">
                                  delete
                                </a>
                              </div>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
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