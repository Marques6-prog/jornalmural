<!DOCTYPE html>
<html lang="pt-pt">

<?php require_once "topBase.php" ?>
<?php $posts = $posts ?? []; ?>
<?php $categories = $categories ?? []; ?>

<body>
    <?php require_once "components/header.php" ?>

    <!-- News With Sidebar Start -->
    <div class="container-fluid mt-5 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h4 class="m-0 text-uppercase font-weight-bold">Categoria: <?= htmlspecialchars($category, ENT_QUOTES, "UTF-8") ?></h4>
                            </div>
                        </div>
                        <?php if (empty($posts)) { ?>
                        <div class="col-12">
                            <div class="alert alert-light border" role="status">Ainda não há publicações nesta categoria.</div>
                        </div>
                        <?php } ?>
                        <?php foreach ($posts as $value) { ?>
                        <div class="col-lg-6">
                            <div class="position-relative mb-3">
                                <?php if (isVideoMedia($value["image"] ?? null)) { ?>
                                <video class="img-fluid w-100" controls preload="metadata" playsinline
                                    src="<?= htmlspecialchars(imageRepository($value["image"]), ENT_QUOTES, "UTF-8") ?>"
                                    aria-label="<?= htmlspecialchars($value["title"], ENT_QUOTES, "UTF-8") ?>"
                                    style="aspect-ratio: 16 / 9; object-fit: cover; background: #000;">
                                    O seu navegador não suporta a reprodução deste vídeo.
                                </video>
                                <?php } else { ?>
                                <img class="img-fluid w-100"
                                    src="<?= htmlspecialchars(imageRepository($value["image"]), ENT_QUOTES, "UTF-8") ?>"
                                    alt="<?= htmlspecialchars($value["title"], ENT_QUOTES, "UTF-8") ?>"
                                    loading="lazy"
                                    style="object-fit: cover;">
                                <?php } ?>
                                <div class="bg-white border border-top-0 p-4">
                                    <div class="mb-2">
                                        <span class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2">
                                            <?= htmlspecialchars($value["name"], ENT_QUOTES, "UTF-8") ?>
                                        </span>
                                        <small class="text-body"><?= htmlspecialchars($value["created_at"], ENT_QUOTES, "UTF-8") ?></small>
                                    </div>
                                    <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" 
                                        href="<?= route("/details/" . (int)$value["id"]) ?>">
                                        <?= htmlspecialchars($value["title"], ENT_QUOTES, "UTF-8") ?>
                                    </a>
                                    <p class="m-0">
                                        <?= nl2br(htmlspecialchars($value["description"], ENT_QUOTES, "UTF-8")) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>                      
                    </div>
                </div>
                
                <div class="col-lg-4">        
                    <!-- Tags Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Tags</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <div class="d-flex flex-wrap m-n1">
                                <?php if (empty($categories)) { ?>
                                    <span class="text-muted">Ainda não há categorias disponíveis.</span>
                                <?php } ?>
                                <?php foreach ($categories as $value) { ?>
                                    <a href="<?= route("/categories/" . (int)$value["id"]) ?>"
                                        class="btn btn-sm btn-outline-secondary m-1">
                                        <?= htmlspecialchars($value["name"], ENT_QUOTES, "UTF-8") ?>
                                    </a>
                                <?php } ?>                                
                            </div>
                        </div>
                    </div>
                    <!-- Tags End -->
                </div>
            </div>
        </div>
    </div>
    <!-- News With Sidebar End -->

    <?php require_once "components/footer.php" ?>

    <!-- JavaScript Librarie+ -->
    <?php require_once "bottomBase.php" ?>
</body>

</html>