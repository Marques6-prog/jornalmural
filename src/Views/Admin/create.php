<!DOCTYPE html>
<html lang="pt-pt">

<?php include_once "topBase.php"; ?>

<body id="main">
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
                  <h4 class="card-title"><?= htmlspecialchars($createTitle ?? "Nova publicação", ENT_QUOTES, "UTF-8") ?></h4>
                  <p class="card-description">
                    Adicione o conteúdo e associe-o à categoria correta.
                  </p>

                  <?php if (isset($_GET["status"], $_GET["msg"])) { ?>
                    <?php $alertType = in_array($_GET["status"], ["success", "danger"], true) ? $_GET["status"] : "info"; ?>
                    <div class="alert alert-<?= $alertType ?>" role="status">
                      <?= htmlspecialchars($_GET["msg"], ENT_QUOTES, "UTF-8") ?>
                    </div>
                  <?php } ?>

                  <form
                    method="post"
                    action="<?= route("/create/post") ?>"
                    enctype="multipart/form-data"
                    class="forms-sample"
                    >
                    <div class="form-group">
                      <label for="exampleInputTitle3">Título</label>
                      <input
                        type="text"
                        name="title"
                        class="form-control"
                        id="exampleInputTitle3"
                        placeholder="Título da publicação"
                        maxlength="180"
                        required>
                    </div>
                    <div class="form-group">
                      <label for="post-category">Categoria</label>
                      <select class="form-control" id="post-category" name="category" required>
                        <option value="" disabled <?= empty($selectedCategoryId) ? "selected" : "" ?>>Selecione uma categoria</option>
                        <?php foreach ($categories as $value) { ?>
                          <option value="<?= (int)$value["id"] ?>"
                            data-requires-media="<?= in_array($value["name"], ["Destaques", "Galeria"], true) ? "true" : "false" ?>"
                            data-allows-video="<?= $value["name"] === "Galeria" ? "true" : "false" ?>"
                            <?= (int)$value["id"] === (int)($selectedCategoryId ?? 0) ? "selected" : "" ?>>
                            <?= htmlspecialchars($value["name"], ENT_QUOTES, "UTF-8") ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <?php $gallerySelected = ($selectedCategoryName ?? "") === "Galeria"; ?>
                      <label id="post-media-label" for="post-photo"><?= $gallerySelected ? "Imagem ou vídeo" : "Imagem" ?></label>
                      <input id="post-photo" type="file" name="photo"
                        accept="<?= $gallerySelected ? "image/jpeg,image/png,video/mp4,video/webm" : "image/jpeg,image/png" ?>"
                        class="form-control file-upload-info"
                        <?= in_array($selectedCategoryName ?? "", ["Destaques", "Galeria"], true) ? "required" : "" ?>>
                      <small id="post-media-help" class="form-text text-muted">
                        <?= $gallerySelected
                          ? "Formatos aceites: JPG, PNG, MP4 e WebM. Vídeos até " . \Vendor\Settings\Upload::MAX_VIDEO_SIZE_MB . " MB; um ficheiro por publicação."
                          : "Formatos aceites: JPG e PNG. Destaques precisam de uma imagem; uma imagem por publicação." ?>
                      </small>
                    </div>

                    <div class="form-group">
                      <label for="exampleTextarea1">Descrição</label>
                      <textarea class="form-control" name="description" id="exampleTextarea1" rows="4" maxlength="10000" required></textarea>
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

    <?php include_once "bottomBase.php" ?>

    <script>
      const postCategory = document.querySelector("#post-category");
      const postPhoto = document.querySelector("#post-photo");
      const postMediaLabel = document.querySelector("#post-media-label");
      const postMediaHelp = document.querySelector("#post-media-help");
      const videoMaxSizeMb = <?= \Vendor\Settings\Upload::MAX_VIDEO_SIZE_MB ?>;

      const updateMediaInput = () => {
        const selectedCategory = postCategory.selectedOptions[0];
        const isGallery = selectedCategory.dataset.allowsVideo === "true";
        postPhoto.required = selectedCategory.dataset.requiresMedia === "true";
        postPhoto.accept = isGallery
          ? "image/jpeg,image/png,video/mp4,video/webm"
          : "image/jpeg,image/png";
        postMediaLabel.textContent = isGallery ? "Imagem ou vídeo" : "Imagem";
        postMediaHelp.textContent = isGallery
          ? `Formatos aceites: JPG, PNG, MP4 e WebM. Vídeos até ${videoMaxSizeMb} MB; um ficheiro por publicação.`
          : "Formatos aceites: JPG e PNG. Destaques precisam de uma imagem; uma imagem por publicação.";
      };

      postCategory.addEventListener("change", updateMediaInput);
      updateMediaInput();
    </script>
</body>

</html>