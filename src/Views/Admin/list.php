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
                method="get"
                action="<?= route("/list-post") ?>"                
                >
                <div class="form-group">
                  <label for="exampleInputName1">Pesquisar por post</label>
                  <div class="bo-search">
                    <i class="mdi mdi-magnify"></i>
                    <input type="text" name="search" value="<?= htmlspecialchars($search ?? '', ENT_QUOTES, 'UTF-8') ?>" class="form-control" id="exampleInputName1" placeholder="Pesquisar publicações">
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
                            Post
                          </th>
                          <th>
                            Titulo
                          </th>
                          <th>
                            Categoria
                          </th>
                          <th>
                            Descrição
                          </th>
                          <th>
                            Postado em
                          </th>
                          <th>

                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          foreach (($posts ?? []) as $value) {                            
                        ?>
                        <tr>
                          <td class="py-1">
                            <?php if (isVideoMedia($value["image"] ?? null)) { ?>
                              <span class="badge badge-info">Vídeo</span>
                            <?php } else { ?>
                            <img src="<?= imageRepository($value["image"]) ?>" alt="<?= $value["title"]?>" />
                            <?php } ?>
                          </td>
                          <td>
                            <?= $value["title"] ?>
                          </td>
                          <td>
                            <?= $value["name"] ?>
                          </td>
                          <td>
                            <?=  breakingText($value["description"], 110) ?>
                          </td>
                          <td>
                            <?= $value["created_at"] ?>
                          </td>
                          <td>
                            <div>
                              <a 
                                href="<?= route("/post/{$value['id']}/update") ?>"
                                >Edit</a>
                              <a
                                onclick="return confirm('Deseja eliminar esse post?')" 
                                href="<?= route("/post/{$value['id']}/delete") ?>"
                                >Delete</a>
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