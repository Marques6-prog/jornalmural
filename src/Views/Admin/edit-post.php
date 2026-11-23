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
                  <h4 class="card-title">Formulário de posts</h4>
                  <p class="card-description">
                    Informe os dados no formulário
                  </p>

                  <form 
                    method="post" 
                    action="<?= route("/edit/post") ?>"
                    enctype="multipart/form-data"
                    class="forms-sample"
                    >                   
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="form-group">
                      <label for="exampleInputTitle3">Titulo</label>
                      <input 
                        type="text" 
                        name="title"
                        value="<?= $title ?>"
                        class="form-control" 
                        id="exampleInputTitle3" 
                        placeholder="Title"                       
                        />
                    </div>
                    <div class="form-group">
                      <label for="exampleSelectGender">Categorias</label>
                      <select class="form-control" id="exampleSelectGender" name="category">
                        <?php foreach ($categories as $value) { ?>
                          <option value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Foto</label>
                      <input type="file" name="photo" class="form-control file-upload-info">                     
                    </div>

                    <div class="form-group">
                      <label for="exampleTextarea1">Descrição</label>
                      <textarea class="form-control" name="description" id="exampleTextarea1" rows="4">
                          <?= $description ?>
                      </textarea>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Editar</button>
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

    <?php include_once "bottomBase.php" ?>
</body>

</html>